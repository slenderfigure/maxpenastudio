<?php
    include 'src/header.php';
    include_once 'php_fn/fn_get_all_posts.php';

    $dbh_path = 'db_files/dbh.inc.php';
?>
<main class="usr-main">
<?php
    if (!isset($_SESSION['userId'])) {
        header("Location: index");
        exit();
    }
    echo '<img src="'.matchRecords('img').'" alt="">';
?>    
    <div class="wrapper">
        <section class="container userprofile-container">
            <div class="user-info">
            <?php
                if (isset($_SESSION['userId'])) {
                    echo '
                    <div class="propic-container">
                        <img class="propic" src="'.matchRecords('img').'" draggable="false">
                        
                        <div class="update-pic-overlay">
                            <i class="material-icons">&#xe3b0;</i>
                        </div>
                    </div>';
                    
                    echo '
                    <div class="desc">
                        <p class="username">'.matchRecords('name').'</p>
                        <p><span>Username: @</span>'.matchRecords('usr').'</p>
                        <p><span>E-mail: </span>'.matchRecords('email').'</p>
                    </div>';

                } else {
                    header("Location: index.php");
                    exit();
                }
            ?>
            </div>

            <div class="new-posts-wrapper">
                <h2>Write a new post</h2>

                <form action="db_files/publish_post.inc.php" method="post" name="postForm" id="postForm">
                    <div class="row">
                        <input type="text" name="subject" maxlength="80" placeholder="Subject">
                    </div>
                    <div class="row">
                        <textarea rows="3" maxlength="1100" name="content" form="postForm" placeholder="Content"></textarea>
                        <span class="char-counter">1100/1100</span>
                    </div>
                    <div class="row">
                        <button class="btn" type="submit" value="post-submit" name="post-submit">Post</button>
                    </div>
                </form>
            </div>

            <?php
                if (!count(getAllPosts("crrtUsers")) > 0) {
                    echo '
                    <section class="prev-posts-wrapper">
                        <h3 class="no-posts">Your posts will appear here</h3>
                    </section>';
                } else {
                    echo '<section class="posts prev-posts-wrapper">';
                    foreach(getAllPosts("crrtUsers") as $key => $value) {
                        $subject  = $value['subject'];
                        $content  = $value['content'];
                        $postid   = $value['postId'];
                        $postDate = date("D M jS Y - H:ia", strtotime($value['creation_date']));

                        echo'
                        <article id="'.$postid.'">
                            <div class="exp-menu-wrapper">
                                <i class="postEditBtn material-icons">&#xe5d3;</i>
                                <ul class="editControls">
                                    <li>Edit</li>
                                    <li>Hide</li>
                                    <li>Delete</li>
                                </ul>
                            </div>

                            <h3 class="subject">'.$subject.'</h3>
                            <p class="content">'.$content.'</p>                               
                            <div class="date">
                                <i class="material-icons">&#xe192;</i>
                                <span>'.$postDate.'</span>
                            </div>
                            <hr>
                        </article>';
                    }
                    echo '</section>';

                    echo '
                    <form action="db_files/edit_post.inc.php" method="post" name="editForm" id="editForm">
                        <input type="hidden" name="postid">
                        <input type="hidden" name="option">
                        <input type="hidden" name="post-edit-submit" value="post-edit-submit">
                    </form>';
                }
            ?>
        </section>
    </div>
</main>

<!-- <div class="msgbox-overlay">
    <div class="msgbox update-wrapper">
    <form action="db_files/update_profile_pic.php" 
    method="post" enctype="multipart/form-data" name="updateForm"
    id="updateForm">
        <div class="option-wrapper">
            <label class="update-btn">
                <i class="material-icons">&#xe145;</i>
                <span>Upload Photo</span>
                <input type="file" name="propic">
            </label>
        </div>
        <div class="btn-wrapper">
            <button class="cancel-update" type="button">Cancel</button>
        </div>
    </form>
    </div>

    <div class="preview">
        <i class="close-btn material-icons" title="Close">&#xe5cd;</i>

        <img src="data/profile_pic/profile_picture_userID__1.jpg">

        <button type="submit" name="update-submit" value="update"
        form="updateForm">Update</button>
        </div>
    </div>
</div> -->
<?php
    include 'src/footer.php';
?>