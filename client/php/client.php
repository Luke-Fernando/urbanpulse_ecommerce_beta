<?php

class Client
{
    public function generate_products($resultset, $user, $link)
    {
        $resultset_num = $resultset->num_rows;
        for ($i = 0; $i < $resultset_num; $i++) {
            /* --------------------------------- product -------------------------------- */

            $product_data = $resultset->fetch_assoc();
?>
            <!-- product  -->
            <div class="w-60 min:w-72 max:w-80 xl:w-80 bg-white  rounded-lg shadow">
                <a href="<?php echo $link . "product/?id=" . $product_data["id"] . "&clicked=true"; ?>" class="w-4/5 flex justify-center items-center 
                        aspect-square overflow-hidden mx-auto">
                    <?php
                    $product_image_resultset = Database::search("SELECT * FROM `product_image` WHERE `product_id`=? LIMIT 1", [$product_data["id"]]);
                    $product_image_data = $product_image_resultset->fetch_assoc();
                    ?>
                    <img class="min-w-full min-h-full object-cover" src="../assets/images/products/<?php echo $product_image_data["product_image"]; ?>" alt="product image" />
                </a>
                <div class="px-5 pb-5">
                    <a href="<?php echo $link . "product/?id=" . $product_data["id"] . "&clicked=true"; ?>">
                        <h5 class="text-sm truncate font-medium tracking-tight text-gray-900 font-fm-inter"><?php echo $product_data["title"]; ?></h5>
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
                        <span class="text-lg xl:text-2xl font-bold text-gray-900 dark:text-white">$<?php echo $product_data["price"]; ?></span>
                        <?php
                        if ($user != "") {
                            $wishlist_resultset = Database::search("SELECT * FROM `wishlist` WHERE `product_id`=? AND `users_id`=?", [$product_data["id"], $user["id"]]);
                            $wishlist_num = $wishlist_resultset->num_rows;
                            if ($wishlist_num == 1) {
                        ?>
                                <button data-toggle-wishlist="<?php echo $product_data["id"]; ?>" class="text-[var(--text-white-high)] bg-[var(--active-bg)] 
                                transition-all duration-200 ease-linear hover:bg-[var(--main-bg-low)] font-medium text-xs xl:text-xs px-4 py-1 capitalize font-fm-inter">
                                    <span class="material-symbols-outlined !text-lg pointer-events-none">
                                        favorite
                                    </span>
                                </button>
                            <?php
                            } else if ($wishlist_num == 0) {
                            ?>
                                <button data-toggle-wishlist="<?php echo $product_data["id"]; ?>" class="text-[var(--text-white-high)] bg-[var(--main-bg-high)] 
                                transition-all duration-200 ease-linear hover:bg-[var(--main-bg-low)] font-medium text-xs px-4 py-1 capitalize font-fm-inter">
                                    <span class="material-symbols-outlined !text-lg pointer-events-none">
                                        favorite
                                    </span>
                                </button>
                            <?php
                            }
                        } else {
                            ?>
                            <button data-toggle-wishlist="<?php echo $product_data["id"]; ?>" class="text-[var(--text-white-high)] bg-[var(--main-bg-high)] 
                            transition-all duration-200 ease-linear hover:bg-[var(--main-bg-low)] font-medium text-xs xl:text-xs px-4 py-1 capitalize font-fm-inter">
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
            /* --------------------------------- product -------------------------------- */
        }
    }
}
