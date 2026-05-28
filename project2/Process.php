<?php
session_start();
require_once "extrafiles/settings.php";
$conn = new mysqli($host, $user, $pwd, $sql_db); // Create connection

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Check if the request method is POST
     $username = trim($_POST['username']); // Get the username and password from the POST request
     $password = trim($_POST['password']);

     $username = $conn->real_escape_string($username); // Escape the username and password to prevent SQL injection
     $password = $conn->real_escape_string($password);

     $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'"; // Query the database to check if the username and password are correct
     $result = mysqli_query($conn, $query);

        if ($user = mysqli_fetch_assoc($result)) { //check if the query was successful and if there is exactly one matching user
            $_SESSION['username'] = $user['username']; // Set the username in the session
            if ($user['username'] == 'admin') {
                header('Location: manager.php');
            exit();
            } else {
            header('Location: index.php');
            exit();
            }
        }
        else {
            $_SESSION['error'] = 'Invalid username or password.';
            header('Location: login.php');
            exit();
        }
     }
    

    

  

?>

