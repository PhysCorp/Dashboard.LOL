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
    <title>Dashboard.LOL - Home</title>
    <script src="js/feather.js"></script>
    <script src="js/jquery-3.6.0.min.js"></script>
    <link rel="icon" href="img/favicon.png" />
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">

    <style>
        body {
            background-color: #000000;
            background-image: url("./img/Background.png");
        }

        .center {
            display: block;
            margin-left: auto;
            margin-right: auto;
            width: 50%;
        }

        .rightmost {
            position: absolute;
            top: 8px;
            right: 16px;
        }

        .leftmost {
            position: absolute;
            top: 8px;
            left: 16px;
        }

        .form-group {
            margin-top: 8px;
        }

        .navbar-brand {
            padding: 12px;
        }

        .col-md-4 {
            margin-bottom: 8px;
        }
    </style>
</head>

<body>
    <!-- Loading spinner -->
    <div id="loading-spinner">
        <div class="spinner-background"></div>
        Div with spinner icon
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
                    <!-- Check if GET var "customize" is set to 1 -->
                    <?php if (isset($_GET['customize']) && $_GET['customize'] == 1) { 
                        echo '<a class="nav-link" href="dashboard.php"><i data-feather="home"></i><br>Home</a>';
                        echo '<a class="nav-link active" href="dashboard.php?customize=1"><i data-feather="edit"></i><br>Customize</a>';
                    } else {
                        echo '<a class="nav-link active" href="dashboard.php"><i data-feather="home"></i><br>Home</a>';
                        echo '<a class="nav-link" href="dashboard.php?customize=1"><i data-feather="edit"></i><br>Customize</a>';
                    } ?>
                    <a class="nav-link" href="apps.php"><i data-feather="download"></i><br>App Store</a>
                    <a class="nav-link" href="about.php"><i data-feather="info"></i><br>About</a>
                    <a class="nav-link" href="logout.php"><i data-feather="log-out"></i><br>Logout</a>
                    <a class="nav-link rightmost" href="https://github.com/PhysCorp" target="_blank"><i
                            data-feather="github"></i><br>GitHub</a>
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
    $db_config = json_decode(file_get_contents('key/db_config.json'), true);

    // Connect to database
    $host = $db_config['host'];
    $user = $db_config['user'];
    $pass = $db_config['pass'];
    $db = $db_config['db'];
    $port = $db_config['port'];

    $conn = mysqli_connect ($host, $user, $pass, $db, $port);

    if ($conn) {
        // Get user id from database
        $sql = "SELECT user_id FROM users WHERE user_name = ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $_SESSION['username']);
        $stmt->execute() or trigger_error($stmt->error, E_USER_ERROR);
        $result_id = $stmt->get_result();
        $row_id = $result_id->fetch_assoc();
        $user_id = $row_id['user_id'];

        // Get user from database
        $sql = "SELECT * FROM users WHERE user_id = ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute() or trigger_error($stmt->error, E_USER_ERROR);
        $result_user = $stmt->get_result();
        $row_user = $result_user->fetch_assoc();

        // Get num_of_columns from database
        $sql = "SELECT num_of_columns FROM users WHERE user_id = ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute() or trigger_error($stmt->error, E_USER_ERROR);
        $result_col = $stmt->get_result();
        $row_col = $result_col->fetch_assoc();
        $num_of_columns = $row_col['num_of_columns'];

        // Get the entire "added" table from database
        $sql = "SELECT * FROM added WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute() or trigger_error($stmt->error, E_USER_ERROR);
        $result_1st_added = $stmt->get_result();

        // Get the entire "added" table from database
        $sql = "SELECT * FROM added WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute() or trigger_error($stmt->error, E_USER_ERROR);
        $result_2nd_added = $stmt->get_result();

        // Join the appstore, added, and widget tables on widget_id
        $sql = "SELECT * FROM appstore INNER JOIN added ON appstore.widget_id = added.widget_id INNER JOIN widgets ON added.widget_id = widgets.widget_id WHERE user_id = ? ORDER BY added.placed_column ASC";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute() or trigger_error($stmt->error, E_USER_ERROR);
        $result_join = $stmt->get_result();
    }
    else {
        die ("Connection failed: " . mysqli_connect_error());
    }

    ?>

    <div class="row align-items-md-stretch"
        style="margin-left: 24px; margin-right: 24px; margin-top: 24px; margin-bottom: 12px; padding-top: 72px;">
        <div class="col-md-12" style="margin-top: 12px; margin-bottom: 128px;">
            <div class="h-100 p-5 bg-light border rounded-3">

                <?php
                    echo "<h3>Welcome, " . $row_user["user_first_name"] . " " . $row_user["user_last_name"] . "</h3>";
                ?>

                <div class="row align-items-md-stretch">
                    <div class="col-md-12">
                        <div class="h-100 p-5 bg-light border rounded-3">
                            <h2><i data-feather="database"></i> Dashboard:</h2>
                            <?php
                            // If customize mode is enabled, show the customize form later
                            if (isset($_GET['customize']) && $_GET['customize'] == 1) {
                                echo '<div class="form-check"><input class="form-check-input" type="checkbox" value="" id="autorefresh"><label class="form-check-label" for="autorefresh">Refresh page every min</label></div>';
                                echo '<div class="alert alert-warning" role="alert"><h5><i data-feather="edit-2"></i> You are currently customizing the dashboard</h5>';
                                echo "<button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#widgetaddmodal'><i data-feather='plus-square'></i> Modify Widget</button>";
                                echo "</div>";
                            }
                            else {
                                echo '<div class="form-check"><input class="form-check-input" type="checkbox" value="" id="autorefresh" checked><label class="form-check-label" for="autorefresh">Refresh page every min</label></div>';
                            }

                            // Loop through result_apps and display each app
                            $current_col = 0;
                            echo '<div class="container">';

                            while ($row_added = mysqli_fetch_assoc($result_1st_added)) {
                                // While $current_col is less than $num_of_columns
                                if ($current_col < $num_of_columns) {
                                    // If $current_col is 0, start a new row
                                    if ($current_col == 0) {
                                        echo '<div class="row">';
                                    }

                                    $row_join = mysqli_fetch_assoc($result_join);

                                    // Display widget
                                    if ($row_join['placed_column'] != 0) {
                                        echo '<div class="col">';
                                        echo '<div class="card">';
                                        echo '<h5 class="card-header"><i data-feather="git-commit"></i> ' . $row_join['name'] . '</h5>';
                                        echo '<div class="card-body">';
                                        if (isset($_GET['customize']) && $_GET['customize'] == 1) {
                                            echo '<p class="card-text">' . $row_join['description'] . '</p>';
                                        }
                                        echo $row_join['data_dump'];
                                        // echo '<p><a class="btn btn-primary" target="_blank" href="actions/install.php?id=' . $row['app_id'] . '">Install</a></p>';
                                        echo '</div>';
                                        echo '</div>';
                                        echo '</div>';
                                    }

                                    // Increment $current_col
                                    $current_col++;
                                    // If $current_col is $num_of_columns, end the row
                                    if ($current_col == $num_of_columns) {
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


    <div class="modal fade" id="widgetaddmodal" tabindex="-1" aria-labelledby="widgetaddmodallabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="widgetaddmodallabel">Add a Widget</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Please select a widget from the list to add:</p>
                    <ul class="list-group">
                        <?php
                        // For each widget_id in the added table, navigate through widgets table and appstore table, displaying each widget name
                        while ($row_added = mysqli_fetch_assoc($result_2nd_added)) {
                            // echo '<li class="list-group-item">' . $row_added['widget_id'] . '</li>';
                            $widget_id = $row_added['widget_id'];
                            $sql = "SELECT * FROM appstore WHERE widget_id = ? LIMIT 1";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("s", $widget_id);
                            $stmt->execute() or trigger_error($stmt->error, E_USER_ERROR);
                            $result_appstore = $stmt->get_result();
                            $row_appstore = $result_appstore->fetch_assoc();

                            // If row_added["placed_column"] is not 0
                            if ($row_added['placed_column'] == 0) {
                                echo '<li class="list-group-item"><a style="" href="add.php?id=' . $widget_id . '"><i data-feather="plus-square"></i> ' . $row_appstore['name'] . '</a></li>';
                            }
                            else {
                                echo '<li class="list-group-item"><a style="" href="remove.php?id=' . $widget_id . '"><i data-feather="minus-square"></i> ' . $row_appstore['name'] . '</a></li>';
                            }
                            
                        }
                        ?>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
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

    <!-- <footer class="footer mt-auto py-3 bg-dark fixed-bottom">
        <div class="container">
            <span class="text-muted">
                <p style="text-align: center;">Copyright SAD IT GUYS 2022 | Icons retrieved from Feather icons,
                    which is under
                    the MIT license <span class="badge bg-secondary">VER 22.10.2</span></p>
            </span>
        </div>
    </footer> -->

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

    <!-- Refresh page every 60 seconds -->
    <script>
        // If autorefresh is checked, refresh page every 60 seconds
        setInterval(function () {
            var autorefresh = document.getElementById("autorefresh");
            if (autorefresh.checked) {
                location.reload();
            }
        }, 60000);
    </script>

</body>

</html>