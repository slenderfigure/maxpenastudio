<?php
    if (isset($_SESSION['userId'])) {
        function matchRecords($value) {
            require 'db_files/dbh.inc.php';

            $userid = $_SESSION['userId'];
            $query = "CALL sp_get_user_info('$userid', NULL)";
            $result = mysqli_query($db_conn, $query);
            $resultCheck = mysqli_num_rows($result);

            if ($resultCheck < 0) {
                header("Location: ../index.php?sql=error");
                exit();
            } else {
                if ($row = mysqli_fetch_assoc($result)) {
                    $record;
                    switch ($value) {
                        case 'img':
                            $record = $row['profile_pic'].'?'.mt_rand();
                            break;
                        
                        case 'name':
                            $record = $row['fullName'];
                            break;
    
                        case 'usr':
                            $record = $row['username'];
                            break;
    
                        case 'email':
                            $record = $row['email_addr'];
                            break;
                    }
                    return $record;
                }
            }
            mysqli_close($db_conn);
        }
    }
?>