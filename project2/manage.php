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
                    <label for="job_ref">Job Reference:</label>
                    <input type="text" id="sort_job_ref" name="sort_job_ref" value="<?php echo $display_job_ref; ?>">

                    <label for="name">Applicant Name:</label>
                    <input type="text" id="sort_name" value="<?php echo $display_name; ?>">

                    <label for="sort_by">Sort By:</label>
                    <select id="sort_by" name="sort_by">
                        <option value="eoi_number" <?php if ($sort_field == 'eoi_number') echo 'selected'; ?>>EOI Number</option>
                        <option value="state" <?php if ($sort_field == 'state') echo 'selected'; ?>>State</option>
                        <option value="status" <?php if ($sort_field == 'status') echo 'selected'; ?>>Status</option>
                    </select>
                    <button type="submit">Apply Filters</button>
                    <a href="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">Reset</a>
                </form>
            </section>
            <section>
                <h2>Application Records List</h2>
                <?php

                ?>
            </section>
        </main>
    </body>
</html>