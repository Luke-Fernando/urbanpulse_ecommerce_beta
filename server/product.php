<?php
session_start();
require "./connection.php";
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

    public function load_brands()
    {
        if ($this->check_session()) {
            if (isset($_POST["category"]) || !empty($_POST["category"])) {
                if ($_POST["category"] > 0) {
                    $category = $_POST["category"];
                    $category_has_brand_resultset = Database::search("SELECT * FROM `category_has_brand` WHERE `category_id` = ?", [$category]);
                    $category_has_brand_num = $category_has_brand_resultset->num_rows;
?>
                    <option value="0">Pleass select your brand</option>
                    <?php
                    for ($i = 0; $i < $category_has_brand_num; $i++) {
                        $category_has_brand_data = $category_has_brand_resultset->fetch_assoc();
                        $brand = $category_has_brand_data["brand_id"];
                        $brand_resultset = Database::search("SELECT * FROM `brand` WHERE `id` = ?", [$brand]);
                        $brand_data = $brand_resultset->fetch_assoc();
                    ?>
                        <option value="<?php echo $brand_data["id"] ?>"><?php echo $brand_data["brand"] ?></option>
                    <?php
                    }
                } else {
                    ?>
                    <option value="0" selected>Pleass select your category first</option>
                <?php
                }
            }
        } else {
            echo ("Please signin to your account");
        }
    }

    public function load_models()
    {
        if ($this->check_session()) {
            if (isset($_POST["brand"]) || !empty($_POST["brand"])) {
                if ($_POST["brand"] > 0) {
                    $brand = $_POST["brand"];
                    $brand_has_model_resultset = Database::search("SELECT * FROM `brand_has_model` WHERE `brand_id` = ?", [$brand]);
                    $brand_has_model_num = $brand_has_model_resultset->num_rows;
                ?>
                    <option value="0">Pleass select your model</option>
                    <?php
                    for ($i = 0; $i < $brand_has_model_num; $i++) {
                        $brand_has_model_data = $brand_has_model_resultset->fetch_assoc();
                        $model = $brand_has_model_data["model_id"];
                        $model_resultset = Database::search("SELECT * FROM `model` WHERE `id` = ?", [$model]);
                        $model_data = $model_resultset->fetch_assoc();
                    ?>
                        <option value="<?php echo $model_data["id"] ?>"><?php echo $model_data["model"] ?></option>
                    <?php
                    }
                } else {
                    ?>
                    <option value="0" selected>Pleass select your brand first</option>
                <?php
                }
            }
        } else {
            echo ("Please signin to your account");
        }
    }

    public function manage_locations_worldwide()
    {
        if ($this->check_session()) {
            if (isset($_POST["location"]) && !empty($_POST["location"])) {
                $location_specific = $_POST["location"];
                if ($location_specific == "worldwide") {
                ?>
                    <option value="worldwide" selected>worldwide</option>
                    <?php
                }
            }
        }
    }

    public function manage_locations_countries()
    {
        if ($this->check_session()) {
            if (isset($_POST["location"]) && !empty($_POST["location"])) {
                $location_specific = $_POST["location"];
                if ($location_specific != "worldwide" && $location_specific > 0) {
                    $country_resultset = Database::search("SELECT * FROM `country`", []);
                    $country_num = $country_resultset->num_rows;
                    for ($i = 0; $i < $country_num; $i++) {
                        $country_data = $country_resultset->fetch_assoc();
                        if ($country_data["id"] == $location_specific) {
                    ?>
                            <option value="<?php echo $country_data["id"] ?>" selected><?php echo $country_data["country"] ?></option>
                        <?php
                        } else {
                        ?>
                            <option value="<?php echo $country_data["id"] ?>"><?php echo $country_data["country"] ?></option>
                    <?php
                        }
                    }
                }
            }
        }
    }

    public function manage_locations_none()
    {
        if ($this->check_session()) {
            if (isset($_POST["location"]) && !empty($_POST["location"])) {
                $location_specific = $_POST["location"];
                if ($location_specific != "worldwide" && $location_specific == "none") {
                    ?>
                    <option value="worldwide" selected>worldwide</option>
                    <?php
                    $country_resultset = Database::search("SELECT * FROM `country`", []);
                    $country_num = $country_resultset->num_rows;
                    for ($i = 0; $i < $country_num; $i++) {
                        $country_data = $country_resultset->fetch_assoc();
                    ?>
                        <option value="<?php echo $country_data["id"] ?>"><?php echo $country_data["country"] ?></option>
                    <?php
                    }
                }
            }
        }
    }

    public function manage_shipping_type_flat()
    {
        if ($this->check_session()) {
            if (isset($_POST["shipping_type"]) && !empty($_POST["shipping_type"])) {
                $shipping_type = $_POST["shipping_type"];
                if ($shipping_type == "flat") {
                    ?>
                    <option value="general">General</option>
                    <?php
                }
            }
        }
    }

    public function manage_shipping_type_custom()
    {
        if ($this->check_session()) {
            if (isset($_POST["shipping_type"]) && !empty($_POST["shipping_type"])) {
                $shipping_type = $_POST["shipping_type"];
                if ($shipping_type == "custom") {
                    if (isset($_POST["shipping_locations"])) {
                        if (sizeof(json_decode($_POST["shipping_locations"])) > 0) {
                            $shipping_locations = json_decode($_POST["shipping_locations"]);
                            $if_worldwide = false;
                            foreach ($shipping_locations as $item) {
                                if ($item->value == "worldwide") {
                                    $if_worldwide = true;
                                    break;
                                }
                            }
                            if ($if_worldwide) {
                    ?>
                                <option value="general">General</option>
                                <?php
                                $country_resultset = Database::search("SELECT * FROM `country`", []);
                                $country_num = $country_resultset->num_rows;
                                for ($i = 0; $i < $country_num; $i++) {
                                    $country_data = $country_resultset->fetch_assoc();
                                ?>
                                    <option value="<?php echo $country_data["id"] ?>"><?php echo $country_data["country"] ?></option>
                                <?php
                                }
                            } else {
                                ?>
                                <option value="general">General</option>
                                <?php
                                $country_resultset = Database::search("SELECT * FROM `country`", []);
                                $country_num = $country_resultset->num_rows;
                                for ($i = 0; $i < $country_num; $i++) {
                                    $country_data = $country_resultset->fetch_assoc();
                                    foreach ($shipping_locations as $item) {
                                        if ($item->value == $country_data["id"]) {
                                ?>
                                            <option value="<?php echo $country_data["id"] ?>"><?php echo $country_data["country"] ?></option>
                            <?php
                                            break;
                                        }
                                    }
                                }
                            }
                        } else {
                            ?>
                            <option value="0">Please add your shipping location(s)</option>
                    <?php
                        }
                    }
                }
            }
        }
    }

    public function manage_shipping_type_none()
    {
        if ($this->check_session()) {
            if (isset($_POST["shipping_type"]) && !empty($_POST["shipping_type"])) {
                $shipping_type = $_POST["shipping_type"];
                if ($shipping_type == "none") {
                    ?>
                    <option value="0">Please select the shipping type first</option>
<?php
                }
            }
        }
    }

    public function list_product()
    {
        if ($this->check_session()) {
            if (isset($_FILES)) {
                if (count($_FILES)) {
                    if (isset($_POST["title"]) && !empty($_POST["title"])) {
                        if (isset($_POST["description"]) && !empty($_POST["description"])) {
                            if (isset($_POST["category"]) && !empty($_POST["category"])) {
                                if ($_POST["category"] > 0) {
                                    if (isset($_POST["brand"]) && !empty($_POST["brand"])) {
                                        if ($_POST["brand"] > 0) {
                                            if (isset($_POST["model"]) && !empty($_POST["model"])) {
                                                if ($_POST["model"] > 0) {
                                                    if (isset($_POST["colors"])) {
                                                        if (sizeof(json_decode($_POST["colors"])) > 0) {
                                                            if (isset($_POST["condition"]) && !empty($_POST["condition"])) {
                                                                if ($_POST["condition"] > 0) {
                                                                    if (isset($_POST["price"]) && !empty($_POST["price"])) {
                                                                        if (ctype_digit($_POST["price"])) {
                                                                            if ($_POST["price"] > 0) {
                                                                                if (isset($_POST["quantity"]) && !empty($_POST["quantity"])) {
                                                                                    if (ctype_digit($_POST["quantity"])) {
                                                                                        if ($_POST["quantity"] > 0) {
                                                                                            if (isset($_POST["shipping_locations"])) {
                                                                                                if (sizeof(json_decode($_POST["shipping_locations"])) > 0) {
                                                                                                    if (isset($_POST["shipping_type"]) && !empty($_POST["shipping_type"])) {
                                                                                                        if ($_POST["shipping_type"] > 0) {
                                                                                                            // list
                                                                                                        } else {
                                                                                                            echo ("Please select your shipping type");
                                                                                                        }
                                                                                                    } else {
                                                                                                        echo ("Please select your shipping type");
                                                                                                    }
                                                                                                } else {
                                                                                                    echo ("Please add at least 1 location");
                                                                                                }
                                                                                            } else {
                                                                                                echo ("Please add your location(s)");
                                                                                            }
                                                                                        } else {
                                                                                            echo ("Please enter a valid quantity");
                                                                                        }
                                                                                    } else {
                                                                                        echo ("Please enter a valid quantity");
                                                                                    }
                                                                                } else {
                                                                                    echo ("Please add your quantity");
                                                                                }
                                                                            } else {
                                                                                echo ("Please enter a valid price");
                                                                            }
                                                                        } else {
                                                                            echo ("Please enter a valid price");
                                                                        }
                                                                    } else {
                                                                        echo ("Please add your price");
                                                                    }
                                                                } else {
                                                                    echo ("Please select your condition");
                                                                }
                                                            } else {
                                                                echo ("Please select your condition");
                                                            }
                                                        } else {
                                                            echo ("Please add at least 1 color");
                                                        }
                                                    } else {
                                                        echo ("Please add your color(s)");
                                                    }
                                                } else {
                                                    echo ("Please select your model");
                                                }
                                            } else {
                                                echo ("Please select your model");
                                            }
                                        } else {
                                            echo ("Please select your brand");
                                        }
                                    } else {
                                        echo ("Please select your brand");
                                    }
                                } else {
                                    echo ("Please select your category");
                                }
                            } else {
                                echo ("Please select your category");
                            }
                        } else {
                            echo ("Please add your description");
                        }
                    } else {
                        echo ("Please add your title");
                    }
                } else {
                    echo ("Please add at least 3 images");
                }
            } else {
                echo ("Please add at least 3 images");
            }
        } else {
            echo ("Please signin to your account");
        }
    }
}
