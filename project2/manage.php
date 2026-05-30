<?php
// Secure gatekeeper check if the username and password are entered as 'admin'
session_start();

if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'manager') {
    header("Location: login.php");
    exit();
}

require_once("extrafiles/settings.php");
require_once("sanitise_functions.inc.php");

$conn = @mysqli_connect($host, $user, $pwd, $sql_db);
if (!$conn) {
    die("<p>Database Connection Failed: " . mysqli_connect_error() . "</p>");
}

// Handle Status Update (Change an EOI status)
if (isset($_POST['action']) && $_POST['action'] == 'update_status') {
    $eoi_id = mysqli_real_escape_string($conn, sanitise_input($_POST['eoi_number']));
    $new_status = mysqli_real_escape_string($conn, sanitise_input($_POST['status']));

    if (in_array($new_status, ['New', 'Current', 'Final'])) {
        $update_query = "UPDATE eoi SET status = '$new_status' WHERE eoi_number = '$eoi_id'";
        mysqli_query($conn, $update_query);
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Handle Bulk Delete by Job Reference
// FIXED: Form now sends via POST, allowing this block to execute properly
if (isset($_POST['action']) && $_POST['action'] == 'delete_job_ref') {
    $delete_ref = mysqli_real_escape_string($conn, sanitise_input($_POST['delete_ref']));

    if (!empty($delete_ref)) {
        $delete_query = "DELETE FROM eoi WHERE job_reference = '$delete_ref'";
        mysqli_query($conn, $delete_query);
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Fetch unique references to build dropdowns
$job_refs_query = "SELECT DISTINCT job_reference, job_title FROM eoi ORDER BY job_reference";
$job_refs_result = mysqli_query($conn, $job_refs_query);
$job_refs_array = [];

// FIXED: Checking the execution result instead of the string query name
if ($job_refs_result) {
    while ($job_refs_row = mysqli_fetch_assoc($job_refs_result)) {
        // FIXED: Explicitly map reference codes to titles as key => value pairing
        $job_refs_array[$job_refs_row['job_reference']] = $job_refs_row['job_title'];
    }
}

// Get unique combined names for the new dropdown
$names_query = "SELECT DISTINCT CONCAT(first_name, ' ', last_name) AS full_name FROM eoi ORDER BY full_name";
$names_result = mysqli_query($conn, $names_query);
$names_array = [];

// FIXED: Checking the result pointer variable
if ($names_result) {
    while ($name_row = mysqli_fetch_assoc($names_result)) {
        $names_array[] = $name_row['full_name'];
    }
}

// Variables to build List All, sort, filter
$where_clause = [];
$display_job_ref = "";
$display_name = "";

// FIXED STEP: Process the GET parameters BEFORE building the master query string
// List by Job reference
if (!empty($_GET['lby_job_ref'])) {
    $display_job_ref = sanitise_input($_GET['lby_job_ref']);
    $job_ref_db = mysqli_real_escape_string($conn, $display_job_ref);
    $where_clause[] = "job_reference LIKE '%$job_ref_db%'";
}

// List by Applicant Name
if (!empty($_GET['lby_name'])) {
    $display_name = sanitise_input($_GET['lby_name']);
    $name_db = mysqli_real_escape_string($conn, $display_name);
    $where_clause[] = "CONCAT(first_name, ' ', last_name) LIKE '%$name_db%'";
}

// Apply Safe Sorting
$sort_field = 'eoi_number';
$sql_sort_order = 'eoi_number ASC'; // DEFAULT SORTING   
if (!empty($_GET['sort_by'])) {
    $sort_field = sanitise_input($_GET['sort_by']);
    
    switch ($sort_field) {
        case 'name':
            $sql_sort_order = 'first_name ASC, last_name ASC';
            break;
        case 'job_ref':
            $sql_sort_order = 'job_reference ASC';
            break;
        case 'state':
            $sql_sort_order = 'state ASC';
            break;
        case 'status':
            $sql_sort_order = 'status ASC';
            break;
        case 'eoi_number':
        default:
            $sort_field = 'eoi_number';
            $sql_sort_order = 'eoi_number ASC';
            break;
    }
}

// Build final query string
$query = "SELECT * FROM eoi";
if (count($where_clause) > 0) {
    $query .= " WHERE " . implode(" AND ", $where_clause);
}
// FIXED: Added a deliberate space character before ORDER BY to prevent SQL string smashing
$query .= " ORDER BY $sql_sort_order";

// Execute main records fetch
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>TechHive Recruitment - HR Management Dashboard</title>
        <link rel="stylesheet" href="styles/pagestyle.css">
        <link rel="stylesheet" href="styles/index-layout.css">
    </head>
    <body>
        <?php include_once ('extrafiles/header.inc'); ?>
        <?php include_once ('extrafiles/nav.inc'); ?>
        <main>
            <h1>HR Manager Dashboard</h1>
            <hr>

            <section>
                <h2>Filter & Sort EOIs</h2>
                <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="GET">
                    <label for="lby_job_ref">Job Reference:</label>
                    <select id="lby_job_ref" name="lby_job_ref">
                        <option value="">-- All Job References --</option>
                        <?php 
                        foreach ($job_refs_array as $ref => $title) {
                            $safe_ref = htmlspecialchars($ref);
                            $safe_title = htmlspecialchars($title);
                            $selected = ($ref == $display_job_ref) ? 'selected' : '';
                            echo "<option value='$safe_ref' $selected>$safe_ref ($safe_title)</option>";
                        }                                   
                        ?>
                    </select>

                    <label for="lby_name">Applicant Name:</label>
                    <select id="lby_name" name="lby_name">
                        <option value="">-- All Applicants --</option>
                        <?php
                        foreach ($names_array as $name) {
                            $safe_name = htmlspecialchars($name);
                            $selected = ($name == $display_name) ? 'selected' : '';
                            echo "<option value='$safe_name' $selected>$safe_name</option>\n";
                        }
                        ?>
                    </select>

                    <label for="sort_by">Sort By:</label>
                    <select id="sort_by" name="sort_by">
                        <option value="eoi_number" <?php if ($sort_field == 'eoi_number') echo 'selected'; ?>>EOI Number</option>
                        <option value="job_ref" <?php if ($sort_field == 'job_ref') echo 'selected'; ?>>Job Reference</option>
                        <option value="name" <?php if ($sort_field == 'name') echo 'selected'; ?>>Applicant's Name</option>                        
                        <option value="state" <?php if ($sort_field == 'state') echo 'selected'; ?>>State</option>
                        <option value="status" <?php if ($sort_field == 'status') echo 'selected'; ?>>Status</option>
                    </select>
                    <button type="submit">Apply Settings</button>
                    <a href="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">Reset</a>
                </form>
            </section>
            
            <section>
                <h2>Application Records List</h2>
                <?php
                    if ($result && mysqli_num_rows($result) > 0) {
                        echo "<table border='1' cellpadding='8'>
                                <thead>
                                    <tr>
                                        <th>EOI Number</th>
                                        <th>Job Reference</th>
                                        <th>Name</th>
                                        <th>Date of Birth</th>
                                        <th>Gender</th>
                                        <th>Location</th>
                                        <th>Email</th>
                                        <th>Phone Number</th>
                                        <th>Skills</th>
                                        <th>Other Skills</th>
                                        <th>Status</th>                                            
                                    </tr>
                                </thead>
                                <tbody>";

                        while ($row = mysqli_fetch_assoc($result)) {
                            $eoi_id = htmlspecialchars($row['eoi_number']);
                            // FIXED: Adjusted array keys to match full schema columns safely
                            $job_ref = htmlspecialchars($row['job_reference']);
                            $full_name = htmlspecialchars($row['first_name'] . ' ' . $row['last_name']);
                            $dob = htmlspecialchars($row['dob']);
                            $gender = htmlspecialchars($row['gender']);
                            $location = htmlspecialchars($row['suburb_town'] . ', ' . $row['state']);
                            $email = htmlspecialchars($row['email']);
                            $phone = htmlspecialchars($row['phone_number']);
                            $skills = htmlspecialchars($row['skills']);
                            $other_skills = htmlspecialchars($row['other_skills']);
                            $status = htmlspecialchars($row['status']);
                            
                            echo "<tr>
                                    <td>$eoi_id</td>
                                    <td>$job_ref</td>
                                    <td>$full_name</td>
                                    <td>$dob</td>
                                    <td>$gender</td>
                                    <td>$location</td>
                                    <td>$email</td>
                                    <td>$phone</td>
                                    <td>$skills</td>";
                            
                            if (!empty($row['other_skills'])) {
                                echo "<td>$other_skills</td>";
                            } else {
                                echo "<td><em>None</em></td>";
                            }
                            
                            echo "<td>
                                    <form action='" . htmlspecialchars($_SERVER['PHP_SELF']) . "' method='POST'>
                                        <input type='hidden' name='action' value='update_status'>
                                        <input type='hidden' name='eoi_number' value='$eoi_id'>
                                        <select name='status' onchange=\"if(confirm('Are you sure you want to change the status of EOI #$eoi_id?')) { this.form.submit(); } else { location.reload(); }\">";
                            
                            foreach (['New', 'Current', 'Final'] as $opt) {
                                $selected = ($row['status'] == $opt) ? 'selected' : '';
                                echo "<option value='$opt' $selected>$opt</option>";
                            }
                            echo "        </select>
                                    </form>
                                </td>
                            </tr>";                    
                        }
                    echo "</tbody>
                        </table> ";        
                    } else {
                        echo "<p>No active EOI records meet the search settings.</p>";
                    }
                ?>             
            </section>

            <section>
                <h2>Danger Zone: Bulk Delete Applications</h2>
                <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete all applications for this job reference? This action cannot be reversed.');">
                    <input type="hidden" name="action" value="delete_job_ref">
                    <label for="delete_ref">Enter Target Job Reference Number:</label>
                    <select id="delete_ref" name="delete_ref" required>
                        <option value="" disabled selected>-- Select Reference Number --</option>
                        <?php
                        if (count($job_refs_array) > 0) {
                            foreach ($job_refs_array as $ref => $title) {
                                $safe_ref = htmlspecialchars($ref);
                                $safe_title = htmlspecialchars($title);
                                echo "<option value='$safe_ref'>$safe_ref ($safe_title)</option>";
                            }
                        } else {
                            echo "<option value='' disabled>No active job references available</option>";
                        }
                        ?>
                    </select>
                    <button type="submit">Delete All Matching Applications</button>
                </form> 
            </section>
        </main>
        <?php include_once ('extrafiles/footer.inc'); ?>
    </body>
</html>
<?php 
mysqli_close($conn); 
?>