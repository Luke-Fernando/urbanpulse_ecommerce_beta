<?php
session_start();
require "../server/connection.php";
require "../head.php";
require "../navbar.php";
require "../components/customSelect.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (isset($_SESSION["user"])) {
    if (isset($_GET["invoice_id"])) {
        $user = $_SESSION["user"];
        $invoice_id = $_GET["invoice_id"];
        $invoice_resultset = Database::search("SELECT * FROM `invoice` WHERE `id`=?", [$invoice_id]);
        $invoice_data = $invoice_resultset->fetch_assoc();
        $product_id = $invoice_data["product_id"];
?>
        <!DOCTYPE html>
        <html lang="en">
        <?php
        $title = "UrbanPulse | Add a Review";
        head($title);
        ?>

        <body>
            <?php navbar($user);
            ?>


            <?php
            $review_resultset = Database::search("SELECT * FROM `review` WHERE `invoice_id`=?;", [$invoice_id]);
            $review_num = $review_resultset->num_rows;
            if ($review_num == 0) {
                require "./add-review/index.php";
            } else if ($review_num == 1) {
                require "./update-review/index.php";
            }
            ?>
        </body>

        </html>
    <?php
    } else {
    ?>
        <script>
            window.location.href = "/urbanpulse_ecommerce_beta/orders/";
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
