<?php
session_start();
require "./connection.php";
class Order
{

    public function check_session()
    {
        if (isset($_SESSION["user"])) {
            return true;
        } else if (!isset($_SESSION["user"])) {
            return false;
        }
    }

    public function get_current_datetime()
    {
        date_default_timezone_set('Asia/Colombo');
        $current_datetime = date('Y-m-d H:i:s');
        return $current_datetime;
    }

    public function generate_placed_products()
    {
        if ($this->check_session()) {
            if (isset($_POST["products"])) {
                if (sizeof(json_decode($_POST["products"])) > 0) {
                    if (isset($_POST["root_path"])) {

                        $products = json_decode($_POST["products"]);
                        $root_path = $_POST["root_path"];
                        foreach ($products as $product) {
                            $product_id = $product->product;
                            $quantity = $product->quantity;
                            $color = $product->color;
                            $product_resultset = Database::search("SELECT * FROM `product` WHERE `id`=?;", [$product_id]);
                            $product_num = $product_resultset->num_rows;
                            if ($product_num == 1) {
                                $product_data = $product_resultset->fetch_assoc();
                                $product_image_resultset = Database::search("SELECT * FROM `product_image` WHERE `product_id`=?;", [$product_id]);
                                $product_image_num = $product_image_resultset->num_rows;
                                $product_image_data = $product_image_resultset->fetch_assoc();
                                $title = $product_data["title"];
                                $product_image = $product_image_data["product_image"];
                                $color_resultset = Database::search("SELECT * FROM `color` WHERE `id`=?;", [$color]);
                                $color_data = $color_resultset->fetch_assoc();
                                $color_name = $color_data["color"];
                                $condition_resultset = Database::search("SELECT * FROM `condition` WHERE `id`=?;", [$product_data["condition_id"]]);
                                $condition_data = $condition_resultset->fetch_assoc();
                                $condition = $condition_data["condition"];
?>
                                <!-- product  -->
                                <div class="w-full h-auto box-border px-5 bg-gray-100 py-5 flex justify-between items-start my-2">
                                    <a href="../?id=<?php echo $product_id; ?>&clicked=true" class="w-28 aspect-square flex justify-center items-center mr-5 overflow-hidden">
                                        <img src="<?php echo $root_path; ?>assets/images/products/<?php echo $product_image; ?>" class="min-w-full min-h-full object-cover">
                                    </a>
                                    <div class="flex-1 h-auto">
                                        <a href="../?id=<?php echo $product_id; ?>&clicked=true" class="font-fm-inter text-sm font-normal block mb-3"><?php echo $title; ?></a>
                                        <p class="font-fm-inter text-sm font-normal text-gray-700">Condition: <span class="text-inherit"><?php echo $condition; ?></span></p>
                                        <p class="font-fm-inter text-sm font-normal text-gray-700">Color: <span class="text-inherit"><?php echo $color_name; ?></span></p>
                                        <p class="font-fm-inter text-sm font-normal text-gray-700">Quantity: <span class="text-inherit"><?php echo $quantity; ?></span></p>
                                    </div>
                                </div>
                                <!-- product  -->
<?php
                            }
                        }
                    }
                }
            }
        }
    }

