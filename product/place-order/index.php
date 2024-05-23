<?php
session_start();
require "../../server/connection.php";
require "../../navbar.php";
require "../../head.php";
require "../../components/customSelect.php";
require "../../components/InputElements.php";

if (isset($_SESSION["user"])) {
    $user = $_SESSION["user"];
?>
    <!DOCTYPE html>
    <html lang="en">
    <?php
    $title = "UrbanPulse | Place Order";
    head($title);
    ?>

    <body>
        <?php
        navbar($user);
        ?>
        <main id="place-order" class="container mx-auto h-auto px-3 sm:px-0 mt-5 flex justify-between items-start flex-wrap">
            <div class="w-full h-auto mb-10 mt-5 text-left">
                <h1 class="font-fm-inter text-2xl text-gray-800 font-medium">Place Order</h1>
            </div>
            <div class="w-full md:w-[58%] h-auto">
                <?php
                $country_resultset = Database::search("SELECT * FROM `country` WHERE `id`=?;", [$user["country_id"]]);
                $country_data = $country_resultset->fetch_assoc();
                $country = $country_data["country"];
                $country_code_resultset = Database::search("SELECT * FROM `country_code` WHERE `id`=?", [$user["country_code_id"]]);
                $country_code_data = $country_code_resultset->fetch_assoc();
                $country_code = $country_code_data["country_code"];
                ?>
                <div class="w-full h-auto bg-gray-100 px-5 py-5">
                    <p class="text-base text-left font-fm-inter">Deliver to:</p>
                    <p class="text-left text-sm font-fm-inter"><?php echo $user["first_name"]; ?> <?php echo $user["last_name"]; ?>, <?php echo $user["address_line_1"]; ?>, <?php echo $user["address_line_2"]; ?>, <?php echo $user["city"]; ?>, <?php echo $user["zip_code"]; ?>, <?php echo $country; ?>.</p>
                    <p class="text-left text-sm font-fm-inter"><?php echo $country_code; ?> <?php echo $user["mobile"]; ?></p>
                </div>
                <section id="products-container" class="w-full h-auto flex flex-col justify-start items-center mt-5">

                </section>
            </div>
            <div id="products-costs-container" class="w-full md:w-[38%] h-auto">
                <section class="w-full h-auto bg-gray-100 p-4">
                    <div class="flex justify-between items-center h-auto w-full">
                        <p class="font-fm-inter capitalize">items (<span id="items">1</span>)</p>
                        <p class="font-fm-inter capitalize">US $<span id="items-total">0</span></p>
                    </div>
                    <div class="flex justify-between items-center h-auto w-full mt-3">
                        <p class="font-fm-inter capitalize">shipping to <span><?php echo $country; ?></span></p>
                        <p class="font-fm-inter capitalize">US $<span id="shipping-total">0</span></p>
                    </div>
                    <div class="flex justify-between items-center h-auto w-full border border-r-0 border-l-0 border-b-0 pt-3 mt-4">
                        <p class="font-fm-inter capitalize text-xl text-gray-900 font-medium">subtotal</p>
                        <p class="font-fm-inter capitalize text-xl text-gray-900 font-medium">US $<span id="subtotal">0</span></p>
                    </div>
                    <button id="place-order-btn" type="button" class="w-full text-white bg-[var(--main-bg-low)] hover:bg-[var(--main-bg-high)] focus:ring-0 transition-all 
                duration-100 ease-linear font-medium rounded-lg text-lg py-2.5 mt-5 font-fm-inter">Place order</button>
                </section>
            </div>
        </main>
    </body>

    </html>
<?php
} else {
?>
    <script>
        window.location.href = "../home/";
    </script>
<?php
}
