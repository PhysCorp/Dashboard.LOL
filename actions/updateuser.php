<?php
// Debug
// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);

session_start();
$username = $_SESSION['username'];

// Get info from POST variables
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$phone_number = $_POST['phone_number'];
$num_of_columns = $_POST['num_of_columns'];
$num_of_columns = (int)$num_of_columns;

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
    // Update user info
    $sql = "UPDATE users SET user_first_name = ?, user_last_name = ?, user_email = ?, user_phone_num = ?, num_of_columns = ? WHERE user_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssis", $first_name, $last_name, $email, $phone_number, $num_of_columns, $username);
    $stmt->execute() or trigger_error($stmt->error);
    $stmt->close();

    // Redirect to userinfo.php
    $_SESSION['toast'] = "Successfully updated user info";
    header("Location: ../profile.php");
}
else {
    die ("Connection failed: " . mysqli_connect_error());
}

?>
