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

    public function list_product_image($image, $email, $product_id)
    {
        $target_directory = "../assets/images/products/";
        $original_file_name = $image["name"];
        $custom_file_name = $product_id . "_" . $email . "_" . uniqid() . "." . pathinfo($original_file_name, PATHINFO_EXTENSION);
        $target_file = $target_directory . $custom_file_name;
        $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_extensions = array("jpg", "jpeg", "png", "svg");
        if (in_array($image_file_type, $allowed_extensions)) {
            if (move_uploaded_file($image["tmp_name"], $target_file)) {
                Database::iud(
                    "INSERT INTO `product_image`(`product_id`,`product_image`) VALUES (?,?)",
                    [$product_id, $custom_file_name]
                );
            }
        }
    }

    public function insert_product()
    {
        $title = $_POST["title"];
        $description = $_POST["description"];
        $category = $_POST["category"];
        $brand = $_POST["brand"];
        $model = $_POST["model"];
        $colors = json_decode($_POST["colors"]);
        $condition = $_POST["condition"];
        $price = $_POST["price"];
        $quantity = $_POST["quantity"];
        $user = $_SESSION["user"];
        $brand_has_model_resultset = Database::search("SELECT * FROM `brand_has_model` WHERE `brand_id`=? AND `model_id`=?", [$brand, $model]);
        $brand_has_model_data = $brand_has_model_resultset->fetch_assoc();
        $brand_has_model = $brand_has_model_data["id"];
        $status_resultset = Database::search("SELECT * FROM `status` WHERE `status`=?", ["Active"]);
        $status_data = $status_resultset->fetch_assoc();
        $status = $status_data["id"];
        $datetime_added = $this->get_current_datetime();
        $click_count = 0;
        Database::iud(
            "INSERT INTO `product`(`title`,`description`,`datetime_added`,`qty`,`price`,`users_id`,`category_id`,`brand_has_model_id`,`condition_id`,`status_id`,`click_count`) VALUES(?,?,?,?,?,?,?,?,?,?,?);",
            [$title, $description, $datetime_added, $quantity, $price, $user["id"], $category, $brand_has_model, $condition, $status, $click_count]
        );
        $product_id = mysqli_insert_id(Database::$connection);
        foreach ($colors as $item) {
            $color = $item->value;
            Database::iud("INSERT INTO `product_has_color`(`product_id`,`color_id`) VALUES(?,?);", [$product_id, $color]);
        }
        return $product_id;
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
                                                                                                            if (isset($_POST["shipping_cost"])) {
                                                                                                                if (sizeof(json_decode($_POST["shipping_cost"])) > 0) {
                                                                                                                    $shipping_type = $_POST["shipping_type"];
                                                                                                                    $shipping_locations = json_decode($_POST["shipping_locations"]);
                                                                                                                    $shipping_costs = json_decode($_POST["shipping_cost"]);
                                                                                                                    /* -------------------------------------------------------------------------- */
                                                                                                                    /*                             LOCATION VALIDATION                            */
                                                                                                                    /* -------------------------------------------------------------------------- */
                                                                                                                    $shipping_state = "Something went wrong";
                                                                                                                    $is_worldwide = false;
                                                                                                                    foreach ($shipping_locations as $item) {
                                                                                                                        if ($item->value == "worldwide") {
                                                                                                                            $is_worldwide = true;
                                                                                                                            break;
                                                                                                                        }
                                                                                                                    }
                                                                                                                    $has_general = false;
                                                                                                                    $general = null;
                                                                                                                    foreach ($shipping_costs as $item) {
                                                                                                                        if ($item->value == "general") {
                                                                                                                            $has_general = true;
                                                                                                                            $general = $item->name->value;
                                                                                                                            break;
                                                                                                                        }
                                                                                                                    }
                                                                                                                    if ($is_worldwide) {
                                                                                                                        $shipping_option_resultset = Database::search("SELECT * FROM `shipping_option` WHERE `shipping_option`=?", ["Worldwide"]);
                                                                                                                        $shipping_option_data = $shipping_option_resultset->fetch_assoc();
                                                                                                                        $shipping_option = $shipping_option_data["id"];
                                                                                                                        if (sizeof($shipping_locations) == 1) {
                                                                                                                            if ($has_general) {
                                                                                                                                if (sizeof($shipping_costs) == 1) {
                                                                                                                                    $product_id = $this->insert_product();
                                                                                                                                    Database::iud(
                                                                                                                                        "INSERT INTO `shipping`(`product_id`,`shipping_option_id`,`general_cost`) VALUES(?,?,?);",
                                                                                                                                        [$product_id, $shipping_option, $general]
                                                                                                                                    );
                                                                                                                                    $shipping_state = "success";
                                                                                                                                } else if (sizeof($shipping_costs) > 1) {
                                                                                                                                    $product_id = $this->insert_product();
                                                                                                                                    Database::iud(
                                                                                                                                        "INSERT INTO `shipping`(`product_id`,`shipping_option_id`,`general_cost`) VALUES(?,?,?);",
                                                                                                                                        [$product_id, $shipping_option, $general]
                                                                                                                                    );
                                                                                                                                    $shipping_id = mysqli_insert_id(Database::$connection);
                                                                                                                                    foreach ($shipping_costs as $item) {
                                                                                                                                        if ($item->value != "general") {
                                                                                                                                            $has_general = true;
                                                                                                                                            $country = $item->name->country;
                                                                                                                                            $cost = $item->name->value;
                                                                                                                                            Database::iud(
                                                                                                                                                "INSERT INTO `shipping_cost`(`shipping_id`,`country_id`,`shipping_cost`) VALUES(?,?,?);",
                                                                                                                                                [$shipping_id, $country, $cost]
                                                                                                                                            );
                                                                                                                                        }
                                                                                                                                    }
                                                                                                                                    $shipping_state = "success";
                                                                                                                                }
                                                                                                                            } else {
                                                                                                                                $country_resultset = Database::search("SELECT * FROM `country`", []);
                                                                                                                                $country_num = $country_resultset->num_rows;
                                                                                                                                $is_locations_covered = false;
                                                                                                                                for ($i = 0; $i < $country_num; $i++) {
                                                                                                                                    $country_data = $country_resultset->fetch_assoc();
                                                                                                                                    $country = $country_data["id"];
                                                                                                                                    $is_location_covered = false;
                                                                                                                                    foreach ($shipping_costs as $item) {
                                                                                                                                        if ($item->value == $country) {
                                                                                                                                            $is_location_covered = true;
                                                                                                                                            break;
                                                                                                                                        }
                                                                                                                                    }
                                                                                                                                    if (!$is_location_covered) {
                                                                                                                                        $is_locations_covered = false;
                                                                                                                                        $shipping_state = "Please add shipping cost for every location or add a general cost";
                                                                                                                                        break;
                                                                                                                                    } else {
                                                                                                                                        $is_locations_covered = true;
                                                                                                                                    }
                                                                                                                                }
                                                                                                                                if ($is_locations_covered) {
                                                                                                                                    $product_id = $this->insert_product();
                                                                                                                                    Database::iud(
                                                                                                                                        "INSERT INTO `shipping`(`product_id`,`shipping_option_id`,`general_cost`) VALUES(?,?,?);",
                                                                                                                                        [$product_id, $shipping_option, $general]
                                                                                                                                    );
                                                                                                                                    $shipping_id = mysqli_insert_id(Database::$connection);
                                                                                                                                    for ($i = 0; $i < $country_num; $i++) {
                                                                                                                                        $country_data = $country_resultset->fetch_assoc();
                                                                                                                                        $country = $country_data["id"];
                                                                                                                                        foreach ($shipping_costs as $item) {
                                                                                                                                            if ($item->value == $country) {
                                                                                                                                                Database::iud(
                                                                                                                                                    "INSERT INTO `shipping_cost`(`shipping_id`,`country_id`,`shipping_cost`) VALUES(?,?,?);",
                                                                                                                                                    [$shipping_id, $item->value, $item->name->value]
                                                                                                                                                );
                                                                                                                                            }
                                                                                                                                        }
                                                                                                                                    }
                                                                                                                                    $shipping_state = "success";
                                                                                                                                }
                                                                                                                            }
                                                                                                                        }
                                                                                                                    } else {
                                                                                                                        $shipping_option_resultset = Database::search("SELECT * FROM `shipping_option` WHERE `shipping_option`=?", ["Custom"]);
                                                                                                                        $shipping_option_data = $shipping_option_resultset->fetch_assoc();
                                                                                                                        $shipping_option = $shipping_option_data["id"];
                                                                                                                        if ($has_general) {
                                                                                                                            $product_id = $this->insert_product();
                                                                                                                            Database::iud(
                                                                                                                                "INSERT INTO `shipping`(`product_id`,`shipping_option_id`,`general_cost`) VALUES(?,?,?);",
                                                                                                                                [$product_id, $shipping_option, $general]
                                                                                                                            );
                                                                                                                            $shipping_id = mysqli_insert_id(Database::$connection);
                                                                                                                            foreach ($shipping_locations as $location) {
                                                                                                                                $country = $location->value;
                                                                                                                                $cost = null;
                                                                                                                                foreach ($shipping_costs as $item) {
                                                                                                                                    if ($item->value == $country) {
                                                                                                                                        $cost = $item->name->value;
                                                                                                                                    }
                                                                                                                                }
                                                                                                                                Database::iud(
                                                                                                                                    "INSERT INTO `shipping_cost`(`shipping_id`,`country_id`,`shipping_cost`) VALUES(?,?,?);",
                                                                                                                                    [$shipping_id, $country, $cost]
                                                                                                                                );
                                                                                                                            }
                                                                                                                            $shipping_state = "success";
                                                                                                                        } else {
                                                                                                                            //
                                                                                                                            $is_locations_covered = false;
                                                                                                                            foreach ($shipping_locations as $location) {
                                                                                                                                $country = $location->value;
                                                                                                                                $is_location_covered = false;
                                                                                                                                foreach ($shipping_costs as $item) {
                                                                                                                                    if ($item->value == $country) {
                                                                                                                                        $is_location_covered = true;
                                                                                                                                        break;
                                                                                                                                    }
                                                                                                                                }
                                                                                                                                if (!$is_location_covered) {
                                                                                                                                    $is_locations_covered = false;
                                                                                                                                    $shipping_state = "Please add shipping cost for every location or add a general cost";
                                                                                                                                    break;
                                                                                                                                } else {
                                                                                                                                    $is_locations_covered = true;
                                                                                                                                }
                                                                                                                            }
                                                                                                                            if ($is_locations_covered) {
                                                                                                                                $product_id = $this->insert_product();
                                                                                                                                Database::iud(
                                                                                                                                    "INSERT INTO `shipping`(`product_id`,`shipping_option_id`,`general_cost`) VALUES(?,?,?);",
                                                                                                                                    [$product_id, $shipping_option, $general]
                                                                                                                                );
                                                                                                                                $shipping_id = mysqli_insert_id(Database::$connection);
                                                                                                                                foreach ($shipping_locations as $location) {
                                                                                                                                    $country = $location->value;
                                                                                                                                    foreach ($shipping_costs as $item) {
                                                                                                                                        Database::iud(
                                                                                                                                            "INSERT INTO `shipping_cost`(`shipping_id`,`country_id`,`shipping_cost`) VALUES(?,?,?);",
                                                                                                                                            [$shipping_id, $country, $item->name->value]
                                                                                                                                        );
                                                                                                                                    }
                                                                                                                                }
                                                                                                                                $shipping_state = "success";
                                                                                                                            } else {
                                                                                                                                $shipping_state = "Please add a shipping cost for every location or add a general cost";
                                                                                                                            }
                                                                                                                        }
                                                                                                                    }
                                                                                                                    /* -------------------------------------------------------------------------- */
                                                                                                                    /*                             LOCATION VALIDATION                            */
                                                                                                                    /* -------------------------------------------------------------------------- */
                                                                                                                    if ($shipping_state == "success") {
                                                                                                                        echo ("success");
                                                                                                                    } else {
                                                                                                                        echo $shipping_state;
                                                                                                                    }
                                                                                                                } else {
                                                                                                                    echo ("Please add your shipping cost(s)");
                                                                                                                }
                                                                                                            } else {
                                                                                                                echo ("Please add your shipping cost(s)");
                                                                                                            }
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
