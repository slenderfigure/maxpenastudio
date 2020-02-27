<?php
    function inputField($type) {
        switch ($type) {
            case 'fname':
                if (isset($_GET['fname'])) {
                    $fname = $_GET['fname'];

                    echo '<input class="input-2" type="text" name="fname" placeholder="First Name" value="'.$fname.'">';
                } else {
                    echo '<input class="input-2" type="text" name="fname" placeholder="First Name">';
                }
                break;

            case 'lname':
                if (isset($_GET['lname'])) {
                    $lname = $_GET['lname'];

                    echo '<input class="input-2" type="text" name="lname" placeholder="Last Name" value="'.$lname.'">';
                } else {
                    echo '<input class="input-2" type="text" name="lname" placeholder="Last Name">';
                }
                break;

            case 'email':
                if (isset($_GET['email'])) {
                    $email = $_GET['email'];

                    echo '<input class="input-2" type="text" name="email" placeholder="email@domain.com" value="'.$email.'">';
                } else {
                    echo '<input class="input-2" type="text" name="email" placeholder="email@domain.com">';
                }
                break;

            case 'userid': 
                if (isset($_GET['user'])) {
                    $user = $_GET['user'];

                    echo '<input class="input-2" type="text" name="username" placeholder="Username" value="'.$user.'">';
                } else {
                    echo '<input class="input-2" type="text" name="username" placeholder="Username">';
                }
                break;
        }
    }