<?php

function navbar($user)

{
    $root =  $_SERVER['HTTP_HOST'];
?>
    <nav class="w-full h-auto flex flex-col justify-center items-center">
        <section class="w-full min-h-[60px] bg-[var(--main-bg-high)] flex justify-center items-center">
            <div class="w-[98%] h-full flex flex-wrap md:flex-nowrap justify-between items-center">
                <!-- logo  -->
                <div class=" w-max h-full min-w-max flex justify-start items-center md:mr-5">
                    <a href="/urbanpulse_ecommerce_beta/home/" class="block h-3/4">
                        <img src="http://<?php echo $root ?>/urbanpulse_ecommerce_beta/assets/images/logo-light.svg" alt="Urbanpulse logo" class="h-full">
                    </a>
                </div>
                <!-- logo  -->
                <!-- search  -->
                <div class="w-full md:flex-1 flex justify-center items-center h-max order-last md:order-none">
                    <div class="w-full h-[35px] my-3 lg:my-0 flex justify-between items-center">
                        <div class="h-full w-36 flex justify-center items-center mr-1">
                            <?php
                            $categoryOptions = generate_options("SELECT * FROM `category`", [], "All", "category", "id");
                            customSelect("w-full", "h-full", "text-[14px]", "categories", $categoryOptions, false);
                            ?>
                        </div>
                        <input id="basic-search-input" type="text" class="flex-1 box-border h-full font-fm-inter font-normal text-[15px] border-none focus:ring-0 focus:ring-offset-0">
                        <button data-see-all="search" id="basic-search-btn" class="h-full w-24 border-none bg-[var(--active-bg)] flex justify-center items-center !text-[25px] text-white">
                            <span class="material-symbols-outlined">
                                search
                            </span>
                        </button>
                    </div>
                </div>
                <!-- search  -->
                <!-- links  -->
                <div class=" w-max h-auto min-w-max flex justify-end items-center md:ml-5">

                    <button id="account-dropdown-button" data-dropdown-toggle="accountLink" class="flex items-center text-sm text-[var(--text-white-low)] 
                    hover:text-[var(--text-white-high)] transition-all ease-linear duration-200 mr-2 sm:mr-5" type="button">
                        <span class="material-symbols-outlined !text-[20px]">
                            person
                        </span>
                        <span class="hidden lg:block font-fm-inter capitalize text-[15px]">account</span>
                    </button>
                    <a href="/urbanpulse_ecommerce_beta/wishlist/" class="flex items-center mx-1 sm:mx-3 text-sm md:mr-0 text-[var(--text-white-low)] 
                    hover:text-[var(--text-white-high)] transition-all ease-linear duration-200">
                        <span class="material-symbols-outlined !text-[20px]">
                            favorite
                        </span>
                        <span class="hidden lg:block font-fm-inter capitalize text-[15px]">wishlist</span>
                    </a>
                    <a href="/urbanpulse_ecommerce_beta/cart/" class="flex items-center mx-1 sm:mx-3 text-sm md:mr-0 text-[var(--text-white-low)] 
                    hover:text-[var(--text-white-high)] transition-all ease-linear duration-200">
                        <span class="material-symbols-outlined !text-[20px]">
                            shopping_cart
                        </span>
                        <span class="hidden lg:block font-fm-inter capitalize text-[15px]">cart</span>
                    </a>
                    <!-- account dropdown  -->
                    <div id="accountLink" class="z-50 hidden bg-white divide-y divide-gray-100 shadow w-44">
                        <div class="px-4 py-3 text-sm text-gray-900">
                            <div class="capitalize"><?php
                                                    if (!empty($user)) {
                                                        echo $user['first_name'] . " " . $user['last_name'];
                                                    } else {
                                                        echo ("hi");
                                                    }
                                                    ?></div>
                            <!-- <div class="font-medium truncate">name@flowbite.com</div> -->
                            <div class="font-medium truncate"><?php
                                                                if (!empty($user)) {
                                                                    echo $user["email"];
                                                                }
                                                                ?>
                            </div>
                        </div>
                        <ul class="py-2 text-sm text-gray-700" aria-labelledby="account-dropdown-button">
                            <?php
                            if (!empty($user)) {
                            ?>
                                <li>
                                    <a href="/urbanpulse_ecommerce_beta/profile/" class="block px-4 py-2 hover:bg-gray-100 capitalize">profile</a>
                                </li>
                            <?php
                            }
                            ?>
                            <?php
                            if (!empty($user)) {
                            ?>
                                <li>
                                    <a href="/urbanpulse_ecommerce_beta/orders/" class="block px-4 py-2 hover:bg-gray-100 capitalize">my orders</a>
                                </li>
                            <?php
                            }
                            ?>
                            <li>
                                <a href="#" class="block px-4 py-2 hover:bg-gray-100 capitalize">Settings</a>
                            </li>
                            <?php
                            if (!empty($user)) {
                            ?>
                                <li>
                                    <a href="/urbanpulse_ecommerce_beta/seller-dashboard/" class="block px-4 py-2 hover:bg-gray-100 capitalize">seller dashboard</a>
                                </li>
                            <?php
                            }
                            ?>
                        </ul>
                        <?php
                        if (!empty($user)) {
                        ?>
                            <div class="py-2">
                                <button id="signout-btn" class="w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100 capitalize">Sign out</button>
                            </div>
                        <?php
                        } else {
                        ?>
                            <div class="py-2">
                                <a href="/urbanpulse_ecommerce_beta/signin/" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 capitalize">sign in / register</a>
                            </div>
                        <?php
                        }
                        ?>

                    </div>
                    <!-- account dropdown  -->
                </div>
                <!-- links  -->
            </div>
        </section>
        <section class="w-full h-[35px] bg-[var(--secondary-bg)] flex justify-center items-center">
            <div class="w-[98%] h-full flex justify-start items-center">
                <!-- drawer  -->
                <!-- drawer init and toggle -->
                <div class="text-center">
                    <button class="text-white flex justify-center items-center font-medium text-sm focus:outline-none" type="button" data-drawer-target="drawer-disable-body-scrolling" data-drawer-show="drawer-disable-body-scrolling" data-drawer-body-scrolling="false" aria-controls="drawer-disable-body-scrolling">
                        <span class="material-symbols-outlined">
                            menu
                        </span>
                    </button>
                </div>
                <a href="/urbanpulse_ecommerce_beta/add-product/" class="capitalize font-fm-inter text-[15px] text-[var(--text-white-low)] hover:text-[var(--text-white-high)] block h-auto w-max ml-5 
                transition-all ease-linear duration-200">sell</a>
                <!-- drawer component -->
                <div id="drawer-disable-body-scrolling" class="fixed top-0 bg-[var(--main-bg-high)] left-0 z-40 overflow-y-auto overflow-x-hidden h-screen p-4 
                transition-transform -translate-x-full w-64" tabindex="-1" aria-labelledby="drawer-disable-body-scrolling-label">
                    <h5 id="drawer-disable-body-scrolling-label" class="text-base font-fm-inter text-gray-300 capitalize">categories</h5>
                    <button type="button" data-drawer-hide="drawer-disable-body-scrolling" aria-controls="drawer-disable-body-scrolling" class="text-gray-300 
                    bg-transparent hover:text-gray-100 text-sm w-8 h-8 absolute top-2.5 right-2.5 inline-flex items-center 
                    justify-center">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close menu</span>
                    </button>
                    <div class="py-4 min-w-max">
                        <ul class="space-y-2 min-w-max font-medium">
                            <!-- category  -->
                            <?php
                            $category_resultset = Database::search("SELECT * FROM `category`", []);
                            $category_num = $category_resultset->num_rows;
                            for ($i = 0; $i < $category_num; $i++) {
                                $category_data = $category_resultset->fetch_assoc();

                            ?>
                                <li class="min-w-max">
                                    <button type="button" class="flex items-center  min-w-max w-full p-2 text-base text-gray-900 transition duration-75 group 
                                hover:bg-[var(--secondary-bg)]" aria-controls="<?php echo "category-" . $category_data["id"]; ?>" data-collapse-toggle="<?php echo "category-" . $category_data["id"]; ?>">
                                        <span class="flex-1 ml-3 text-left whitespace-nowrap text-white font-fm-inter text-[15px] !font-normal"><?php echo $category_data["category"]; ?></span>
                                        <span class="material-symbols-outlined text-white">
                                            expand_more
                                        </span>
                                    </button>
                                    <ul id="<?php echo "category-" . $category_data["id"]; ?>" class="hidden py-2 space-y-2">
                                        <li>
                                            <a href="#" class="font-fm-inter font-normal flex items-center w-full p-2 transition duration-75 pl-11 
                                            group hover:bg-[var(--secondary-bg)] text-white">Products</a>
                                        </li>
                                        <li>
                                            <a href="#" class="font-fm-inter font-normal flex items-center w-full p-2 transition duration-75 pl-11 
                                            group hover:bg-[var(--secondary-bg)] text-white">Billing</a>
                                        </li>
                                        <li>
                                            <a href="#" class="font-fm-inter font-normal flex items-center w-full p-2 transition duration-75 pl-11 
                                            group hover:bg-[var(--secondary-bg)] text-white">Invoice</a>
                                        </li>
                                    </ul>
                                </li>
                            <?php
                            }
                            ?>

                            <!-- category  -->
                        </ul>
                    </div>
                </div>
                <!-- drawer  -->
            </div>
        </section>
    </nav>
<?php } ?>