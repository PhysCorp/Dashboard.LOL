<!-- REQUIRES: -->
<!-- INTERNAL_NAME, NAME, DESCRIPTION, RATING -->

<?php
// Debug
// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);
session_start();

$username = $_POST['username'];
$password = $_POST['password'];

// Get database info from json file in db_config.json
$db_config = json_decode(file_get_contents('../../private/db_config.json'), true);

// Connect to database
$host = $db_config['host'];
$user = $db_config['user'];
$pass = $db_config['pass'];
$db = $db_config['db'];
$port = $db_config['port'];

if ($username == $user && $password == $pass) {
    $conn = mysqli_connect ($host, $user, $pass, $db, $port);

    if ($conn) {
        // Add a widget to the database, getting name from GET variable
        $widget_name = $_POST['internal_name'];
        $sql = "INSERT INTO widgets (internal_name) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $widget_name);
        $result = $stmt->execute() or trigger_error($stmt->error);

        // Get widget_id where internal_name = $widget_name
        $sql = "SELECT widget_id FROM widgets WHERE internal_name = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $widget_name);
        $stmt->execute() or trigger_error($stmt->error, E_USER_ERROR);
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $widget_id = $row['widget_id'];

        // Add widget to appstore
        $name = $_POST['name'];
        $description = $_POST['description'];
        $rating = $_POST['rating'];
        $ratings_count = 0;
        $count_users_enabled = 0;
        $sql = "INSERT INTO appstore (app_id, widget_id, name, description, ratings_count, rating, count_users_enabled) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iissidi", $widget_id, $widget_id, $name, $description, $ratings_count, $rating, $count_users_enabled);
        $result = $stmt->execute() or trigger_error($stmt->error);
    }
    else {
        die ("Connection failed: " . mysqli_connect_error());
        echo "FAILED - Connection failed";
    }
    $conn->close();
    echo "SUCCESS";
}
else {
    echo "FAILED - Incorrect username or password";
}

?>