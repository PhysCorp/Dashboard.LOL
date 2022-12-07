<?php
session_start();
// Get username from session
$username = $_SESSION['username'];

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
    $sql = "SELECT * FROM noteapp WHERE user_name = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $note = $row['note'];
        $stmt->close();

        // WRITE HTML HERE
        // echo "<h1> Your note: $note </h1>";
        // echo $note;

    }
    else {
        $stmt->close();
        echo "No note found";
    }
}
else {
    die ("Connection failed: " . mysqli_connect_error());
    echo "Connection failed";
}
?>