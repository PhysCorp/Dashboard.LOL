<?php
// Debug
// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);
session_start();
// Get username from POST variable
$username = $_POST['username'];

// Get password from POST variable
$password = $_POST['password'];

// Get database info from json file in db_config.json
$db_config = json_decode(file_get_contents('key/db_config.json'), true);

// Connect to database
$host = $db_config['host'];
$user = $db_config['user'];
$pass = $db_config['pass'];
$db = $db_config['db'];
$port = $db_config['port'];
// $port = 3344;

$conn = mysqli_connect ($host, $user, $pass, $db, $port);

if ($conn) {
    // Check if username and password are correct
    // $sql = "SELECT * FROM users WHERE user_name = '$username' AND password = '$password' LIMIT 1";
    // $result = mysqli_query($conn, $sql);
    // $numrows = mysqli_num_rows($result);
    $sql = "SELECT * FROM users WHERE user_name = ? AND password = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    $numrows = $result->num_rows;

    if ($numrows == 1) {
        // If username and password are correct, set session variables and redirect to dashboard.php
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;
        $conn->close();
        header("Location: dashboard.php");
    }
    else {
        // If username and password are incorrect, redirect to login.php
        $_SESSION['toast'] = "Username or password is incorrect";
        $conn->close();
        header("Location: login.php");
    }
}
else {
    die ("Connection failed: " . mysqli_connect_error());
    $_SESSION['toast'] = "Connection failed";
    header('Location: login.php');
}

?>