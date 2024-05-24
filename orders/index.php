<?php
session_start();
require "../server/connection.php";
require "../head.php";
require "../navbar.php";
require "../components/customSelect.php";

if (isset($_SESSION["user"])) {
    $user = $_SESSION["user"];
    $order_resultset = Database::search("SELECT * FROM `order` WHERE `users_id`=?", [$user["id"]]);
    $order_num = $order_resultset->num_rows;
?>
    <!DOCTYPE html>
    <html lang="en">
    <?php
    $title = "UrbanPulse | My Orders";
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
            <h1 class="font-fm-inter text-2xl text-gray-800 font-medium">my orders</h1>
        </div>
        <!-- <div class="container mx-auto h-5 bg-red-500 sm:bg-gray-800 md:bg-blue-400 lg:bg-emerald-400 xl:bg-pink-400 2xl:bg-purple-500"></div> -->

        <div class="container mx-auto h-auto flex flex-col justify-start items-center">
            <?php
            for ($j = 0; $j < $order_num; $j++) {
                $order_data = $order_resultset->fetch_assoc();
                $order_id = $order_data["id"];
                $invoice_resultset = Database::search("SELECT * FROM `invoice` WHERE `order_id`=?", [$order_id]);
                $invoice_num = $invoice_resultset->num_rows;
                for ($i = 0; $i < $invoice_num; $i++) {
                    $invoice_data = $invoice_resultset->fetch_assoc();
                    $product_resultset = Database::search("SELECT * FROM `product` WHERE `id`=?", [$invoice_data["product_id"]]);
                    $product_data = $product_resultset->fetch_assoc();
                    $product_title = $product_data["title"];
                    $product_img_resultset = Database::search("SELECT * FROM `product_image` WHERE `product_id`=? LIMIT 1", [$invoice_data["product_id"]]);
                    $product_img_data = $product_img_resultset->fetch_assoc();
                    $product_img = $product_img_data["product_image"];
                    $quantity = $invoice_data["qty"];
                    $date = $order_data["datetime_ordered"];
                    $price = $invoice_data["total_price"];
                    $shipping = $invoice_data["total_shipping_price"];
                    $total = $price + $shipping;
                    $order_id = $order_data["order"];
            ?>
                    <!-- order  -->
                    <div class="w-full border-b h-auto flex flex-wrap justify-start sm:justify-between items-start py-4">
                        <a href="#" class="w-3/12 sm:w-56 aspect-square flex justify-center items-center overflow-hidden">
                            <img class="min-w-full min-h-full object-cover" src="../assets/images/products/<?php echo $product_img; ?>" alt="">
                        </a>
                        <div class="w-3/4 sm:flex-1 h-auto box-border py-4 px-6 flex flex-col justify-start items-start">
                            <div class="w-full h-auto">
                                <a href="#" class="font-fm-inter line-clamp-2 font-normal text-sm lg:text-base"><?php echo $product_title; ?></a>
                            </div>
                            <span class="bg-green-100 text-green-800 text-xs font-medium mt-1 px-2.5 py-0.5 rounded border border-green-400 font-fm-inter capitalize">purchased</span>
                            <div class="w-max h-auto mt-4">
                                <p class="font-fm-inter text-sm text-gray-600 capitalize">quantity: <?php echo $quantity; ?></p>
                            </div>
                            <div class="w-max h-auto mt-2">
                                <p class="font-fm-inter text-sm text-gray-600 capitalize">date: <?php echo $date; ?></p>
                            </div>
                            <div class="w-max h-auto mt-4">
                                <p class="font-fm-inter text-base text-gray-800 capitalize">total: $<?php echo $total; ?></p>
                            </div>
                        </div>
                        <div class="w-full sm:w-max h-auto flex flex-row sm:flex-col justify-center sm:justify-start items-center sm:items-end box-content sm:p-4">
                            <div class="w-max h-auto mx-3 sm:mx-0">
                                <a href="/urbanpulse_ecommerce_beta/invoice/?order_id=<?php echo $order_id; ?>" class="font-fm-inter font-normal text-sm capitalize text-[var(--active-bg)]">invoice</a>
                            </div>
                            <div class="w-max h-auto mx-3 sm:mx-0 sm:mt-5">
                                <a href="/urbanpulse_ecommerce_beta/add-review/?invoice_id=<?php echo $invoice_data["id"] ?>" class="font-fm-inter font-normal text-sm capitalize text-[var(--active-bg)]">review item</a>
                            </div>
                        </div>
                    </div>
                    <!-- order  -->
            <?php
                }
            }
            ?>

        </div>
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