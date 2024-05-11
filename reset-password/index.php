<?php

require "../server/connection.php";
require "../head.php";
require "../components/InputElements.php";

if (isset($_GET["id"]) && isset($_GET["token"])) {
    $id = $_GET["id"];
    $token = $_GET["token"];
    $user_resultset = Database::search("SELECT * FROM `users` WHERE `id`=? AND token=?", [$id, $token]);
    $user_num = $user_resultset->num_rows;
    if ($user_num == 1) {
        $user_data = $user_resultset->fetch_assoc();
?>
        <!DOCTYPE html>
        <html lang="en">
        <?php
        $title = "UrbanPulse | Reset Your Password";
        head($title);
        ?>

        <body>
            <div id="loader" class="w-screen h-screen fixed top-0 left-0 overflow-hidden flex justify-center items-center z-50 bg-white">
                <div class="spinner"></div>
            </div>
            <nav class="w-full h-[75px]">
                <div class="container mx-auto h-full flex justify-center items-end">
                    <div class="w-max h-[90%]">
                        <a href="home.php" class="w-max h-full flex justify-center items-center no-underline">
                            <img src="../assets/images/logo-dark.svg" alt="UrbanPulse" class="h-full">
                        </a>
                    </div>
                </div>
            </nav>


            <section class="container px-3 sm:px-0 mx-auto mt-20 max-w-sm p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700">
                <section class="space-y-6" action="#">
                    <h5 class="text-lg font-medium text-gray-900 font-fm-inter capitalize mb-10">reset password</h5>
                    <div class="pb-5">
                        <div class="w-full h-auto flex flex-col justify-center items-start relative">
                            <?php floatingInput("w-full", "h-11", "text-[14px]", "new password", "new-password", "password", ""); ?>
                            <button data-password-toggle="new-password" class="absolute right-0 bottom-0 w-max h-11 flex items-center pr-3 cursor-default select-none border-none">
                                <span data-password-toggle-eye class="material-symbols-outlined !text-xl password-toggle-eye">
                                    visibility
                                </span>
                            </button>
                        </div>
                    </div>
                    <div class="pb-10">
                        <div class="w-full h-auto flex flex-col justify-center items-start relative">
                            <?php floatingInput("w-full", "h-11", "text-[14px]", "confirm password", "confirm-password", "password", ""); ?>
                            <button data-password-toggle="confirm-password" class="absolute right-0 bottom-0 w-max h-11 flex items-center pr-3 cursor-default select-none border-none">
                                <span data-password-toggle-eye class="material-symbols-outlined !text-xl password-toggle-eye">
                                    visibility
                                </span>
                            </button>
                        </div>
                    </div>
                    <button id="reset-password-btn" class="text-[var(--text-white-high)] bg-[var(--main-bg-high)] transition-all duration-200 
                ease-linear hover:bg-[var(--main-bg-low)] 
                    font-medium text-[15px] w-full py-2 capitalize font-fm-inter">reset password</button>
                </section>
            </section>

            <script src="../assets/js/accountAccess.js"></script>
            <!-- <script type="module" src="../assets/js/resetPassword.js"></script> -->
        </body>

        </html>
<?php
    } else {
        echo ("Something went wrong!");
    }
}
