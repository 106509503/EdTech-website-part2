<?php
require_once "extrafiles/settings.php";
$conn = new mysqli($host, $user, $pwd, $sql_db);

mysqli_query($conn, "CREATE TABLE IF NOT EXISTS eoi (
    eoinum      INT AUTO_INCREMENT PRIMARY KEY,
    jobref      VARCHAR(5),
    firstname   VARCHAR(20),
    lastname    VARCHAR(20),
    dob         VARCHAR(10),
    gender      VARCHAR(20),
    street      VARCHAR(40),
    suburb      VARCHAR(40),
    state       VARCHAR(3),
    postcode    CHAR(4),
    email       VARCHAR(100),
    phone       VARCHAR(12),
    skills      VARCHAR(255),
    otherskills TEXT,
    status      ENUM('New','Current','Final') DEFAULT 'New'
)");

$statement = mysqli_prepare($conn,
    "INSERT INTO eoi (jobref, firstname, lastname, dob, gender, street, suburb, state, postcode, email, phone, skills, otherskills)
     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

$skills = implode(', ', $_POST['skills'] ?? []);

mysqli_stmt_bind_param($statement, "sssssssssssss",
    $_POST['jobref'], $_POST['firstname'], $_POST['lastname'],
    $_POST['dob'], $_POST['gender'], $_POST['street'],
    $_POST['suburb'], $_POST['state'], $_POST['postcode'],
    $_POST['email'], $_POST['phone'], $skills, $_POST['otherskills']);

mysqli_stmt_execute($statement);
$eoinum = mysqli_insert_id($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>EOI Confirmation</title>
</head>
<body>
    <p>Submitted. Your EOI number is <strong><?php echo $eoinum; ?></strong></p>
    <a href="apply.php">Back</a>
</body>
</html>