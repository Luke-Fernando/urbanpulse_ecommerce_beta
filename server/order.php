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

    public function __construct()
    {
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

    public function generate_placed_products_costs()
    {
        if ($this->check_session()) {
            if (isset($_POST["products"])) {
                if (sizeof(json_decode($_POST["products"])) > 0) {
                    $user = $_SESSION["user"];
                    $products = json_decode($_POST["products"]);
                    $items = sizeof(json_decode($_POST["products"]));
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
                    echo json_encode($details_array);
                }
            }
        }
    }
}
