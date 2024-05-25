<div class="container mx-auto my-8 sm:my-10 capitalize p-4 sm:p-0 box-border">
    <h1 class="font-fm-inter text-2xl text-gray-800 font-medium">update review</h1>
</div>
<!-- <div class="container mx-auto h-5 bg-red-500 sm:bg-gray-800 md:bg-blue-400 lg:bg-emerald-400 xl:bg-pink-400 2xl:bg-purple-500"></div> -->
<section id="update-review" class="container h-auto mx-auto mb-52 box-border px-4 sm:px-0">
    <?php
    $review_data = $review_resultset->fetch_assoc();
    $stars_count = $review_data["stars_count"];
    $review_title = $review_data["title"];
    $review_description = $review_data["description"];
    $product_resultset = Database::search("SELECT * FROM `product` WHERE `id`=?", [$product_id]);
    $product_data = $product_resultset->fetch_assoc();
    $product_title = $product_data["title"];
    $product_image_resultset = Database::search("SELECT * FROM `product_image` WHERE `product_id`=? LIMIT 1", [$product_id]);
    $product_image_data = $product_image_resultset->fetch_assoc();
    $product_image = $product_image_data["product_image"];
    $brand_has_model_resultset = Database::search("SELECT * FROM `brand_has_model` WHERE `id`=?", [$product_data["brand_has_model_id"]]);
    $brand_has_model_data = $brand_has_model_resultset->fetch_assoc();
    $brand_resultset = Database::search("SELECT * FROM `brand` WHERE `id`=?", [$brand_has_model_data["brand_id"]]);
    $brand_data = $brand_resultset->fetch_assoc();
    $brand = $brand_data["brand"];
    $model_resultset = Database::search("SELECT * FROM `model` WHERE `id`=?", [$brand_has_model_data["model_id"]]);
    $model_data = $model_resultset->fetch_assoc();
    $model = $model_data["model"];
    $color_resultset = Database::search("SELECT * FROM `color` WHERE `id`=?", [$invoice_data["color_id"]]);
    $color_data = $color_resultset->fetch_assoc();
    $color = $color_data["color"];
    $condition_resultset = Database::search("SELECT * FROM `condition` WHERE `id`=?", [$product_data["condition_id"]]);
    $condition_data = $condition_resultset->fetch_assoc();
    $condition = $condition_data["condition"];
    ?>
    <div class="w-full h-auto flex justify-between items-start border-t border-b py-3">
        <a href="#" class="w-36 sm:w-52 p-3 sm:p-0 aspect-square flex justify-center items-center overflow-hidden">
            <img src="../assets/images/products/<?php echo $product_image_data["product_image"]; ?>" class="min-h-full min-w-full object-cover" alt="">
        </a>
        <div class="flex flex-1 flex-col justify-start items-start box-border p-3">
            <a href="#" class="font-fm-inter text-base font-normal text-gray-950 line-clamp-2"><?php echo $product_title; ?></a>
            <p class="font-fm-inter text-sm text-gray-800 capitalize mt-3 mb-1">brand: <?php echo $brand; ?></p>
            <p class="font-fm-inter text-sm text-gray-800 capitalize my-1 line-clamp-1">model: <?php echo $model; ?></p>
            <p class="font-fm-inter text-sm text-gray-800 capitalize my-1">color: <?php echo $color; ?></p>
            <p class="font-fm-inter text-sm text-gray-800 capitalize my-1">condition: <?php echo $condition; ?></p>
        </div>
    </div>
    <?php
    // $review_data
    ?>
    <!-- rate  -->
    <div class="w-full h-auto flex flex-col justify-start items-center mt-10">
        <div class="w-full h-auto flex justify-start items-start">
            <h3 class="font-fm-inter text-base font-normal capitalize text-gray-950">rate the product</h3>
        </div>
        <div class="w-full max-w-xs sm:max-w-none sm:w-max h-auto flex justify-start items-start mt-5">
            <!-- star 1 -->
            <div class="w-max h-auto mx-auto sm:mx-3">
                <label for="star-1" class="flex w-max aspect-square">
                    <span data-rating-star-icon="1" class="material-symbols-outlined !text-gray-300 !text-5xl lg:!text-7xl pointer-events-none">
                        star
                    </span>
                </label>
                <input data-rating-star="1" type="checkbox" name="" id="star-1" class="hidden">
            </div>
            <!-- star 1 -->
            <!-- star 2 -->
            <div class="w-max h-auto mx-auto sm:mx-3">
                <label for="star-2" class="flex w-max aspect-square">
                    <span data-rating-star-icon="2" class="material-symbols-outlined !text-gray-300 !text-5xl lg:!text-7xl pointer-events-none">
                        star
                    </span>
                </label>
                <input data-rating-star="2" type="checkbox" name="" id="star-2" class="hidden">
            </div>
            <!-- star 2 -->
            <!-- star 3 -->
            <div class="w-max h-auto mx-auto sm:mx-3">
                <label for="star-3" class="flex w-max aspect-square">
                    <span data-rating-star-icon="3" class="material-symbols-outlined !text-gray-300 !text-5xl lg:!text-7xl pointer-events-none">
                        star
                    </span>
                </label>
                <input data-rating-star="3" type="checkbox" name="" id="star-3" class="hidden">
            </div>
            <!-- star 3 -->
            <!-- star 4 -->
            <div class="w-max h-auto mx-auto sm:mx-3">
                <label for="star-4" class="flex w-max aspect-square">
                    <span data-rating-star-icon="4" class="material-symbols-outlined !text-gray-300 !text-5xl lg:!text-7xl pointer-events-none">
                        star
                    </span>
                </label>
                <input data-rating-star="4" type="checkbox" name="" id="star-4" class="hidden">
            </div>
            <!-- star 4 -->
            <!-- star 5 -->
            <div class="w-max h-auto mx-auto sm:mx-3">
                <label for="star-5" class="flex w-max aspect-square">
                    <span data-rating-star-icon="5" class="material-symbols-outlined !text-gray-300 !text-5xl lg:!text-7xl pointer-events-none">
                        star
                    </span>
                </label>
                <input data-rating-star="5" type="checkbox" name="" id="star-5" class="hidden">
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
            <div id="review-images" class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-5">
                <?php
                $image_resultset = Database::search("SELECT * FROM `review_image` WHERE `review_id`=?", [$review_data["id"]]);
                $image_num = $image_resultset->num_rows;
                for ($i = 0; $i < $image_num; $i++) {
                    $image_data = $image_resultset->fetch_assoc();
                ?>
                    <div data-loaded-review-image-item="<?php echo $image_data["id"]; ?>" class="aspect-square flex justify-center items-center overflow-hidden relative">
                        <img src="../assets/images/review/<?php echo $image_data["review_image"]; ?>" class="min-w-full min-h-full object-cover" alt="">
                        <button data-loaded-review-image-remove="<?php echo $image_data["id"]; ?>" class="aspect-square absolute top-0 right-0 flex 
                        justify-center items-center transition-all duration-100 ease-in-out text-gray-500 hover:text-gray-950">
                            <span class="material-symbols-outlined !text-lg !text-inherit p-2 pointer-events-none">
                                close
                            </span>
                        </button>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
    <!-- add images  -->
    <!-- title  -->
    <div class="w-full h-auto flex flex-col justify-start items-start mt-10">
        <div class="w-full h-auto flex justify-start items-start">
            <label for="title" class="font-fm-inter text-base font-normal capitalize text-gray-950">add a title</label>
        </div>
        <div class="mt-5 w-full h-auto">
            <input value="<?php echo $review_title; ?>" type="text" id="title" class="font-fm-inter font-normal bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full h-11" placeholder="Add your title">
        </div>
    </div>
    <!-- title  -->
    <!-- description  -->
    <div class="w-full h-auto flex flex-col justify-start items-start mt-10">
        <div class="w-full h-auto flex justify-start items-start">
            <label for="description" class="font-fm-inter text-base font-normal capitalize text-gray-950">add a description</label>
        </div>
        <div class="mt-5 w-full h-auto">
            <textarea rows="10" id="description" class="font-fm-inter font-normal bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg 
            focus:ring-blue-500 focus:border-blue-500 block w-full" placeholder="Add your description"><?php echo $review_description; ?></textarea>
        </div>
    </div>
    <!-- description  -->
    <div class="w-full h-auto mt-10 flex justify-end items-start">
        <button id="update-review-btn" class="min-w-max text-[var(--text-white-high)] bg-[var(--main-bg-high)] transition-all duration-200 ease-linear hover:bg-[var(--main-bg-low)] 
                    font-medium text-sm px-3 sm:px-8 py-2.5 mr-4 sm:mr-0 capitalize font-fm-inter">update</button>
    </div>
</section>