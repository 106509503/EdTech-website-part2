<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Fill out our application form to join our team!">
    <meta name="keywords" content="apply, application form, join our team, careers">
    <meta name="authors" content="Ton Hoang Do, David Tucker, Myles McCarthy and Oscar Hill">
    <link rel="stylesheet" href="styles/pagestyle.css">
    <link rel="stylesheet" href="styles/jobs-layout.css">
    <title>Login</title>
    <style>
    .center-form {
        text-align: center;
    }
    </style>
</head>

<body>
    <?php include 'extrafiles/header.inc'; 
    include 'extrafiles/nav.inc';
    require_once "extrafiles/settings.php";
    ?>

    <form method="post" action="Process.php" class="center-form">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>
        <label for="password">Password:</label>
        <input type="password" id = "password" name="password" required><br>
        <input type="hidden" name="token" value="123456789">
        <input type="submit" value="Login">
    </form>
   <?php
    include 'extrafiles/footer.inc';
    ?>  
</body>

</html>