    public function calculate_costs($products, $user)
    {
        $items = sizeof($products);
        $items_total = 0;
        $shipping_total = 0;
        $subtotal = 0;
        foreach ($products as $product) {
            $product_id = $product->product;
            $quantity = $product->quantity;
            $product_resultset = Database::search("SELECT * FROM `product` WHERE `id`=?;", [$product_id]);
            $product_num = $product_resultset->num_rows;
            if ($product_num == 1) {
                $product_data = $product_resultset->fetch_assoc();
                $price = $product_data["price"];
                $items_total = $items_total + ($price * $quantity);
                // //
                // check shipping availability
                $is_shipping_available = true;
                $shipping_resultset = Database::search("SELECT * FROM `shipping` WHERE `product_id`=?;", [$product_id]);
                $shipping_option_worldwide_resultset = Database::search("SELECT * FROM `shipping_option` WHERE `shipping_option`=?;", ["Worldwide"]);
                $shipping_option_worldwide_data = $shipping_option_worldwide_resultset->fetch_assoc();
                $shipping_data = $shipping_resultset->fetch_assoc();
                if ($shipping_data["shipping_option_id"] == $shipping_option_worldwide_data["id"]) {
                    $is_shipping_available = true;
                } else {
                    $shipping_available_resultset = Database::search(
                        "SELECT * FROM `shipping_cost` WHERE `shipping_id`=? AND `country_id`=?",
                        [$shipping_data["id"], $user["country_id"]]
                    );
                    $shipping_available_num = $shipping_available_resultset->num_rows;
                    if ($shipping_available_num == 0) {
                        $is_shipping_available = false;
                        array_push($shippping_unavailable_products, $product_data["id"]);
                    } else if ($shipping_available_num == 1) {
                        $is_shipping_available = true;
                    }
                }
                // check shipping availability
                $item_shipping_cost = 0;
                if ($is_shipping_available) {
                    $shipping_cost_resultset = Database::search(
                        "SELECT * FROM `shipping_cost` WHERE `shipping_id`=? AND `country_id`=?",
                        [$shipping_data["id"], $user["country_id"]]
                    );
                    $shipping_cost_data = $shipping_cost_resultset->fetch_assoc();
                    $shipping_cost_num = $shipping_cost_resultset->num_rows;
                    if ($shipping_cost_num == 0) {
                        $item_shipping_cost = $shipping_data["general_cost"];
                    } else if ($shipping_cost_num == 1) {
                        if ($shipping_cost_data["shipping_cost"] == null) {
                            $item_shipping_cost = $shipping_data["general_cost"];
                        } else {
                            $item_shipping_cost = $shipping_cost_data["shipping_cost"];
                        }
                    }

                    $item_shipping_cost_total = $item_shipping_cost * $quantity;
                    $shipping_total += $item_shipping_cost_total;
                }
                // //
            }
        }
        $subtotal = $items_total + $shipping_total;
        $details_array = array(
            "items" => $items,
            "items_total" => $items_total,
            "shipping_total" => $shipping_total,
            "subtotal" => $subtotal
        );
        return $details_array;
    }

    public function generate_placed_products_costs()
    {
        if ($this->check_session()) {
            if (isset($_POST["products"])) {
                if (sizeof(json_decode($_POST["products"])) > 0) {
                    $user = $_SESSION["user"];
                    $products = json_decode($_POST["products"]);
                    echo json_encode($this->calculate_costs($products, $user));
                }
            }
        }
    }

    public function generate_order_id()
    {
        return uniqid();
    }

    public function generate_hash($merchant_id, $order_id, $amount, $currency, $merchant_secret)
    {
        $hash = strtoupper(
            md5(
                $merchant_id .
                    $order_id .
                    number_format($amount, 2, '.', '') .
                    $currency .
                    strtoupper(md5($merchant_secret))
            )
        );
        return $hash;
    }

