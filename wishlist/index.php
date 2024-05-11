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
    $title = "UrbanPulse | Wishlist";
    head($title);
    ?>

    <body>
        <?php navbar($user);
        ?>
        <!-- <div class="container mx-auto h-5 bg-red-500 sm:bg-gray-700 md:bg-blue-400 lg:bg-emerald-400 xl:bg-pink-400 2xl:bg-purple-500"></div> -->
        <div class="container mx-auto my-10 capitalize px-3 sm:px-0">
            <h1 class="font-fm-inter text-2xl text-gray-800 font-medium">wishlist</h1>
        </div>
        <!-- <div class="container mx-auto h-5 bg-red-500 md:bg-blue-400 lg:bg-emerald-400 xl:bg-pink-400 2xl:bg-purple-500"></div> -->
        <?php
        $wishlist_resultset = Database::search("SELECT * FROM `wishlist` WHERE `users_id`=?", [$user["id"]]);
        $wishlist_num = $wishlist_resultset->num_rows;
        if ($wishlist_num != 0) {
        ?>
            <div class="container px-3 sm:px-0 mx-auto mt-5 flex flex-col justify-start items-center">
                <!-- cart  -->
                <section class="w-full">
                    <!-- cart item  -->
                    <?php
                    for ($i = 0; $i < $wishlist_num; $i++) {
                        $wishlist_data = $wishlist_resultset->fetch_assoc();
                        $product_image_resultset = Database::search("SELECT * FROM `product_image` WHERE `product_id`=? LIMIT 1", [$wishlist_data["product_id"]]);
                        $product_image_data = $product_image_resultset->fetch_assoc();
                        $product_resultset = Database::search("SELECT * FROM `product` WHERE `id`=?", [$wishlist_data["product_id"]]);
                        $product_data = $product_resultset->fetch_assoc();
                        $condition_resultset = Database::search("SELECT * FROM `condition` WHERE id=?", [$product_data["condition_id"]]);
                        $condition_data = $condition_resultset->fetch_assoc();
                    ?>
                        <div class="w-full flex flex-row justify-start items-start mb-5 border border-l-0 border-r-0 p-4">
                            <!-- image  -->
                            <a href="<?php echo "productPage.php?id=" . $product_data["id"] . "&clicked=true"; ?>" class="flex justify-center items-center overflow-hidden h-24 sm:h-36 aspect-square">
                                <img src="../assets/images/products/<?php echo $product_image_data["product_image"]; ?>" alt="" class="min-h-full min-w-full object-cover">
                            </a>
                            <!-- image  -->
                            <!-- title  -->
                            <div class="flex-1 flex flex-col justify-start items-start h-auto px-4 pt-0 sm:pt-3">
                                <a href="<?php echo "productPage.php?id=" . $product_data["id"] . "&clicked=true"; ?>" class="font-fm-inter text-gray-800 text-sm sm:text-base"><?php echo $product_data["title"]; ?></a>
                                <p class="font-fm-inter text-gray-500 text-xs capitalize mt-1">condition: <span><?php echo $condition_data["condition"]; ?></span></p>
                                <p class="font-fm-inter text-gray-500 text-xs capitalize mt-1"><span><?php echo $product_data["qty"]; ?></span> items available</p>
                                <p class="font-fm-inter text-sm font-medium text-[var(--main-bg-high)] mt-3 mb-2">$<?php echo $product_data["price"]; ?></p>
                            </div>
                            <!-- title  -->
                            <!-- remove  -->
                            <div class="h-24 flex flex-col justify-center items-center w-max">
                                <a href="<?php echo "productPage.php?id=" . $product_data["id"] . "&clicked=true"; ?>" title="Buy Now" class="my-2 flex justify-center items-center text-[var(--main-bg-low)] hover:text-[var(--main-bg-high)] transition-all duration-100 ease-linear">
                                    <span class="material-symbols-outlined text-inherit !text-xl sm:!text-2xl">
                                        move_item
                                    </span>
                                </a>
                                <button onclick="removeFromWishlist(<?php echo $product_data['id'] ?>, <?php echo $wishlist_data['id'] ?>);" class="my-2 flex justify-center items-center text-[var(--main-bg-low)] hover:text-[var(--main-bg-high)] transition-all duration-100 ease-linear">
                                    <span class="material-symbols-outlined text-inherit !text-xl sm:!text-2xl">
                                        delete
                                    </span>
                                </button>
                            </div>
                            <!-- remove  -->
                        </div>
                    <?php
                    }
                    ?>
                    <!-- cart item  -->
                </section>
                <!-- cart  -->
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

        <script type="module" src="../assets/js/wishlist.js"></script>
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