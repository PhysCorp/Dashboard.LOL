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
    <title>Dashboard.LOL - Login</title>
    <script src="js/feather.js"></script>
    <script src="js/jquery-3.6.0.min.js"></script>
    <link rel="icon" href="img/favicon.png" />
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
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
                    <a class="nav-link disabled" href="#"><i data-feather="home"></i> Home</a>
                    <a class="nav-link disabled" href="#"><i data-feather="edit"></i> Customize</a>
                    <a class="nav-link disabled" href="#"><i data-feather="download"></i> App Store</a>
                    <a class="nav-link disabled" href="#"><i data-feather="info"></i> About</a>
                    <a class="nav-link disabled" href="#"><i data-feather="user"></i> Profile</a>
                    <a class="nav-link active" href="#"><i data-feather="log-in"></i> Login / Sign Up</a>
                    <a class="nav-link rightmost" href="https://github.com/PhysCorp/Dashboard" target="_blank"><i data-feather="github"></i> GitHub</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="row align-items-md-stretch"
        style="margin-left: 24px; margin-right: 24px; margin-top: 24px; margin-bottom: 12px; padding-top: 72px;">
        <div class="col-md-12" style="margin-top: 12px;">
            <div class="h-100 p-5 bg-light border rounded-3">                
                <h1><i data-feather="log-in"></i> Login</h1>
                <p>Don't have an account? <a href="signup.php">Sign up here</a></p>
                <!-- <a class="btn btn-secondary" href="signup.php" role="button"><i data-feather="user-plus"></i> Sign Up</a> -->

                <form action="actions/login.php" method="post">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input autocomplete="off" type="text" class="form-control" id="username" name="username" placeholder="Username"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input autocomplete="off" type="password" class="form-control" id="password" name="password" placeholder="Password"
                            required>
                    </div>
                    <p>Forgot password? <a href="mailto:physcorp@protonmail.com?subject=Dashboard.LOL%20Password%20Reset%20Request&body=I%20forgot%20my%20password%20to%20Dashboard.LOL.%20Please%20reset%20it%20and%20email%20me%20back.%20Thanks!">Click here</a></p>
                    <div class="d-grid gap-2 d-md-block" style="margin-top: 8px;">
                        <button type="submit" class="btn btn-primary"><i data-feather="user"></i> Login</button>
                    </div>
                </form>
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
                <p style="text-align: center;">Copyright SAD IT GUYS 2022 | Icons retrieved from Feather icons,
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
</body>

</html>