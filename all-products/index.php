<?php
session_start();
require "../server/connection.php";
require "../head.php";
require "../navbar.php";
require "../components/customSelect.php";
require "../components/cusCheck.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (isset($_POST["popular"]) || isset($_POST["search"]) || isset($_POST["category"])) {
    //
    //
}
$products_per_page = 8;
if (isset($_GET["page"])) {
    $current_page = $_GET["page"];
} else {
    $current_page = 1;
}
$offset = $products_per_page * ($current_page - 1);
if (isset($_SESSION["user"])) {
    $user = $_SESSION["user"];
} else {
    $user = "";
}

?>

<!DOCTYPE html>
<html lang="en">

<?php
$title = "UrbanPulse | Products";
head($title);
?>

<body>
    <!--  -->
    <?php
    //
    if (isset($_GET["search"]) && isset($_GET["category"])) {
        $category = $_GET["category"];
        $search_text = str_replace("+", " ", $_GET["search"]);
        $search = '%' . $search_text . '%';
        Database::iud_nor("DROP VIEW IF EXISTS `output_products`");
        Database::iud_nor("CREATE VIEW `output_products` AS SELECT * FROM `product` WHERE (`title` LIKE '$search' OR `description` LIKE '$search') AND category_id='$category'");
    } else if (isset($_GET["search"]) && !isset($_GET["category"])) {
        $search_text = str_replace("+", " ", $_GET["search"]);
        $search = '%' . $search_text . '%';
        Database::iud_nor("DROP VIEW IF EXISTS `output_products`");
        Database::iud_nor("CREATE VIEW `output_products` AS SELECT * FROM `product` WHERE `title` LIKE '$search' OR `description` LIKE '$search'");
    } else if (!isset($_GET["search"]) && isset($_GET["category"])) {
        $category = $_GET["category"];
        Database::iud_nor("DROP VIEW IF EXISTS `output_products`");
        Database::iud_nor("CREATE VIEW `output_products` AS SELECT * FROM `product` WHERE category_id='$category'");
    }
    //
    if (isset($_GET["popular"])) {
        Database::iud_nor("CREATE VIEW `output_products` AS SELECT * FROM `product`");
    }
    $product_resultset = Database::search("SELECT * FROM `output_products` LIMIT ? OFFSET ?", [$products_per_page, $offset]);
    $product_num = $product_resultset->num_rows;
    ?>

    <!--  -->
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

    <section class="container mx-auto h-auto mt-10 px-3 sm:px-0">
        <div class="container mx-auto my-10 capitalize">
            <h1 class="font-fm-inter text-xl text-gray-800 font-medium">
                <?php
                if (isset($_GET["popular"])) {
                    echo ("popular products");
                }
                if (isset($_GET["category"]) && !isset($_GET["search"])) {
                    $category_resultset = Database::search("SELECT * FROM `category` WHERE id=?", [$category]);
                    $category_data = $category_resultset->fetch_assoc();
                    echo $category_data["category"];
                }
                if (isset($_GET["search"])) {
                    echo ("search results");
                }
                ?>
            </h1>
        </div>
        <div class="w-full h-auto flex flex-col justify-start items-start">
            <button data-drawer-toggle="filter" class="flex justify-center items-center w-max h-auto font-fm-inter capitalize rounded-xl py-1 px-2 
            bg-[var(--main-bg-low)] hover:bg-[var(--main-bg-high)] text-[var(--text-white-high)] text-sm transition-all duration-100 ease-linear hover:text-[var(--text-white-high)]">
                filter
                <span class="material-symbols-outlined pl-2 !text-lg">
                    tune
                </span>
            </button>
        </div>
        <section id="all-products" class="flex flex-row justify-end mt-5 h-auto relative overflow-x-hidden">
            <!-- drawer  -->
            <div data-drawer="filter" class="min-w-max w-max min-h-full h-max absolute overflow-y-auto lg:overflow-hidden lg:relative left-0 top-0 bg-white border-r-2 border-r-gray-200 
            -ml-[200%] transition-all duration-300 ease-linear p-4 sm:pr-20">
                <!-- filter section -->
                <div class="flex flex-col justify-start items-start">
                    <p class="font-fm-inter text-gray-900 text-base font-medium capitalize mb-3">condition</p>
                    <?php
                    $condition_resultset = Database::search("SELECT * FROM `condition`", []);
                    $condition_num = $condition_resultset->num_rows;
                    for ($i = 0; $i < $condition_num; $i++) {
                        $condition_data = $condition_resultset->fetch_assoc();
                    ?>
                        <div class="w-full h-auto my-1 pl-3">
                            <?php customCheck("text-sm", "condition-" . $condition_data["id"], $condition_data["condition"], ""); ?>
                        </div>
                    <?php
                    }
                    ?>
                </div>
                <!-- filter section -->
                <!-- filter section -->
                <div class="flex flex-col justify-start items-start mt-5">
                    <p class="font-fm-inter text-gray-900 text-base font-medium capitalize mb-3">color</p>
                    <?php
                    $color_resultset = Database::search("SELECT * FROM `color`", []);
                    $color_num = $color_resultset->num_rows;
                    for ($i = 0; $i < $color_num; $i++) {
                        $color_data = $color_resultset->fetch_assoc();
                    ?>
                        <div class="w-full h-auto my-1 pl-3">
                            <?php customCheck("text-sm", "color-" . $color_data["id"], $color_data["color"], ""); ?>
                        </div>
                    <?php
                    }
                    ?>
                </div>
                <!-- filter section -->
                <!-- filter section -->
                <div class="flex flex-col justify-start items-start mt-5">
                    <p class="font-fm-inter text-gray-900 text-base font-medium capitalize mb-3">price</p>
                    <div class="w-full h-auto my-1 pl-3">
                        <?php customCheck("text-sm", "under-100", "under $100.00", ""); ?>
                    </div>
                    <div class="w-full h-auto my-1 pl-3">
                        <?php customCheck("text-sm", "100-500", "$100.00 to $500.00", ""); ?>
                    </div>
                    <div class="w-full h-auto my-3 pl-3 flex justify-start items-center">
                        <div class="w-14 sm:w-24 md:w-32 h-auto">
                            <input type="text" id="min-price" value="" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg 
                    focus:ring-blue-500 focus:border-blue-500 block w-full font-fm-inter h-10 text-[15px]" placeholder="Min">
                        </div>
                        <p class="font-fm-inter text-sm lowercase mx-3">to</p>
                        <div class="w-14 sm:w-24 md:w-32 h-auto">
                            <input type="text" id="max-price" value="" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg 
                    focus:ring-blue-500 focus:border-blue-500 block w-full font-fm-inter h-10 text-[15px]" placeholder="Max">
                        </div>
                    </div>
                </div>
                <!-- filter section -->
                <!-- filter section -->
                <div class="flex flex-col justify-start items-start mt-5">
                    <p class="font-fm-inter text-gray-900 text-base font-medium capitalize mb-3">brand</p>
                    <?php
                    if (isset($_GET["category"])) {
                        $brand_resultset = Database::search("SELECT * FROM `category_has_brand` INNER JOIN `brand` 
                    ON category_has_brand.brand_id=brand.id WHERE category_id=?", [$category]);
                    } else {
                        $brand_resultset = Database::search("SELECT * FROM `brand`", []);
                    }
                    $brand_num = $brand_resultset->num_rows;
                    for ($i = 0; $i < $brand_num; $i++) {
                        $brand_data = $brand_resultset->fetch_assoc();
                    ?>
                        <div class="w-full h-auto my-1 pl-3">
                            <?php customCheck("text-sm", "brand-" . $brand_data["id"], $brand_data["brand"], ""); ?>
                        </div>
                    <?php
                    }
                    ?>
                </div>
                <!-- filter section -->
                <!-- filter section -->
                <div class="flex flex-col justify-start items-start mt-5">
                    <p class="font-fm-inter text-gray-900 text-base font-medium capitalize mb-3">shipping options</p>
                    <div class="w-full h-auto my-1 pl-3">
                        <?php customCheck("text-sm", "free-shipping", "free international shipping", ""); ?>
                    </div>
                </div>
                <!-- filter section -->
                <button onclick='filterProducts("<?php echo $query; ?>");' id="filter-apply-btn" class="min-w-max text-[var(--text-white-high)] bg-[var(--main-bg-high)] transition-all duration-200 ease-linear hover:bg-[var(--main-bg-low)] 
                    font-medium text-sm px-3 sm:px-8 py-2.5 mt-10 capitalize font-fm-inter">apply</button>
            </div>
            <!-- drawer  -->
            <div class="max-w-full flex-1 h-max grid grid-cols-2 gap-2 md:grid-cols-[repeat(auto-fill,minmax(15rem,1fr))] md:gap-5">
                <?php
                for ($i = 0; $i < $product_num; $i++) {
                    $product_data = $product_resultset->fetch_assoc();
                    $product_image_resultset = Database::search("SELECT * FROM product_image WHERE product_id=? LIMIT 1", [$product_data["id"]]);
                    $product_image_data = $product_image_resultset->fetch_assoc();
                ?>
                    <!-- product  -->
                    <div class="bg-white  rounded-lg shadow">
                        <a href="<?php echo "productPage.php?id=" . $product_data["id"] . "&clicked=true"; ?>" class="w-4/5 flex justify-center items-center 
                        aspect-square overflow-hidden mx-auto">
                            <img class="min-w-full min-h-full object-cover" src="../assets/images/products/<?php echo $product_image_data["product_image"] ?>" alt="product image" />
                        </a>
                        <div class="px-5 pb-5">
                            <a href="<?php echo "productPage.php?id=" . $product_data["id"] . "&clicked=true"; ?>">
                                <h5 class="text-sm xl:text-base font-medium tracking-tight text-gray-900 font-fm-inter truncate"><?php echo $product_data["title"]; ?></h5>
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
                                <span class="text-base xl:text-lg font-bold text-gray-900 dark:text-white">$<?php echo $product_data["price"]; ?></span>
                                <!--  -->
                                <?php
                                if (isset($_SESSION["user"])) {
                                    $wishlist_resultset = Database::search("SELECT * FROM wishlist WHERE product_id=? AND users_id=?", [$product_data["id"], $user["id"]]);
                                    $wishlist_num = $wishlist_resultset->num_rows;
                                    if ($wishlist_num == 1) {
                                        $wishlist_data = $wishlist_resultset->fetch_assoc();
                                ?>
                                        <button onclick="removeFromWishlist(<?php echo $product_data['id'] ?>, <?php echo $wishlist_data['id'] ?>);" id="add-to-wishlist" class="text-[var(--text-white-high)] bg-[var(--active-bg)] transition-all duration-200 ease-linear hover:bg-[var(--main-bg-low)] 
                    font-medium text-xs xl:text-xs px-4 py-1 capitalize font-fm-inter">
                                            <span class="material-symbols-outlined !text-lg pointer-events-none">
                                                favorite
                                            </span>
                                        </button>
                                    <?php
                                    } else if ($wishlist_num == 0) {
                                    ?>
                                        <button onclick="addToWishlist(<?php echo $product_data['id']; ?>,event)" id="add-to-wishlist" class="text-[var(--text-white-high)] bg-[var(--main-bg-high)] transition-all duration-200 ease-linear hover:bg-[var(--main-bg-low)] 
                    font-medium text-xs px-4 py-1 capitalize font-fm-inter">
                                            <span class="material-symbols-outlined !text-lg pointer-events-none">
                                                favorite
                                            </span>
                                        </button>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <button onclick="addToWishlist(<?php echo $product_data['id']; ?>,event)" id="add-to-wishlist" class="text-[var(--text-white-high)] bg-[var(--main-bg-high)] transition-all duration-200 ease-linear hover:bg-[var(--main-bg-low)] 
                    font-medium text-xs xl:text-xs px-4 py-1 capitalize font-fm-inter">
                                        <span class="material-symbols-outlined !text-lg pointer-events-none">
                                            favorite
                                        </span>
                                    </button>
                                <?php
                                }
                                ?>
                                <!-- <button onclick="addToWishlist(<?php echo $product_data['id']; ?>)" id="add-to-cart" class="text-[var(--text-white-high)] bg-[var(--main-bg-high)] transition-all duration-200 ease-linear hover:bg-[var(--main-bg-low)] 
                    font-medium px-4 py-1 capitalize font-fm-inter">
                                    <span class="material-symbols-outlined !text-lg pointer-events-none">
                                        favorite
                                    </span>
                                </button> -->

                            </div>
                        </div>
                    </div>
                    <!-- product  -->
                <?php
                }
                ?>
            </div>
        </section>

        <!-- pagination  -->
        <section class="flex justify-center items-center mt-10">
            <nav aria-label="Page navigation example">
                <ul class="flex items-center -space-x-px h-10 text-base">
                    <?php
                    $all_products_count_resultset = Database::search("SELECT DISTINCT * FROM `output_products`", []);
                    // $all_products_count_data = $all_products_count_resultset->fetch_assoc();
                    $all_products_count = $all_products_count_resultset->num_rows;
                    $number_of_pages = ceil($all_products_count / $products_per_page);
                    ?>
                    <?php
                    if ($current_page == 1) {
                    ?>
                        <li class="cursor-not-allowed ">
                            <a href="" class="pointer-events-none flex items-center justify-center px-4 h-10 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <span class="sr-only">Previous</span>
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4" />
                                </svg>
                            </a>
                        </li>
                    <?php
                    } else {
                    ?>
                        <li>
                            <a href="<?php echo "?page=" . ($current_page - 1); ?>" class="flex items-center justify-center px-4 h-10 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <span class="sr-only">Previous</span>
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4" />
                                </svg>
                            </a>
                        </li>
                    <?php
                    }
                    ?>

                    <?php
                    for ($i = 0; $i < $number_of_pages; $i++) {
                        if ($current_page == $i + 1) {
                    ?>
                            <li>
                                <a href="<?php echo "?page=" . ($i + 1); ?>" aria-current="page" class="z-10 flex items-center justify-center px-4 h-10 leading-tight text-gray-50 border border-[var(--main-bg-low)] bg-[var(--main-bg-high)] hover:bg-[var(--main-bg-low)] hover:text-gray-200"><?php echo ($i + 1); ?></a>
                            </li>
                        <?php
                        } else {
                        ?>
                            <li>
                                <a href="<?php echo "?page=" . ($i + 1); ?>" class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700"><?php echo ($i + 1); ?></a>
                            </li>
                    <?php
                        }
                    }
                    ?>
                    <?php
                    if ($current_page == $number_of_pages) {
                    ?>
                        <li class="cursor-not-allowed">
                            <a href="" class="pointer-events-none flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100 hover:text-gray-700">
                                <span class="sr-only">Next</span>
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                                </svg>
                            </a>
                        </li>
                    <?php
                    } else if ($current_page < $number_of_pages) {
                    ?>
                        <li>
                            <a href="<?php echo "?page=" . ($current_page + 1); ?>" class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100 hover:text-gray-700">
                                <span class="sr-only">Next</span>
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                                </svg>
                            </a>
                        </li>
                    <?php
                    }
                    ?>
                </ul>
            </nav>
        </section>
        <!-- pagination  -->

    </section>

    <script type="module" src="../assets/js/productFilter.js"></script>
    <script type="module" src="../assets/js/addToWishlist.js"></script>
    <script type="module" src="../assets/js/wishlist.js"></script>
    <script src="../assets/js/cusCheck.js"></script>
    <script type="module" src="../assets/js/filterProducts.js"></script>
</body>

</html>