<?php
    if (!isset($_POST['update-submit'])) {
        header("Location: ../userprofile?update_status=error");
        exit();
    } else {
        require 'dbh.inc.php';
        session_start();

        $userid     = $_SESSION['userId'];
        $defaultpic = "data/profile_pic/default_profile_image.jpg";

        $picture      = $_FILES['propic'];
        $name         = $picture['name'];
        $tmp_name     = $picture['tmp_name'];
        $error        = $picture['error'];
        $size         = $picture['size'];
        $ext          = strtolower(pathinfo($name, PATHINFO_EXTENSION));
        $allowed_exts = array("jpg", "png", "jpeg");

        if ($error > 0) {
            header("Location: ../userprofile?update_status=error");
            exit();
        }
        elseif (!in_array($ext, $allowed_exts)) {
            header("Location: ../userprofile?update_status=invalid+file");
            exit();
        }
        elseif ($size > 4000000) {
            header("Location: ../userprofile?update_status=file+too+large");
            exit();
        }
        else {
            $path = "../data/profile_pic/";
            $name = "profile_picture_userID__".$userid;
            $fileinfo = glob($path.$name."*");

            if (count($fileinfo) > 0) {
                foreach ($fileinfo as $i) {
                    unlink($i);
                }
            } 

            $destination = $path.$name.".".$ext;
            move_uploaded_file($tmp_name, $destination);

            $destination = str_replace("../", "", $destination);
            $update = "UPDATE tbl_users SET profile_pic = '$destination' WHERE userId = '$userid'";
            $db_conn->query($update);
            
            $db_conn->close();
            header("Location: ../userprofile?update_status=success");
        }
    }