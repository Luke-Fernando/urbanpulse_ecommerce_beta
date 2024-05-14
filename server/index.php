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
            // manage_cost_locations 
            if ($_GET["process"] == "manage_cost_locations") {
                $product->manage_cost_locations();
            }
            // manage_cost_locations 
            // list_product 
            if ($_GET["process"] == "list_product") {
                $product->list_product();
            }
            // list_product 
        }
        // product 
        // cart
        if ($_GET["action"] == "cart") {
            require "./cart.php";
            $cart = new Cart();
            // add_to_cart 
            if ($_GET["process"] == "add_to_cart") {
                $cart->add_to_cart();
            }
            // add_to_cart 
            // remove_from_cart 
            if ($_GET["process"] == "remove_from_cart") {
                $cart->remove_from_cart();
            }
            // remove_from_cart 
            // cart_to_wishlist 
            if ($_GET["process"] == "cart_to_wishlist") {
                $cart->cart_to_wishlist();
            }
            // cart_to_wishlist 
            // decrease_cart_quantity 
            if ($_GET["process"] == "decrease_cart_quantity") {
                $cart->decrease_cart_quantity();
            }
            // decrease_cart_quantity 
            // increase_cart_quantity 
            if ($_GET["process"] == "increase_cart_quantity") {
                $cart->increase_cart_quantity();
            }
            // increase_cart_quantity 
        }
        // cart
        // wishlist
        if ($_GET["action"] == "wishlist") {
            require "./wishlist.php";
            $wishlist = new Wishlist();
            // add_to_wishlist 
            if ($_GET["process"] == "add_to_wishlist") {
                $wishlist->add_to_wishlist();
            }
            // add_to_wishlist 
            // remove_from_wishlist 
            if ($_GET["process"] == "remove_from_wishlist") {
                $wishlist->remove_from_wishlist();
            }
            // remove_from_wishlist 
        }
        // cart
        // update_product
        if ($_GET["action"] == "update_product") {
            require "./product.php";
            $product = new Product();
            // load_product_data 
            if ($_GET["process"] == "load_product_data") {
                $product->load_product_data();
            }
            // load_product_data 
        }
        // update_product
    }
}
