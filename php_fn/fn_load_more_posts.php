<?php
    require '../db_files/dbh.inc.php';
    
    if (isset($_GET['offset'])) {
        $offset = filter_var($_GET['offset'], FILTER_VALIDATE_INT);
    
        $select = "CALL sp_get_user_posts (NULL, $offset);";
        $result = $db_conn->query($select);
        $separator = 0;

        while ($value = $result->fetch_assoc()) {
            if ($value['visibility'] != "HIDDEN") {
                $propic   = $value['profile_pic'];
                $fullname = $value['fullName'];
                $username = $value['username'];
                $subject  = $value['subject'];
                $content  = $value['content'];
                $postDate = date("D M jS Y - H:ia", strtotime($value['creation_date']));

                echo '
                <article>
                    <div class="user-info">
                        <img src="'.$propic.'">
                        
                        <a href="#" class="desc" title="'.$fullname.'">
                            <p class="fullname">'.$fullname.'</p>
                            <p class="username">@'.$username.'</p>
                        </a>
                    </div>
                    <br>
                    <h3 class="subject">'.$subject.'</h3>
                    <p class="content">'.$content.'</p>
                    <div class="date">
                        <i class="material-icons">&#xe192;</i>
                        <span>'.$postDate.'</span>
                    </div>
                    <hr>
                </article>';
                $separator++;
            }
        }
    }