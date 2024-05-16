<?php
session_start();
require "../server/connection.php";
require "../head.php";
require "../navbar.php";
require "../components/customSelect.php";
require "../client/generate.php";

$generator = new Generate();


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
                $generator->generate_products($popular_products_resultset, $user);
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
                    $generator->generate_products($products_resultset, $user);
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
    <script src="../assets/js/scrollProducts.js"></script>
</body>

</html>