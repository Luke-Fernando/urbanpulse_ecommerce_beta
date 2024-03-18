<?php
session_start();
require "../src/php/connection.php";
require "../head.php";
require "../components/customSelect.php";
require "../components/cusCheck.php";
require "../components/InputElements.php";

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
$title = "UrbanPulse | Sign In to Your Account";
head($title);
?>

<body>

    <div id="loader" class="w-screen h-screen fixed top-0 left-0 overflow-hidden flex justify-center items-center z-50 bg-white">
        <div class="spinner"></div>
    </div>
    <nav class="w-full h-[75px]">
        <div class="container mx-auto h-full flex justify-center items-end">
            <div class="w-max h-[90%]">
                <a href="/urbanpulse_ecommerce_beta/home" class="w-max h-full flex justify-center items-center no-underline">
                    <img src="../assets/images/logo-dark.svg" alt="UrbanPulse" class="h-full">
                </a>
            </div>
        </div>
    </nav>

    <div class="container m-auto mt-8">
        <h1 class="account-access-page-topic text-center font-fm-inter capitalize text-2xl">sign in your account</h1>
    </div>

    <!-- account access  -->
    <div class="container px-3 sm:px-0 mx-auto h-auto flex flex-col-reverse lg:flex-row justify-center items-center mt-24 relative">
        <section class="w-full lg:w-1/2 pt-14 lg:pt-0 h-auto lg:border-r border-solid account-access-border flex justify-center lg:justify-start items-center">
            <div class="w-11/12 h-auto flex justify-between items-end flex-wrap">
                <div class="w-full mt-6 h-auto flex flex-col justify-center items-start">
                    <?php floatingInput("w-full", "h-11", "text-[15px]", "email", "email", "email", checkCookie("email")); ?>
                </div>
                <div class="w-full mt-6 h-auto flex flex-col justify-center items-start relative">
                    <?php floatingInput("w-full", "h-11", "text-[15px]", "password", "password", "password", checkCookie("password")); ?>
                    <button data-password-toggle="password" class="absolute right-0 bottom-0 w-max h-11 flex items-center pr-3 cursor-default select-none border-none">
                        <span data-password-toggle-eye class="material-symbols-outlined !text-xl password-toggle-eye">
                            visibility
                        </span>
                    </button>
                </div>
                <div class="w-[48%] h-8 flex flex-col justify-center items-start mt-12">
                    <?php
                    customCheck("text-[14px]", "rememberme", "remember me", checkCookie("rememberme"));
                    ?>
                </div>
                <div class="w-full sm:w-[48%] h-8 flex flex-col justify-center items-start sm:items-end my-3 sm:my-0 sm:mt-12">
                    <button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal" class="sm:ml-6 text-sm text-gray-900 font-normal 
                    capitalize font-fm-inter underline !text-[var(--active-bg)]">forgoten password</button>
                </div>
                <!-- Main modal -->
                <div id="authentication-modal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden 
                overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative w-full max-w-md max-h-full">
                        <!-- Modal content -->
                        <div class="relative bg-white rounded-lg shadow">
                            <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 
                            rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center" data-modal-hide="authentication-modal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                            <div class="px-6 py-6 lg:px-8">
                                <h3 class="mb-10 text-xl font-medium text-gray-900 font-fm-inter capitalize">reset your password</h3>
                                <div class="space-y-6">
                                    <div>
                                        <?php floatingInput("w-full", "h-11", "text-[14px]", "enter your email", "forgot-email", "email", ""); ?>
                                    </div>
                                    <button id="reset-link-btn" class="text-[var(--text-white-high)] bg-[var(--main-bg-high)] transition-all duration-200 ease-linear hover:bg-[var(--main-bg-low)] 
                    font-medium text-[15px] w-full py-2 capitalize font-fm-inter">send the reset link</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Main modal -->
                <div class="w-full h-8 flex justify-start items-center mt-6">
                    <button id="signin-btn" class="min-w-max text-[var(--text-white-high)] bg-[var(--main-bg-high)] transition-all duration-200 ease-linear hover:bg-[var(--main-bg-low)] 
                    font-medium text-sm px-3 sm:px-8 py-2.5 mr-4 sm:mr-0 capitalize font-fm-inter">sign in</button>
                    <p class="sm:ml-6 text-sm text-gray-900 font-normal capitalize font-fm-inter">
                        new to <span class="">urbanpulse</span>
                        <a href="/urbanpulse_ecommerce_beta/signup/" class="underline text-[var(--active-bg)]">create an account</a>
                    </p>
                </div>
            </div>
        </section>
        <section class="w-[90%] lg:w-1/2 border-b lg:border-none border-solid account-access-border pb-14 lg:pb-0 h-auto flex flex-col items-center justify-center">
            <button type="button" class="w-80 text-white bg-[#3b5998] hover:bg-[#3b5998]/90 focus:ring-4 focus:outline-none focus:ring-[#3b5998]/50 
            capitalize font-normal font-fm-inter rounded-lg text-sm px-5 py-2.5 my-1 text-center inline-flex items-center justify-center mr-2 mb-2">
                <svg class="w-4 h-4 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 8 19">
                    <path fill-rule="evenodd" d="M6.135 3H8V0H6.135a4.147 4.147 0 0 0-4.142 4.142V6H0v3h2v9.938h3V9h2.021l.592-3H5V3.591A.6.6 0 0 1 5.592 3h.543Z" clip-rule="evenodd" />
                </svg>
                Sign in with Facebook
            </button>
            <button type="button" class="w-80 text-white bg-[#4285F4] hover:bg-[#4285F4]/90 focus:ring-4 focus:outline-none focus:ring-[#4285F4]/50 
            capitalize font-normal font-fm-inter rounded-lg text-sm px-5 py-2.5 my-1 text-center inline-flex items-center justify-center mr-2 mb-2">
                <svg class="w-4 h-4 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 19">
                    <path fill-rule="evenodd" d="M8.842 18.083a8.8 8.8 0 0 1-8.65-8.948 8.841 8.841 0 0 1 8.8-8.652h.153a8.464 8.464 0 0 1 5.7 2.257l-2.193 
                    2.038A5.27 5.27 0 0 0 9.09 3.4a5.882 5.882 0 0 0-.2 11.76h.124a5.091 5.091 0 0 0 5.248-4.057L14.3 11H9V8h8.34c.066.543.095 1.09.088 1.636-.086 
                    5.053-3.463 8.449-8.4 8.449l-.186-.002Z" clip-rule="evenodd" />
                </svg>
                Sign in with Google
            </button>
            <button type="button" class="w-80 text-white bg-[#050708] hover:bg-[#050708]/90 focus:ring-4 focus:outline-none focus:ring-[#050708]/50 
            capitalize font-normal font-fm-inter rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center justify-center mr-2 mb-2">
                <svg class="w-5 h-5 mr-2 -ml-1" aria-hidden="true" focusable="false" data-prefix="fab" data-icon="apple" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                    <path fill="currentColor" d="M318.7 268.7c-.2-36.7 16.4-64.4 50-84.8-18.8-26.9-47.2-41.7-84.7-44.6-35.5-2.8-74.3 20.7-88.5 20.7-15 
                    0-49.4-19.7-76.4-19.7C63.3 141.2 4 184.8 4 273.5q0 39.3 14.4 81.2c12.8 36.7 59 126.7 107.2 125.2 25.2-.6 43-17.9 75.8-17.9 31.8 0 48.3 17.9 
                    76.4 17.9 48.6-.7 90.4-82.5 102.6-119.3-65.2-30.7-61.7-90-61.7-91.9zm-56.6-164.2c27.3-32.4 24.8-61.9 24-72.5-24.1 1.4-52 16.4-67.9 34.9-17.5 
                    19.8-27.8 44.3-25.6 71.9 26.1 2 49.9-11.4 69.5-34.3z"></path>
                </svg>
                Sign in with Apple
            </button>
    </div>
    <!-- account access  -->

    <script src="../assets/js/cusSelector.js"></script>
    <script src="../assets/js/accountAccess.js"></script>
    <script src="../assets/js/cusCheck.js"></script>
    <!-- <script type="module" src="../assets/js/connectDatabase.js"></script>
    <script type="module" src="../assets/js/signin.js"></script> -->
    <!-- <script type="module" src="../assets/js_beta/index.js"></script> -->
    <!-- <script type="module" src="../assets/js/resetLink.js"></script> -->
</body>

</html>