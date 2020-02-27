<?php
    function toCapitalize($str) {
        $str = strtolower($str);
        $str = ucwords($str);
        return $str;
    }

    if (isset($_POST['signup-submit'])) {
        require 'dbh.inc.php';

        $fname    = toCapitalize($_POST['fname']);
        $lname    = toCapitalize($_POST['lname']);
        $email    = strtoLower($_POST['email']);
        $username = strtoLower($_POST['username']);
        $pswrd    = $_POST['pswrd'];
        $repswrd  = $_POST['re-pswrd'];
        
        if (empty($fname)    ||
            empty($lname)    ||
            empty($email)    ||
            empty($username) ||
            empty($pswrd)    ||
            empty($repswrd)) {
            
            header("Location: ../signup?signup=empty&fname=$fname&lname=$lname&email=$email&user=$username");    
            exit();
        }

        /** All input fields are being validated 
        *   using ReGex through JavaScript! **/

        else {
            $defaultpic = 'data/profile_pic/default_profile_image.jpg';
            $select = "SELECT username FROM tbl_users WHERE username=? OR email_addr=?";

            if (!$stmt = $db_conn->prepare($select)) {
                header("Location: ../signup?sql=error");    
                exit();
            } 
            else {
                $stmt->bind_param("ss", $username, $email);
                $stmt->execute();
                $stmt->store_result();
                $resultCheck = $stmt->num_rows();
                
                if ($resultCheck > 0) {
                    header("Location: ../signup?signup=useridinuse&fname=$fname&lname=$lname&email=$email&user=$username");
                    exit();
                } else {
                    $insert = "INSERT INTO tbl_users(firstName, lastName, profile_pic, email_addr, username, current_pswrd)
                    VALUES(?, ?, ?, ?, ?, ?)";
                    
                    if (!$stmt = $db_conn->prepare($insert)) {
                        header("Location: ../signup?sql=error");    
                        exit();
                    } else {
                        $hashed_pswrd = password_hash($pswrd, PASSWORD_BCRYPT);
                        $stmt->bind_param("ssssss", $fname, $lname, $defaultpic, $email, $username, $hashed_pswrd);
                        $stmt->execute();

                        header("Location: ../login?login=signup+complete"); 
                    }
                }
            }
            $stmt->close();
            $db_conn->close();
        }
    } else {
        header("Location: ../signup");    
        exit();
    }