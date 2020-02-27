<?php
    if (isset($_POST['login-submit'])) {
        require 'dbh.inc.php';
        include_once '../php_fn/fn_login_atts_err_handler.php';

        $userid = $_POST['userid'];
        $pswrd  = $_POST['pswrd'];

        if (empty($userid) || empty($pswrd)) {
            header("Location: ../login?login=emptyfields");
            exit();
        } 
        else {
            $query = "SELECT userId FROM tbl_users WHERE username=? OR email_addr=?;";

            if (!$stmt = $db_conn->prepare($query)) {
                header("Location: ../index?sql=error");
                exit();
            }
            else {
                $stmt->bind_param("ss", $userid, $userid);
                $stmt->execute();
                $stmt->store_result();
                $resultCheck = $stmt->num_rows();
    
                if (!$resultCheck) {
                    header("Location: ../login?login=invalidusername&userid=$userid");
                    exit();
                } 
                else {
                    if (checkAcctLock_Timeout($db_conn, $userid) == false) {
                        header("Location: ../login?login=accountlocked&userid=$userid");
                        exit();
                    } 
                    
                    else {
                        $query = "SELECT * FROM tbl_users WHERE username=? OR email_addr=?;";

                        if (!$stmt = $db_conn->prepare($query)) {
                            header("Location: ../login?sql=error");
                            exit();
                        } else {
                            $stmt->bind_param("ss", $userid, $userid);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            if ($row = $result->fetch_assoc()) {
                                $hashed_pswrd = password_verify($pswrd, $row['current_pswrd']);
                                
                                if (!$hashed_pswrd) {
                                    login_atts_handler($db_conn, $userid);

                                    header("Location: ../login?login=invalidpassword&userid=$userid");
                                    exit();
                                } else {
                                    session_start();
                                    $_SESSION['userId'] = $row['userId'];
                                    resetTimeout($db_conn, $userid);
                                    
                                    header("Location: ../userprofile");
                                    exit();
                                }
                            }
                        }
                    }
                }
            }
            $stmt->close();
            $db_conn->close();
        }
    } else {
        header("Location: ../login.php");
        exit();
    }