    public function place_order()
    {
        if ($this->check_session()) {
            if (isset($_POST["products"])) {
                if (sizeof(json_decode($_POST["products"])) > 0) {
                    $products = json_decode($_POST["products"]);
                    $user = $_SESSION["user"];
                    $order_id = $this->generate_order_id();
                    $merchant_id = $_ENV["MERCHANT_ID"];
                    $merchant_secret = $_ENV["MERCHANT_SECRET"];
                    $currency = "USD";
                    $costs = $this->calculate_costs($products, $user);
                    $amount = $costs["subtotal"];
                    $hash = $this->generate_hash($merchant_id, $order_id, $amount, $currency, $merchant_secret);
                    $first_name = $user["first_name"];
                    $last_name = $user["last_name"];
                    $email = $user["email"];
                    $country_code_resultset = Database::search("SELECT * FROM `country_code` WHERE `id`=?;", [$user["country_code_id"]]);
                    $country_code_data = $country_code_resultset->fetch_assoc();
                    $country_code = $country_code_data["country_code"];
                    $mobile = $user["mobile"];
                    $phone = $country_code . "" . $mobile;
                    $address = $user["address_line_1"] . ", " . $user["address_line_2"];
                    $city = $user["city"];
                    $country_resultset = Database::search("SELECT * FROM `country` WHERE `id`=?;", [$user["country_id"]]);
                    $country_data = $country_resultset->fetch_assoc();
                    $country = $country_data["country"];
                    $payment = array(
                        "sandbox" => true,
                        "merchant_id" => $_ENV["MERCHANT_ID"],
                        "return_url" => null,     // Important
                        "cancel_url" => null,     // Important
                        "notify_url" => null,
                        "order_id" => $order_id,
                        "items" => $order_id,
                        "amount" => $amount,
                        "currency" => $currency,
                        "hash" => $hash,
                        "first_name" => $first_name,
                        "last_name" => $last_name,
                        "email" => $email,
                        "phone" => $phone,
                        "address" => $address,
                        "city" => $city,
                        "country" => $country,
                        "delivery_address" => $address,
                        "delivery_city" => $city,
                        "delivery_country" => $country
                    );
                    $products_count = sizeof($products);
                    for ($i = 0; $i < $products_count; $i++) {
                        $product = $products[$i];
                        $product_id = $product->product;
                        $quantity = $product->quantity;
                        $product_resultset = Database::search("SELECT * FROM `product` WHERE `id`=?;", [$product_id]);
                        $product_data = $product_resultset->fetch_assoc();
                        $title = $product_data["title"];
                        $payment["item_name_" . $i + 1] = $title;
                        $payment["quantity_" . $i + 1] = $quantity;
                    }

                    echo (json_encode($payment));
                    // echo ("success");
                }
            }
        }
    }

