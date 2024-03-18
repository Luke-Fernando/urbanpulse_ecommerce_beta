<!-- products  -->
<div class="relative overflow-x-auto shadow-md sm:rounded-lg w-full">
    <div class="flex items-center justify-between flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-4 bg-white dark:bg-gray-900">
        <label for="table-search" class="sr-only">Search</label>
        <div class="relative">
            <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                </svg>
            </div>
            <input value="<?php echo $search_text; ?>" type="text" id="table-search-products" class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-[var(--active-bg)] focus:border-[var(--active-bg)]" placeholder="Search for products">
        </div>
    </div>
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-16 py-3">
                    <span class="sr-only">Image</span>
                </th>
                <th scope="col" class="px-6 py-3">
                    Product
                </th>
                <th scope="col" class="px-6 py-3">
                    Status
                </th>
                <th scope="col" class="px-6 py-3">
                    Price
                </th>
                <th scope="col" class="px-6 py-3">
                    Action
                </th>
            </tr>
        </thead>
        <tbody id="products">
            <?php
            $products_resultset = Database::search("SELECT * FROM `product` WHERE `title` LIKE ? LIMIT ? OFFSET ?", [$search, $products_per_page, $offset]);
            $products_num = $products_resultset->num_rows;
            for ($i = 0; $i < $products_num; $i++) {
                $product_data = $products_resultset->fetch_assoc();
                $product_title = $product_data["title"];
                $price = $product_data["price"];
                $product_img_resultset = Database::search("SELECT * FROM `product_image` WHERE `product_id`=? LIMIT 1", [$product_data["id"]]);
                $product_img_data = $product_img_resultset->fetch_assoc();
                $product_img = $product_img_data["product_image"];
                $product_status_resultset = Database::search("SELECT * FROM `status` WHERE `id`=?", [$product_data["status_id"]]);
                $product_status_data = $product_status_resultset->fetch_assoc();
                $product_status = $product_status_data["status"];
            ?>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="p-4">
                        <img src="../assets/images/products/<?php echo $product_img; ?>" class="w-16 md:w-32 max-w-full max-h-full" alt="Apple Watch">
                    </td>
                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white line-clamp-2">
                        <?php echo $product_title; ?>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="h-2.5 w-2.5 rounded-full <?php
                                                                    if ($product_status == "Active") {
                                                                    ?>bg-green-500<?php
                                                                                } else if ($product_status == "Inactive") {
                                                                                    ?>bg-red-500<?php
                                                                                            } else if ($product_status == "Suspended") {
                                                                                                ?>bg-gray-300<?php
                                                                                                            }
                                                                                                                ?> me-2"></div> <?php echo $product_status; ?>
                        </div>
                    </td>
                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                        $<?php echo $price; ?>
                    </td>
                    <td class="px-6 py-4">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input data-product-toggle="<?php echo $product_data["id"]; ?>" type="checkbox" value="" class="sr-only peer" <?php
                                                                                                                                            if ($product_status != "Suspended") {
                                                                                                                                            ?>checked<?php
                                                                                                                                                    }
                                                                                                                                                        ?>>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-0 rounded-full peer 
                                                peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] 
                                                after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 
                                                after:h-5 after:transition-all peer-checked:bg-[var(--active-bg)]"></div>
                        </label>
                    </td>
                </tr>
            <?php
            }
            ?>

        </tbody>
    </table>
</div>
<!-- products  -->
<section id="pagination-products" data-products-per-page="<?php echo $products_per_page; ?>" class="w-full flex justify-center items-center mt-10">
    <nav aria-label="Page navigation example">
        <ul class="flex items-center -space-x-px h-10 text-base">
            <?php
            $all_products_count_resultset = Database::search("SELECT COUNT(`id`) FROM `product`", []);
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
                    <a href="<?php echo $static_link . "" . ($current_page - 1); ?>" class="flex items-center justify-center px-4 h-10 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
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
                        <a href="<?php echo $static_link . "" . ($i + 1); ?>" aria-current="page" class="z-10 pointer-events-none flex items-center justify-center px-4 h-10 leading-tight text-gray-50 border border-[var(--main-bg-low)] bg-[var(--main-bg-high)] hover:bg-[var(--main-bg-low)] hover:text-gray-200"><?php echo ($i + 1); ?></a>
                    </li>
                <?php
                } else {
                ?>
                    <li>
                        <a href="<?php echo $static_link . "" . ($i + 1); ?>" class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700"><?php echo ($i + 1); ?></a>
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
                    <a href="<?php echo $static_link . "" . ($current_page + 1); ?>" class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100 hover:text-gray-700">
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