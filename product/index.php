<?php
session_start();
require "../server/connection.php";
require "../navbar.php";
require "../head.php";
require "../components/customSelect.php";
require "../components/InputElements.php";
require "../client/php/client.php";

$client = new Client();

if (isset($_GET["id"])) {
    $product_id = $_GET["id"];
    if (isset($_SESSION["user"])) {
        $user = $_SESSION["user"];
    } else {
        $user = "";
    }
    $product_resultset = Database::search("SELECT * FROM `product` WHERE `id`=?", [$product_id]);
    $product_data = $product_resultset->fetch_assoc();
    if (isset($_GET["clicked"])) {
        $clicked = $_GET["clicked"];
        $older_click_count = $product_data["click_count"];
        $new_click_count = intval($older_click_count) + 1;
        Database::iud("UPDATE `product` SET `click_count`=? WHERE `id`=?", [$new_click_count, $product_id]);
    }
?>
    <!DOCTYPE html>
    <html lang="en">
    <?php
    $title = "UrbanPulse | " . $product_data["title"];
    head($title);
    ?>

    <body>
        <?php
        navbar($user);
        ?>

        <section id="product" class="container px-3 sm:px-0 h-auto mt-5 mx-auto flex flex-wrap flex-col justify-start items-center lg:items-start lg:flex-row lg:justify-between">
            <div class="w-full md:w-3/4 lg:w-2/5">

                <div class="grid gap-4">
                    <?php
                    $image_resultset = Database::search("SELECT * FROM `product_image` WHERE `product_id`=?", [$product_id]);
                    $image_num = $image_resultset->num_rows;
                    $primary_image = $image_resultset->fetch_assoc();

                    ?>
                    <div data-image-primary class="w-full aspect-square flex justify-center items-center overflow-hidden">
                        <img class="h-auto max-w-full rounded-lg min-h-full min-w-full object-cover pointer-events-none" src="../assets/images/products/<?php echo $primary_image["product_image"]; ?>" alt="">
                    </div>
                    <div class="grid grid-cols-5 gap-8">
                        <?php
                        for ($i = 0; $i < $image_num; $i++) {
                            if ($i == 0) {
                        ?>
                                <div data-product-image-selector data-image-secondary class="aspect-square flex justify-center items-center overflow-hidden">
                                    <img class="h-auto max-w-full rounded-lg min-h-full min-w-full object-cover pointer-events-none" src="../assets/images/products/<?php echo $primary_image["product_image"]; ?>" alt="">
                                </div>
                            <?php
                            } else {
                                $image_data = $image_resultset->fetch_assoc();
                            ?>
                                <div data-product-image-selector data-image-secondary class="aspect-square flex justify-center items-center overflow-hidden">
                                    <img class="h-auto max-w-full rounded-lg min-h-full min-w-full object-cover pointer-events-none" src="../assets/images/products/<?php echo $image_data["product_image"]; ?>" alt="">
                                </div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>

            </div>
            <div class="w-full lg:w-1/2">
                <h3 class="font-fm-inter text-xl font-normal mt-4 capitalize"><?php echo $product_data["title"]; ?></h3>

                <?php
                $invoice_resultset = Database::search("SELECT * FROM `invoice` WHERE `product_id`=?;", [$product_id]);
                $invoice_num = $invoice_resultset->num_rows;
                $total_reviews = 0;
                $total_stars = 0;
                for ($i = 0; $i < $invoice_num; $i++) {
                    $invoice_data = $invoice_resultset->fetch_assoc();
                    $review_resultset = Database::search("SELECT * FROM `review` WHERE `invoice_id`=?;", [$invoice_data["id"]]);
                    $review_num = $review_resultset->num_rows;
                    if ($review_num == 1) {
                        $review_data = $review_resultset->fetch_assoc();
                        $total_stars = $total_stars + $review_data["stars_count"];
                        $total_reviews = $total_reviews + 1;
                    }
                }
                if ($total_reviews != 0) {
                    $average_stars = $total_stars / $total_reviews;
                } else {
                    $average_stars = 0;
                }
                $rounded_average_stars = round($average_stars);
                ?>
                <div class="flex items-center mt-3">
                    <?php
                    for ($i = 1; $i < 6; $i++) {
                        if ($i <= $rounded_average_stars) {
                    ?>
                            <svg class="w-4 h-4 text-yellow-300 mr-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                            </svg>
                        <?php
                        } else {
                        ?>
                            <svg class="w-4 h-4 text-gray-300 mr-1 dark:text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                            </svg>
                    <?php
                        }
                    }
                    ?>
                    <p class="ml-2 text-sm font-medium text-gray-500 font-fm-inter"><?php echo $average_stars; ?> out of 5</p>
                    <span class="w-1 h-1 mx-1.5 bg-gray-500 rounded-full"></span>
                    <a href="#" class="text-sm font-medium text-gray-600 underline hover:no-underline font-fm-inter"><?php echo $total_reviews; ?> reviews</a>
                </div>

                <div class="mt-10">
                    <?php
                    $brand_has_model_resultset = Database::search("SELECT * FROM `brand_has_model` WHERE `id`=?", [$product_data["brand_has_model_id"]]);
                    $brand_has_model_data = $brand_has_model_resultset->fetch_assoc();
                    $brand_resultset = Database::search("SELECT * FROM `brand` WHERE `id`=?", [$brand_has_model_data["brand_id"]]);
                    $brand_data = $brand_resultset->fetch_assoc();
                    $model_resultset = Database::search("SELECT * FROM `model` WHERE `id`=?", [$brand_has_model_data["model_id"]]);
                    $model_data = $model_resultset->fetch_assoc();
                    ?>
                    <div class="flex justify-start items-center w-auto h-auto my-2">
                        <p class="text-sm font-fm-inter text-gray-700 capitalize">brand</p>
                        <span class="w-1 h-1 mx-1.5 bg-gray-500 rounded-full"></span>
                        <p class="text-sm font-fm-inter text-gray-700 capitalize"><?php echo $brand_data["brand"]; ?></p>
                    </div>
                    <div class="flex justify-start items-center w-auto h-auto my-2">
                        <p class="text-sm font-fm-inter text-gray-700 capitalize">model</p>
                        <span class="w-1 h-1 mx-1.5 bg-gray-500 rounded-full"></span>
                        <p class="text-sm font-fm-inter text-gray-700 capitalize"><?php echo $model_data["model"]; ?></p>
                    </div>
                    <div class="flex justify-start items-center w-auto h-auto my-2">
                        <p class="text-sm font-fm-inter text-gray-700 capitalize">warrenty</p>
                        <span class="w-1 h-1 mx-1.5 bg-gray-500 rounded-full"></span>
                        <p class="text-sm font-fm-inter text-gray-700 capitalize">7 days return</p>
                    </div>
                </div>

                <div class="mt-10 flex justify-start items-start">
                    <div class="w-1/2 flex flex-col justify-start items-start">
                        <div class="w-max h-11 flex justify-center items-center">
                            <input value="0" type="text" id="quantity" class="bg-gray-50 border-l border-t border-b border-r-0 border-gray-300 text-gray-900 
                            focus:ring-blue-500 focus:border-blue-500 block font-fm-inter w-14 h-full px-3 text-base" disabled>
                            <div class="flex flex-col justify-center items-center h-full w-8 bg-gray-50 border-l-0 border-t border-b border-r border-gray-300">
                                <button data-change-quantity="increase" class="h-1/2 w-full overflow-hidden flex justify-center items-center 
                                transition-all duration-100 ease-linear hover:bg-gray-100">
                                    <span class="material-symbols-outlined text-[var(--main-bg-high)] !text-3xl pointer-events-none">
                                        arrow_drop_up
                                    </span>
                                </button>
                                <button data-change-quantity="decrease" class="h-1/2 w-full overflow-hidden flex justify-center items-center 
                                transition-all duration-100 ease-linear hover:bg-gray-100">
                                    <span class="material-symbols-outlined text-[var(--main-bg-high)] !text-3xl pointer-events-none">
                                        arrow_drop_down
                                    </span>
                                </button>
                            </div>
                        </div>
                        <div class="w-max h-auto mt-4">
                            <label for="color" class="block text-sm font-medium text-gray-800 capitalize font-fm-inter mb-2">Select a color</label>
                            <select id="color" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm block w-full p-2.5 font-fm-inter capitalize">
                                <option value="0" selected>Select A Color</option>
                                <?php
                                $color_resultset = Database::search("SELECT DISTINCT color,color_id FROM product INNER JOIN product_has_color 
                                ON product.id=product_has_color.product_id INNER JOIN color ON product_has_color.color_id=color.id WHERE product.id=?", [$product_id]);
                                $color_num = $color_resultset->num_rows;
                                for ($i = 0; $i < $color_num; $i++) {
                                    $color_data = $color_resultset->fetch_assoc();
                                ?>
                                    <option value="<?php echo $color_data["color_id"]; ?>"><?php echo $color_data["color"]; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <!--  -->
                <div class="mt-10 flex justify-center items-start">
                    <div class="w-1/2 flex flex-col justify-start items-start">
                        <p class="font-fm-inter text-gray-800 text-sm lg:text-base capitalize mb-1 lg:mb-3">price:</p>
                        <p class="font-fm-inter text-2xl sm:text-3xl lg:text-4xl text-[var(--active-bg)]">$<?php echo $product_data["price"]; ?></p>
                    </div>
                    <div class="w-1/2">
                        <button id="buy-now-btn" class="text-[var(--text-white-high)] bg-[var(--active-bg)] transition-all duration-200 
                ease-linear hover:bg-[var(--main-bg-low)] 
                    font-medium text-[15px] w-full py-2 capitalize font-fm-inter">buy now</button>
                        <button id="add-to-cart-btn" class="text-[var(--text-white-high)] bg-[var(--main-bg-high)] transition-all duration-200 ease-linear hover:bg-[var(--main-bg-low)] 
                        font-medium text-[15px] w-full py-2 capitalize font-fm-inter mt-3">add to cart</button>
                        <button id="add-to-wishlist-btn" class="text-[var(--text-white-high)] bg-[var(--main-bg-high)] transition-all duration-200 ease-linear hover:bg-[var(--main-bg-low)] 
                        font-medium text-[15px] w-full py-2 capitalize font-fm-inter mt-3">add to wishlist</button>

                    </div>
                </div>
                <!--  -->

            </div>
            <div class="w-full flex flex-col-reverse lg:flex-row justify-start items-center lg:justify-between lg:items-start mt-10">
                <div class="w-full lg:w-[48%]">
                    <!--  -->

                    <div id="accordion-collapse" data-accordion="collapse">
                        <h2 id="accordion-collapse-heading-1">
                            <button type="button" class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border 
                            border-gray-200 focus:ring-0 capitalize font-fm-inter" data-accordion-target="#description" aria-expanded="false" aria-controls="accordion-collapse-body-1">
                                <span>description</span>
                                <!-- <span class="material-symbols-outlined">
                                    expand_more
                                </span> -->
                                <!-- <svg data-accordion-icon class="w-3 h-3 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5" />
                                </svg> -->
                                <span data-accordion-icon class="material-symbols-outlined shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    expand_more
                                </span>
                            </button>
                        </h2>
                        <div id="description" class="hidden" aria-labelledby="accordion-collapse-heading-1">
                            <div class="p-5 border border-gray-200">
                                <p class="mb-2 text-gray-500 font-fm-inter text-base"><?php echo $product_data["description"]; ?></p>
                            </div>
                        </div>
                    </div>

                    <!--  -->
                </div>
                <div class="w-full lg:w-[48%] mb-5 lg:mb-0">
                    <div class="w-full h-auto">
                        <div class="w-full h-auto px-5 sm:px-10 bg-white border border-gray-200 shadow flex justify-between items-start">
                            <div class="flex flex-col items-start mt-4">
                                <?php
                                $seller_resultset = Database::search("SELECT * FROM `users` WHERE `id`=?", [$product_data["users_id"]]);
                                $seller_data = $seller_resultset->fetch_assoc();
                                $seller_profile_picture_resultset = Database::search("SELECT * FROM `profile_picture` WHERE `user_id`=?", [$seller_data["id"]]);
                                $seller_profile_picture_data = $seller_profile_picture_resultset->fetch_assoc();
                                $seller_profile_picture_num = $seller_profile_picture_resultset->num_rows;
                                ?>
                                <img class="w-10 h-10 mb-2 rounded-full" src="../assets/images/user/<?php
                                                                                                    if ($seller_profile_picture_num == 0) {
                                                                                                        if ($seller_data["gender_id"] == 1) {
                                                                                                            echo ("default-user-male.png");
                                                                                                        } else if ($seller_data["gender_id"] == 2) {
                                                                                                            echo ("default-user-female.png");
                                                                                                        } else if ($seller_data["gender_id"] == 3) {
                                                                                                            echo ("default-user-other.png");
                                                                                                        }
                                                                                                    } else if ($seller_profile_picture_num == 1) {
                                                                                                        echo $seller_profile_picture_data["profile_picture"];
                                                                                                    } else {
                                                                                                        if ($seller_data["gender_id"] == 1) {
                                                                                                            echo ("default-user-male.png");
                                                                                                        } else if ($seller_data["gender_id"] == 2) {
                                                                                                            echo ("default-user-female.png");
                                                                                                        } else if ($seller_data["gender_id"] == 3) {
                                                                                                            echo ("default-user-other.png");
                                                                                                        }
                                                                                                    }
                                                                                                    ?>" alt="">
                                <div class="">
                                    <div class="font-fm-inter text-sm font-medium"><?php echo $seller_data["first_name"] . " " . $seller_data["last_name"]; ?></div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Joined in August 2014</div>
                                </div>
                            </div>
                            <div class="flex w-36 md:w-48 flex-col my-4">
                                <button class="flex w-full items-center justify-center py-2 my-2 text-xs sm:text-sm font-medium text-center text-white bg-[var(--secondary-bg)] 
                            transition-all duration-200 ease-linear hover:bg-[var(--main-bg-low)] focus:ring-4 focus:outline-none 
                            focus:ring-blue-300 capitalize font-fm-inter">follow</button>
                                <button class="flex w-full items-center justify-center py-2 my-2 text-xs sm:text-sm font-medium text-center text-gray-900 bg-white border 
                                border-gray-300 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 capitalize font-fm-inter">Message</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full flex flex-col justify-start items-center md:flex-row md:justify-between md:items-start mt-10">
                <div class="w-full mb-5 md:mb-0 md:w-[48%]">
                    <div class="flex items-center mb-2">
                        <?php
                        for ($i = 1; $i < 6; $i++) {
                            if ($i <= $rounded_average_stars) {
                        ?>
                                <svg class="w-4 h-4 text-yellow-300 mr-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                    <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                                </svg>
                            <?php
                            } else {
                            ?>
                                <svg class="w-4 h-4 text-gray-300 mr-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                    <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                                </svg>
                        <?php
                            }
                        }
                        ?>
                        <p class="ml-2 text-sm font-medium text-gray-900"><?php echo $total_stars; ?> out of 5</p>
                    </div>
                    <p class="text-sm font-medium text-gray-500"><?php echo $total_reviews; ?> global ratings</p>
                    <?php
                    $stars_percentage = array(
                        "1" => 0,
                        "2" => 0,
                        "3" => 0,
                        "4" => 0,
                        "5" => 0,
                    );
                    if ($total_reviews > 0) {
                        $invoice_resultset = Database::search("SELECT * FROM `invoice` WHERE `product_id` = ?;", [$product_id]);
                        $invoice_num = $invoice_resultset->num_rows;
                        $star_count = array(
                            "1" => 0,
                            "2" => 0,
                            "3" => 0,
                            "4" => 0,
                            "5" => 0,
                        );
                        for ($i = 0; $i < $invoice_num; $i++) {
                            $invoice_data = $invoice_resultset->fetch_assoc();
                            for ($j = 1; $j < 6; $j++) {
                                $star_review_resultset = Database::search("SELECT COUNT(`id`) FROM `review` WHERE `invoice_id`=? AND `stars_count`=?;", [$invoice_data["id"], $j]);
                                $star_review_data = $star_review_resultset->fetch_assoc();
                                $star_count["$j"] += $star_review_data["COUNT(`id`)"];
                            }
                        }
                        for ($i = 1; $i < 6; $i++) {
                            if ($star_count["$i"] > 0) {
                                $star_percentage = ($star_count["$i"] / $total_reviews) * 100;
                                $stars_percentage["$i"] = round($star_percentage);
                            }
                        }
                    }
                    ?>
                    <div class="flex items-center mt-4">
                        <a href="#" class="text-sm font-medium text-[var(--main-bg-high)] hover:underline">5 star</a>
                        <div class="w-2/4 h-5 mx-4 bg-gray-200 rounded">
                            <div class="h-5 bg-yellow-300 rounded" style="width: <?php echo $stars_percentage["5"]; ?>%"></div>
                        </div>
                        <span class="text-sm font-medium text-gray-500"><?php echo $stars_percentage["5"]; ?>%</span>
                    </div>
                    <div class="flex items-center mt-4">
                        <a href="#" class="text-sm font-medium text-[var(--main-bg-high)] hover:underline">4 star</a>
                        <div class="w-2/4 h-5 mx-4 bg-gray-200 rounded">
                            <div class="h-5 bg-yellow-300 rounded" style="width: <?php echo $stars_percentage["4"]; ?>%"></div>
                        </div>
                        <span class="text-sm font-medium text-gray-500"><?php echo $stars_percentage["4"]; ?>%</span>
                    </div>
                    <div class="flex items-center mt-4">
                        <a href="#" class="text-sm font-medium text-[var(--main-bg-high)] hover:underline">3 star</a>
                        <div class="w-2/4 h-5 mx-4 bg-gray-200 rounded">
                            <div class="h-5 bg-yellow-300 rounded" style="width: <?php echo $stars_percentage["3"]; ?>%"></div>
                        </div>
                        <span class="text-sm font-medium text-gray-500"><?php echo $stars_percentage["3"]; ?>%</span>
                    </div>
                    <div class="flex items-center mt-4">
                        <a href="#" class="text-sm font-medium text-[var(--main-bg-high)] hover:underline">2 star</a>
                        <div class="w-2/4 h-5 mx-4 bg-gray-200 rounded">
                            <div class="h-5 bg-yellow-300 rounded" style="width: <?php echo $stars_percentage["2"]; ?>%"></div>
                        </div>
                        <span class="text-sm font-medium text-gray-500"><?php echo $stars_percentage["2"]; ?>%</span>
                    </div>
                    <div class="flex items-center mt-4">
                        <a href="#" class="text-sm font-medium text-[var(--main-bg-high)] hover:underline">1 star</a>
                        <div class="w-2/4 h-5 mx-4 bg-gray-200 rounded">
                            <div class="h-5 bg-yellow-300 rounded" style="width: <?php echo $stars_percentage["1"]; ?>%"></div>
                        </div>
                        <span class="text-sm font-medium text-gray-500"><?php echo $stars_percentage["1"]; ?>%</span>
                    </div>
                </div>
                <div class="w-full md:w-[48%]">
                    <?php
                    if ($total_reviews > 0) {
                        $invoice_resultset = Database::search("SELECT * FROM `invoice` WHERE `product_id`=?;", [$product_id]);
                        $invoice_num = $invoice_resultset->num_rows;
                        for ($i = 0; $i < $invoice_num; $i++) {
                            $invoice_data = $invoice_resultset->fetch_assoc();
                            $review_resultset = Database::search("SELECT * FROM `review` WHERE `invoice_id`=?;", [$invoice_data["id"]]);
                            $review_num = $review_resultset->num_rows;
                            if ($review_num == 1) {
                                $review_data = $review_resultset->fetch_assoc();
                                $review_title = $review_data["title"];
                                $review_description = $review_data["description"];
                                $help_count = $review_data["help_count"];
                                $current_star_count = $review_data["stars_count"];
                                $datetime_added = $review_data["datetime_added"];
                                $datetime_object = new DateTime($datetime_added);
                                $order_resultset = Database::search("SELECT * FROM `order` WHERE `id`=?;", [$invoice_data["order_id"]]);
                                $order_data = $order_resultset->fetch_assoc();
                                $reviewer_id = $order_data["users_id"];
                                $reviewer_resultset = Database::search("SELECT * FROM `users` WHERE `id`=?;", [$reviewer_id]);
                                $reviewer_data = $reviewer_resultset->fetch_assoc();
                                $reviewer_first_name = $reviewer_data["first_name"];
                                $reviewer_last_name = $reviewer_data["last_name"];
                                $datetime_joined = $reviewer_data["datetime_joined"];
                                $datetime_joined_object = new DateTime($datetime_joined);
                                $profile_picture_resultset = Database::search("SELECT * FROM `profile_picture` WHERE `user_id`=?;", [$reviewer_id]);
                                $profile_picture_data = $profile_picture_resultset->fetch_assoc();
                                $profile_picture = $profile_picture_data["profile_picture"];
                                $review_images_resultset = Database::search("SELECT * FROM `review_image` WHERE `review_id`=?;", [$review_data["id"]]);
                                $review_images_num = $review_images_resultset->num_rows;
                    ?>
                                <!-- review  -->
                                <article class="my-4">
                                    <div class="flex items-center mb-4 space-x-4">
                                        <img class="w-10 h-10 rounded-full" src="../assets/images/user/<?php echo $profile_picture; ?>" alt="">
                                        <div class="space-y-1 font-medium dark:text-white">
                                            <p>
                                                <?php echo "$reviewer_first_name $reviewer_last_name"; ?>
                                                <time datetime="<?php echo $datetime_joined; ?>" class="block text-sm text-gray-500">
                                                    Joined on <?php echo $datetime_joined_object->format("Y F"); ?>
                                                </time>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex items-center mb-1">
                                        <?php
                                        for ($i = 1; $i < 6; $i++) {
                                            if ($i <= $current_star_count) {
                                        ?>
                                                <svg class="w-4 h-4 text-yellow-300 mr-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                                    <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                                                </svg>
                                            <?php
                                            } else {
                                            ?>
                                                <svg class="w-4 h-4 text-gray-300 mr-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                                    <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                                                </svg>
                                        <?php
                                            }
                                        }
                                        ?>
                                        <h3 class="ml-2 text-sm font-semibold text-gray-900"><?php echo $review_title; ?></h3>
                                    </div>
                                    <footer class="mb-5 text-sm text-gray-500 font-fm-inter">
                                        <p>Reviewed in the United Kingdom on <time datetime="<?php echo $datetime_added; ?>"><?php echo $datetime_object->format('Y'); ?> <?php echo $datetime_object->format('M'); ?> <?php echo $datetime_object->format('d'); ?></time></p>
                                    </footer>
                                    <p class="mb-2 text-gray-500 font-fm-inter text-sm"><?php echo $review_description; ?></p>
                                    <?php
                                    if ($review_images_num > 0) {
                                    ?>
                                        <div class="w-full flex justify-start items-start flex-wrap">
                                            <?php
                                            for ($i = 0; $i < $review_images_num; $i++) {
                                                $review_images_data = $review_images_resultset->fetch_assoc();
                                                $review_image = $review_images_data["review_image"];
                                            ?>
                                                <div class="w-28 aspect-square flex justify-center items-center overflow-hidden">
                                                    <img src="../assets/images/review/<?php echo $review_image; ?>" class="min-w-full min-h-full object-cover" alt="">
                                                </div>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                    <aside>
                                        <p class="mt-1 text-xs text-gray-500"><?php echo $help_count; ?> people found this helpful</p>
                                        <div class="flex items-center mt-3 space-x-3 divide-x divide-gray-200 dark:divide-gray-600">
                                            <a href="#" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-xs px-2 py-1.5">Helpful</a>
                                            <a href="#" class="pl-4 text-sm font-medium text-blue-600 hover:underline">Report abuse</a>
                                        </div>
                                    </aside>
                                </article>
                                <!-- review  -->
                        <?php
                            }
                        }
                        ?>
                        <a href="#" class="flex justify-start items-center w-full font-fm-inter text-[var(--active-bg)] capitalize text-sm mt-10">see all
                            <span class="material-symbols-outlined !text-sm !no-underline ml-1">
                                east
                            </span>
                        </a>
                    <?php
                    } else {
                    ?>
                        <p class="text-sm font-normal font-fm-inter">There are no reviews yet.</p>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <div class="w-full flex justify-start items-center mt-10 mb-5">
                <h3 class="font-fm-inter text-lg font-medium text-left capitalize mr-5">related products</h3>
                <a href="#" class="capitalize font-fm-inter text-sm font-medium text-[var(--active-bg)]">see all</a>
            </div>
            <div class="w-full h-auto flex justify-start items-center overflow-hidden relative">
                <button data-product-move-left="related-products" class="h-max w-max absolute left-0 top-1/2 -translate-y-1/2 z-10 transition-all duration-75 ease-linear bg-[var(--main-bg-low)] 
                hover:bg-[var(--main-bg-high)] flex justify-center items-center text-white shadow">
                    <span class="material-symbols-outlined !text-4xl !m-0 !p-0">
                        arrow_left
                    </span>
                </button>
                <div data-product-move-target="related-products" class="w-max flex transition-all duration-100 ease-linear relative">
                    <?php
                    $category = $product_data["category_id"];
                    $related_products_resultset = Database::search("SELECT * FROM `product` WHERE `category_id`=? LIMIT 10;", [$category]);
                    $client->generate_products($related_products_resultset, $user, "../");
                    ?>
                </div>
                <button data-product-move-right="related-products" class="h-max w-max absolute right-0 top-1/2 -translate-y-1/2 transition-all duration-75 ease-linear bg-[var(--main-bg-low)] 
                hover:bg-[var(--main-bg-high)] flex justify-center items-center text-white z-10">
                    <span class="material-symbols-outlined !text-4xl !m-0 !p-0">
                        arrow_right
                    </span>
                </button>
            </div>
        </section>

        <!-- <script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script>
        <script type="module" src="../assets/js/payment.js"></script> -->
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
?>