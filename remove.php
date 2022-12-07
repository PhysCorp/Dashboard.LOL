<?php
    // Debug
    // ini_set('display_errors', '1');
    // ini_set('display_startup_errors', '1');
    // error_reporting(E_ALL);
    session_start();
    // If username session var is not set or password is not set, redirect to login page
    if (!isset($_SESSION['username']) || !isset($_SESSION['password'])) {
        header("Location: login.php");
    }

    // Get database info from json file in db_config.json
    $db_config = json_decode(file_get_contents('key/db_config.json'), true);

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

        // Update added table at widget_id = $id, setting placed_column to 0
        $sql = "UPDATE added SET placed_column = 0 WHERE user_id = ? AND widget_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $user_id, $id);
        $stmt->execute() or trigger_error($stmt->error, E_USER_ERROR);
        $result = $stmt->get_result();

        $_SESSION['toast'] = "App removed successfully";
        // echo "<script> window.close(); </script>";
        header('Location: dashboard.php?customize=1');
    }
    else {
        die ("Connection failed: " . mysqli_connect_error());
    }

    ?>