<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>MAXPENA Studio</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="src/img/favicon-logo.ico">
    <link rel="stylesheet" href="src/css/reset_style.css">
    <link rel="stylesheet" href="src/css/style.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <nav class="main-nav">
        <div class="nav-wrapper wrapper">
            <a class="logo-wrapper" href="index" title="Home">
                <img src="src/img/logo.png" alt="Website Logo">
                <span>MAX-PENA</span>
            </a>

        <?php
            if (!isset($_SESSION['userId'])) {
                echo '
                <form action="db_files/login.inc.php" method="POST"           name="loginForm">
                    <div class="row">
                        <input type="text" name="userid" placeholder="Username/E-mail">
                    </div>
                    <div class="row">
                        <input type="password" name="pswrd" placeholder="Password">
                    </div>
                    <div class="row">
                        <button class="btn btn-l" type="submit" name="login-submit" value="login-submit">Log In</button>
                    </div>
                    <div class="row">
                        <a class="btn btn-l" href="signup">Sign Up</a>
                    </div>                    
                </form>';
            } 
            else {
                include_once 'php_fn/fn_match_records.php';
                echo '
                <div class="my-acct-wrapper">
                    <a href="userprofile" class="my-acct-link" 
                    title="'.matchRecords('name').'">
                        <span>My Account</span>
                        <img class="propic-nav" src="'.matchRecords('img').'" draggable="false">   
                    </a>

                    <button class="btn btn-l" type="button" id="logout-submit">Log Out</button>
                </div>';
            }
        ?>
        </div>
        <form action="db_files/logout.inc.php" method="POST" name="logoutForm">
            <input type="hidden" value="logout-submit" name="logout-submit">
        </form>
    </nav>