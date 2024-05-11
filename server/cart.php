<?php

session_start();
require "./connection.php";

class Cart
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

    public function add_to_cart()
    {
        if ($this->check_session()) {
            if (isset($_POST["product_id"]) && !empty($_POST["product_id"])) {
                if (isset($_POST["quantity"]) && !empty($_POST["quantity"])) {
                    if (isset($_POST["color"]) && !empty($_POST["color"])) {
                        $product_id = $_POST["product_id"];
                        $quantity = $_POST["quantity"];
                        $color = $_POST["color"];
                        $user = $_SESSION["user"];
                        $cart_resultset = Database::search("SELECT * FROM `cart` WHERE `product_id`=? AND `users_id`=?;", [$product_id, $user["id"]]);
                        $cart_num = $cart_resultset->num_rows;
                        if ($cart_num != 1) {
                            $product_resultset = Database::search("SELECT * FROM `product` WHERE `id`=?", [$product_id]);
                            $product_data = $product_resultset->fetch_assoc();
                            Database::iud(
                                "INSERT INTO `cart`(`qty`,`product_id`,`color_id`,`users_id`) VALUES(?,?,?,?);",
                                [$quantity, $product_id, $color, $user["id"]]
                            );
                            echo ("success");
                        } else if ($cart_num == 1) {
                            echo ("Item already in cart");
                        } else {
                            echo ("Something went wrong!");
                        }
                    } else {
                        echo ("Please select your color");
                    }
                } else {
                    echo ("Please add your quantity");
                }
            } else {
                echo ("Something went wrong!");
            }
        } else {
            echo ("Please signin or signup to your account");
        }
    }

    public function remove_from_cart()
    {
        if ($this->check_session()) {
            if (isset($_POST["cart_id"]) && !empty($_POST["cart_id"])) {
                $cart_id = $_POST["cart_id"];
                $user = $_SESSION["user"];
                $cart_resultset = Database::search("SELECT * FROM `cart` WHERE `id`=? AND `users_id`=?", [$cart_id, $user["id"]]);
                $cart_num = $cart_resultset->num_rows;
                if ($cart_num == 1) {
                    Database::iud("DELETE FROM `cart` WHERE `id`=? AND `users_id`=?", [$cart_id, $user["id"]]);
                    echo ("success");
                } else {
                    echo ("Something went wrong!");
                }
            }
        } else {
            echo ("Please signin or signup to your account");
        }
    }

    public function cart_to_wishlist()
    {
        if ($this->check_session()) {
            if (isset($_POST["cart_id"]) && !empty($_POST["cart_id"])) {
                $cart_id = $_POST["cart_id"];
                $user = $_SESSION["user"];
                $cart_resultset = Database::search("SELECT * FROM `cart` WHERE `id`=? AND `users_id`=?", [$cart_id, $user["id"]]);
                $cart_num = $cart_resultset->num_rows;
                if ($cart_num == 1) {
                    $cart_data = $cart_resultset->fetch_assoc();
                    $product_id = $cart_data["product_id"];
                    $product_resultset = Database::search("SELECT * FROM `product` WHERE `id`=?", [$product_id]);
                    $product_num = $product_resultset->num_rows;
                    if ($product_num == 1) {
                        $wishlist_resultset = Database::search("SELECT * FROM `wishlist` WHERE `product_id`=? AND `users_id`=?", [$product_id, $user["id"]]);
                        $wishlist_num = $wishlist_resultset->num_rows;
                        if ($wishlist_num == 0) {
                            Database::iud("INSERT INTO `wishlist`(`product_id`,`users_id`) VALUES(?,?)", [$product_id, $user["id"]]);
                            Database::iud("DELETE FROM `cart` WHERE `id`=? AND `users_id`=?", [$cart_id, $user["id"]]);
                            echo ("success");
                        } else if ($wishlist_num == 1) {
                            echo ("Item already in wishlist");
                        } else {
                            echo ("Something went wrong!");
                        }
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

    public function decrease_cart_quantity()
    {
        if ($this->check_session()) {
            if (isset($_POST["cart_id"]) && !empty($_POST["cart_id"])) {
                $cart_id = $_POST["cart_id"];
                $user = $_SESSION["user"];
                $cart_resultset = Database::search("SELECT * FROM `cart` WHERE `id`=? AND `users_id`=?", [$cart_id, $user["id"]]);
                $cart_num = $cart_resultset->num_rows;
                if ($cart_num == 1) {
                    $cart_data = $cart_resultset->fetch_assoc();
                    $product_id = $cart_data["product_id"];
                    $product_resultset = Database::search("SELECT * FROM `product` WHERE `id`=?", [$product_id]);
                    $product_num = $product_resultset->num_rows;
                    if ($product_num == 1) {
                        $product_data = $product_resultset->fetch_assoc();
                        $product_quantity = $product_data["qty"];
                        $cart_quantity = $cart_data["qty"];
                        if ($cart_quantity > 1 && $cart_quantity <= $product_quantity) {
                            Database::iud("UPDATE `cart` SET `qty`=? WHERE `id`=? AND `users_id`=?", [$cart_quantity - 1, $cart_id, $user["id"]]);
                            echo ("success");
                        }
                    }
                }
            }
        }
    }

    public function increase_cart_quantity()
    {
        if ($this->check_session()) {
            if (isset($_POST["cart_id"]) && !empty($_POST["cart_id"])) {
                $cart_id = $_POST["cart_id"];
                $user = $_SESSION["user"];
                $cart_resultset = Database::search("SELECT * FROM `cart` WHERE `id`=? AND `users_id`=?", [$cart_id, $user["id"]]);
                $cart_num = $cart_resultset->num_rows;
                if ($cart_num == 1) {
                    $cart_data = $cart_resultset->fetch_assoc();
                    $product_id = $cart_data["product_id"];
                    $product_resultset = Database::search("SELECT * FROM `product` WHERE `id`=?", [$product_id]);
                    $product_num = $product_resultset->num_rows;
                    if ($product_num == 1) {
                        $product_data = $product_resultset->fetch_assoc();
                        $product_quantity = $product_data["qty"];
                        $cart_quantity = $cart_data["qty"];
                        if ($cart_quantity >= 1 && $cart_quantity < $product_quantity) {
                            Database::iud("UPDATE `cart` SET `qty`=? WHERE `id`=? AND `users_id`=?", [$cart_quantity + 1, $cart_id, $user["id"]]);
                            echo ("success");
                        }
                    }
                }
            }
        }
    }
}
