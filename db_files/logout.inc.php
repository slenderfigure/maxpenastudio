<?php
    if(!isset($_POST['logout-submit'])) {
        header('Location: ../index');
        exit();
    } else {
        session_start();
        unset($_SESSION['userId']);
        session_destroy();
        header('Location: ../index?session=ended');
    }