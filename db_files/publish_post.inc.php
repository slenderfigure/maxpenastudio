<?php
    if (!isset($_POST['post-submit'])) {
        header("Location: ../userprofile");
        exit();
    } else {
        require 'dbh.inc.php';
        session_start();

        $userid  = $_SESSION['userId'];
        $subject = ucwords($_POST['subject']);
        $content = str_replace("\r\n", '<br>', $_POST['content']);
        
        if (empty($subject) || empty($content)) {
            header("Location: ../userprofile?post=emptyfields");
            exit();
        } 
        else {
            $insert = "INSERT INTO tbl_posts(subject, content, userId)
            VALUES(?, ?, ?)";

            if (!$stmt = $db_conn->prepare($insert)) {
                header("Location: ../userprofile?sql=error");
                exit();
            } else {
                $stmt->bind_param("ssi", $subject, $content, $userid);
                $stmt->execute();
                header("Location: ../userprofile?post_status=completed");
            }
        }
        $stmt->close();
        $db_conn->close();
    }