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
            // manage_locations_worldwide 
            if ($_GET["process"] == "manage_locations_worldwide") {
                $product->manage_locations_worldwide();
            }
            // manage_locations_worldwide 
            // manage_locations_countries 
            if ($_GET["process"] == "manage_locations_countries") {
                $product->manage_locations_countries();
            }
            // manage_locations_countries 
            // manage_locations_none 
            if ($_GET["process"] == "manage_locations_none") {
                $product->manage_locations_none();
            }
            // manage_locations_none 
            // manage_shipping_type_flat 
            if ($_GET["process"] == "manage_shipping_type_flat") {
                $product->manage_shipping_type_flat();
            }
            // manage_shipping_type_flat 
            // manage_shipping_type_custom 
            if ($_GET["process"] == "manage_shipping_type_custom") {
                $product->manage_shipping_type_custom();
            }
            // manage_shipping_type_custom 
            // manage_shipping_type_none 
            if ($_GET["process"] == "manage_shipping_type_none") {
                $product->manage_shipping_type_none();
            }
            // manage_shipping_type_none 
            // list_product 
            if ($_GET["process"] == "list_product") {
                $product->list_product();
            }
            // list_product 
        }
        // product 
    }
}
