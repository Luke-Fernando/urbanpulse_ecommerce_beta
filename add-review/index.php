<?php
session_start();
require "../server/connection.php";
require "../head.php";
require "../navbar.php";
require "../components/customSelect.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (isset($_SESSION["user"])) {
    if (isset($_GET["invoice_id"])) {
        $user = $_SESSION["user"];
        $invoice_id = $_GET["invoice_id"];
        $invoice_resultset = Database::search("SELECT * FROM `invoice` WHERE `id`=?", [$invoice_id]);
        $invoice_data = $invoice_resultset->fetch_assoc();
        $product_id = $invoice_data["product_id"];
?>
        <!DOCTYPE html>
        <html lang="en">
        <?php
        $title = "UrbanPulse | Add a Review";
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

            <?php
            $review_resultset = Database::search("SELECT * FROM `review` WHERE `invoice_id`=?;", [$invoice_id]);
            $review_num = $review_resultset->num_rows;
            if ($review_num == 0) {
            ?>
                <div class="container mx-auto my-8 sm:my-10 capitalize p-4 sm:p-0 box-border">
                    <h1 class="font-fm-inter text-2xl text-gray-800 font-medium">add review</h1>
                </div>
                <!-- <div class="container mx-auto h-5 bg-red-500 sm:bg-gray-800 md:bg-blue-400 lg:bg-emerald-400 xl:bg-pink-400 2xl:bg-purple-500"></div> -->
                <section class="container h-auto mx-auto mb-52 box-border px-4 sm:px-0">
                    <?php
                    $invoice_resultset = Database::search("SELECT * FROM `invoice` WHERE `id`=?", [$invoice_id]);
                    $invoice_data = $invoice_resultset->fetch_assoc();
                    $product_resultset = Database::search("SELECT * FROM `product` WHERE `id`=?", [$product_id]);
                    $product_data = $product_resultset->fetch_assoc();
                    $product_image_resultset = Database::search("SELECT * FROM `product_image` WHERE `product_id`=? LIMIT 1", [$product_id]);
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
                    ?>
                    <div class="w-full h-auto flex justify-between items-start border-t border-b py-3">
                        <a href="#" class="w-36 sm:w-52 p-3 sm:p-0 aspect-square flex justify-center items-center overflow-hidden">
                            <img src="../assets/images/products/<?php echo $product_image_data["product_image"]; ?>" class="min-h-full min-w-full object-cover" alt="">
                        </a>
                        <div class="flex flex-1 flex-col justify-start items-start box-border p-3">
                            <a href="#" class="font-fm-inter text-base font-normal text-gray-950 line-clamp-2"><?php echo $product_data["title"]; ?></a>
                            <p class="font-fm-inter text-sm text-gray-800 capitalize mt-3 mb-1">brand: <?php echo $brand_data["brand"]; ?></p>
                            <p class="font-fm-inter text-sm text-gray-800 capitalize my-1 line-clamp-1">model: <?php echo $model_data["model"]; ?></p>
                            <p class="font-fm-inter text-sm text-gray-800 capitalize my-1">color: <?php echo $color_data["color"]; ?></p>
                            <p class="font-fm-inter text-sm text-gray-800 capitalize my-1">condition: <?php echo $condition_data["condition"]; ?></p>
                        </div>
                    </div>
                    <!-- rate  -->
                    <div class="w-full h-auto flex flex-col justify-start items-center mt-10">
                        <div class="w-full h-auto flex justify-start items-start">
                            <h3 class="font-fm-inter text-base font-normal capitalize text-gray-950">rate the product</h3>
                        </div>
                        <div class="w-full max-w-xs sm:max-w-none sm:w-max h-auto flex justify-start items-start mt-5">
                            <!-- star 1 -->
                            <div class="w-max h-auto mx-auto sm:mx-3">
                                <label for="star-1" class="flex w-max aspect-square">
                                    <span data-rating-star-icon="0" class="material-symbols-outlined !text-gray-300 !text-5xl lg:!text-7xl">
                                        star
                                    </span>
                                </label>
                                <input data-rating-star="0" type="checkbox" name="" id="star-1" class="hidden">
                            </div>
                            <!-- star 1 -->
                            <!-- star 2 -->
                            <div class="w-max h-auto mx-auto sm:mx-3">
                                <label for="star-2" class="flex w-max aspect-square">
                                    <span data-rating-star-icon="1" class="material-symbols-outlined !text-gray-300 !text-5xl lg:!text-7xl">
                                        star
                                    </span>
                                </label>
                                <input data-rating-star="1" type="checkbox" name="" id="star-2" class="hidden">
                            </div>
                            <!-- star 2 -->
                            <!-- star 3 -->
                            <div class="w-max h-auto mx-auto sm:mx-3">
                                <label for="star-3" class="flex w-max aspect-square">
                                    <span data-rating-star-icon="2" class="material-symbols-outlined !text-gray-300 !text-5xl lg:!text-7xl">
                                        star
                                    </span>
                                </label>
                                <input data-rating-star="2" type="checkbox" name="" id="star-3" class="hidden">
                            </div>
                            <!-- star 3 -->
                            <!-- star 4 -->
                            <div class="w-max h-auto mx-auto sm:mx-3">
                                <label for="star-4" class="flex w-max aspect-square">
                                    <span data-rating-star-icon="3" class="material-symbols-outlined !text-gray-300 !text-5xl lg:!text-7xl">
                                        star
                                    </span>
                                </label>
                                <input data-rating-star="3" type="checkbox" name="" id="star-4" class="hidden">
                            </div>
                            <!-- star 4 -->
                            <!-- star 5 -->
                            <div class="w-max h-auto mx-auto sm:mx-3">
                                <label for="star-5" class="flex w-max aspect-square">
                                    <span data-rating-star-icon="4" class="material-symbols-outlined !text-gray-300 !text-5xl lg:!text-7xl">
                                        star
                                    </span>
                                </label>
                                <input data-rating-star="4" type="checkbox" name="" id="star-5" class="hidden">
                            </div>
                            <!-- star 5 -->
                        </div>
                    </div>
                    <!-- rate  -->
                    <!-- add images  -->
                    <div class="w-full h-auto flex flex-col justify-start items-start mt-10">
                        <div class="w-full h-auto flex justify-start items-start">
                            <h3 class="font-fm-inter text-base font-normal capitalize text-gray-950">add images</h3>
                        </div>
                        <div class="mt-5 w-full grid grid-cols-[1fr,1fr] sm:grid-cols-[1fr,2fr] md:grid-cols-[1fr,3fr] lg:grid-cols-[1fr,4fr] xl:grid-cols-[1fr,5fr] gap-5">
                            <!-- image input  -->
                            <div class="flex items-center justify-center aspect-square">
                                <label for="review-img-input" class="flex flex-col items-center justify-center w-full h-full border-2 border-gray-300 border-dashed cursor-pointer bg-gray-50">
                                    <div class="flex flex-col items-center justify-center w-full h-full">
                                        <svg class="w-6 h-6 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-500 font-fm-inter"><span class="font-medium">Click to upload</p>
                                        <p class="text-xs text-gray-500 font-fm-inter">SVG, PNG, JPG or GIF</p>
                                    </div>
                                    <input id="review-img-input" accept="image/*" type="file" class="hidden" multiple />
                                </label>
                            </div>
                            <!-- image input  -->
                            <div id="review-images" class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-5"></div>
                        </div>
                    </div>
                    <!-- add images  -->
                    <!-- title  -->
                    <div class="w-full h-auto flex flex-col justify-start items-start mt-10">
                        <div class="w-full h-auto flex justify-start items-start">
                            <label for="title" class="font-fm-inter text-base font-normal capitalize text-gray-950">add a title</label>
                        </div>
                        <div class="mt-5 w-full h-auto">
                            <input type="text" id="title" class="font-fm-inter font-normal bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full h-11" placeholder="Add your title">
                        </div>
                    </div>
                    <!-- title  -->
                    <!-- description  -->
                    <div class="w-full h-auto flex flex-col justify-start items-start mt-10">
                        <div class="w-full h-auto flex justify-start items-start">
                            <label for="description" class="font-fm-inter text-base font-normal capitalize text-gray-950">add a description</label>
                        </div>
                        <div class="mt-5 w-full h-auto">
                            <textarea rows="10" id="description" class="font-fm-inter font-normal bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full" placeholder="Add your description"></textarea>
                        </div>
                    </div>
                    <!-- description  -->
                    <div class="w-full h-auto mt-10 flex justify-end items-start">
                        <button id="submit-review-btn" class="min-w-max text-[var(--text-white-high)] bg-[var(--main-bg-high)] transition-all duration-200 ease-linear hover:bg-[var(--main-bg-low)] 
                    font-medium text-sm px-3 sm:px-8 py-2.5 mr-4 sm:mr-0 capitalize font-fm-inter">submit</button>
                    </div>
                </section>
                <script>
                    let invoiceId = '<?php echo $invoice_data["id"]; ?>';
                    let productId = '<?php echo $invoice_data["product_id"]; ?>';
                </script>
                <script src="../assets/js/rateStar.js"></script>
                <script type="module" src="../assets/js/addReview.js"></script>
            <?php
            } else if ($review_num == 1) {
                require "../update-review/index.php";
            }
            ?>
        </body>

        </html>
    <?php
    } else {
    ?>
        <script>
            window.location.href = "myOrders.php";
        </script>
    <?php
    }
} else {
    ?>
    <script>
        window.location.href = "/urbanpulse_ecommerce_beta/signin/";
    </script>
<?php
}
