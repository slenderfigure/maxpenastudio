<?php
    include 'src/header.php';
    include 'php_fn/fn_signup_inputfield.php';

    if (isset($_SESSION['userId'])) {
        header("Location: userprofile.php");
        exit();
    }
?>
    <main class="main login-main">
        <h5>Log into your account</h5>

        <form action=<?php echo htmlspecialchars("db_files/login.inc.php")?> method="POST" name="loginForm2">
            <div class="row">
                <label for="userid">Username/E-mail</label>
                <?php
                    if (!isset($_GET['userid'])) {
                        echo '<input class="input-2" type="text" name="userid" placeholder="Username/E-mail">';
                    } else {
                        $userid = $_GET['userid'];
                        echo '<input class="input-2" type="text" name="userid" placeholder="Username/E-mail" value="'.$userid.'">';
                    }
                ?>
            </div>
            <div class="row">
                <label for="pswrd">Password</label>
                <input class="input-2" type="password" name="pswrd" placeholder="Password">
            </div>
            <div class="row">
                <button class="btn btn-xl" type="submit" name="login-submit" value="login-submit">Log In</button>
            </div>
        </form>

        <div class="error-box">
        <?php
            include 'php_fn/fn_login_input_error.php';
            login_input_error();
        ?>
        </div>
    </main>

<?php
    include 'src/footer.php';
?>