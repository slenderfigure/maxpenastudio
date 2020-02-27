<?php
    function checkAcctLock_Timeout($db_conn, $_userid) {
        $select = "SELECT * FROM tbl_login_attempts WHERE username = '$_userid'";
        $result = mysqli_query($db_conn, $select);
        $resultCheck = mysqli_num_rows($result);

        if (!$resultCheck > 0) {
            return true;
        } 
        else {
            if ($row = mysqli_fetch_assoc($result)) {
                $acctLock = $row['acct_lock'];
                $lastAttDate = $row['last_att_date'];
                $timeout = $row['timeout'];
                $crrDate = date('Y-m-d H:i:s');
                $diff = floor((strtotime($crrDate) - strtotime($lastAttDate))/60);

                if (($diff < $timeout) && ($acctLock == 1)) {
                    return false;
                } 
                else {
                    return true;
                }
            }
        }
    }

    function login_atts_handler($db_conn, $_userid) {
        $select = "SELECT * FROM tbl_login_attempts WHERE username = '$_userid';";
        $result = mysqli_query($db_conn, $select);
        $resultCheck = mysqli_num_rows($result);

        if (!$resultCheck > 0) {
            $insert = "INSERT INTO tbl_login_attempts(username, failed_atts)
            VALUES('$_userid', 1)";
            mysqli_query($db_conn, $insert);
        } 
        else {
            if ($row = mysqli_fetch_assoc($result)) {
                $failedAtts  = $row['failed_atts'];
                $lastAttDate = $row['last_att_date'];
               
                $crrDate = date('Y-m-d H:i:s');
                $diff = floor((strtotime($crrDate) - strtotime($lastAttDate))/60);

                if ($failedAtts >= 4 && $diff <= 120) {
                    $update = "UPDATE tbl_login_attempts SET failed_atts = failed_atts + 1, acct_lock = 1, timeout = 10 WHERE username = '$_userid';";
                    mysqli_query($db_conn, $update);
                } 
                else {
                    $update = "UPDATE tbl_login_attempts SET last_att_date = '$crrDate', failed_atts = failed_atts + 1 WHERE username = '$_userid';";
                    mysqli_query($db_conn, $update);
                }
            }
        }
    }

    function resetTimeout($db_conn, $_userid) {
        $update = "CALL resetAttempts('$_userid');";
        mysqli_query($db_conn, $update);
    }