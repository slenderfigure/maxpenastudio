<?php
    function getAllPosts($_type) {
        require 'db_files/dbh.inc.php';

        $arr = array();

        switch ($_type) {
            case 'crrtUsers':
                $userid = $_SESSION['userId'];
                $select = "SELECT * FROM tbl_posts WHERE userId = '$userid' ORDER BY creation_date DESC LIMIT 5";
                $result = mysqli_query($db_conn, $select);
                break;
            
            case 'all':
                /**CALL sp_get_user_posts ([Keyword], [Offset]) */
                if (isset($_SESSION['keyword'])) {
                    $keyword = $_SESSION['keyword'];
                    $select = "CALL sp_get_user_posts (?, 0);";
                    $stmt = $db_conn->prepare($select);
                    $stmt->bind_param("s", $keyword);
                    $stmt->execute();
                } 
                else {
                    $select = "CALL sp_get_user_posts (NULL, 0);";
                    $stmt = $db_conn->prepare($select);
                    $stmt->execute();
                }
                $result = $stmt->get_result();
                break;
        }
        while ($row = $result->fetch_assoc()) {
            if ($row['visibility'] != "HIDDEN") {
                array_push($arr, $row);
            }
        }
        $db_conn->close();
        return $arr;
    }

    function searchedKeyword($num) {
        if (isset($_SESSION['keyword'])) {
            $keyword = $_SESSION['keyword'];
            return '<span class="keyword">Searched as "'.$keyword.'".&#160;&#160;Results: '.$num.'</span>';
        } else {
            return '<span class="keyword"></span>';
        }
    }
?>