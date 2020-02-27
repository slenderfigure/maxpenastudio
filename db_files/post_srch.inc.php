<?php
    if (!isset($_POST['srch-submit'])) {
        header("Location: ../index");
        exit();
    } else {
        $keyword = trim($_POST['srch-item']);
        $_SESSION['keyword'] = "";

        if (!$keyword) {
            session_start();
            unset($_SESSION['keyword']);
            header("Location: ../index?show=allposts");
            exit();
        } else {
            session_start();
            $_SESSION['keyword'] = $keyword;
            header("Location: ../index?searched by $keyword");
        }
    }