<?php
    function login_input_error() {
        if (isset($_GET['login'])) {
            $error = $_GET['login'];
    
            switch ($error) {
                case 'emptyfields':
                    echo '<p class="error">Enter your username/e-mail and password</p>';
                    break;
    
                case 'invalidusername':
                    echo '<p class="error">Invalid username/e-mail</p>';
                    break;
                
                case 'invalidpassword':
                    echo '<p class="error">Invalid Password</p>';
                    break;

                case 'accountlocked':
                    echo '<p class="error">Sorry. Your account has been locked due to too many failed login attempts. You may retry to login in <strong>10 minutes</strong></p>';
                    break;

                default:
                    echo '<p class="welcome-msg">Thank you for joining us!<br>You can now log into your account</p>';
            }
        }
    }