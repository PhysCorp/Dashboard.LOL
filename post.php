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

// Get the widget internal name from POST variable
$internal_name = $_POST['internal_name'];

// Get data from POST variable
$data = $_POST['data'];

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
    // Check if $username matches $user and $password matches $pass
    if ($username == $user && $password == $pass) {
        // Update data_dump where internal_name = $internal_name in widgets table
        $sql = "UPDATE widgets SET data_dump = ? WHERE internal_name = ?";
        $sql = $conn->prepare($sql);
        $sql->bind_param("ss", $data, $internal_name);
        $sql->execute();

        if ($sql) {
            echo "SUCCESS";
        } else {
            echo "FAILED - " . mysqli_error($conn);
        }
    } else {
        echo "FAILED - Insufficient credentials";
    }
    
}
else {
    echo "FAILED - Connection to database failed";
    die ("Connection failed: " . mysqli_connect_error());
}

$conn->close();
?>
