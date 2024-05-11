<?php
session_start();
require "../server/connection.php";
require "../head.php";
require "../navbar.php";
require "../components/customSelect.php";
require "../components/cusCheck.php";

if (isset($_SESSION["user"])) {
    $user = $_SESSION["user"];
?>
    <!DOCTYPE html>
    <html lang="en">

    <?php
    $title = "UrbanPulse | Cart";
    head($title);
    ?>

    <body>
        <?php navbar($user);
        ?>

        <div class="w-max fixed top-10 left-1/2 -translate-x-1/2 z-50">
            <div id="success" class="items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50 transition-opacity duration-300 ease-out opacity-0 hidden" role="alert">
                <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>
                <span class="sr-only">Info</span>
                <div id="success-content" class="ml-3 text-sm font-medium mr-10 font-fm-inter capitalize">
                    item added successfully.
                </div>
                <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 
            hover:bg-green-200 inline-flex items-center justify-center h-8 w-8" data-dismiss-target="#success" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
            <div id="error" class="items-center p-4 mb-4 text-red-800 rounded-lg bg-red-50 transition-opacity duration-300 ease-out opacity-0 hidden" role="alert">
                <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>
                <span class="sr-only">Info</span>
                <div id="error-content" class="ml-3 text-sm font-medium mr-10 capitalize">
                    something went wrong!
                </div>
                <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 
            hover:bg-red-200 inline-flex items-center justify-center h-8 w-8" data-dismiss-target="#error" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="container mx-auto my-10 capitalize">
            <h1 class="font-fm-inter text-2xl text-gray-800 font-medium">shopping cart</h1>
        </div>
        <?php
        $cart_resultset = Database::search("SELECT * FROM `cart` WHERE `users_id`=?", [$user["id"]]);
        $cart_num = $cart_resultset->num_rows;
        if ($cart_num != 0) {
        ?>
            <div class="container mx-auto mt-5 flex flex-col justify-start items-center lg:flex-row lg:justify-between lg:items-start px-3 sm:px-0">
                <!-- cart  -->
                <section class="w-full lg:w-7/12">
                    <!-- cart item  -->
                    <?php
                    $items_total = 0;
                    $shipping_total = 0;
                    $shippping_unavailable_products = array();
                    for ($i = 0; $i < $cart_num; $i++) {
                        $cart_data = $cart_resultset->fetch_assoc();
                        $product_image_resultset = Database::search("SELECT * FROM `product_image` WHERE `product_id`=? LIMIT 1", [$cart_data["product_id"]]);
                        $product_image_data = $product_image_resultset->fetch_assoc();
                        $product_resultset = Database::search("SELECT * FROM `product` WHERE `id`=?", [$cart_data["product_id"]]);
                        $product_data = $product_resultset->fetch_assoc();
                        $color_resultset = Database::search("SELECT * FROM color WHERE id=?", [$cart_data["color_id"]]);
                        $color_data = $color_resultset->fetch_assoc();
                        $condition_resultset = Database::search("SELECT * FROM `condition` WHERE id=?", [$product_data["condition_id"]]);
                        $condition_data = $condition_resultset->fetch_assoc();
                        //
                        // check shipping availability
                        $is_shipping_available = true;
                        $shipping_resultset = Database::search("SELECT * FROM `shipping` WHERE `product_id`=?;", [$cart_data["product_id"]]);
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

                            $quantity = $cart_data["qty"];
                            $item_price = $product_data["price"];
                            $item_shipping_cost_total = $item_shipping_cost * $quantity;
                            $shipping_total += $item_shipping_cost_total;
                            $item_total = $item_price * $quantity;
                            $items_total += $item_total;
                        }
                    ?>
                        <div data-cart-item="<?php echo $cart_data["id"]; ?>" class="w-full flex justify-start items-start mb-5 border p-4">
                            <!-- image  -->
                            <a href="<?php echo "../product/?id=" . $product_data["id"] . "&clicked=true"; ?>" class="flex justify-center items-center overflow-hidden h-28 aspect-square">
                                <img src="../assets/images/products/<?php echo $product_image_data["product_image"]; ?>" alt="" class="min-h-full min-w-full object-cover">
                            </a>
                            <!-- image  -->
                            <!-- title  -->
                            <div class="flex-1 flex flex-col justify-start items-start h-auto px-4 pt-3">
                                <a href="<?php echo "../product/?id=" . $product_data["id"] . "&clicked=true"; ?>" class="font-fm-inter text-gray-800 text-sm"><?php echo $product_data["title"]; ?></a>
                                <p class="font-fm-inter text-gray-500 text-xs capitalize mt-1">color: <span><?php echo $color_data["color"]; ?></span></p>
                                <p class="font-fm-inter text-gray-500 text-xs capitalize mt-1">condition: <span><?php echo $condition_data["condition"]; ?></span></p>
                                <div class="w-full h-auto flex justify-start items-center mt-2">
                                    <p class="font-fm-inter text-sm font-medium text-[var(--main-bg-high)]">$<?php echo $product_data["price"]; ?></p>
                                    <!-- quantity  -->
                                    <div class="h-7 flex justify-center items-center ml-8">
                                        <button data-cart-decrease="<?php echo $cart_data["id"]; ?>" class="h-full w-max flex justify-center items-center rounded-s-md bg-gray-100 
                                        text-gray-50 hover:bg-gray-200 
                                transition-all duration-100 ease-linear">
                                            <span class="material-symbols-outlined p-1 text-[var(--main-bg-low)] opacity-80 !text-xs pointer-events-none">
                                                remove
                                            </span>
                                        </button>
                                        <div class="h-full w-max flex justify-center items-center">
                                            <p data-cart-quantity="<?php echo $cart_data["id"]; ?>" class="text-xs font-fm-inter px-2 text-gray-600"><?php echo $cart_data["qty"]; ?></p>
                                        </div>
                                        <button data-cart-increase="<?php echo $cart_data["id"]; ?>" class="h-full w-max flex justify-center items-center rounded-e-md bg-gray-100 
                                        text-gray-50 hover:bg-gray-200 
                                transition-all duration-100 ease-linear">
                                            <span class="material-symbols-outlined rounded-full p-1 text-[var(--main-bg-low)] opacity-80 !text-xs pointer-events-none">
                                                add
                                            </span>
                                        </button>
                                    </div>
                                    <!-- quantity  -->
                                </div>
                                <?php
                                if (!$is_shipping_available) {
                                ?>
                                    <p class="text-xs font-fm-inter text-red-500 capitalize">Shipping unavailable for your country</p>
                                <?php
                                }
                                ?>
                            </div>
                            <!-- title  -->
                            <div class="flex flex-col justify-between items-center w-max h-28 py-3">

                                <!-- remove  -->
                                <div class="h-auto flex flex-col justify-between items-center w-max">
                                    <button data-cart-wishlist="<?php echo $cart_data["id"]; ?>" class="flex justify-center items-center mx-1 text-[var(--main-bg-low)] 
                                    hover:text-[var(--main-bg-high)] transition-all duration-100 ease-linear">
                                        <span class="material-symbols-outlined text-inherit !text-2xl pointer-events-none">
                                            favorite
                                        </span>
                                    </button>
                                    <button data-cart-delete="<?php echo $cart_data["id"]; ?>" class="flex justify-center items-center mx-1 text-[var(--main-bg-low)] 
                                    hover:text-[var(--main-bg-high)] transition-all duration-100 ease-linear">
                                        <span class="material-symbols-outlined text-inherit !text-2xl pointer-events-none">
                                            delete
                                        </span>
                                    </button>
                                </div>
                                <!-- remove  -->
                            </div>


                        </div>
                    <?php
                    }
                    $subtotal = $items_total + $shipping_total;
                    ?>
                    <!-- cart item  -->
                </section>
                <!-- cart  -->
                <!-- sub total  -->
                <section class="w-full lg:w-[38%] h-auto border p-4">
                    <div class="flex justify-between items-center h-auto w-full">
                        <p class="font-fm-inter capitalize">items <span>(<?php echo $cart_num; ?>)</span></p>
                        <p class="font-fm-inter capitalize">US $<?php echo $items_total; ?></p>
                    </div>
                    <div class="flex justify-between items-center h-auto w-full mt-3">
                        <?php
                        $country_resultset = Database::search("SELECT * FROM country WHERE id=?;", [$user["country_id"]]);
                        $country_data = $country_resultset->fetch_assoc();
                        ?>
                        <p class="font-fm-inter capitalize">shipping to <span><?php echo $country_data["country"]; ?></span></p>
                        <p class="font-fm-inter capitalize">US $<?php echo $shipping_total; ?></p>
                    </div>
                    <div class="flex justify-between items-center h-auto w-full border border-r-0 border-l-0 border-b-0 pt-3 mt-4">
                        <p class="font-fm-inter capitalize text-xl text-gray-900 font-medium">subtotal</p>
                        <p class="font-fm-inter capitalize text-xl text-gray-900 font-medium">US $<?php echo $subtotal; ?></p>
                    </div>
                    <button type="button" class="w-full text-white bg-[var(--main-bg-low)] hover:bg-[var(--main-bg-high)] focus:ring-0 transition-all 
                duration-100 ease-linear font-medium rounded-lg text-lg py-2.5 mt-5 font-fm-inter capitalize">go to checkout</button>
                </section>
                <!-- sub total  -->
            </div>
        <?php
        } else {
        ?>
            <div class="container h-auto mx-auto flex flex-col justify-center items-center">
                <img src="../assets/images/cart/empty-cart.svg" alt="" class="w-3/4 lg:w-1/2 pointer-events-none">
                <a href="/urbanpulse_ecommerce_beta/home/" class="w-1/2 flex justify-center items-center text-white bg-[var(--main-bg-low)] hover:bg-[var(--main-bg-high)] focus:ring-0 transition-all 
                duration-100 ease-linear font-medium rounded-lg text-lg py-2.5 mt-5 font-fm-inter capitalize">go to shopping</a>
            </div>
        <?php
        }
        ?>


        <script src="../assets/js/cusCheck.js"></script>
    </body>

    </html>
<?php
} else {
?>
    <script>
        window.location.href = "/urbanpulse_ecommerce_beta/signin/";
    </script>
<?php
}

?>