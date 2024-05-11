<?php
session_start();
require "../server/connection.php";
require "../head.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (isset($_SESSION["admin"])) {
    $admin = $_SESSION["admin"];
    if (isset($_GET["location"])) {
        $location = $_GET["location"];
    } else {
        $location = "dashboard";
    }
?>
    <!DOCTYPE html>
    <html lang="en">

    <?php
    $title = "UrbanPulse | Admin";
    head($title);
    ?>

    <body>
        <nav class="w-full h-auto bg-[var(--main-bg-high)] ">
            <section class="w-full box-border px-5 sm:px-10 mx-auto h-[60px] flex justify-between items-center">
                <!-- logo  -->
                <div class="w-max min-h-full flex justify-center items-center">
                    <a href="/urbanpulse_ecommerce_beta/admin/" class="flex h-3/4 w-max justify-center items-center">
                        <img src="../assets/images/logo-light.svg" alt="urbanpulse logo" class="h-full">
                    </a>
                </div>
                <!-- logo  -->
            </section>
            <section class="w-full h-[35px] bg-[var(--secondary-bg)] flex justify-start items-center px-5 sm:px-10">
                <button id="admin-tabs-toggle" class="w-auto h-4/5 flex justify-center items-center text-[var(--text-white-low)] hover:text-[var(--text-white-high)] transition-all duration-100 ease-in-out">
                    <!-- <span class="material-symbols-outlined !text-inherit py-5">
                            close
                        </span> -->
                    <span class="material-symbols-outlined !text-inherit py-5">
                        menu
                    </span>
                </button>
            </section>
        </nav>

        <!-- <div class="container mx-auto h-5 bg-red-500 sm:bg-gray-800 md:bg-blue-400 lg:bg-emerald-400 xl:bg-pink-400 2xl:bg-purple-500"></div> -->

        <!-- alerts  -->
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
        <!-- alerts  -->

        <section class="w-full h-auto min-h-[1000px] flex justify-between items-start relative">
            <!-- tabs  -->
            <section id="tabs-container" class="min-w-max md:w-[15%] -translate-x-full md:-translate-x-0 transition-all duration-100 ease-in-out hidden md:flex 
            min-h-max h-full md:h-screen bg-[var(--main-bg-high)] absolute z-50 md:z-auto md:sticky top-0 left-0">
                <div class="min-w-max w-full h-max mt-10 flex flex-col justify-start items-start !sticky !top-0 !left-0">
                    <!-- tab link  -->
                    <div class="min-w-max w-full h-auto flex justify-center items-center text-[var(--text-white-low)] transition-all duration-100 ease-in-out 
                    hover:text-[var(--text-white-high)] hover:bg-[var(--secondary-bg)] box-border px-5 sm:px-10 <?php if ($location == "dashboard") {
                                                                                                                    echo ("text-[var(--text-white-high)] bg-[var(--secondary-bg)]");
                                                                                                                } ?>">
                        <a href="?location=dashboard" class="flex min-w-max w-full h-auto justify-start items-center font-fm-inter text-inherit text-md font-medium capitalize py-3">
                            <span class="material-symbols-outlined mr-3 !text-inherit !text-xl">
                                dashboard
                            </span>dashboard
                        </a>
                    </div>
                    <!-- tab link  -->
                    <!-- tab link  -->
                    <div class="min-w-max w-full h-auto flex justify-center items-center text-[var(--text-white-low)] transition-all duration-100 ease-in-out 
                    hover:text-[var(--text-white-high)] hover:bg-[var(--secondary-bg)] box-border px-5 sm:px-10 <?php if ($location == "messages") {
                                                                                                                    echo ("text-[var(--text-white-high)] bg-[var(--secondary-bg)]");
                                                                                                                } ?>">
                        <a href="?location=messages" class="flex min-w-max w-full h-auto justify-start items-center font-fm-inter text-inherit text-md font-medium capitalize py-3">
                            <span class="material-symbols-outlined mr-3 !text-inherit !text-xl">
                                forum
                            </span>messages
                        </a>
                    </div>
                    <!-- tab link  -->
                    <!-- tab link  -->
                    <div class="min-w-max w-full h-auto flex justify-center items-center text-[var(--text-white-low)] transition-all duration-100 ease-in-out 
                    hover:text-[var(--text-white-high)] hover:bg-[var(--secondary-bg)] box-border px-5 sm:px-10 <?php if ($location == "products") {
                                                                                                                    echo ("text-[var(--text-white-high)] bg-[var(--secondary-bg)]");
                                                                                                                } ?>">
                        <a href="?location=products" class="flex min-w-max w-full h-auto justify-start items-center font-fm-inter text-inherit text-md font-medium capitalize py-3">
                            <span class="material-symbols-outlined mr-3 !text-inherit !text-xl">
                                inventory
                            </span>manage products
                        </a>
                    </div>
                    <!-- tab link  -->
                    <!-- tab link  -->
                    <div class="min-w-max w-full h-auto flex justify-center items-center text-[var(--text-white-low)] transition-all duration-100 ease-in-out 
                    hover:text-[var(--text-white-high)] hover:bg-[var(--secondary-bg)] box-border px-5 sm:px-10 <?php if ($location == "users") {
                                                                                                                    echo ("text-[var(--text-white-high)] bg-[var(--secondary-bg)]");
                                                                                                                } ?>">
                        <a href="?location=users" class="flex min-w-max w-full h-auto justify-start items-center font-fm-inter text-inherit text-md font-medium capitalize py-3">
                            <span class="material-symbols-outlined mr-3 !text-inherit !text-xl">
                                manage_accounts
                            </span>manage users
                        </a>
                    </div>
                    <!-- tab link  -->
                    <!-- tab link  -->
                    <div class="min-w-max w-full h-auto flex justify-center items-center text-[var(--text-white-low)] transition-all duration-100 ease-in-out 
                    hover:text-[var(--text-white-high)] hover:bg-[var(--secondary-bg)] box-border px-5 sm:px-10 <?php if ($location == "admins") {
                                                                                                                    echo ("text-[var(--text-white-high)] bg-[var(--secondary-bg)]");
                                                                                                                } ?>">
                        <a href="?location=admins" class="flex min-w-max w-full h-auto justify-start items-center font-fm-inter text-inherit text-md font-medium capitalize py-3">
                            <span class="material-symbols-outlined mr-3 !text-inherit !text-xl">
                                productivity
                            </span>manage admins
                        </a>
                    </div>
                    <!-- tab link  -->
                </div>
            </section>
            <!-- tabs  -->
            <section id="admin-main" class="w-full md:w-[85%] min-h-screen flex flex-col justify-start items-start box-border px-4">
                <?php
                if ($location == "dashboard") {
                ?>
                    <div class="w-full my-10 capitalize">
                        <h1 class="font-fm-inter text-2xl text-gray-800 font-medium">dashboard</h1>
                    </div>
                    <?php
                    require "./dashboard/index.php";
                    ?>
                <?php
                }
                ?>
                <?php
                if ($location == "messages") {
                ?>
                    <div class="w-full my-10 capitalize">
                        <h1 class="font-fm-inter text-2xl text-gray-800 font-medium">messages</h1>
                    </div>
                    <?php
                    require "./messages/index.php";
                    ?>
                <?php
                }
                ?>
                <?php
                if ($location == "products") {
                    $products_per_page = 5;
                    if (isset($_GET["page"])) {
                        $current_page = $_GET["page"];
                    } else {
                        $current_page = 1;
                    }
                    if (isset($_GET["search"]) && !empty($_GET["search"])) {
                        $search_text = str_replace("+", " ", $_GET["search"]);
                        $search = '%' . $search_text . '%';
                        $static_link = "?location=products&search=" . $_GET["search"] . "&page=";
                    } else {
                        $search_text = "";
                        $search = "%%";
                        $static_link = "?location=products&page=";
                    }
                    $offset = $products_per_page * ($current_page - 1);
                ?>
                    <div class="w-full my-10 capitalize">
                        <h1 class="font-fm-inter text-2xl text-gray-800 font-medium">manage products</h1>
                    </div>
                    <?php
                    require "./products/index.php";
                    ?>
                <?php
                }
                ?>
                <?php
                if ($location == "users") {
                    $users_per_page = 3;
                    if (isset($_GET["page"])) {
                        $current_page = $_GET["page"];
                    } else {
                        $current_page = 1;
                    }
                    if (isset($_GET["search"]) && !empty($_GET["search"])) {
                        $search_text = str_replace("+", " ", $_GET["search"]);
                        $search = '%' . $search_text . '%';
                        $static_link = "?location=users&search=" . $_GET["search"] . "&page=";
                    } else {
                        $search_text = "";
                        $search = "%%";
                        $static_link = "?location=users&page=";
                    }
                    $offset = $users_per_page * ($current_page - 1);
                ?>
                    <div class="w-full my-10 capitalize">
                        <h1 class="font-fm-inter text-2xl text-gray-800 font-medium">manage users</h1>
                    </div>
                    <?php
                    require "./users/index.php";
                    ?>
                <?php
                }
                ?>
            </section>
        </section>
        <script type="module" src="../assets/js/adminCharts.js"></script>
        <script type="module" src="../assets/js/admin.js"></script>

    </body>

    </html>
<?php
} else {
?>
    <script>
        window.location.href = "/urbanpulse_ecommerce_beta/admin/signin/";
    </script>
<?php
}
?>