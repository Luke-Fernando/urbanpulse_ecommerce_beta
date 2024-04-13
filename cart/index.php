<?php
session_start();
require "../src/php/connection.php";
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
                    ?>
                        <div class="w-full flex justify-start items-start mb-5 border p-4">
                            <!-- image  -->
                            <a href="#" class="flex justify-center items-center overflow-hidden h-28 aspect-square">
                                <img src="../assets/images/products/<?php echo $product_image_data["product_image"]; ?>" alt="" class="min-h-full min-w-full object-cover">
                            </a>
                            <!-- image  -->
                            <!-- title  -->
                            <div class="flex-1 flex flex-col justify-start items-start h-auto px-4 pt-3">
                                <a href="#" class="font-fm-inter text-gray-800 text-sm"><?php echo $product_data["title"]; ?></a>
                                <p class="font-fm-inter text-gray-500 text-xs capitalize mt-1">color: <span><?php echo $color_data["color"]; ?></span></p>
                                <p class="font-fm-inter text-gray-500 text-xs capitalize mt-1">condition: <span><?php echo $condition_data["condition"]; ?></span></p>
                                <div class="w-full h-auto flex justify-start items-center mt-2">
                                    <p class="font-fm-inter text-sm font-medium text-[var(--main-bg-high)]">$<?php echo $product_data["price"]; ?></p>
                                    <!-- quantity  -->
                                    <div class="h-auto flex justify-center items-center ml-8">
                                        <button onclick="changeQuantity('decrease',<?php echo $product_data['id']; ?>);" class="h-3 w-max py-5 flex justify-center items-center rounded-s-2xl bg-gray-100 text-gray-50 hover:bg-gray-200 
                                transition-all duration-100 ease-linear">
                                            <span class="material-symbols-outlined p-1 text-[var(--main-bg-low)] opacity-80 !text-xs">
                                                remove
                                            </span>
                                        </button>
                                        <div class="h-3 w-max flex justify-center items-center">
                                            <p class="text-xs font-fm-inter px-2 text-gray-600"><?php echo $cart_data["qty"]; ?></p>
                                        </div>
                                        <button onclick="changeQuantity('increase',<?php echo $product_data['id']; ?>);" class="h-3 w-max py-5 flex justify-center items-center rounded-e-2xl bg-gray-100 text-gray-50 hover:bg-gray-200 
                                transition-all duration-100 ease-linear">
                                            <span class="material-symbols-outlined rounded-full p-1 text-[var(--main-bg-low)] opacity-80 !text-xs">
                                                add
                                            </span>
                                        </button>
                                    </div>
                                    <!-- quantity  -->
                                </div>
                            </div>
                            <!-- title  -->
                            <div class="flex flex-col justify-between items-center w-max h-28 py-3">

                                <!-- remove  -->
                                <div class="h-auto flex flex-col justify-between items-center w-max">
                                    <button onclick="addToWishlist(<?php echo $product_data['id']; ?>);" class="flex justify-center items-center mx-1 text-[var(--main-bg-low)] hover:text-[var(--main-bg-high)] transition-all duration-100 ease-linear">
                                        <span class="material-symbols-outlined text-inherit !text-2xl">
                                            favorite
                                        </span>
                                    </button>
                                    <button onclick="removeFromCart(<?php echo $cart_data['product_id'] . ',' . $cart_data['id']; ?>);" class="flex justify-center items-center mx-1 text-[var(--main-bg-low)] hover:text-[var(--main-bg-high)] transition-all duration-100 ease-linear">
                                        <span class="material-symbols-outlined text-inherit !text-2xl">
                                            delete
                                        </span>
                                    </button>
                                </div>
                                <!-- remove  -->
                            </div>


                        </div>
                    <?php
                    }
                    ?>
                    <!-- cart item  -->
                </section>
                <!-- cart  -->
                <!-- sub total  -->
                <section class="w-full lg:w-[38%] h-auto border p-4">
                    <div class="flex justify-between items-center h-auto w-full">
                        <p class="font-fm-inter capitalize">items <span>(<?php echo $cart_num; ?>)</span></p>
                        <?php
                        $total_price_resultset = Database::search("SELECT SUM(total) FROM cart", []);
                        $total_price_data = $total_price_resultset->fetch_assoc();
                        $total_price = $total_price_data["SUM(total)"];
                        ?>
                        <p class="font-fm-inter capitalize">US $<?php echo $total_price; ?></p>
                    </div>
                    <div class="flex justify-between items-center h-auto w-full mt-3">
                        <?php
                        $cart_resultset = Database::search("SELECT * FROM `cart`", []);
                        $cart_num = $cart_resultset->num_rows;
                        $country_resultset = Database::search("SELECT * FROM country WHERE id=(SELECT country_id FROM country_code 
                    WHERE id=(SELECT country_code_id FROM users WHERE id=?));", [$user["id"]]);
                        $country_data = $country_resultset->fetch_assoc();
                        $shipping_total = 0;
                        for ($i = 0; $i < $cart_num; $i++) {
                            $cart_data = $cart_resultset->fetch_assoc();
                            $product_resultset = Database::search("SELECT * FROM `product` WHERE `id`=?", [$cart_data["product_id"]]);
                            $product_data = $product_resultset->fetch_assoc();
                            $shipping_resultset = Database::search(
                                "SELECT delivery_fee FROM delivery_fee WHERE country_id=? AND product_id=?",
                                [$country_data["id"], $product_data["id"]]
                            );
                            $shipping_data = $shipping_resultset->fetch_assoc();
                            $shipping_total += $shipping_data["delivery_fee"];
                        }
                        $subtotal = $total_price + $shipping_total;
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
        <script type="module" src="../assets/js/cart.js"></script>
        <script type="module" src="../assets/js/addToWishlist.js"></script>
        <script type="module" src="../assets/js/addToWishlist.js"></script>
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