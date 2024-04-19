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
                    <option value="worldwide">worldwide</option>
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
                ?>
                    <option value="worldwide">worldwide</option>
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
