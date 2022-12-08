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
    <title>Dashboard.LOL - About</title>
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
                    <a class="nav-link" href="index.php"><i data-feather="home"></i><br>Home</a>
                    <a class="nav-link" href="index.php?customize=1"><i data-feather="edit"></i><br>Customize</a>
                    <a class="nav-link" href="apps.php"><i data-feather="download"></i><br>App Store</a>
                    <a class="nav-link active" href="#"><i data-feather="info"></i><br>About</a>
                    <a class="nav-link" href="actions/logout.php"><i data-feather="log-out"></i><br>Logout</a>
                    <a class="nav-link rightmost" href="https://github.com/PhysCorp/Dashboard" target="_blank"><i data-feather="github"></i><br>GitHub</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="row align-items-md-stretch"
        style="margin-left: 24px; margin-right: 24px; margin-top: 24px; margin-bottom: 12px; padding-top: 72px;">
        <div class="col-md-12" style="margin-top: 12px; margin-bottom: 128px;">
            <div class="h-100 p-5 bg-light border rounded-3">

                <div class="row align-items-md-stretch">
                    <div class="col-md-12">
                        <div class="h-100 p-5 bg-light border rounded-3">
                            <h2><i data-feather="info"></i> About Dashboard.LOL:</h2>
                            <p>
                                Every day, people consume a wide variety of information online. Rather than viewing
                                multiple different sources, our software serves as a convenient way to pull and organize
                                statistics into a single webpage that users can visit; it saves time and effort to have
                                a customizable, centralized dashboard where you can view and organize all of the
                                information that you frequently access.
                                Our software provides an intuitive interface for you to consume information from
                                multiple different sources. The database is an essential component to remembering the
                                layouts of each user, widgets that they’ve enabled, and stored user credentials. Users
                                can choose from a variety of prebuilt widgets available on our website’s app store,
                                located as a separate component to our database.
                            </p>
                            <break>
                            <h2><i data-feather="users"></i> About the Developers:</h2>
                            <p>
                                We are the SAD IT Guys, two students from Oakland University, studying Information Technology and Computer Science. We are both very passionate about technology and software development, and we hope to continue to develop our skills and knowledge in the future.
                            </p>
                            <break>
                            <h2><i data-feather="github"></i> About the GitHub Repository:</h2>
                            <p>
                                The GitHub repository for this project can be found at <a href="https://www.github.com/PhysCorp/Dashboard" target="_blank">https://www.github.com/PhysCorp/Dashboard</a>. The repository contains the source code for the website, as well as the source code for the database. The website is written in PHP, HTML, and CSS, and the database is written in MySQL.
                            </p>
                            <break>
                            <h2><i data-feather="info"></i> Licensing:</h2>
                            <p>
                                Copyright SAD IT GUYS 2022 | This project is licensed under the MIT License. The full license can be found in the GitHub repository. Icons retrieved from Feather icons, which is under the MIT license.
                            </p>
                            
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

    <!-- Remove loading spinner with id loading-spinner -->
    <script>
        document.getElementById("loading-spinner").remove();
    </script>
</body>

</html>