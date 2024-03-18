<?php
session_start();
require "../src/php/connection.php";
require "../head.php";
require "../navbar.php";
require "../components/customSelect.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_SESSION["user"])) {
    $user = $_SESSION["user"];
    if (isset($_GET["order_id"])) {
        $order_id = $_GET["order_id"];
        $invoice_resultset = Database::search("SELECT * FROM `invoice` WHERE `users_id`=? and `order_id`=?", [$user["id"], $order_id]);
        $invoice_num = $invoice_resultset->num_rows;
?>
        <!DOCTYPE html>
        <html lang="en">
        <?php
        $title = "UrbanPulse | My Orders";
        head($title);
        ?>


        <body>
            <div id="loader" class="w-screen h-screen fixed top-0 left-0 overflow-hidden flex justify-center items-center z-50 bg-white">
                <div class="spinner"></div>
            </div>

            <?php navbar($user);
            ?>
            <!-- <div class="container mx-auto h-5 bg-red-500 sm:bg-gray-800 md:bg-blue-400 lg:bg-emerald-400 xl:bg-pink-400 2xl:bg-purple-500"></div> -->
            <div class="container h-auto mx-auto flex flex-col justify-start items-center my-10 box-border px-4">
                <nav class="w-full h-[75px]">
                    <div class="container mx-auto h-full flex justify-between items-end">
                        <div class="w-max h-[90%]">
                            <a href="/" class="w-max h-full flex justify-center items-center no-underline">
                                <img src="../assets/images/logo-dark.svg" alt="UrbanPulse" class="h-full">
                            </a>
                        </div>
                        <div class="w-max h-[90%] flex justify-center items-center">
                            <p class="text-3xl text-[var(--main-bg-high)] font-medium capitalize">invoice</p>
                        </div>
                    </div>
                </nav>
                <div class="w-full h-auto flex flex-col-reverse sm:flex-row justify-start sm:justify-between items-start sm:items-center border-b py-3">
                    <div class="w-max h-auto mt-3 sm:mt-0 max-w-full">
                        <p class="font-fm-inter text-sm text-gray-950 capitalize truncate">order: <span class="text-[var(--active-bg)]"><?php echo $order_id; ?></span></p>
                    </div>
                    <div class="w-max h-auto">
                        <p class="font-fm-inter text-xl text-gray-950 capitalize">total: <span id="invoice-total" class="text-[var(--main-bg-high)]">$1442.25</span></p>
                    </div>
                </div>
                <div class="w-full flex flex-col md:flex-row justify-between items-start mt-10 border-b">
                    <div class="w-full md:w-[70%] h-auto flex flex-col justify-start items-start">
                        <?php
                        $subtotal = 0;
                        $total_delivery_fee = 0;
                        for ($i = 0; $i < $invoice_num; $i++) {
                            $invoice_data = $invoice_resultset->fetch_assoc();
                            $product_quantity = $invoice_data["qty"];
                            $datetime_added = $invoice_data["datetime_added"];
                            $datetime_object = new DateTime($datetime_added);
                            $product_resultset = Database::search("SELECT * FROM `product` WHERE `id`=?", [$invoice_data["product_id"]]);
                            $product_data = $product_resultset->fetch_assoc();
                            $product_title = $product_data["title"];
                            $product_price = $product_data["price"];
                            $subtotal += $invoice_data["total"];
                            $seller_resultset = Database::search("SELECT * FROM `users` WHERE `id`=?", [$product_data["users_id"]]);
                            $seller_data = $seller_resultset->fetch_assoc();
                            $product_image_resultset = Database::search("SELECT * FROM `product_image` WHERE `product_id`=? LIMIT 1", [$product_data["id"]]);
                            $product_image_data = $product_image_resultset->fetch_assoc();
                            $brand_has_model_resultset = Database::search("SELECT * FROM `brand_has_model` WHERE `id`=?", [$product_data["brand_has_model_id"]]);
                            $brand_has_model_data = $brand_has_model_resultset->fetch_assoc();
                            $brand_resultset = Database::search("SELECT * FROM `brand` WHERE `id`=?", [$brand_has_model_data["brand_id"]]);
                            $brand_data = $brand_resultset->fetch_assoc();
                            $model_resultset = Database::search("SELECT * FROM `model` WHERE `id`=?", [$brand_has_model_data["model_id"]]);
                            $model_data = $model_resultset->fetch_assoc();
                            $color_resultset = Database::search("SELECT * FROM `color` WHERE `id`=?", [$invoice_data["color_id"]]);
                            $color_data = $color_resultset->fetch_assoc();
                            $condition_resultset = Database::search("SELECT * FROM `condition` WHERE `id`=?", [$product_data["condition_id"]]);
                            $condition_data = $condition_resultset->fetch_assoc();
                            $country_code_resultset = Database::search("SELECT * FROM `country_code` WHERE `id`=?", [$user["country_code_id"]]);
                            $country_code_data = $country_code_resultset->fetch_assoc();
                            $delivery_fee_resultset = Database::search("SELECT * FROM `delivery_fee` WHERE `product_id`=? AND `country_id`=?", [$product_data["id"], $country_code_data["country_id"]]);
                            $delivery_fee_data = $delivery_fee_resultset->fetch_assoc();
                            $total_delivery_fee += $delivery_fee_data["delivery_fee"];
                            $address_line_1 = $user["address_line_1"];
                            $address_line_2 = $user["address_line_2"];
                            $city = $user["city"];
                            $zip_code = $user["zip_code"];
                            $country_resultset = Database::search("SELECT * FROM `country` WHERE `id`=?", [$user["country_id"]]);
                            $country_data = $country_resultset->fetch_assoc();
                            $country = $country_data["country"];
                        ?>
                            <!-- product details  -->
                            <div class="w-full h-auto flex flex-col sm:flex-row justify-start sm:justify-between items-center sm:items-start">
                                <div class="w-3/4 sm:w-60 box-border p-4 aspect-square flex justify-center items-center overflow-hidden">
                                    <img src="../assets/images/products/<?php echo $product_image_data["product_image"]; ?>" alt="Product Image" class="min-w-full min-h-full object-cover">
                                </div>
                                <div class="w-full sm:flex-1 flex flex-col justify-between sm:justify-start items-start h-auto box-border py-2">
                                    <div class="w-full h-auto">
                                        <p class="font-fm-inter text-base text-gray-950"><?php echo $product_title; ?></p>
                                    </div>
                                    <div class="w-full h-auto flex justify-between items-start mt-5">
                                        <div class="w-1/2 h-auto flex flex-col justify-start items-start">
                                            <p class="font-fm-inter text-sm text-gray-800 capitalize my-1">brand: <?php echo $brand_data["brand"]; ?></p>
                                            <p class="font-fm-inter text-sm text-gray-800 capitalize my-1 line-clamp-1">model: <?php echo $model_data["model"]; ?></p>
                                            <p class="font-fm-inter text-sm text-gray-800 capitalize my-1">color: <?php echo $color_data["color"]; ?></p>
                                            <p class="font-fm-inter text-sm text-gray-800 capitalize my-1">condition: <?php echo $condition_data["condition"]; ?></p>
                                        </div>
                                        <div class="w-max sm:w-1/2 h-auto flex flex-col justify-start items-start">
                                            <p class="font-fm-inter text-sm text-gray-900 capitalize my-1">quantity: <?php echo $product_quantity; ?></p>
                                            <p class="font-fm-inter text-base text-gray-950 capitalize my-1">price: <span class="text-[var(--main-bg-high)]">$<?php echo number_format($product_price, 2); ?></span></p>
                                            <p class="font-fm-inter text-sm text-gray-950 capitalize mt-4">sold by:</p>
                                            <a href="#" class="font-fm-inter text-[var(--active-bg)] text-sm capitalize mt-1"><?php echo $seller_data["first_name"] . " " . $seller_data["last_name"] ?></a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- product details  -->
                        <?php
                        }
                        ?>
                    </div>

                    <div class="w-full md:w-[30%] h-auto box-border border-r border-l px-4 py-3">
                        <h3 class="font-fm-inter text-lg font-medium text-left capitalize text-gray-950">total summary</h3>
                        <div class="w-full h-auto grid grid-cols-2 gap-2 mt-4 border-b border-gray-300 pb-3">
                            <div class="h-auto">
                                <p class="font-fm-inter text-base text-left font-normal capitalize text-gray-900">subtotal:</p>
                            </div>
                            <div class="h-auto">
                                <p class="font-fm-inter text-base text-right font-normal capitalize text-gray-900">$<?php echo number_format($subtotal, 2); ?></p>
                            </div>
                            <div class="h-auto">
                                <p class="font-fm-inter text-base text-left font-normal capitalize text-gray-900">delivery fee:</p>
                            </div>
                            <div class="h-auto">
                                <p class="font-fm-inter text-base text-right font-normal capitalize text-gray-900">$<?php echo number_format($total_delivery_fee, 2); ?></p>
                            </div>
                        </div>
                        <div class="w-full h-auto grid grid-cols-2 gap-2 mt-4 pb-3">
                            <div class="h-auto">
                                <p class="font-fm-inter text-lg text-left font-normal capitalize text-gray-950">total:</p>
                            </div>
                            <div class="h-auto">
                                <p class="font-fm-inter text-lg text-right font-normal capitalize text-gray-950">$<?php echo number_format($subtotal + $total_delivery_fee, 2); ?></p>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="w-full flex justify-start items-start mt-10">
                    <div class="w-max mr-32">
                        <h3 class="font-fm-inter text-base font-medium text-left capitalize text-gray-950">placed on:</h3>
                        <p class="font-fm-inter text-gray-800 text-sm capitalize mt-1"><?php echo $datetime_object->format('Y'); ?> <?php echo $datetime_object->format('M'); ?> <?php echo $datetime_object->format('d'); ?></p>
                    </div>
                    <div class="w-max">
                        <h3 class="font-fm-inter text-base font-medium text-left capitalize text-gray-950">address:</h3>
                        <?php
                        if (!empty($address_line_1)) {
                        ?>
                            <p class="font-fm-inter text-gray-800 text-sm capitalize mt-1"><?php echo $address_line_1; ?>,</p>
                        <?php
                        }
                        if (!empty($address_line_2)) {
                        ?>
                            <p class="font-fm-inter text-gray-800 text-sm capitalize mt-1"><?php echo $address_line_2; ?>,</p>
                        <?php
                        }
                        ?>
                        <p class="font-fm-inter text-gray-800 text-sm capitalize mt-1"><?php echo $city; ?>,</p>
                        <p class="font-fm-inter text-gray-800 text-sm capitalize mt-1"><?php echo $country; ?>.</p>
                    </div>
                </div>
            </div>
            <script>
                document.getElementById("invoice-total").innerText = "<?php echo "$" . number_format($subtotal + $total_delivery_fee, 2); ?>"
            </script>
        </body>

        </html>
    <?php
    } else {
    ?>
        <script>
            window.location.href = "/urbanpulse_ecommerce_beta/home/";
        </script>
    <?php
    }
} else {
    ?>
    <script>
        window.location.href = "signin/";
    </script>
<?php
}
?>