<?php
session_start();
require "./connection.php";
class Product
{
    public function __construct()
    {
    }

    public function get_current_datetime()
    {
        date_default_timezone_set('Asia/Colombo');
        $current_datetime = date('Y-m-d H:i:s');
        return $current_datetime;
    }

    public function check_session()
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

    public function manage_cost_locations()
    {
        if ($this->check_session()) {
            if (isset($_POST["location"]) && !empty($_POST["location"])) {
                $locations = json_decode($_POST["location"]);
                if (sizeof($locations) > 0) {
                    if ($locations[0]->name == "worldwide") {
                    ?>
                        <option value="0">Please select shipping location</option>
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
                        <option value="0">Please select shipping location</option>
                        <option value="general">General</option>
                        <?php
                        foreach ($locations as $item) {
                            $location = $item->value;
                            $country_resultset = Database::search("SELECT * FROM `country` WHERE `id` = ?", [$location]);
                            $country_data = $country_resultset->fetch_assoc();
                        ?>
                            <option value="<?php echo $country_data["id"] ?>"><?php echo $country_data["country"] ?></option>
                            <?php
                            ?>
                    <?php
                        }
                    }
                } else {
                    ?>
                    <option value="0">Please select shipping location</option>
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

    public function insert_product($user)
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
                                                                                                    if (isset($_POST["shipping_cost"])) {
                                                                                                        if (sizeof(json_decode($_POST["shipping_cost"])) > 0) {
                                                                                                            //
                                                                                                            if (count($_FILES) >= 3) {
                                                                                                                $user = $_SESSION["user"];
                                                                                                                $shipping_locations = json_decode($_POST["shipping_locations"]);
                                                                                                                $shipping_costs = json_decode($_POST["shipping_cost"]);
                                                                                                                $product_id = null;
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
                                                                                                                                $product_id = $this->insert_product($user);
                                                                                                                                Database::iud(
                                                                                                                                    "INSERT INTO `shipping`(`product_id`,`shipping_option_id`,`general_cost`) VALUES(?,?,?);",
                                                                                                                                    [$product_id, $shipping_option, $general]
                                                                                                                                );
                                                                                                                                $shipping_state = "success";
                                                                                                                            } else if (sizeof($shipping_costs) > 1) {
                                                                                                                                $product_id = $this->insert_product($user);
                                                                                                                                Database::iud(
                                                                                                                                    "INSERT INTO `shipping`(`product_id`,`shipping_option_id`,`general_cost`) VALUES(?,?,?);",
                                                                                                                                    [$product_id, $shipping_option, $general]
                                                                                                                                );
                                                                                                                                $shipping_id = mysqli_insert_id(Database::$connection);
                                                                                                                                foreach ($shipping_costs as $item) {
                                                                                                                                    if ($item->value != "general") {
                                                                                                                                        $country = $item->value;
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
                                                                                                                                $product_id = $this->insert_product($user);
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
                                                                                                                        $product_id = $this->insert_product($user);
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
                                                                                                                            $product_id = $this->insert_product($user);
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
                                                                                                                    $image_num = count($_FILES);
                                                                                                                    for ($i = 0; $i < $image_num; $i++) {
                                                                                                                        if (isset($_FILES["image-$i"])) {
                                                                                                                            $image = $_FILES["image-$i"];
                                                                                                                            $this->list_product_image($image, $user["email"], $product_id);
                                                                                                                        }
                                                                                                                    }
                                                                                                                    echo ("success");
                                                                                                                } else {
                                                                                                                    echo $shipping_state;
                                                                                                                }
                                                                                                            } else {
                                                                                                                echo ("Please add at least 3 images");
                                                                                                            }
                                                                                                            //
                                                                                                        } else {
                                                                                                            echo ("Please add your shipping cost(s)");
                                                                                                        }
                                                                                                    } else {
                                                                                                        echo ("Please add your shipping cost(s)");
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

    public function set_product_quantity()
    {
        if ($this->check_session()) {
            if (isset($_POST["product_id"]) && !empty($_POST["product_id"])) {
                $product_id = $_POST["product_id"];
                $product_resultset = Database::search("SELECT * FROM `product` WHERE `id`=?", [$product_id]);
                $product_num = $product_resultset->num_rows;
                if ($product_num == 1) {
                    $product_data = $product_resultset->fetch_assoc();
                    $stock = $product_data["qty"];
                    echo ($stock);
                }
            }
        }
    }

    public function get_order_details()
    {
        if (isset($_SESSION["user"])) {
            if (isset($_POST["products"])) {
                if (sizeof(json_decode($_POST["products"])) > 0) {
                    $products = json_decode($_POST["products"]);
                    $is_data_correct = null;
                    foreach ($products as $product) {
                        $product_id = $product->product_id;
                        $quantity = $product->quantity;
                        $color = $product->color;
                        // verification 
                        if ($product_id != null && $product_id != "" && $product_id > 0) {
                            if ($quantity != null && $quantity != "" && $quantity > 0) {
                                if ($color != null && $color != "" && $color > 0) {
                                    $product_resultset = Database::search("SELECT * FROM `product` WHERE `id`=?;", [$product_id]);
                                    $product_num = $product_resultset->num_rows;
                                    if ($product_num == 1) {
                                        $product_data = $product_resultset->fetch_assoc();
                                        $stock = $product_data["qty"];
                                        if ($stock >= $quantity) {
                                            $product_has_color_resultset = Database::search(
                                                "SELECT * FROM `product_has_color` WHERE `product_id`=? AND `color_id`=?;",
                                                [$product_id, $color]
                                            );
                                            $product_has_color_num = $product_has_color_resultset->num_rows;
                                            if ($product_has_color_num == 1) {
                                                $is_data_correct = true;
                                            } else {
                                                $is_data_correct = false;
                                                break;
                                            }
                                        } else {
                                            $is_data_correct = false;
                                            break;
                                        }
                                    } else {
                                        $is_data_correct = false;
                                        break;
                                    }
                                } else {
                                    $is_data_correct = false;
                                    break;
                                }
                            } else {
                                $is_data_correct = false;
                                break;
                            }
                        } else {
                            $is_data_correct = false;
                            break;
                        }
                        // verification 
                    }
                    if ($is_data_correct) {
                        echo ("success");
                    } else {
                        echo ("Something went wrong!");
                    }
                } else {
                    echo ("Something went wrong!");
                }
            } else {
                echo ("Something went wrong!");
            }
        } else {
            echo ("Please signin or signup to ypur account");
        }
    }

    // update product 
    public function load_product_data()
    {
        if ($this->check_session()) {
            if (isset($_POST["product_id"]) && !empty($_POST["product_id"])) {
                $product_id = $_POST["product_id"];
                $user = $_SESSION["user"];
                $product_resultset = Database::search("SELECT * FROM `product` WHERE `id` = ? AND `users_id` = ?;", [$product_id, $user["id"]]);
                $product_num = $product_resultset->num_rows;
                if ($product_num == 1) {
                    // fill colors 
                    $color_array = array();
                    $product_has_color_resultset = Database::search("SELECT * FROM `product_has_color` WHERE `product_id`=?", [$product_id]);
                    $product_has_color_num = $product_has_color_resultset->num_rows;
                    if ($product_has_color_num > 0) {
                        for ($i = 0; $i < $product_has_color_num; $i++) {
                            $product_has_color_data = $product_has_color_resultset->fetch_assoc();
                            $color_id = $product_has_color_data["color_id"];
                            $color_resultset = Database::search("SELECT * FROM `color` WHERE `id`=?", [$color_id]);
                            $color_data = $color_resultset->fetch_assoc();
                            $color = $color_data["color"];
                            $color_value = $color_data["id"];
                            $new_color_array = array(
                                "name" => $color,
                                "value" => $color_value
                            );
                            array_push($color_array, $new_color_array);
                        }
                    }
                    // fill colors 
                    // fill locations 
                    $location_array = array();
                    $shipping_resultset = Database::search("SELECT * FROM `shipping` WHERE `product_id`=?;", [$product_id]);
                    $shipping_data = $shipping_resultset->fetch_assoc();
                    $shipping_option_resultset = Database::search("SELECT * FROM `shipping_option` WHERE `id`=?;", [$shipping_data["shipping_option_id"]]);
                    $shipping_option_data = $shipping_option_resultset->fetch_assoc();
                    if ($shipping_option_data["shipping_option"] == "Worldwide") {
                        $new_location_array = array(
                            "name" => "worldwide",
                            "value" => "worldwide"
                        );
                        array_push($location_array, $new_location_array);
                    } else if ($shipping_option_data["shipping_option"] == "Custom") {
                        $shipping_cost_resultset = Database::search("SELECT * FROM `shipping_cost` WHERE `shipping_id`=?;", [$shipping_data["id"]]);
                        $shipping_cost_num = $shipping_cost_resultset->num_rows;
                        for ($i = 0; $i < $shipping_cost_num; $i++) {
                            $shipping_cost_data = $shipping_cost_resultset->fetch_assoc();
                            $country_resultset = Database::search("SELECT * FROM `country` WHERE `id`=?;", [$shipping_cost_data["country_id"]]);
                            $country_data = $country_resultset->fetch_assoc();
                            $new_location_array = array(
                                "name" => $country_data["country"],
                                "value" => $shipping_cost_data["country_id"]
                            );
                            array_push($location_array, $new_location_array);
                        }
                    }
                    // fill locations 
                    // fill costs
                    $shipping_cost_array = array();
                    if ($shipping_data["general_cost"] != null) {
                        $new_shipping_cost_array = array(
                            "name" => array(
                                "country" => "General",
                                "value" => $shipping_data["general_cost"]
                            ),
                            "value" => "general"
                        );
                        array_push($shipping_cost_array, $new_shipping_cost_array);
                    }
                    $shipping_cost_resultset = Database::search("SELECT * FROM `shipping_cost` WHERE `shipping_id`=?;", [$shipping_data["id"]]);
                    $shipping_cost_num = $shipping_cost_resultset->num_rows;
                    if ($shipping_cost_num > 0) {
                        for ($i = 0; $i < $shipping_cost_num; $i++) {
                            $shipping_cost_data = $shipping_cost_resultset->fetch_assoc();
                            $country_resultset = Database::search("SELECT * FROM `country` WHERE `id`=?;", [$shipping_cost_data["country_id"]]);
                            $country_data = $country_resultset->fetch_assoc();
                            if ($shipping_cost_data["shipping_cost"] != null) {
                                $new_shipping_cost_array = array(
                                    "name" => array(
                                        "country" => $country_data["country"],
                                        "value" => $shipping_cost_data["shipping_cost"]
                                    ),
                                    "value" => $shipping_cost_data["country_id"]
                                );
                                array_push($shipping_cost_array, $new_shipping_cost_array);
                            }
                        }
                    }
                    // fill costs 
                    // fill images 
                    $image_array = array();
                    $image_resultset = Database::search("SELECT * FROM `product_image` WHERE `product_id`=?", [$product_id]);
                    $image_num = $image_resultset->num_rows;
                    for ($i = 0; $i < $image_num; $i++) {
                        $image_data = $image_resultset->fetch_assoc();
                        $new_image_array = array(
                            "name" => $image_data["product_image"],
                            "value" => $image_data["id"]
                        );
                        array_push($image_array, $new_image_array);
                    }
                    // fill images 
                    $response_array = array(
                        "colors" => $color_array,
                        "locations" => $location_array,
                        "costs" => $shipping_cost_array,
                        "images" => $image_array
                    );
                    echo json_encode($response_array);
                }
            }
        }
    }

    private function reset_shipping($product_id)
    {
        $shipping_resultset = Database::search("SELECT * FROM `shipping` WHERE `product_id`=?;", [$product_id]);
        $shipping_num = $shipping_resultset->num_rows;
        for ($i = 0; $i < $shipping_num; $i++) {
            $shipping_data = $shipping_resultset->fetch_assoc();
            $shipping_id = $shipping_data["id"];
            Database::iud("DELETE FROM `shipping_cost` WHERE `shipping_id`=?;", [$shipping_id]);
        }
        Database::iud("DELETE FROM `shipping` WHERE `product_id`=?;", [$product_id]);
    }

    public function update_product()
    {
        if ($this->check_session()) {
            if (isset($_POST["title"]) && !empty($_POST["title"])) {
                if (isset($_POST["description"]) && !empty($_POST["description"])) {
                    if (isset($_POST["colors"])) {
                        if (sizeof(json_decode($_POST["colors"])) > 0) {
                            if (isset($_POST["quantity"]) && !empty($_POST["quantity"])) {
                                if (ctype_digit($_POST["quantity"])) {
                                    if ($_POST["quantity"] > 0) {
                                        if (isset($_POST["shipping_locations"])) {
                                            if (sizeof(json_decode($_POST["shipping_locations"])) > 0) {
                                                if (isset($_POST["shipping_cost"])) {
                                                    if (sizeof(json_decode($_POST["shipping_cost"])) > 0) {
                                                        //
                                                        if ((count($_FILES) + sizeof(json_decode($_POST["loaded_images"]))) >= 3) {
                                                            $user = $_SESSION["user"];
                                                            $product_id = $_POST["product_id"];
                                                            $shipping_locations = json_decode($_POST["shipping_locations"]);
                                                            $shipping_costs = json_decode($_POST["shipping_cost"]);
                                                            $loaded_images = json_decode($_POST["loaded_images"]);
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
                                                                            $this->reset_shipping($product_id);
                                                                            Database::iud(
                                                                                "INSERT INTO `shipping`(`product_id`,`shipping_option_id`,`general_cost`) VALUES(?,?,?);",
                                                                                [$product_id, $shipping_option, $general]
                                                                            );
                                                                            $shipping_state = "success";
                                                                        } else if (sizeof($shipping_costs) > 1) {
                                                                            $this->reset_shipping($product_id);
                                                                            Database::iud(
                                                                                "INSERT INTO `shipping`(`product_id`,`shipping_option_id`,`general_cost`) VALUES(?,?,?);",
                                                                                [$product_id, $shipping_option, $general]
                                                                            );
                                                                            $shipping_id = mysqli_insert_id(Database::$connection);
                                                                            foreach ($shipping_costs as $item) {
                                                                                if ($item->value != "general") {
                                                                                    $country = $item->value;
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
                                                                            $this->reset_shipping($product_id);
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
                                                                    $this->reset_shipping($product_id);
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
                                                                        $this->reset_shipping($product_id);
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
                                                                // update the product
                                                                $title = $_POST["title"];
                                                                $description = $_POST["description"];
                                                                $colors = json_decode($_POST["colors"]);
                                                                $quantity = $_POST["quantity"];
                                                                Database::iud(
                                                                    "UPDATE `product` SET `title`=?,`description`=?,`qty`=? WHERE `id`=? AND `users_id`=?;",
                                                                    [$title, $description, $quantity, $product_id, $user["id"]]
                                                                );
                                                                Database::iud("DELETE FROM `product_has_color` WHERE `product_id`=?;", [$product_id]);
                                                                foreach ($colors as $item) {
                                                                    $color = $item->value;
                                                                    Database::iud("INSERT INTO `product_has_color`(`product_id`,`color_id`) VALUES(?,?);", [$product_id, $color]);
                                                                }
                                                                // update the product
                                                                $old_images_resultset = Database::search("SELECT * FROM `product_image` WHERE `product_id`=?;", [$product_id]);
                                                                $old_images_num = $old_images_resultset->num_rows;
                                                                for ($i = 0; $i < $old_images_num; $i++) {
                                                                    $old_image_data = $old_images_resultset->fetch_assoc();
                                                                    $old_image_id = $old_image_data["id"];
                                                                    $is_available = false;
                                                                    foreach ($loaded_images as $item) {
                                                                        $image = $item->value;
                                                                        if ($image == $old_image_id) {
                                                                            $is_available = true;
                                                                            break;
                                                                        }
                                                                    }
                                                                    if (!$is_available) {
                                                                        Database::iud("DELETE FROM `product_image` WHERE `id`=?;", [$old_image_id]);
                                                                        // delete the image from the files
                                                                        if (file_exists($old_image_data["product_image"])) {
                                                                            unlink($old_image_data["product_image"]);
                                                                        }
                                                                        //
                                                                    }
                                                                }
                                                                if (count($_FILES) > 0) {
                                                                    $image_num = count($_FILES);
                                                                    for ($i = 0; $i < $image_num; $i++) {
                                                                        if (isset($_FILES["image-$i"])) {
                                                                            $image = $_FILES["image-$i"];
                                                                            $this->list_product_image($image, $user["email"], $product_id);
                                                                        }
                                                                    }
                                                                }
                                                                echo ("success");
                                                            } else {
                                                                echo $shipping_state;
                                                            }
                                                        } else {
                                                            echo ("Please add at least 3 images");
                                                        }
                                                        //
                                                    } else {
                                                        echo ("Please add your shipping cost(s)");
                                                    }
                                                } else {
                                                    echo ("Please add your shipping cost(s)");
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
                            echo ("Please add at least 1 color");
                        }
                    } else {
                        echo ("Please add your color(s)");
                    }
                } else {
                    echo ("Please add your description");
                }
            } else {
                echo ("Please add your title");
            }
        } else {
            echo ("Please signin to your account");
        }
    }
    // update product 
}
