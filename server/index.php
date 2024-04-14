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
            // update_profile 
            if ($_GET["process"] == "update_profile") {
                $user->update_profile();
            }
            // update_profile 
            // update_profile_picture 
            if ($_GET["process"] == "update_profile_picture") {
                $user->update_profile_picture();
            }
            // update_profile_picture 
        }
        // user 
        // product 
        if ($_GET["action"] == "product") {
            require "./product.php";
            $product = new Product();
            // load_brands 
            if ($_GET["process"] == "load_brands") {
                $product->load_brands();
            }
            // load_brands 
            // load_models 
            if ($_GET["process"] == "load_models") {
                $product->load_models();
            }
            // load_models 
        }
        // product 
    }
}
