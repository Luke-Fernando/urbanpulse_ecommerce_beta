<div class="container mx-auto pb-10 px-3 sm:px-0">
    <section class="mt-10 grid grid-cols-2 md:grid-cols-4 gap-4">

        <?php
        $products_per_page = 6;
        if (isset($_GET["page"])) {
            $current_page = $_GET["page"];
        } else {
            $current_page = 1;
        }
        $offset = $products_per_page * ($current_page - 1);
        $product_resultset = Database::search("SELECT * FROM `product` WHERE `users_id`=? LIMIT ? OFFSET ?", [$user["id"], $products_per_page, $offset]);
        $product_num = $product_resultset->num_rows;
        for ($i = 0; $i < $product_num; $i++) {
            $product_data = $product_resultset->fetch_assoc();
            $product_image_resultset = Database::search("SELECT * FROM `product_image` WHERE `product_id`=? LIMIT 1", [$product_data["id"]]);
            $product_image_data = $product_image_resultset->fetch_assoc();
        ?>
            <div class="h-max bg-white border border-gray-200 rounded-lg shadow">
                <a href="<?php echo "productPage.php?id=" . $product_data["id"]; ?>" class="rounded-t-lg w-4/5 aspect-square my-3 mx-auto flex justify-center items-center overflow-hidden">
                    <img class="min-h-full min-w-full object-cover" src="../assets/images/products/<?php echo $product_image_data["product_image"]; ?>" alt="product image" />
                </a>
                <div class="px-5 pb-5">
                    <a href="<?php echo "productPage.php?id=" . $product_data["id"]; ?>">
                        <h5 class="text-sm truncate font-medium tracking-tight text-gray-900 font-fm-inter"><?php echo $product_data["title"]; ?></h5>
                    </a>
                    <div class="flex items-center mt-2.5 mb-5">
                        <svg class="w-4 h-4 text-yellow-300 mr-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                            <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                        </svg>
                        <svg class="w-4 h-4 text-yellow-300 mr-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                            <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                        </svg>
                        <svg class="w-4 h-4 text-yellow-300 mr-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                            <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                        </svg>
                        <svg class="w-4 h-4 text-yellow-300 mr-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                            <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                        </svg>
                        <svg class="w-4 h-4 text-gray-200 dark:text-gray-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                            <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                        </svg>
                        <span class="bg-blue-100 text-blue-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800 ml-3">5.0</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-base sm:text-lg xl:text-xl font-bold text-gray-900 dark:text-white">$<?php echo $product_data["price"]; ?></span>
                        <a href="<?php echo "../update-product/?id=" . $product_data["id"]; ?>" title="Edit Product" class="flex justify-center items-center text-white bg-[var(--main-bg-high)] hover:bg-[var(--main-bg-low)] transition-all duration-100 ease-linear focus:outline-none font-medium rounded-lg px-2 sm:px-3 py-1 text-center capitalize font-fm-inter">
                            <span class="material-symbols-outlined !text-sm sm:!text-base">
                                edit
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </section>

    <section class="flex justify-center items-center mt-10">
        <nav aria-label="Page navigation example">
            <ul class="flex items-center -space-x-px h-10 text-base">
                <?php
                $all_products_count_resultset = Database::search("SELECT COUNT(`id`) FROM `product` WHERE `users_id`=?", [$user["id"]]);
                $all_products_count_data = $all_products_count_resultset->fetch_assoc();
                $all_products_count = $all_products_count_data["COUNT(`id`)"];
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
</div>