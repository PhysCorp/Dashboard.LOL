<?php
    // Debug
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
    session_start();
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

        // Get results of added table where user_id = $user_id
        $sql = "SELECT * FROM added WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute() or trigger_error($stmt->error, E_USER_ERROR);
        $result = $stmt->get_result();
        $rows = $result->fetch_all(MYSQLI_ASSOC);

        // Get placed_column of widget with widget_id = $id
        $sql = "SELECT placed_column FROM added WHERE user_id = ? AND widget_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $user_id, $id);
        $stmt->execute() or trigger_error($stmt->error, E_USER_ERROR);
        $result_column = $stmt->get_result();
        $row_column = $result_column->fetch_assoc();
        $column = $row_column['placed_column'];

        $column_minus_one = $column - 1;

        // Get widget_id of widget with placed_column = $column - 1
        $sql = "SELECT widget_id FROM added WHERE user_id = ? AND placed_column = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $user_id, $column_minus_one);
        $stmt->execute() or trigger_error($stmt->error, E_USER_ERROR);
        $result_id = $stmt->get_result();
        $row_id = $result_id->fetch_assoc();

        // If widget_id is not null, swap the placed_column values of the two widgets
        if ($row_id['widget_id'] != null) {
            $sql = "UPDATE added SET placed_column = ? WHERE user_id = ? AND widget_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iii", $column_minus_one, $user_id, $id);
            $stmt->execute() or trigger_error($stmt->error, E_USER_ERROR);
            $result = $stmt->get_result();

            $sql = "UPDATE added SET placed_column = ? WHERE user_id = ? AND widget_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iii", $column, $user_id, $row_id['widget_id']);
            $stmt->execute() or trigger_error($stmt->error, E_USER_ERROR);
            $result = $stmt->get_result();
        } else {
            // If widget_id is null, update added table at widget_id = $id, setting placed_column to $column - 1
            $sql = "UPDATE added SET placed_column = ? WHERE user_id = ? AND widget_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iii", $column_minus_one, $user_id, $id);
            $stmt->execute() or trigger_error($stmt->error, E_USER_ERROR);
            $result = $stmt->get_result();
        }

        $_SESSION['toast'] = "Moved widget successfully";
        header('Location: ../index.php?customize=1');
    }
    else {
        die ("Connection failed: " . mysqli_connect_error());
    }

    ?>