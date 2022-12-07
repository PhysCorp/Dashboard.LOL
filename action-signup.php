<?php
// Debug
// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);
session_start();
// Get info from POST variables
$username = $_POST['username'];
$password = $_POST['password'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$phone_number = $_POST['phone_number'];

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
    // Check if username already exists
    $sql = "SELECT * FROM users WHERE user_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute() or trigger_error($stmt->error);
    $result = $stmt->get_result();
    $numrows = $result->num_rows;

    if ($numrows == 0) {
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // If username does not exist, insert new user into database
        $num_of_columns = 3;
        $sql = "INSERT INTO users (user_name, password, num_of_columns, user_first_name, user_last_name, user_email, user_phone_num) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssissss", $username, $hashed_password, $num_of_columns, $first_name, $last_name, $email, $phone_number);
        $result = $stmt->execute() or trigger_error($stmt->error);
        if ($result) {
            // If username and password are correct, set session variables and redirect to dashboard.php
            $_SESSION['username'] = $username;
            $_SESSION['password'] = $hashed_password;
            $_SESSION['toast'] = "Signup successful. Welcome to Dashboard.lol, $username!";
            $stmt->close();
            header("Location: dashboard.php");
        }
        else {
            // If user is not successfully inserted into database, redirect to signup.php
            $_SESSION['toast'] = "Signup failed";
            $stmt->close();
            header("Location: signup.php");
        }
    }
    else {
        // If username already exists, redirect to login.php
        $_SESSION['toast'] = "Username already exists";
        $stmt->close();
        header("Location: login.php");
    }
}
else {
    die ("Connection failed: " . mysqli_connect_error());
    $_SESSION['toast'] = "Connection failed";
    header('Location: signup.php');
}

?>