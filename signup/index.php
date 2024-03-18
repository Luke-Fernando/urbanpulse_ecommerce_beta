<?php
require "../src/php/connection.php";
require "../head.php";
require "../components/customSelect.php";
require "../components/cusCheck.php";
require "../components/InputElements.php";
?>


<!DOCTYPE html>
<html lang="en">

<?php
$title = "UrbanPulse | Create An Account";
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

    <section id="instructions" class="fixed left-1/2 -translate-x-1/2 top-[75px] z-50 w-full max-w-max h-auto">
        <div id="error-password" class="hidden transition-all duration-100 ease-linear -translate-y-2 p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
            <svg class="flex-shrink-0 inline w-4 h-4 mr-3 mt-[2px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <span class="sr-only">Danger</span>
            <div>
                <span class="font-medium capitalize">password must contain atleast:</span>
                <ul class="mt-1.5 ml-4 list-disc list-inside">
                    <li class="capitalize">8- 15 characters</li>
                    <li class="capitalize">one lowercase letter</li>
                    <li class="capitalize">one uppercase letter</li>
                    <li class="capitalize">one number</li>
                    <li class="capitalize">one special character, e.g., ! @ # ?</li>
                </ul>
            </div>
        </div>
        <div id="error-normal" class="hidden transition-all duration-100 ease-linear -translate-y-2 items-center p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
            <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <span class="sr-only">Info</span>
            <div>
                <span id="alert-content" class="font-medium">Danger alert! Change a few things up and try submitting again.</span>
            </div>
        </div>
        <div id="success-signup" class="hidden transition-all duration-100 ease-linear -translate-y-2 items-center p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
            <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <span class="sr-only">Info</span>
            <div>
                <span id="alert-content" class="font-medium">Successfully signed in! You will redirect to the homepage soon.</span>
            </div>
        </div>
    </section>

    <div class="container m-auto mt-8">
        <h1 class="account-access-page-topic text-center font-fm-inter capitalize text-2xl">create an account</h1>
    </div>

    <!-- account access  -->
    <section class="container mx-auto h-auto flex flex-col-reverse lg:flex-row justify-center items-center mt-12 relative px-3 sm:px-0">
        <section class="w-full lg:w-1/2 pt-14 lg:pt-0 h-auto lg:border-r border-solid account-access-border flex justify-center lg:justify-start items-center">
            <div class="w-11/12 h-auto flex justify-between items-end flex-wrap">
                <div class="w-[48%] h-auto flex flex-col justify-center items-start">
                    <?php floatingInput("w-full", "h-11", "text-[15px]", "first name", "first-name", "text", ""); ?>
                </div>
                <div class="w-[48%] h-auto flex flex-col justify-center items-end">
                    <?php floatingInput("w-full", "h-11", "text-[15px]", "last name", "last-name", "text", ""); ?>
                </div>
                <div class="w-full mt-6 h-auto flex flex-col justify-center items-start">
                    <?php floatingInput("w-full", "h-11", "text-[15px]", "email", "email", "email", ""); ?>
                </div>
                <div class="w-full mt-6 h-auto flex flex-col justify-center items-start relative">
                    <?php floatingInput("w-full", "h-11", "text-[15px]", "password", "password", "password", ""); ?>
                    <button data-password-toggle="password" class="absolute right-0 bottom-0 w-max h-11 flex items-center pr-3 cursor-default select-none border-none">
                        <span data-password-toggle-eye class="material-symbols-outlined !text-xl password-toggle-eye">
                            visibility
                        </span>
                    </button>
                </div>
                <div class="w-full mt-6 h-auto flex flex-col justify-center items-start relative">
                    <?php floatingInput("w-full", "h-11", "text-[15px]", "confirm password", "confirm-password", "password", ""); ?>
                    <button data-password-toggle="confirm-password" class="absolute right-0 bottom-0 w-max h-8 flex items-center pr-3 cursor-default select-none border-none">
                        <span data-password-toggle-eye class="material-symbols-outlined !text-xl password-toggle-eye">
                            visibility
                        </span>
                    </button>
                </div>
                <div class="w-[48%] h-auto flex flex-row items-end justify-between mt-6">

                    <?php
                    $countryOptions = generate_options("SELECT * FROM `country`", [], "select your country", "country", "id");
                    customSelect("w-full", "h-11", "text-[15px]", "country", $countryOptions, true); ?>
                    <?php //floatingInput("w-[75%]", "h-11", "text-[15px]", "mobile number", "mobile", "text", ""); 
                    ?>


                </div>
                <div class="w-[48%] h-auto flex flex-col justify-center items-start mt-6">
                    <?php
                    // $genderOptions = [
                    //     ["name" => "select your gender", "value" => "0"],
                    //     ["name" => "male", "value" => "1"],
                    //     ["name" => "female", "value" => "2"],
                    //     ["name" => "other", "value" => "3"],
                    // ];
                    $genderOptions = generate_options("SELECT * FROM `gender`", [], "select your gender", "gender", "id");
                    customSelect("w-full", "h-11", "text-[15px]", "gender", $genderOptions, true); ?>
                    <!-- <input id="first-name" type="text" class="w-full h-8 account-access-input pl-3 text-[15px] font-normal text-gray-900 font-fm-inter"> -->
                </div>
                <div class="w-full h-8 flex flex-col justify-center items-start mt-12">
                    <?php
                    customCheck("text-sm", "agreement", "I agree to UrbanPulse's Conditions of Use and Privacy Notice.", "0");
                    ?>
                </div>
                <div class="w-full h-8 flex justify-start items-center mt-8 sm:mt-6">
                    <button id="signup-btn" class="min-w-max text-[var(--text-white-high)] bg-[var(--main-bg-high)] transition-all duration-200 ease-linear hover:bg-[var(--main-bg-low)] 
                    font-medium text-sm px-3 sm:px-8 py-2.5 mr-4 sm:mr-0 capitalize font-fm-inter">sign up</button>
                    <p class="sm:ml-6 text-sm text-gray-900 font-normal capitalize font-fm-inter">already have an account
                        <a href="../signin" class="underline text-[var(--active-bg)]">sign in</a>
                    </p>
                </div>
            </div>
        </section>
        <section class="w-[90%] lg:w-1/2 border-b lg:border-none border-solid account-access-border pb-14 lg:pb-0 h-auto flex flex-col items-center justify-center">
            <button type="button" class="w-80 text-white bg-[#3b5998] hover:bg-[#3b5998]/90 focus:ring-4 focus:outline-none focus:ring-[#3b5998]/50 
            capitalize font-normal font-fm-inter rounded-lg text-sm px-5 py-2.5 my-1 text-center inline-flex items-center justify-center dark:focus:ring-[#3b5998]/55 mr-2 mb-2">
                <svg class="w-4 h-4 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 8 19">
                    <path fill-rule="evenodd" d="M6.135 3H8V0H6.135a4.147 4.147 0 0 0-4.142 4.142V6H0v3h2v9.938h3V9h2.021l.592-3H5V3.591A.6.6 0 0 1 5.592 3h.543Z" clip-rule="evenodd" />
                </svg>
                Continue with Facebook
            </button>
            <button type="button" class="w-80 text-white bg-[#4285F4] hover:bg-[#4285F4]/90 focus:ring-4 focus:outline-none focus:ring-[#4285F4]/50 
            capitalize font-normal font-fm-inter rounded-lg text-sm px-5 py-2.5 my-1 text-center inline-flex items-center justify-center dark:focus:ring-[#4285F4]/55 mr-2 mb-2">
                <svg class="w-4 h-4 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 19">
                    <path fill-rule="evenodd" d="M8.842 18.083a8.8 8.8 0 0 1-8.65-8.948 8.841 8.841 0 0 1 8.8-8.652h.153a8.464 8.464 0 0 1 5.7 2.257l-2.193 
                    2.038A5.27 5.27 0 0 0 9.09 3.4a5.882 5.882 0 0 0-.2 11.76h.124a5.091 5.091 0 0 0 5.248-4.057L14.3 11H9V8h8.34c.066.543.095 1.09.088 1.636-.086 
                    5.053-3.463 8.449-8.4 8.449l-.186-.002Z" clip-rule="evenodd" />
                </svg>
                Continue with Google
            </button>
            <button type="button" class="w-80 text-white bg-[#050708] hover:bg-[#050708]/90 focus:ring-4 focus:outline-none focus:ring-[#050708]/50 
            capitalize font-normal font-fm-inter rounded-lg text-sm px-5 py-2.5 my-1 text-center inline-flex items-center justify-center dark:focus:ring-[#050708]/50 
            dark:hover:bg-[#050708]/30 mr-2 mb-2">
                <svg class="w-5 h-5 mr-2 -ml-1" aria-hidden="true" focusable="false" data-prefix="fab" data-icon="apple" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                    <path fill="currentColor" d="M318.7 268.7c-.2-36.7 16.4-64.4 50-84.8-18.8-26.9-47.2-41.7-84.7-44.6-35.5-2.8-74.3 20.7-88.5 
                    20.7-15 0-49.4-19.7-76.4-19.7C63.3 141.2 4 184.8 4 273.5q0 39.3 14.4 81.2c12.8 36.7 59 126.7 107.2 125.2 25.2-.6 43-17.9 75.8-17.9 31.8 0 48.3 17.9 76.4 17.9 
                    48.6-.7 90.4-82.5 102.6-119.3-65.2-30.7-61.7-90-61.7-91.9zm-56.6-164.2c27.3-32.4 24.8-61.9 24-72.5-24.1 1.4-52 16.4-67.9 34.9-17.5 19.8-27.8 44.3-25.6 71.9 
                    26.1 2 49.9-11.4 69.5-34.3z"></path>
                </svg>
                Continue with Apple
            </button>
        </section>
    </section>
    <!-- account access  -->


    <script src="../assets/js/cusSelector.js"></script>
    <script src="../assets/js/accountAccess.js"></script>
    <script src="../assets/js/cusCheck.js"></script>
    <!-- <script type="module" src="../assets/js/signup.js"></script> -->
    <!-- <script type="module" src="../assets/js/connectDatabase.js"></script> -->
    <!-- <script type="module" src="../assets/js_beta/index.js"></script> -->
</body>

</html>