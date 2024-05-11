<?php
session_start();
require "../server/connection.php";
require "../head.php";
require "../navbar.php";
require "../components/customSelect.php";


if (isset($_SESSION["user"])) {
    $user = $_SESSION["user"];
} else {
    $user = "";
}
?>

<!DOCTYPE html>
<html lang="en">
<?php
$title = "UrbanPulse | Home";
head($title);
?>

<body>
    <?php navbar($user);
    ?>
    <!-- <div class="container mx-auto h-5 bg-red-500 sm:bg-gray-800 md:bg-blue-400 lg:bg-emerald-400 xl:bg-pink-400 2xl:bg-purple-500"></div> -->

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

    <section class="container mx-auto h-auto relative overflow-hidden flex justify-start">
        <!-- left arrow  -->
        <div banner-arrow="left" class="w-max h-full flex justify-center items-center cursor-default text-slate-100 transition-all duration-100 ease-linear 
        hover:bg-gray-500/20 hover:text-white absolute top-0 left-0 z-10">
            <span class="material-symbols-outlined xl:px-4 px-1 text-inherit xl:!text-[50px] !text-[40px] transition-all duration-100 ease-linear">
                arrow_left
            </span>
        </div>
        <!-- left arrow  -->
        <!-- banner  -->
        <div id="main-banner" data-banner class="min-w-full h-auto flex justify-start items-center transition-all duration-150 ease-linear">
            <a href="#" class="w-full h-auto flex justify-start items-center">
                <picture>
                    <source media="(max-width: 768px)" srcset="../assets/images/banner/banner-1-mobile.png">
                    <img src="../assets/images/banner/banner-1.png" alt="" class="w-full h-auto">
                </picture>
            </a>
        </div>
        <!-- banner  -->
        <!-- banner  -->
        <div data-banner class="min-w-full h-auto flex justify-start items-center transition-all duration-150 ease-linear">
            <a href="#" class="w-full h-auto flex justify-start items-center">
                <picture>
                    <source media="(max-width: 768px)" srcset="../assets/images/banner/banner-2-mobile.png">
                    <img src="../assets/images/banner/banner-2.png" alt="" class="w-full h-auto">
                </picture>
            </a>
        </div>
        <!-- banner  -->
        <!-- banner  -->
        <div data-banner class="min-w-full h-auto flex justify-start items-center transition-all duration-150 ease-linear">
            <a href="#" class="w-full h-auto flex justify-start items-center">
                <picture>
                    <source media="(max-width: 768px)" srcset="../assets/images/banner/banner-3-mobile.png">
                    <img src="../assets/images/banner/banner-3.png" alt="" class="w-full h-auto">
                </picture>
            </a>
        </div>
        <!-- banner  -->
        <!-- right arrow  -->
        <div banner-arrow="right" class="w-max h-full flex justify-center items-center cursor-default text-slate-100 transition-all duration-100 ease-linear 
        hover:bg-gray-500/20 hover:text-white absolute top-0 right-0 z-10">
            <span class="material-symbols-outlined xl:px-4 px-1 text-inherit xl:!text-[50px] !text-[40px] transition-all duration-100 ease-linear">
                arrow_right
            </span>
        </div>
        <!-- left arrow  -->
    </section>

    <!-- popular products  -->
    <section class="container px-3 sm:px-0 mx-auto my-20">
        <div class="w-full flex justify-start items-center mb-5">
            <h3 class="font-fm-inter text-lg font-medium text-left capitalize mr-5">popular products</h3>
            <button data-see-all="popular" class="capitalize font-fm-inter text-sm font-medium text-[var(--active-bg)]">see all</button>
        </div>
        <!-- <div class="bg-red-500 sm:bg-blue-400 md:bg-emerald-300 lg:bg-pink-400 xl:bg-orange-400 2xl:bg-black">A</div> -->
        <div class="w-full h-auto flex justify-start items-center overflow-hidden relative">
            <button data-product-move-left="popular-products" class="h-max w-max absolute left-0 top-1/2 -translate-y-1/2 z-10 transition-all duration-75 ease-linear bg-[var(--main-bg-low)] 
                hover:bg-[var(--main-bg-high)] flex justify-center items-center text-white shadow">
                <span class="material-symbols-outlined !text-4xl !m-0 !p-0">
                    arrow_left
                </span>
            </button>
            <div data-product-move-target="popular-products" class="w-max flex transition-all duration-100 ease-linear relative">
                <?php
                $popular_products_resultset = Database::search("SELECT * FROM `product` ORDER BY `click_count` DESC LIMIT 10;", []);
                $popular_products_num = $popular_products_resultset->num_rows;
                for ($i = 0; $i < $popular_products_num; $i++) {
                    $popular_products_data = $popular_products_resultset->fetch_assoc();
                ?>
                    <!-- product  -->
                    <div class="w-44 md:w-52 lg:w-72 bg-white  rounded-lg shadow">
                        <a href="<?php echo "/urbanpulse_ecommerce_beta/product/?id=" . $popular_products_data["id"] . "&clicked=true"; ?>" class="w-4/5 flex justify-center items-center 
                        aspect-square overflow-hidden mx-auto">
                            <?php
                            $popular_product_img_resultset = Database::search("SELECT * FROM `product_image` WHERE `product_id`=? LIMIT 1", [$popular_products_data["id"]]);
                            $popular_product_img_data = $popular_product_img_resultset->fetch_assoc();
                            ?>
                            <img class="min-w-full min-h-full object-cover" src="../assets/images/products/<?php echo $popular_product_img_data["product_image"]; ?>" alt="product image" />
                        </a>
                        <div class="px-5 pb-5">
                            <a href="<?php echo "/urbanpulse_ecommerce_beta/product/?id=" . $popular_products_data["id"] . "&clicked=true"; ?>">
                                <h5 class="text-sm font-medium tracking-tight text-gray-900 font-fm-inter truncate"><?php echo $popular_products_data["title"]; ?></h5>
                            </a>
                            <div class="flex items-center mt-2.5 mb-5">
                                <svg class="w-3 h-3 xl:w-4 xl:h-4 text-yellow-300 mr-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                    <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                                </svg>
                                <svg class="w-3 h-3 xl:w-4 xl:h-4 text-yellow-300 mr-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                    <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                                </svg>
                                <svg class="w-3 h-3 xl:w-4 xl:h-4 text-yellow-300 mr-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                    <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                                </svg>
                                <svg class="w-3 h-3 xl:w-4 xl:h-4 text-yellow-300 mr-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                    <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                                </svg>
                                <svg class="w-3 h-3 xl:w-4 xl:h-4 text-gray-200 dark:text-gray-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                    <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                                </svg>
                                <span class="bg-blue-100 text-blue-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800 ml-3">5.0</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-md xl:text-xl font-bold text-gray-900 dark:text-white">$<?php echo $popular_products_data["price"]; ?></span>
                                <?php
                                if (isset($_SESSION["user"])) {
                                    $wishlist_resultset = Database::search("SELECT * FROM wishlist WHERE product_id=? AND users_id=?", [$popular_products_data["id"], $user["id"]]);
                                    $wishlist_num = $wishlist_resultset->num_rows;
                                    if ($wishlist_num == 1) {
                                        $wishlist_data = $wishlist_resultset->fetch_assoc();
                                ?>
                                        <button onclick="removeFromWishlist(<?php echo $popular_products_data['id'] ?>, <?php echo $wishlist_data['id'] ?>);" id="add-to-wishlist" class="text-[var(--text-white-high)] bg-[var(--active-bg)] transition-all duration-200 ease-linear hover:bg-[var(--main-bg-low)] 
                    font-medium text-xs xl:text-xs px-4 py-1 capitalize font-fm-inter">
                                            <span class="material-symbols-outlined !text-lg pointer-events-none">
                                                favorite
                                            </span>
                                        </button>
                                    <?php
                                    } else if ($wishlist_num == 0) {
                                    ?>
                                        <button onclick="addToWishlist(<?php echo $popular_products_data['id']; ?>,event)" id="add-to-wishlist" class="text-[var(--text-white-high)] bg-[var(--main-bg-high)] transition-all duration-200 ease-linear hover:bg-[var(--main-bg-low)] 
                    font-medium text-xs px-4 py-1 capitalize font-fm-inter">
                                            <span class="material-symbols-outlined !text-lg pointer-events-none">
                                                favorite
                                            </span>
                                        </button>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <button onclick="addToWishlist(<?php echo $popular_products_data['id']; ?>,event)" id="add-to-wishlist" class="text-[var(--text-white-high)] bg-[var(--main-bg-high)] transition-all duration-200 ease-linear hover:bg-[var(--main-bg-low)] 
                    font-medium text-xs xl:text-xs px-4 py-1 capitalize font-fm-inter">
                                        <span class="material-symbols-outlined !text-lg pointer-events-none">
                                            favorite
                                        </span>
                                    </button>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <!-- product  -->
                <?php
                }
                ?>
            </div>
            <button data-product-move-right="popular-products" class="h-max w-max absolute right-0 top-1/2 -translate-y-1/2 transition-all duration-75 ease-linear bg-[var(--main-bg-low)] 
                hover:bg-[var(--main-bg-high)] flex justify-center items-center text-white z-10">
                <span class="material-symbols-outlined !text-4xl !m-0 !p-0">
                    arrow_right
                </span>
            </button>

        </div>
    </section>
    <!-- popular products  -->

    <?php
    $category_resultset = Database::search("SELECT * FROM `category`", []);
    $category_num = $category_resultset->num_rows;
    for ($j = 0; $j < $category_num; $j++) {
        $category_data = $category_resultset->fetch_assoc();
    ?>
        <!-- popular products  -->
        <section class="container px-3 sm:px-0 mx-auto my-20">
            <div class="w-full flex justify-start items-center mb-5">
                <h3 class="font-fm-inter text-lg font-medium text-left capitalize mr-5"><?php echo $category_data["category"]; ?></h3>
                <button data-see-all="<?php echo $category_data["id"]; ?>" class="capitalize font-fm-inter text-sm font-medium text-[var(--active-bg)]">see all</button>
            </div>
            <div class="w-full h-auto flex justify-start items-center overflow-hidden relative">
                <button data-product-move-left="category-<?php echo $category_data["id"]; ?>" class="h-max w-max absolute left-0 top-1/2 -translate-y-1/2 z-10 transition-all duration-75 ease-linear bg-[var(--main-bg-low)] 
                hover:bg-[var(--main-bg-high)] flex justify-center items-center text-white shadow">
                    <span class="material-symbols-outlined !text-4xl !m-0 !p-0">
                        arrow_left
                    </span>
                </button>
                <div data-product-move-target="category-<?php echo $category_data["id"]; ?>" class="w-max flex transition-all duration-100 ease-linear relative">
                    <?php
                    $products_resultset = Database::search("SELECT * FROM `product` WHERE `category_id`=?", [$category_data["id"]]);
                    $products_num = $products_resultset->num_rows;
                    for ($i = 0; $i < $products_num; $i++) {
                        $products_data = $products_resultset->fetch_assoc();
                    ?>
                        <!-- product  -->
                        <div class="w-44 md:w-52 lg:w-72 bg-white  rounded-lg shadow">
                            <a href="<?php echo "/urbanpulse_ecommerce_beta/product/?id=" . $products_data["id"] . "&clicked=true"; ?>" class="w-4/5 flex justify-center items-center 
                        aspect-square overflow-hidden mx-auto">
                                <?php
                                $product_img_resultset = Database::search("SELECT * FROM `product_image` WHERE `product_id`=? LIMIT 1", [$products_data["id"]]);
                                $product_img_data = $product_img_resultset->fetch_assoc();
                                ?>
                                <img class="min-w-full min-h-full object-cover" src="../assets/images/products/<?php echo $product_img_data["product_image"]; ?>" alt="product image" />
                            </a>
                            <div class="px-5 pb-5">
                                <a href="<?php echo "/urbanpulse_ecommerce_beta/product/?id=" . $products_data["id"] . "&clicked=true"; ?>">
                                    <h5 class="text-sm font-medium tracking-tight text-gray-900 font-fm-inter truncate"><?php echo $products_data["title"]; ?></h5>
                                </a>
                                <div class="flex items-center mt-2.5 mb-5">
                                    <svg class="w-3 h-3 xl:w-4 xl:h-4 text-yellow-300 mr-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                        <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                                    </svg>
                                    <svg class="w-3 h-3 xl:w-4 xl:h-4 text-yellow-300 mr-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                        <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                                    </svg>
                                    <svg class="w-3 h-3 xl:w-4 xl:h-4 text-yellow-300 mr-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                        <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                                    </svg>
                                    <svg class="w-3 h-3 xl:w-4 xl:h-4 text-yellow-300 mr-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                        <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                                    </svg>
                                    <svg class="w-3 h-3 xl:w-4 xl:h-4 text-gray-200 dark:text-gray-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                        <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                                    </svg>
                                    <span class="bg-blue-100 text-blue-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800 ml-3">5.0</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-md xl:text-xl font-bold text-gray-900 dark:text-white">$<?php echo $products_data["price"]; ?></span>
                                    <?php
                                    if (isset($_SESSION["user"])) {
                                        $wishlist_resultset = Database::search("SELECT * FROM wishlist WHERE product_id=? AND users_id=?", [$products_data["id"], $user["id"]]);
                                        $wishlist_num = $wishlist_resultset->num_rows;
                                        if ($wishlist_num == 1) {
                                            $wishlist_data = $wishlist_resultset->fetch_assoc();
                                    ?>
                                            <button onclick="removeFromWishlist(<?php echo $products_data['id'] ?>, <?php echo $wishlist_data['id'] ?>);" id="add-to-wishlist" class="text-[var(--text-white-high)] bg-[var(--active-bg)] transition-all duration-200 ease-linear hover:bg-[var(--main-bg-low)] 
                    font-medium text-xs xl:text-xs px-4 py-1 capitalize font-fm-inter">
                                                <span class="material-symbols-outlined !text-lg pointer-events-none">
                                                    favorite
                                                </span>
                                            </button>
                                        <?php
                                        } else if ($wishlist_num == 0) {
                                        ?>
                                            <button onclick="addToWishlist(<?php echo $products_data['id']; ?>,event)" id="add-to-wishlist" class="text-[var(--text-white-high)] bg-[var(--main-bg-high)] transition-all duration-200 ease-linear hover:bg-[var(--main-bg-low)] 
                    font-medium text-xs px-4 py-1 capitalize font-fm-inter">
                                                <span class="material-symbols-outlined !text-lg pointer-events-none">
                                                    favorite
                                                </span>
                                            </button>
                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <button onclick="addToWishlist(<?php echo $products_data['id']; ?>,event)" id="add-to-wishlist" class="text-[var(--text-white-high)] bg-[var(--main-bg-high)] transition-all duration-200 ease-linear hover:bg-[var(--main-bg-low)] 
                    font-medium text-xs xl:text-xs px-4 py-1 capitalize font-fm-inter">
                                            <span class="material-symbols-outlined !text-lg pointer-events-none">
                                                favorite
                                            </span>
                                        </button>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <!-- product  -->
                    <?php
                    }
                    ?>
                </div>
                <button data-product-move-right="category-<?php echo $category_data["id"]; ?>" class="h-max w-max absolute right-0 top-1/2 -translate-y-1/2 transition-all duration-75 ease-linear bg-[var(--main-bg-low)] 
                hover:bg-[var(--main-bg-high)] flex justify-center items-center text-white z-10">
                    <span class="material-symbols-outlined !text-4xl !m-0 !p-0">
                        arrow_right
                    </span>
                </button>

            </div>
        </section>
        <!-- popular products  -->
    <?php
    }
    ?>

    <script src="../assets/js/banner.js"></script>
    <script src="../assets/js/signout.js"></script>
    <script src="../assets/js/scrollProducts.js"></script>
    <script type="module" src="../assets/js/addToWishlist.js"></script>
    <script type="module" src="../assets/js/wishlist.js"></script>
</body>

</html>