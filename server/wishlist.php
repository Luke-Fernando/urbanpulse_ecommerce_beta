<?php

session_start();
require "./connection.php";

class Wishlist
{

    public function __construct()
    {
    }

    public function check_session()
    {
        if (isset($_SESSION["user"])) {
            return true;
        } else if (!isset($_SESSION["user"])) {
            return false;
        }
    }

    public function add_to_wishlist()
    {
        if ($this->check_session()) {
            if (isset($_POST["product_id"]) && !empty($_POST["product_id"])) {
                $product_id = $_POST["product_id"];
                $user = $_SESSION["user"];
                $product_resultset = Database::search("SELECT * FROM `product` WHERE `id`=?", [$product_id]);
                $product_num = $product_resultset->num_rows;
                if ($product_num == 1) {
                    $wishlist_resultset = Database::search("SELECT * FROM `wishlist` WHERE `product_id`=? AND `users_id`=?", [$product_id, $user["id"]]);
                    $wishlist_num = $wishlist_resultset->num_rows;
                    if ($wishlist_num == 0) {
                        Database::iud("INSERT INTO `wishlist`(`product_id`,`users_id`) VALUES(?,?)", [$product_id, $user["id"]]);
                        echo ("success");
                    } else if ($wishlist_num == 1) {
                        echo ("Item already in wishlist");
                    } else {
                        echo ("Something went wrong!");
                    }
                } else {
                    echo ("Something went wrong!");
                }
            }
        } else {
            echo ("Please signin or signup to your account");
        }
    }

    public function remove_from_wishlist()
    {
        if ($this->check_session()) {
            if (isset($_POST["wishlist_id"]) && !empty($_POST["wishlist_id"])) {
                $wishlist_id = $_POST["wishlist_id"];
                $user = $_SESSION["user"];
                $wishlist_resultset = Database::search("SELECT * FROM `wishlist` WHERE `id`=? AND `users_id`=?", [$wishlist_id, $user["id"]]);
                $wishlist_num = $wishlist_resultset->num_rows;
                if ($wishlist_num == 1) {
                    $wishlist_data = $wishlist_resultset->fetch_assoc();
                    $product_id = $wishlist_data["product_id"];
                    $product_resultset = Database::search("SELECT * FROM `product` WHERE `id`=?", [$product_id]);
                    $product_num = $product_resultset->num_rows;
                    if ($product_num == 1) {
                        Database::iud("DELETE FROM `wishlist` WHERE `id`=? AND `users_id`=?", [$wishlist_id, $user["id"]]);
                        echo ("success");
                    } else {
                        echo ("Something went wrong!");
                    }
                } else {
                    echo ("Something went wrong!");
                }
            }
        }
    }
}
