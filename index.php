<?php
    include 'src/header.php';
    include_once 'php_fn/fn_get_all_posts.php';

    if (!isset($_SESSION['userId'])) {
        echo '
        <div class="banner">
            <div class="header">
                <h2>Show off your work</h2>
            </div>
        </div>';
    }
    else {
        echo '
        <main class="usr-main">
        <img src="'.matchRecords('img').'">
            <div class="wrapper">';
                echo '
                <div class="container index-container">
                    <h2>Find the most recent posts</h2>

                    <form action="db_files/post_srch.inc.php" method="post" name="srchForm">
                        <input type="text" name="srch-item" placeholder="Search by user, real name or subject">
                        <button type="submit" name="srch-submit" value="srch-submit">Search</button>
                    </form>';

                    echo searchedKeyword(count(getAllPosts("all")));

                    echo'
                    <section class="posts posts-wrapper">';
                        foreach(getAllPosts("all") as $key => $value) {
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
                                        <p>'.$fullname.'</p>
                                        <p>@'.$username.'</p>
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
                        }
                    echo '
                        <span class="load-posts">Load more posts..</span>
                    </section>
                </div>
            </div>

            <a href="#" class="goup-btn">
                <i class="material-icons">&#xe5d8;</i>
            </a>
        </main>';
    }
    
    include 'src/footer.php';
?>