    public function record_order()
    {
        if ($this->check_session()) {
            if (isset($_POST["products"])) {
                if (sizeof(json_decode($_POST["products"])) > 0) {
                    if (isset($_POST["order_id"])) {
                        $products = json_decode($_POST["products"]);
                        $order_id = $_POST["order_id"];
                        $user = $_SESSION["user"];
                        $costs = $this->calculate_costs($products, $user);
                        //
                        $order = $order_id;
                        $users_id = $user["id"];
                        $email = $user["email"];
                        $address_line_1 = $user["address_line_1"];
                        $address_line_2 = $user["address_line_2"];
                        $city = $user["city"];
                        $zip_code = $user["zip_code"];
                        $country_id = $user["country_id"];
                        $country_code_id = $user["country_code_id"];
                        $mobile = $user["mobile"];
                        $datetime_ordered = $this->get_current_datetime();
                        $total_items = $costs["items"];
                        $total_items_price = $costs["items_total"];
                        $total_shipping_cost = $costs["shipping_total"];
                        //
                        Database::iud(
                            "INSERT INTO `order`
                        (`order`,`users_id`,`email`,`address_line_1`,`address_line_2`,`city`,`zip_code`,`country_id`,`country_code_id`,`mobile`,`datetime_ordered`,`total_items`,`total_items_price`,`total_shipping_cost`) VALUES
                        (?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
                            [$order, $users_id, $email, $address_line_1, $address_line_2, $city, $zip_code, $country_id, $country_code_id, $mobile, $datetime_ordered, $total_items, $total_items_price, $total_shipping_cost]
                        );
                        $id = mysqli_insert_id(Database::$connection);
                        $status = true;
                        foreach ($products as $product) {
                            $product_id = $product->product;
                            $quantity = $product->quantity;
                            $color = $product->color;
                            $total_price = 0;
                            $total_shipping_price = 0;
                            $product_resultset = Database::search("SELECT * FROM `product` WHERE `id`=?;", [$product_id]);
                            $product_num = $product_resultset->num_rows;
                            if ($product_num == 1) {
                                $product_data = $product_resultset->fetch_assoc();
                                $stock = $product_data["qty"];
                                if ($stock >= $quantity) {
                                    $color_resultset = Database::search("SELECT * FROM `color` WHERE `id`=?;", [$color]);
                                    $color_num = $color_resultset->num_rows;
                                    if ($color_num == 1) {
                                        $product_has_color_resultset = Database::search("SELECT * FROM `product_has_color` WHERE `product_id`=? AND `color_id`=?;", [$product_id, $color]);
                                        $product_has_color_num = $product_has_color_resultset->num_rows;
                                        if ($product_has_color_num == 1) {
                                            $price = $product_data["price"];
                                            $total_price = $price * $quantity;
                                            // //
                                            // //
                                            // check shipping availability
                                            $is_shipping_available = true;
                                            $shipping_resultset = Database::search("SELECT * FROM `shipping` WHERE `product_id`=?;", [$product_id]);
                                            $shipping_option_worldwide_resultset = Database::search("SELECT * FROM `shipping_option` WHERE `shipping_option`=?;", ["Worldwide"]);
                                            $shipping_option_worldwide_data = $shipping_option_worldwide_resultset->fetch_assoc();
                                            $shipping_data = $shipping_resultset->fetch_assoc();
                                            if ($shipping_data["shipping_option_id"] == $shipping_option_worldwide_data["id"]) {
                                                $is_shipping_available = true;
                                            } else {
                                                $shipping_available_resultset = Database::search(
                                                    "SELECT * FROM `shipping_cost` WHERE `shipping_id`=? AND `country_id`=?",
                                                    [$shipping_data["id"], $user["country_id"]]
                                                );
                                                $shipping_available_num = $shipping_available_resultset->num_rows;
                                                if ($shipping_available_num == 0) {
                                                    $is_shipping_available = false;
                                                    array_push($shippping_unavailable_products, $product_data["id"]);
                                                } else if ($shipping_available_num == 1) {
                                                    $is_shipping_available = true;
                                                }
                                            }
                                            // check shipping availability
                                            $item_shipping_cost = 0;
                                            if ($is_shipping_available) {
                                                $shipping_cost_resultset = Database::search(
                                                    "SELECT * FROM `shipping_cost` WHERE `shipping_id`=? AND `country_id`=?",
                                                    [$shipping_data["id"], $user["country_id"]]
                                                );
                                                $shipping_cost_data = $shipping_cost_resultset->fetch_assoc();
                                                $shipping_cost_num = $shipping_cost_resultset->num_rows;
                                                if ($shipping_cost_num == 0) {
                                                    $item_shipping_cost = $shipping_data["general_cost"];
                                                } else if ($shipping_cost_num == 1) {
                                                    if ($shipping_cost_data["shipping_cost"] == null) {
                                                        $item_shipping_cost = $shipping_data["general_cost"];
                                                    } else {
                                                        $item_shipping_cost = $shipping_cost_data["shipping_cost"];
                                                    }
                                                }

                                                $total_shipping_price = $item_shipping_cost * $quantity;
                                                Database::iud(
                                                    "INSERT INTO `invoice`(`order_id`,`product_id`,`qty`,`color_id`,`total_price`,`total_shipping_price`) VALUES
                                                (?,?,?,?,?,?)",
                                                    [$id, $product_id, $quantity, $color, $total_price, $total_shipping_price]
                                                );
                                            } else {
                                                $status = false;
                                                break;
                                            }
                                            // //
                                            // //
                                        } else {
                                            $status = false;
                                            break;
                                        }
                                    } else {
                                        $status = false;
                                        break;
                                    }
                                } else {
                                    $status = false;
                                    break;
                                }
                            } else {
                                $status = false;
                                break;
                            }
                        }
                        if ($status) {
                            echo ("success");
                        }
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
            echo ("Something went wrong!");
        }
    }
}
