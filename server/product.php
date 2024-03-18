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
            if (isset($_POST["title"])) {
                if (isset($_POST["description"])) {
                    if (isset($_POST["price"])) {
                        if (isset($_POST["quantity"])) {
                            echo ("success");
                        } else {
                            echo ("please add the quantity");
                        }
                    } else {
                        echo ("please add the price");
                    }
                } else {
                    echo ("please fill the description");
                }
            } else {
                echo ("please fill the title");
            }
        } else {
            echo ("please signin to your account");
        }
    }
}
