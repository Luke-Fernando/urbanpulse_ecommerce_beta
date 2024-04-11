<?php
class Product
{
    public function __construct()
    {
    }

    private function get_current_datetime()
    {
        date_default_timezone_set('Asia/Colombo');
        $current_datetime = date('Y-m-d H:i:s');
        return $current_datetime;
    }

    private function check_session()
    {
        if (isset($_SESSION["user"])) {
            return true;
        } else if (!isset($_SESSION["user"])) {
            return false;
        }
    }

    public function load_brands($category_id)
    {
    }

    public function list_product()
    {
        if ($this->check_session()) {
            if (isset($_POST["title"]) && !empty($_POST["title"])) {
                if (isset($_POST["description"]) && !empty($_POST["description"])) {
                    if (isset($_POST["price"]) && !empty($_POST["price"])) {
                        if (isset($_POST["quantity"]) && !empty($_POST["quantity"])) {
                            echo ("success");
                        } else {
                            echo ("Please add the quantity");
                        }
                    } else {
                        echo ("Please add the price");
                    }
                } else {
                    echo ("Please fill the description");
                }
            } else {
                echo ("Please fill the title");
            }
        } else {
            echo ("Please signin to your account");
        }
    }
}
