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
    <title>Dashboard.LOL - App Store</title>
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
                    <a class="nav-link active" href="#"><i data-feather="download"></i> App Store</a>
                    <a class="nav-link" href="about.php"><i data-feather="info"></i> About</a>
                    <a class="nav-link" href="actions/logout.php"><i data-feather="log-out"></i> Logout</a>
                    <a class="nav-link rightmost" href="https://github.com/PhysCorp/Dashboard" target="_blank"><i
                            data-feather="github"></i> GitHub</a>
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
        // Get all apps from database
        $sql = "SELECT * FROM appstore";
        $stmt = $conn->prepare($sql);
        $stmt->execute() or trigger_error($stmt->error, E_USER_ERROR);
        $result_apps = $stmt->get_result();

        // Get user id from database
        $sql = "SELECT user_id FROM users WHERE user_name = ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $_SESSION['username']);
        $stmt->execute() or trigger_error($stmt->error, E_USER_ERROR);
        $result_id = $stmt->get_result();
        $row_id = $result_id->fetch_assoc();
        $user_id = $row_id['user_id'];
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
                            <div class="row align-items-md-stretch">
                                <div class="col-md-8">
                                    <h2><i data-feather="download"></i> Available Widgets:</h2>
                                </div>
                                <div class="col-md-4">
                                    <div class="flexbox">
                                        <input class="form-control" id="search" type="text"
                                            placeholder="Search for a widget ..." style="margin-left: 10px;">
                                    </div>
                                </div>
                            </div>
                            <?php
                            // Loop through result_apps and display each app
                            $current_col = 0;
                            echo '<div class="container">';
                            while ($row = mysqli_fetch_assoc($result_apps)) {
                                // While $current_col is less than 3
                                if ($current_col < 3) {
                                    // If $current_col is 0, start a new row
                                    if ($current_col == 0) {
                                        echo '<div class="row">';
                                    }
                                    // Display app
                                    echo '<div class="col">';
                                    echo '<div class="card">';
                                    echo '<h5 class="card-header"><i data-feather="git-commit"></i> ' . $row['name'] . '</h5>';
                                    echo '<div class="card-body">';
                                    echo '<p class="card-text">' . $row['description'] . '</p>';

                                    // Check if widget_id and user_id are in the added table
                                    $sql = "SELECT * FROM added WHERE widget_id = ? AND user_id = ?";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->bind_param("ii", $row['app_id'], $user_id);
                                    $stmt->execute() or trigger_error($stmt->error, E_USER_ERROR);
                                    $result_added = $stmt->get_result();
                                    $row_added = $result_added->fetch_assoc();

                                    // If widget_id and user_id are in the added table, display remove button
                                    if ($row_added) {
                                        echo '<p><a class="btn btn-danger" href="actions/uninstall.php?id=' . $row['app_id'] . '">Remove</a></p>';
                                    }
                                    else {
                                        echo '<p><a class="btn btn-primary" href="actions/install.php?id=' . $row['app_id'] . '">Install</a></p>';
                                    }
                                    
                                    echo '</div>';
                                    echo '</div>';
                                    echo '</div>';

                                    // Increment $current_col
                                    $current_col++;
                                    // If $current_col is 3, end the row
                                    if ($current_col == 3) {
                                        echo '</div>';
                                        // Reset $current_col
                                        $current_col = 0;
                                    }
                                }
                            }
                            echo '</div>';

                            ?>

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

    <!-- Search bar -->
    <script>
        $(document).ready(function () {
            $("#search").on("keyup", function () {
                var value = $(this).val().toLowerCase();
                $(".card").filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>

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

    <!-- Close the connection -->
    <?php
    $conn->close();
    ?>

    <!-- Remove loading spinner with id loading-spinner -->
    <script>
        document.getElementById("loading-spinner").remove();
    </script>
</body>

</html>