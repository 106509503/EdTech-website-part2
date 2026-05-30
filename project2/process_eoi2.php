<?php
// process_eoi.php
require_once('settings.php');
require_once('sanitise_functions.inc.php');

// -------------------------------------------------------------
// GUARDRAIL: Block Direct URL Access
// -------------------------------------------------------------
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    // Redirect back to the application form if accessed directly
    header("Location: apply.php");
    exit();
}

// Connect to database server
$conn = @mysqli_connect($host, $user, $pwd, $sql_db);
if (!$conn) {
    die("<p>Database connection failure: " . mysqli_connect_error() . "</p>");
}

// -------------------------------------------------------------
// DYNAMIC TABLE CREATION: Create 'eoi' table if it doesn't exist
// -------------------------------------------------------------
$create_table_query = "CREATE TABLE IF NOT EXISTS eoi (
    eoi_number INT AUTO_INCREMENT PRIMARY KEY,
    job_reference VARCHAR(5) NOT NULL,
    first_name VARCHAR(20) NOT NULL,
    last_name VARCHAR(20) NOT NULL,
    dob VARCHAR(10) NOT NULL,
    gender VARCHAR(20) NOT NULL,
    street_address VARCHAR(40) NOT NULL,
    suburb_town VARCHAR(40) NOT NULL,
    state VARCHAR(3) NOT NULL,
    postcode VARCHAR(4) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone_number VARCHAR(12) NOT NULL,
    skills VARCHAR(255),
    other_skills TEXT,
    status ENUM('New', 'Current', 'Final') DEFAULT 'New'
)";

if (!mysqli_query($conn, $create_table_query)) {
    die("<p>Error setting up database tables: " . mysqli_error($conn) . "</p>");
}

// -------------------------------------------------------------
// DATA SANITIZATION & CAPTURE
// -------------------------------------------------------------
$errors = [];

$jobref      = isset($_POST['jobref']) ? mysqli_real_escape_string($conn, sanitise_input($_POST['jobref'])) : '';
$firstname   = isset($_POST['firstname']) ? mysqli_real_escape_string($conn, sanitise_input($_POST['firstname'])) : '';
$lastname    = isset($_POST['lastname']) ? mysqli_real_escape_string($conn, sanitise_input($_POST['lastname'])) : '';
$dob         = isset($_POST['dob']) ? mysqli_real_escape_string($conn, sanitise_input($_POST['dob'])) : '';
$gender      = isset($_POST['gender']) ? mysqli_real_escape_string($conn, sanitise_input($_POST['gender'])) : '';
$street      = isset($_POST['street']) ? mysqli_real_escape_string($conn, sanitise_input($_POST['street'])) : '';
$suburb      = isset($_POST['suburb']) ? mysqli_real_escape_string($conn, sanitise_input($_POST['suburb'])) : '';
$state       = isset($_POST['state']) ? mysqli_real_escape_string($conn, sanitise_input($_POST['state'])) : '';
$postcode    = isset($_POST['postcode']) ? mysqli_real_escape_string($conn, sanitise_input($_POST['postcode'])) : '';
$email       = isset($_POST['email']) ? mysqli_real_escape_string($conn, sanitise_input($_POST['email'])) : '';
$phone       = isset($_POST['phone']) ? mysqli_real_escape_string($conn, sanitise_input($_POST['phone'])) : '';
$otherskills = isset($_POST['otherskills']) ? mysqli_real_escape_string($conn, sanitise_input($_POST['otherskills'])) : '';

// Process the skills array into a clean comma-separated string
$skills_string = "";
if (isset($_POST['skills']) && is_array($_POST['skills'])) {
    $clean_skills = array_map('sanitise_input', $_POST['skills']);
    $skills_string = mysqli_real_escape_string($conn, implode(", ", $clean_skills));
}

// -------------------------------------------------------------
// SERVER-SIDE VALIDATION Engine (Matches your exact HTML Patterns)
// -------------------------------------------------------------
if (!preg_match("/^[A-Za-z0-9]{5}$/", $jobref)) {
    $errors[] = "Job Reference must be exactly 5 alphanumeric characters.";
}
if (!preg_match("/^[A-Za-z]{1,20}$/", $firstname)) {
    $errors[] = "First Name must be up to 20 alphabetic characters only.";
}
if (!preg_match("/^[A-Za-z]{1,20}$/", $lastname)) {
    $errors[] = "Last Name must be up to 20 alphabetic characters only.";
}
if (!preg_match("/^(0[1-9]|[12]\d|3[01])\/(0[1-9]|1[0-2])\/\d{4}$/", $dob)) {
    $errors[] = "Date of Birth must follow the dd/mm/yyyy format.";
}
if (empty($gender)) {
    $errors[] = "Please select a gender option.";
}
if (empty($street) || strlen($street) > 40) {
    $errors[] = "Street address is required and cannot exceed 40 characters.";
}
if (empty($suburb) || strlen($suburb) > 40) {
    $errors[] = "Suburb/Town is required and cannot exceed 40 characters.";
}
$allowed_states = ['VIC', 'NSW', 'QLD', 'NT', 'WA', 'SA', 'TAS', 'ACT'];
if (!in_array($state, $allowed_states)) {
    $errors[] = "Please select a valid Australian state.";
}
if (!preg_match("/^\d{4}$/", $postcode)) {
    $errors[] = "Postcode must be exactly 4 digits.";
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Please enter a valid email address format.";
}
if (!preg_match("/^\d{8,12}$/", $phone)) {
    $errors[] = "Phone Number must contain between 8 and 12 digits (no spaces/symbols).";
}

// -------------------------------------------------------------
// EXECUTION OR ERROR DISPLAY
// -------------------------------------------------------------
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Application Processing Status</title>
    <link rel="stylesheet" href="styles/pagestyle.css">
</head>
<body>

<main style="padding: 40px; max-width: 600px; margin: 0 auto;">
    <?php if (count($errors) > 0): ?>
        <div style="background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; padding: 20px; border-radius: 5px;">
            <h2>Validation Errors Encountered</h2>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
            <p><a href="apply.php" style="color: #721c24; font-weight: bold;">Return to Form</a></p>
        </div>
    <?php else: ?>
        <?php
        // Insert record safely into database
        $insert_query = "INSERT INTO eoi 
            (job_reference, first_name, last_name, dob, gender, street_address, suburb_town, state, postcode, email, phone_number, skills, other_skills) 
            VALUES 
            ('$jobref', '$firstname', '$lastname', '$dob', '$gender', '$street', '$suburb', '$state', '$postcode', '$email', '$phone', '$skills_string', '$otherskills')";
        
        if (mysqli_query($conn, $insert_query)) {
            $generated_id = mysqli_insert_id($conn);
            echo "<div style='background: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 20px; border-radius: 5px;'>";
            echo "<h2>Application Submitted Successfully!</h2>";
            echo "<p>Thank you for applying to our EdTech Platform, <strong>" . htmlspecialchars($firstname) . "</strong>.</p>";
            echo "<p>Your unique application Reference Number is: <strong style='font-size: 1.2em;'>EOI-" . $generated_id . "</strong></p>";
            echo "<p>Please keep this reference for your tracking.</p>";
            echo "<p><a href='index.php' style='color: #155724; font-weight: bold;'>Return Home</a></p>";
            echo "</div>";
        } else {
            echo "<p>Database Error: Unable to store your record at this time. " . mysqli_error($conn) . "</p>";
        }
        ?>
    <?php endif; ?>
</main>

</body>
</html>
<?php 
mysqli_close($conn); 
?>