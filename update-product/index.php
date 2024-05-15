<?php
session_start();
require "../server/connection.php";
require "../head.php";
require "../components/InputElements.php";
if (isset($_SESSION["user"])) {
    if (isset($_GET["id"])) {
        $product_id = $_GET["id"];
        $product_resultset = Database::search("SELECT * FROM `product` WHERE `id`=?", [$product_id]);
        $product_data = $product_resultset->fetch_assoc();
        $product_title = $product_data["title"];
        $description = $product_data["description"];
        $condition_id = $product_data["condition_id"];
        $condition_resultset = Database::search("SELECT * FROM `condition` WHERE `id`=?", [$condition_id]);
        $condition_data = $condition_resultset->fetch_assoc();
        $condition = $condition_data["condition"];
        $price = $product_data["price"];
        $quantity = $product_data["qty"];
        $status = $product_data["status_id"];
        $category_id = $product_data["category_id"];
        $brand_has_model_id = $product_data["brand_has_model_id"];
        $category_resultset = Database::search("SELECT * FROM `category` WHERE `id`=?", [$category_id]);
        $category_data = $category_resultset->fetch_assoc();
        $category = $category_data["category"];
        $brand_has_model_resultset = Database::search("SELECT * FROM `brand_has_model` WHERE `id`=?", [$brand_has_model_id]);
        $brand_has_model_data = $brand_has_model_resultset->fetch_assoc();
        $brand_id = $brand_has_model_data["brand_id"];
        $model_id = $brand_has_model_data["model_id"];
        $brand_resultset = Database::search("SELECT * FROM `brand` WHERE `id`=?", [$brand_id]);
        $brand_data = $brand_resultset->fetch_assoc();
        $brand = $brand_data["brand"];
        $model_resultset = Database::search("SELECT * FROM `model` WHERE `id`=?", [$model_id]);
        $model_data = $model_resultset->fetch_assoc();
        $model = $model_data["model"];
?>
        <!DOCTYPE html>
        <html lang="en">
        <?php
        $title = "UrbanPulse | Update Product";
        head($title);
        ?>

        <body id="update-product" data-product-id="<?php echo $product_id; ?>">
            <nav class="w-full h-[75px]">
                <div class="container mx-auto h-full flex justify-center items-end">
                    <div class="w-max h-[90%]">
                        <a href="/urbanpulse_ecommerce_beta/home/" class="w-max h-full flex justify-center items-center no-underline">
                            <img src="../assets/images/logo-dark.svg" alt="UrbanPulse" class="h-full">
                        </a>
                    </div>
                </div>
            </nav>

            <div class="container m-auto mt-8 px-3 sm:px-0">
                <h1 id="update-product-page-title" class="account-access-page-topic text-center font-fm-inter font-normal capitalize text-xl">product title</h1>
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
                                <?php
                                $image_resultset = Database::search("SELECT * FROM `product_image` WHERE `product_id`=?", [$product_id]);
                                $image_num = $image_resultset->num_rows;
                                for ($i = 0; $i < $image_num; $i++) {
                                    $image_data = $image_resultset->fetch_assoc();
                                ?>
                                    <!-- image item  -->
                                    <div data-loaded-image-item="<?php echo $image_data["id"]; ?>" class="relative aspect-square flex justify-center items-center overflow-hidden">
                                        <img class="h-auto max-w-full rounded-lg min-w-full min-h-full object-cover" src="../assets/images/products/<?php echo $image_data["product_image"]; ?>">
                                        <div class="absolute bottom-0 inset-x-0 flex justify-around items-center w-full h-max bg-black/30 py-4">
                                            <button class="text-gray-100 hover:text-white transition-all duration-75 ease-linear" data-loaded-image-remove="<?php echo $image_data["id"]; ?>">
                                                <span class="material-symbols-outlined pointer-events-none">delete</span>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- image item  -->
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                        <!--  -->
                        <!-- img input  -->
                    </div>
                    <div class="w-full h-auto my-5">
                        <label for="title" class="block mb-2 capitalize font-fm-inter text-[15px] font-medium text-gray-900">product title</label>
                        <input type="text" id="title" value="<?php echo $product_title; ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg 
                    focus:ring-blue-500 focus:border-blue-500 block w-full font-fm-inter h-10 p-2.5 text-[15px]">
                    </div>
                    <div class="w-full h-auto my-5">
                        <label for="description" class="block mb-2 font-fm-inter capitalize font-medium text-gray-900 text-[15px]">product description</label>
                        <textarea id="description" rows="4" class="block p-2.5 font-fm-inter w-full text-[15px] text-gray-900 bg-gray-50 rounded-lg 
                    border border-gray-300 focus:ring-blue-500 focus:border-blue-500"><?php echo $description; ?></textarea>
                    </div>
                    <!-- category  -->
                    <div class="w-full sm:w-[32%] h-auto my-5">
                        <label for="category" class="block mb-2 text-[15px] font-fm-inter font-medium text-gray-900 capitalize">Select the category</label>
                        <select id="category" class="cursor-not-allowed bg-gray-200 border border-gray-300 text-gray-900 text-[14px] font-fm-inter rounded-lg 
                    focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 capitalize" disabled>
                            <option value="0"><?php echo $category; ?></option>
                        </select>
                    </div>
                    <!-- category  -->
                    <!-- brand  -->
                    <div class="w-full sm:w-[32%] h-auto my-5">
                        <label for="brand" class="block mb-2 text-[15px] font-fm-inter font-medium text-gray-900 capitalize">Select the brand</label>
                        <select id="brand" class="cursor-not-allowed bg-gray-200 border border-gray-300 text-gray-900 text-[14px] font-fm-inter rounded-lg focus:ring-blue-500 focus:border-blue-500 
                block w-full p-2.5 capitalize" disabled>
                            <option value="0"><?php echo $brand; ?></option>
                        </select>
                    </div>
                    <!-- brand  -->
                    <!-- model  -->
                    <div class="w-full sm:w-[32%] h-auto my-5">
                        <label for="model" class="block mb-2 text-[15px] font-fm-inter font-medium text-gray-900 capitalize">Select the model</label>
                        <select id="model" class="cursor-not-allowed bg-gray-200 border border-gray-300 text-gray-900 text-[14px] font-fm-inter rounded-lg focus:ring-blue-500 focus:border-blue-500 
                block w-full p-2.5 capitalize" disabled>
                            <option value="0"><?php echo $model; ?></option>
                        </select>
                    </div>
                    <!-- model  -->
                    <!-- colors  -->
                    <div class="w-full sm:w-[49%] h-auto flex flex-row flex-wrap my-5">
                        <label for="color" class="block w-full mb-2 text-[15px] font-fm-inter font-medium text-gray-900 capitalize">Select colors</label>
                        <select id="color" class="bg-gray-50 border border-gray-300 text-gray-900 text-[14px] font-fm-inter rounded-lg focus:ring-blue-500 focus:border-blue-500 
                block flex-1 p-2.5 capitalize">
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
                        <select id="condition" class="cursor-not-allowed bg-gray-200 border border-gray-300 text-gray-900 text-[14px] font-fm-inter rounded-lg focus:ring-blue-500 focus:border-blue-500 
                block w-full p-2.5 capitalize" disabled>
                            <option value="0"><?php echo $condition; ?></option>
                        </select>
                    </div>
                    <!-- condition  -->
                    <!-- price  -->
                    <div class="w-full sm:w-[49%] h-auto my-5">
                        <label for="price" class="block mb-2 capitalize font-fm-inter text-[15px] font-medium text-gray-900">price</label>
                        <input type="text" id="price" value="<?php echo $price; ?>" class="cursor-not-allowed bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg 
                    focus:ring-blue-500 focus:border-blue-500 block w-full font-fm-inter h-10 p-2.5 text-[15px]" disabled>
                    </div>
                    <!-- price  -->
                    <!-- quantity  -->
                    <div class="w-full sm:w-[49%] h-auto my-5">
                        <label for="quantity" class="block mb-2 capitalize font-fm-inter text-[15px] font-medium text-gray-900">quantity</label>
                        <input type="text" id="quantity" value="<?php echo $quantity; ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg 
                    focus:ring-blue-500 focus:border-blue-500 block w-full font-fm-inter h-10 p-2.5 text-[15px]">
                    </div>
                    <!-- quantity  -->
                    <!-- shipping locations  -->
                    <div class="w-[100%] h-auto flex flex-row flex-wrap my-5">
                        <label for="country" class="block w-full mb-2 text-[15px] font-fm-inter font-medium text-gray-900 capitalize">add shippping locations</label>
                        <select id="country" class="bg-gray-50 border border-gray-300 text-gray-900 text-[14px] font-fm-inter rounded-lg focus:ring-blue-500 focus:border-blue-500 
                block flex-1 p-2.5 capitalize">
                            <option value="0" selected>worldwide</option>
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
                    <!-- shipping  -->
                    <div class="w-full h-auto my-5 flex flex-row flex-wrap justify-between items-end">
                        <div class="w-[49%] h-auto sm:mr-5">
                            <label for="ship-country" class="block mb-2 text-[15px] font-fm-inter font-medium text-gray-900 capitalize">country</label>
                            <select id="ship-country" class="bg-gray-50 border border-gray-300 text-gray-900 text-[14px] font-fm-inter rounded-lg focus:ring-blue-500 focus:border-blue-500 
                block w-full p-2.5">
                                <option value="0">Please select shipping location</option>
                                <option value="general">General</option>
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
                        </div>
                        <div class="flex-1 h-auto">
                            <label for="shipping-cost" class="block mb-2 text-[15px] font-medium text-gray-900 capitalize font-fm-inter">shipping cost</label>
                            <div class="flex">
                                <span class="inline-flex items-center px-2 sm:px-3 text-sm text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md">
                                    <span class="material-symbols-outlined text-gray-500">
                                        attach_money
                                    </span>
                                </span>
                                <input type="text" id="shipping-cost" class="rounded-none bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 
                        block flex-1 min-w-0 w-full text-[14px] border-gray-300 p-2.5 font-fm-inter">
                                <span class="inline-flex items-center px-2 sm:px-3 text-[15px] bg-gray-200 border border-r-0 border-gray-300 rounded-r-md font-fm-inter font-normal text-gray-500">
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
                        <div id="shipping-countries" class="w-full h-auto flex flex-wrap my-1">
                        </div>
                    </div>
                    <!-- shipping  -->
                    <div class="w-full flex flex-col justify-center items-center my-5">
                        <button id="update-item-btn" type="button" class="text-white bg-[var(--main-bg-high)] hover:bg-[var(--main-bg-low)] focus:outline-none focus:ring-0 font-medium 
                rounded-full text-[15px] w-full sm:w-auto sm:px-44 py-3 text-center my-5 font-fm-inter capitalize">save changes</button>
                    </div>
                </div>
            </section>

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
} else {
    ?>
    <script>
        window.location.href = "/urbanpulse_ecommerce_beta/signin/";
    </script>
<?php
}
