<?php
session_start();
require "../src/php/connection.php";
require "../head.php";
require "../navbar.php";
require "../components/customSelect.php";
if (isset($_SESSION["user"])) {
    $user = $_SESSION["user"];
?>
    <!DOCTYPE html>
    <html lang="en">
    <?php
    $title = "UrbanPulse | Dashboard";
    head($title);
    ?>

    <body>
        <div id="loader" class="w-screen h-screen fixed top-0 left-0 overflow-hidden flex justify-center items-center z-50 bg-white">
            <div class="spinner"></div>
        </div>
        <?php navbar($user);
        ?>

        <?php
        if (isset($_GET["location"])) {
            $location = $_GET["location"];
            if ($location == "products") {
                $active = "products";
            } else if ($location == "messages") {
                $active = "messages";
            } else if ($location == "reviews") {
                $active = "reviews";
            }
        } else {
            $active = "products";
        }
        ?>
        <section class="container mx-auto px-3 sm:px-0">
            <ul class="flex flex-wrap text-sm font-medium text-center text-gray-500 border-b border-gray-200">
                <li class="mr-2">
                    <a href="?location=products" <?php
                                                    if ($active == "products") {
                                                    ?>aria-current="page" <?php
                                                                        } ?> class="inline-block p-4 rounded-t-lg font-fm-inter capitalize text-sm<?php
                                                                                                                                                    if ($active == "products") {
                                                                                                                                                        echo (" text-blue-600 bg-gray-100 active");
                                                                                                                                                    } else {
                                                                                                                                                        echo (" hover:text-gray-600 hover:bg-gray-50");
                                                                                                                                                    }
                                                                                                                                                    ?>">my products</a>
                </li>
                <li class="mr-2">
                    <a href="?location=messages" <?php
                                                    if ($active == "messages") {
                                                    ?>aria-current="page" <?php
                                                                        } ?> class="inline-block p-4 rounded-t-lg font-fm-inter capitalize text-sm<?php
                                                                                                                                                    if ($active == "messages") {
                                                                                                                                                        echo (" text-blue-600 bg-gray-100 active");
                                                                                                                                                    } else {
                                                                                                                                                        echo (" hover:text-gray-600 hover:bg-gray-50");
                                                                                                                                                    }
                                                                                                                                                    ?>">messages</a>
                </li>
                <li class="mr-2">
                    <a href="?location=reviews" <?php
                                                if ($active == "reviews") {
                                                ?>aria-current="page" <?php
                                                                    } ?> class="inline-block p-4 rounded-t-lg font-fm-inter capitalize text-sm<?php
                                                                                                                                                if ($active == "reviews") {
                                                                                                                                                    echo (" text-blue-600 bg-gray-100 active");
                                                                                                                                                } else {
                                                                                                                                                    echo (" hover:text-gray-600 hover:bg-gray-50");
                                                                                                                                                }
                                                                                                                                                ?>">reviews</a>
                </li>
            </ul>
        </section>

        <?php
        if (isset($_GET["location"])) {
            $location = $_GET["location"];
            if ($location == "products") {
                require "../my-products/index.php";
            } else if ($location == "messages") {
                require "../messages/index.php";
            } else if ($location == "reviews") {
                require "../reviews/index.php";
            }
        } else {
            require "../my-products/index.php";
        }
        ?>

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