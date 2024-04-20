<?php
session_start();
require "../src/php/connection.php";
require "../head.php";
require "../components/InputElements.php";

// require "../components/customSelect.php";
if (isset($_SESSION["user"])) {
?>
    <!DOCTYPE html>
    <html lang="en">
    <?php
    $title = "UrbanPulse | List Your Products";
    head($title);
    ?>

    <body id="window">
        <nav class="w-full h-[75px]">
            <div class="container mx-auto h-full flex justify-center items-end">
                <div class="w-max h-[90%]">
                    <a href="../home/" class="w-max h-full flex justify-center items-center no-underline">
                        <img src="../assets/images/logo-dark.svg" alt="UrbanPulse" class="h-full">
                    </a>
                </div>
            </div>
        </nav>

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

        <div class="container m-auto mt-8 px-3 sm:px-0">
            <h1 class="account-access-page-topic text-center font-fm-inter capitalize text-2xl">add new product</h1>
        </div>

        <section class="container mx-auto mt-16 px-3 sm:px-0">
            <div class="px-5 mt-10 flex flex-row flex-wrap justify-between">
                <div class="w-full h-auto flex items-start">
                    <!-- img input  -->
                    <div class="flex items-center justify-center w-60 sm:w-72">
                        <label for="img-input" class="flex flex-col items-center justify-center w-full aspect-square border-2 border-gray-300 border-dashed rounded-lg 
                    cursor-pointer bg-gray-50 hover:bg-gray-100">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                </svg>
                                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                            </div>
                            <input id="img-input" type="file" accept="image/*" class="hidden" multiple />
                        </label>
                    </div>
                    <!--  -->
                    <div class="flex-1 pl-10">
                        <div id="added-images" class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        </div>
                    </div>
                    <!--  -->
                    <!-- img input  -->
                </div>
                <div class="w-full h-auto my-5">
                    <label for="title" class="block mb-2 capitalize font-fm-inter text-[15px] font-medium text-gray-900">product title</label>
                    <input type="text" id="title" value="" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg 
                    focus:ring-blue-500 focus:border-blue-500 block w-full font-fm-inter h-10 p-2.5 text-[15px]">
                </div>
                <div class="w-full h-auto my-5">
                    <label for="description" class="block mb-2 font-fm-inter capitalize font-medium text-gray-900 text-[15px]">product description</label>
                    <textarea id="description" rows="4" class="block p-2.5 font-fm-inter w-full text-[15px] text-gray-900 bg-gray-50 rounded-lg 
                    border border-gray-300 focus:ring-blue-500 focus:border-blue-500"></textarea>
                </div>
                <!-- category  -->
                <div class="w-full sm:w-[32%] h-auto my-5">
                    <label for="category" class="block mb-2 text-[15px] font-fm-inter font-medium text-gray-900 capitalize">Select the category</label>
                    <select id="category" class="bg-gray-50 border border-gray-300 text-gray-900 text-[14px] font-fm-inter rounded-lg 
                    focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        <option value="0" selected>Pleass select your category</option>
                        <?php
                        $category_resultset = Database::search("SELECT * FROM `category`", []);
                        $category_num = $category_resultset->num_rows;
                        for ($i = 0; $i < $category_num; $i++) {
                            $category_data = $category_resultset->fetch_assoc();
                        ?>
                            <option value="<?php echo $category_data["id"] ?>"><?php echo $category_data["category"] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <!-- category  -->
                <!-- brand  -->
                <div class="w-full sm:w-[32%] h-auto my-5">
                    <label for="brand" class="block mb-2 text-[15px] font-fm-inter font-medium text-gray-900 capitalize">Select the brand</label>
                    <select id="brand" class="bg-gray-50 border border-gray-300 text-gray-900 text-[14px] font-fm-inter rounded-lg focus:ring-blue-500 focus:border-blue-500 
                block w-full p-2.5">
                        <option value="0" selected>Pleass select your category first</option>
                    </select>
                </div>
                <!-- brand  -->
                <!-- model  -->
                <div class="w-full sm:w-[32%] h-auto my-5">
                    <label for="model" class="block mb-2 text-[15px] font-fm-inter font-medium text-gray-900 capitalize">Select the model</label>
                    <select id="model" class="bg-gray-50 border border-gray-300 text-gray-900 text-[14px] font-fm-inter rounded-lg focus:ring-blue-500 focus:border-blue-500 
                block w-full p-2.5">
                        <option value="0" selected>Pleass select your brand first</option>
                    </select>
                </div>
                <!-- model  -->
                <!-- colors  -->
                <div class="w-full sm:w-[49%] h-auto flex flex-row flex-wrap my-5">
                    <label for="color" class="block w-full mb-2 text-[15px] font-fm-inter font-medium text-gray-900 capitalize">Select colors</label>
                    <select id="color" class="bg-gray-50 border border-gray-300 text-gray-900 text-[14px] font-fm-inter rounded-lg focus:ring-blue-500 focus:border-blue-500 
                block flex-1 p-2.5 capitalize">
                        <option value="0">Select your color variations</option>
                        <?php
                        $color_resultset = Database::search("SELECT * FROM `color`", []);
                        $color_num = $color_resultset->num_rows;
                        for ($i = 0; $i < $color_num; $i++) {
                            $color_data = $color_resultset->fetch_assoc();
                        ?>
                            <option value="<?php echo $color_data["id"] ?>"><?php echo $color_data["color"] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <button id="add-color-btn" type="button" class="text-white bg-[var(--main-bg-high)] hover:bg-[var(--main-bg-low)] 
                focus:ring-0 focus:outline-none font-medium rounded-lg text-sm p-2.5 ml-1 text-center inline-flex items-center mr-2">
                        <span class="material-symbols-outlined">
                            add
                        </span>
                        <span class="sr-only">Add Color</span>
                    </button>
                    <div onchange="initDismisses();" id="colors" class="w-full h-auto mt-2">
                    </div>
                </div>
                <!-- colors  -->
                <!-- condition  -->
                <div class="w-full sm:w-[49%] h-auto my-5">
                    <label for="condition" class="block mb-2 text-[15px] font-fm-inter font-medium text-gray-900 capitalize">Select the condition</label>
                    <select id="condition" class="bg-gray-50 border border-gray-300 text-gray-900 text-[14px] font-fm-inter rounded-lg focus:ring-blue-500 focus:border-blue-500 
                block w-full p-2.5">
                        <option value="0" selected>Select the condition</option>
                        <?php
                        $condition_resultset = Database::search("SELECT * FROM `condition`", []);
                        $condition_num = $condition_resultset->num_rows;
                        for ($i = 0; $i < $condition_num; $i++) {
                            $condition_data = $condition_resultset->fetch_assoc();
                        ?>
                            <option value="<?php echo $condition_data["id"] ?>"><?php echo $condition_data["condition"] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <!-- condition  -->
                <!-- price  -->
                <div class="w-full sm:w-[49%] h-auto my-5">
                    <label for="price" class="block mb-2 capitalize font-fm-inter text-[15px] font-medium text-gray-900">price</label>
                    <input type="text" id="price" value="" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg 
                    focus:ring-blue-500 focus:border-blue-500 block w-full font-fm-inter h-10 p-2.5 text-[15px]">
                </div>
                <!-- price  -->
                <!-- quantity  -->
                <div class="w-full sm:w-[49%] h-auto my-5">
                    <label for="quantity" class="block mb-2 capitalize font-fm-inter text-[15px] font-medium text-gray-900">quantity</label>
                    <input type="text" id="quantity" value="" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg 
                    focus:ring-blue-500 focus:border-blue-500 block w-full font-fm-inter h-10 p-2.5 text-[15px]">
                </div>
                <!-- quantity  -->
                <!-- shipping locations  -->
                <div class="w-[100%] h-auto flex flex-row flex-wrap my-5">
                    <label for="country" class="block w-full mb-2 text-[15px] font-fm-inter font-medium text-gray-900 capitalize">add shippping locations</label>
                    <select id="country" class="bg-gray-50 border border-gray-300 text-gray-900 text-[14px] font-fm-inter rounded-lg focus:ring-blue-500 focus:border-blue-500 
                block flex-1 p-2.5 capitalize">
                        <option value="worldwide" selected>worldwide</option>
                        <?php
                        $country_resultset = Database::search("SELECT * FROM `country`", []);
                        $country_num = $country_resultset->num_rows;
                        for ($i = 0; $i < $country_num; $i++) {
                            $country_data = $country_resultset->fetch_assoc();
                        ?>
                            <option value="<?php echo $country_data["id"] ?>"><?php echo $country_data["country"] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <button id="add-location-btn" type="button" class="text-white bg-[var(--main-bg-high)] hover:bg-[var(--main-bg-low)] focus:ring-0 focus:outline-none font-medium 
                rounded-lg text-sm p-2.5 ml-1 text-center inline-flex items-center mr-2">
                        <span class="material-symbols-outlined">
                            add
                        </span>
                        <span class="sr-only">Add country</span>
                    </button>
                    <div id="locations" class="w-full h-auto mt-2">
                    </div>
                </div>
                <!-- shipping locations  -->
                <!-- shipping type  -->
                <div class="w-full sm:w-[49%] h-auto my-5">
                    <label for="shipping-type" class="block mb-2 text-[15px] font-fm-inter font-medium text-gray-900 capitalize">shipping type</label>
                    <select id="shipping-type" class="bg-gray-50 border border-gray-300 text-gray-900 text-[14px] font-fm-inter rounded-lg focus:ring-blue-500 focus:border-blue-500 
                block w-full p-2.5 capitalize">
                        <option selected value="0">select the shipping type</option>
                        <option value="1">flat rate</option>
                        <option value="2">custom</option>
                    </select>
                </div>
                <!-- shipping type  -->
                <!-- shipping  -->
                <div class="w-full sm:w-[49%] h-auto my-5 flex flex-row flex-wrap justify-between items-end">
                    <div class="w-[40%] h-auto">
                        <label for="ship-country" class="block mb-2 text-[15px] font-fm-inter font-medium text-gray-900 capitalize">country</label>
                        <select id="ship-country" class="bg-gray-50 border border-gray-300 text-gray-900 text-[14px] font-fm-inter rounded-lg focus:ring-blue-500 focus:border-blue-500 
                block w-full p-2.5">
                            <option value="0">Please select the shipping type first</option>
                        </select>
                    </div>
                    <div class="flex-1 h-auto">
                        <label for="shipping-cost" class="block mb-2 text-[15px] font-medium text-gray-900 capitalize font-fm-inter">shipping cost</label>
                        <div class="flex">
                            <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md">
                                <span class="material-symbols-outlined text-gray-500">
                                    attach_money
                                </span>
                            </span>
                            <input type="text" id="shipping-cost" class="rounded-none bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 
                        block flex-1 min-w-0 w-full text-[14px] border-gray-300 p-2.5 font-fm-inter">
                            <span class="inline-flex items-center px-3 text-[15px] bg-gray-200 border border-r-0 border-gray-300 rounded-r-md font-fm-inter font-normal text-gray-500">
                                .00
                            </span>
                        </div>
                    </div>
                    <button id="add-country-btn" type="button" class="text-white bg-[var(--main-bg-high)] hover:bg-[var(--main-bg-low)] focus:ring-0 focus:outline-none font-medium 
                rounded-lg text-sm p-2.5 ml-1 text-center inline-flex items-center mr-2 h-12 relative">
                        <span class="material-symbols-outlined">
                            add
                        </span>
                        <span class="sr-only">Add country</span>
                    </button>
                    <div id="shipping-countries" class="w-full h-auto flex my-1">
                    </div>
                </div>
                <!-- shipping  -->
                <div class="w-full flex flex-col justify-center items-center my-5">
                    <button id="list-item-btn" type="button" class="text-white bg-[var(--main-bg-high)] hover:bg-[var(--main-bg-low)] focus:outline-none focus:ring-0 font-medium 
                rounded-full text-[15px] w-full sm:w-auto sm:px-44 py-3 text-center my-5 font-fm-inter capitalize">list item</button>
                </div>
            </div>
        </section>

        <!-- <script type="module" src="../assets/js/addProduct.js"></script>
        <script src="../assets/js/badge.js"></script> -->
        <!-- <script type="module" src="../assets/js_beta/index.js"></script> -->
    </body>

    </html>
<?php
} else {
?>
    <script>
        window.location.href = "/urbanpulse_ecommerce_beta/signin/";
    </script>
<?php
}
?>