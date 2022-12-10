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
    <title>Dashboard.LOL - Profile</title>
    <script src="js/feather.js"></script>
    <script src="js/jquery-3.6.0.min.js"></script>
    <link rel="icon" href="img/favicon.png" />
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
    <!-- Loading spinner -->
    <div id="loading-spinner">
        <div class="spinner-background"></div>
        <!-- Div with spinner icon -->
        <div class="spinner"></div>
    </div>

    <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="navbar-brand" href="#"><img src="./img/favicon.png" alt="" width="32" height="32">
                        Dashboard.LOL</a>
                    <a class="nav-link" href="index.php"><i data-feather="home"></i> Home</a>
                    <a class="nav-link" href="index.php?customize=1"><i data-feather="edit"></i> Customize</a>
                    <a class="nav-link" href="apps.php"><i data-feather="download"></i> App Store</a>
                    <a class="nav-link" href="about.php"><i data-feather="info"></i> About</a>
                    <a class="nav-link active" href="#"><i data-feather="user"></i> Profile</a>
                    <a class="nav-link" href="actions/logout.php"><i data-feather="log-out"></i> Logout</a>
                    <a class="nav-link rightmost" href="https://github.com/PhysCorp/Dashboard" target="_blank"><i data-feather="github"></i> GitHub</a>
                </div>
            </div>
        </div>
    </nav>

    <?php
    // If username session var is not set or password is not set, redirect to login page
    if (!isset($_SESSION['username']) || !isset($_SESSION['password'])) {
        header("Location: login.php");
    }
    ?>

    <?php
    // Get database info from json file in db_config.json
    $db_config = json_decode(file_get_contents('private/db_config.json'), true);

    // Connect to database
    $host = $db_config['host'];
    $user = $db_config['user'];
    $pass = $db_config['pass'];
    $db = $db_config['db'];
    $port = $db_config['port'];

    $conn = mysqli_connect ($host, $user, $pass, $db, $port);

    if ($conn) {
        // Get user info from database
        $username = $_SESSION['username'];
        $sql = "SELECT * FROM users WHERE user_name = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute() or trigger_error($stmt->error);
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
    }
    else {
        die ("Connection failed: " . mysqli_connect_error());
    }

    ?>

    <div class="row align-items-md-stretch"
        style="margin-left: 24px; margin-right: 24px; margin-top: 24px; margin-bottom: 12px; padding-top: 72px;">
        <div class="col-md-12" style="margin-top: 12px; margin-bottom: 128px;">
            <div class="h-100 p-5 bg-light border rounded-3">

                <div class="row align-items-md-stretch">
                    <div class="col-md-12">
                        <div class="h-100 p-5 bg-light border rounded-3">
                            <h2><i data-feather="user"></i> Personal Information</h2>
                            <form action="actions/updateuser.php" method="post">
                                <div class="row align-items-md-stretch" id="viewer_main" name="viewer_main">
                                    <div class="col-md-12">
                                        <input type="hidden" name="username" value="<?php echo $username; ?>">
                                    
                                        <label for="first_name" class="form-label>">First Name</label>
                                        <input type="text" class="form-control" id="first_name" name="first_name"
                                            value="<?php echo $row['user_first_name']; ?>">

                                        <label for="last_name" class="form-label>">Last Name</label>
                                        <input type="text" class="form-control" id="last_name" name="last_name"
                                            value="<?php echo $row['user_last_name']; ?>">
                                        
                                        <label for="email" class="form-label>">Email</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="<?php echo $row['user_email']; ?>">
                                        
                                        <label for="phone_number" class="form-label>">Phone Number</label>
                                        <input type="text" class="form-control" id="phone_number" name="phone_number"
                                            value="<?php echo $row['user_phone_num']; ?>">

                                        <label for="num_of_columns" class="form-label>">Number of Columns</label>
                                        <input type="number" class="form-control" id="num_of_columns" name="num_of_columns"
                                            value="<?php echo $row['num_of_columns']; ?>">
                                        
                                        <button type="submit" class="btn btn-primary" style="margin-top: 12px;"><i data-feather="save"></i> Save</button>
                                        <span style="display: inline-block; width: 6px;"></span>
                                        <a href="index.php" class="btn btn-secondary" style="margin-top: 12px;"><i data-feather="x"></i> Cancel</a>
                                        <span style="display: inline-block; width: 6px;"></span>
                                        <a href="mailto:physcorp@protonmail.com?subject=Dashboard.LOL%20Account%20Deletion%20Request&body=Hello%2C%0D%0A%0D%0APlease%20delete%20my%20user%20account%20for%20Dashboard.LOL%0D%0A%0D%0AThanks." class="btn btn-danger" style="margin-top: 12px;"><i data-feather="trash-2"></i> Request Account Deletion</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="toast-container p-3" style="z-index: 999; bottom: 0; right: 0; position: fixed;">
        <?php
        if (isset($_SESSION['toast']) && $_SESSION['toast'] != "") {
            echo '<div class="toast show align-items-center bg-primary text-white border-0 bottom-0 end-0" role="alert" aria-live="assertive" aria-atomic="true">';
            echo '<div class="d-flex">';
            echo '<div class="toast-body">';
            echo $_SESSION["toast"];
            echo '</div>';
            echo '<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>';
            echo '</div>';
            echo '</div>';
            $_SESSION['toast'] = "";
        }
        ?>
    </div>

    <script src="./js/bootstrap.bundle.min.js"></script>

    <footer class="footer mt-auto py-3 bg-dark">
        <div class="container">
            <span class="text-muted">
                <p style="text-align: center;">Copyright PHYSCORP 2022 | Icons retrieved from Feather icons,
                    which is under
                    the MIT license <span class="badge bg-secondary">VER 22.12.0</span></p>
            </span>
        </div>
        <div class="row align-items-md-stretch">
            <div class="col-md-12">
                <div class="h-100 p-5 bg-light border rounded-3" style="margin-bottom: 24px;">
                    <h2 id="contact">PHYSCORP</h2>
                    
                    <a href="mailto:physcorp@protonmail.com" target="_blank" style="float: left;"><i
                            data-feather="mail"></i> Email (physcorp@protonmail.com)</a>
                    <a href="tel:810-412-8751" target="_blank" style="float: left; margin-left: 12px;"><i
                            data-feather="phone"></i> Phone (810-412-8751)</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        feather.replace()
    </script>

    <!-- Remove loading spinner with id loading-spinner -->
    <script>
        document.getElementById("loading-spinner").remove();
    </script>
</body>

</html>