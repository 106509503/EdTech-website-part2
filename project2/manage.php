<?php
    session_start();
    require_once("extrafiles/settings.php");
    require_once("sanitise_functions.inc.php");
    $conn = @mysqli_connect($host, $user, $pwd, $sql_db);
    if (!$conn) {
        die("<p>Database Connection Failed: " . mysqli_connect_error() . "</p>");
    }
    //Handle Status Update (Change an EOI status)
    if (isset($_POST['action']) &&$_POST['action'] == 'update_status') {
        $eoi_id = mysqli_real_escape_string($conn, sanitise_input($_POST['eoi_number']));
        $new_status = mysqli_real_escape_string($conn, sanitise_input($_POST['status']));

        if (in_array($new_status, ['New', 'Current', 'Final'])) {
            $update_query = "UPDATE eoi SET status = '$new_status' WHERE eoi_number = '$eoi_id'";
            mysqli_query($conn, $update_query);
        }

        header("Location: manage.php");
        exit();
    }
    //Handle Bulk Delete by Job Reference
    if (isset($_POST['action']) && $_POST['action'] == 'delete_job_ref') {
        $delete_ref = mysqli_real_escape_string($conn, sanitise_input($_POST['delete_ref']));

        if ()
    }
?>
<!DOCTYPE html>
<html>
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
                    <input type="text" id="sort_job_ref" name="sort_job_ref" value="<?php echo $display_job_ref; ?>">

                    <label for="lby_name">Applicant Name:</label>
                    <input type="text" id="sort_name" value="<?php echo $display_name; ?>">

                    <label for="sort_by">Sort By:</label>
                    <select id="sort_by" name="sort_by">
                        <option value="eoi_number" <?php if ($sort_field == 'eoi_number') echo 'selected'; ?>>EOI Number</option>
                        <option value="job_ref" <?php if ($sort_field == 'job_ref') echo 'selected'; ?>>JOb Reference</option>
                        <option value="first_name" <?php if ($sort_field == 'first_name') echo 'selected'; ?>>First Name</option>
                        <option value="last_name" <?php if ($sort_field == 'last_name') echo 'selected'; ?>>Last Name</option>
                        <option value="state" <?php if ($sort_field == 'state') echo 'selected'; ?>>State</option>
                        <option value="status" <?php if ($sort_field == 'status') echo 'selected'; ?>>Status</option>
                    </select>
                    <button type="submit">Apply Filters</button>
                    <a href="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">Reset</a>
                </form>
            </section>
            <section>
                <h2>Danger Zone: Bulk Delete Applications</h2>
                <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" onsubmit="return confirm('Are you sure you want to delete all applications for this job reference? This action cannot be reversed.');">
                    <input type="hidden" name="action" value="delete_job_ref">
                    <label Lothar for="delete_ref">Enter Target JOb Reference Number:</label>
                    <select id="delete_ref" name="delete_ref">
                        <option value="chief_web_designer">XcZ35 &lpar;Chief Web Designer&rpar;</option>
                        <option value="web_designer">KMp35 &lpar;Web Designer&rpar;</option>
                        <option value="dlcs">YpT35 &lpar;Digital Learning Content Specialist&rpar;</option>
                    </select>
                    <button type="submit">Delete</button>
                </form> 
            </section>
            <section>
                <h2>Application Records List</h2>
                <?php
                    if ()
                ?>
            </section>
        </main>
    </body>
</html>