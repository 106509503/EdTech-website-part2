<?php
session_start();
require_once "extrafiles/settings.php";
$conn = new mysqli($host, $user, $pwd, $sql_db); // Create connection

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_POST['username']; // Get the username and password from the POST request
$password = $_POST['password']; 

$username = $conn->real_escape_string($username); // Escape the username and password to prevent SQL injection
$password = $conn->real_escape_string($password);

$sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'"; // Query the database to check if the username and password are correct
$result = $conn->query($sql);

if ($result && $result->num_rows === 1) { //check if the query was successful and if there is exactly one matching user
    $_SESSION['user'] = $username;
    header('Location: manager.php');
} else {
    echo 'Invalid username or password. <a href="login.php">Try again</a>';
}

$conn->close();
?>

//this doesnt have any protection stuff or anything, like no hash and stuff 