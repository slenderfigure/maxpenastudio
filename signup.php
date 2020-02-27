<?php
    include 'src/header.php';
    include 'php_fn/fn_signup_inputfield.php';
?>
    <main class="main signup-main">
        <div class="wrapper">
            <h5>Join Us</h5>

            <form action=<?php echo htmlspecialchars("db_files/signup.inc.php")?> method="POST" name="signupForm">   
                <div class="row">
                    <label for="fname">First Name</label>
                    <?php
                        inputField('fname');
                    ?>
                    <p class="err-msg">Please type in a valid first name</p>
                </div>        

                <div class="row">
                <label for="lname">Last Name</label>
                    <?php
                        inputField('lname');
                    ?>
                    <p class="err-msg">Please type in a valid last name</p>
                </div> 

                <div class="row">
                    <label for="email">E-mail Address</label>
                    <?php
                        inputField('email');
                    ?>
                    <p class="err-msg">Invalid e-mail format</p>
                </div>                

                <div class="row">
                    <label for="username">Username</label>
                    <?php
                        inputField('userid');
                    ?>
                    <p class="err-msg">Invalid username</p>
                </div>

                <div class="row">
                    <label for="pswrd">Password</label>
                    <input class="input-2" type="password" name="pswrd" placeholder="Password">
                    <p class="err-msg">Invalid password format</p>
                </div>
                

                <div class="row">
                    <label for="re-pswrd">Reenter Password</label>
                    <input class="input-2" type="password" name="re-pswrd" placeholder="Re Password">
                    <p class="err-msg">The passwords don't match</p>
                </div>

                <div class="row">
                    <input type="hidden" name="signup-submit" value="signup-submit">
                    <button class="btn btn-xl" type="submit" name="signup-submit" value="signup-submit">Sign Up</button>
                </div>
            </form>

            <div class="error-box">
                <?php
                    include 'php_fn/fn_signup_input_error.php';
                    signup_input_error();
                ?>
            </div>
        </div>
    </main>
<?php
    include 'src/footer.php';
?>