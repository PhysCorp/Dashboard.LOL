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
    <title>Dashboard.LOL - UNINSTALLING</title>
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
    $db_config = json_decode(file_get_contents('../private/db_config.json'), true);

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
        $sql = "SELECT user_id FROM users WHERE user_name = ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $_SESSION['username']);
        $stmt->execute() or trigger_error($stmt->error, E_USER_ERROR);
        $result_id = $stmt->get_result();
        $row_id = $result_id->fetch_assoc();
        $user_id = $row_id['user_id'];

        // Get widget_id where app_id = $id
        $sql = "SELECT widget_id FROM appstore WHERE app_id = ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $id);
        $stmt->execute() or trigger_error($stmt->error, E_USER_ERROR);
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $widget_id = $row['widget_id'];

        // Remove widget from added table
        $sql = "DELETE FROM added WHERE user_id = ? AND widget_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $user_id, $widget_id);
        $stmt->execute() or trigger_error($stmt->error, E_USER_ERROR);
        $result = $stmt->get_result();
        
        $_SESSION['toast'] = "App uninstalled successfully!";
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