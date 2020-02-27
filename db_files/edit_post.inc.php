<?php
    require 'dbh.inc.php';

    $option  = $_POST['option'];
    $postid  = $_POST['postid'];
    $subject = ucwords($_POST['subject']);
    $content = str_replace("\r\n", '<br>', $_POST['content']);

    switch ($option) {
        case 'edit':
            $query = "CALL sp_modify_post(?, ?, ?, ?);";
            break;

        case 'hide':
        case 'delete':
            $query = "CALL sp_modify_post(?, ?, NULL, NULL);";
    }

    if (!$stmt = $db_conn->prepare($query)) {
        header("Location: ../userprofile?sql=error");
    } else {
        if ($option == "edit") {
            $stmt->bind_param("siss", $option, $postid, $subject, $content);
        } 
        elseif ($option == "hide" || $option == "delete") {
            $stmt->bind_param("si", $option, $postid);
        }
    }
    $stmt->execute();
    $stmt->close();
    $db_conn->close();
    header("Location: ../userprofile");