<?php
    $db_servername = "localhost";
    $db_username   = "root";
    $db_password   = "Adisonpaque2454!";
    $db_name       = "maxpena";
    
    $db_conn = new mysqli($db_servername, $db_username, $db_password,$db_name);
    $db_conn->set_charset('utf8');
    
    if (!$db_conn) {
        die("Connection failed: ".mysqli_connect_error());
    }