<?php
    function signup_input_error() {
        if (isset($_GET['signup'])) {
            $error = $_GET['signup'];
    
            switch ($error) {
                case 'useridinuse':
                    echo '<p class="error">This username/email is already in use</p>';
                    break;
            }
        }
    }