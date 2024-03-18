<?php
if (isset($_GET["action"])) {
    if (isset($_GET["process"])) {
        // user 
        if ($_GET["action"] == "user") {
            require "./user.php";
            $user = new User();
            // signup 
            if ($_GET["process"] == "signup") {
                $user->signup();
            }
            // signup 
            // signin 
            if ($_GET["process"] == "signin") {
                $user->signin();
            }
            // signin 
            // signout 
            if ($_GET["process"] == "signout") {
                $user->signout();
            }
            // signout
            // send_reset_token 
            if ($_GET["process"] == "send_reset_token") {
                $user->send_reset_token();
            }
            // send_reset_token 
            // reset_password 
            if ($_GET["process"] == "reset_password") {
                $user->reset_password();
            }
            // reset_password 
        }
        // user 
    }
}
