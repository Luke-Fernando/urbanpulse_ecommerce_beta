<?php
session_start();
require "../../src/php/connection.php";
require "../../head.php";
require "../../components/customSelect.php";
require "../../components/cusCheck.php";
require "../../components/InputElements.php";

function checkCookie($cookie_name)
{
    if (isset($_COOKIE["$cookie_name"])) {
        return $_COOKIE["$cookie_name"];
    } else {
        return "";
    }
}
// if (isset($_COOKIE["email"]) && isset($_COOKIE["password"]) && isset($_COOKIE["rememberme"])) {
//     $email = isset($_COOKIE["email"]);
//     $password = isset($_COOKIE["password"]);
//     $rememberme_state = isset($_COOKIE["rememberme"]);
// }
?>


<!DOCTYPE html>
<html lang="en">

<?php
$title = "UrbanPulse | Sign In to Your Admin Account";
head($title);
?>

<body>
    <div id="loader" class="w-screen h-screen fixed top-0 left-0 overflow-hidden flex justify-center items-center z-50 bg-white">
        <div class="spinner"></div>
    </div>
    <nav class="w-full h-[75px]">
        <div class="container mx-auto h-full flex justify-center items-end">
            <div class="w-max h-[90%]">
                <a href="/urbanpulse_ecommerce_beta/admin/" class="w-max h-full flex justify-center items-center no-underline">
                    <img src="../../assets/images/logo-dark.svg" alt="UrbanPulse" class="h-full">
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

    <div class="container m-auto mt-8">
        <h1 class="account-access-page-topic text-center font-fm-inter capitalize text-2xl">sign in to your admin account</h1>
    </div>

    <!-- account access  -->
    <div class="container px-3 sm:px-0 mx-auto h-auto flex flex-col-reverse lg:flex-row justify-center items-center mt-24 relative">
        <section class="w-full lg:w-1/2 pt-14 lg:pt-0 h-auto flex justify-center lg:justify-start items-center">
            <div class="w-11/12 h-auto flex justify-between items-end flex-wrap">
                <div class="w-full mt-6 h-auto flex justify-between items-end">
                    <?php floatingInput("flex-1", "h-11", "text-[15px]", "email", "email", "email", ""); ?>
                    <button id="send-token-btn" type="button" class="h-9 aspect-square ms-3 flex justify-center items-center text-[var(--text-white-high)] bg-[var(--main-bg-high)] transition-all duration-200 ease-linear hover:bg-[var(--main-bg-low)] focus:outline-none font-medium rounded-lg text-sm">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                        </svg>
                        <span class="sr-only">Send Token</span>
                    </button>
                </div>
                <div class="w-full mt-6 h-auto flex flex-col justify-center items-start relative">
                    <?php floatingInput("w-full", "h-11", "text-[15px]", "token", "token", "text", ""); ?>
                </div>
                <div class="w-full h-8 flex justify-start items-center mt-10">
                    <button id="admin-signin-btn" class="min-w-max text-[var(--text-white-high)] bg-[var(--main-bg-high)] transition-all duration-200 ease-linear hover:bg-[var(--main-bg-low)] 
                    font-medium text-sm px-3 sm:px-8 py-2.5 mr-4 sm:mr-0 capitalize font-fm-inter">sign in</button>
                </div>
            </div>
        </section>
    </div>
    <!-- account access  -->

    <script src="../../assets/js/cusSelector.js"></script>
    <script src="../../assets/js/accountAccess.js"></script>
    <script src="../../assets/js/cusCheck.js"></script>
    <script type="module" src="../../assets/js/connectDatabase.js"></script>
    <script type="module" src="../../assets/js/sendAdminToken.js"></script>
    <script type="module" src="../../assets/js/adminSignin.js"></script>
</body>

</html>