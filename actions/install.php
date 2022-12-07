<!DOCTYPE html>
<html lang="en">

<?php
// Debug
// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);
session_start();
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" , shrink-to-fit="no">
    <meta name="description" content="Dashboard.LOL" />
    <meta name="author" content="SAD IT Guys" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard.LOL - INSTALLING</title>
    <script src="../js/feather.js"></script>
    <script src="../js/jquery-3.6.0.min.js"></script>
    <link rel="icon" href="../img/favicon.png" />
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">

<body>
    <!-- Loading spinner -->
    <div id="loading-spinner">
        <div class="spinner-background"></div>
        <!-- Div with spinner icon -->
        <div class="spinner"></div>
    </div>

    <?php
    // If username session var is not set or password is not set, redirect to login page
    if (!isset($_SESSION['username']) || !isset($_SESSION['password'])) {
        header("Location: ../login.php");
    }

    // Get database info from json file in db_config.json
    $db_config = json_decode(file_get_contents('../key/db_config.json'), true);

    // Connect to database
    $host = $db_config['host'];
    $user = $db_config['user'];
    $pass = $db_config['pass'];
    $db = $db_config['db'];
    $port = $db_config['port'];

    $conn = mysqli_connect ($host, $user, $pass, $db, $port);

    if ($conn) {
        // Get ID from get variable
        $id = $_GET['id'];

        // Get user id from database
        $sql = "SELECT user_id FROM users WHERE user_name = '" . $_SESSION['username'] . "' LIMIT 1";
        $result_id = mysqli_query($conn, $sql);
        $row_id = mysqli_fetch_assoc($result_id);
        $user_id = $row_id['user_id'];

        // Get widget_id where app_id = $id
        $sql = "SELECT widget_id FROM appstore WHERE app_id = '$id' LIMIT 1";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $widget_id = $row['widget_id'];

        // Add widget to added table by tranversing through widgets table
        $sql = "INSERT INTO added (user_id, widget_id, placed_column, order_in_column) VALUES ('$user_id', '$widget_id', '0', '0')";
        $result = mysqli_query($conn, $sql);

        $_SESSION['toast'] = "App installed successfully!";
        // echo "<script> window.close(); </script>";
        header('Location: ../apps.php');
    }
    else {
        die ("Connection failed: " . mysqli_connect_error());
    }

    ?>
    <!-- Remove loading spinner with id loading-spinner -->
    <script>
        document.getElementById("loading-spinner").remove();
    </script>
</body>
</html>