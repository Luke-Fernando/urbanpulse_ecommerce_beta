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
    $title = "UrbanPulse | Profile";
    head($title);
    ?>

    <body>
        <div id="loader" class="w-screen h-screen fixed top-0 left-0 overflow-hidden flex justify-center items-center z-50 bg-white">
            <div class="spinner"></div>
        </div>
        <?php
        navbar($user);
        ?>

        <!-- alerts -->
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
            <div id="error-password" class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 transition-opacity duration-300 ease-out opacity-0 hidden" role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 mr-3 mt-[2px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>
                <span class="sr-only">Danger</span>
                <div>
                    <span class="font-medium font-fm-inter capitalize">new password must contain atleast:</span>
                    <ul class="mt-1.5 ml-4 list-disc list-inside">
                        <li class="capitalize">8- 15 characters</li>
                        <li class="capitalize">one lowercase letter</li>
                        <li class="capitalize">one uppercase letter</li>
                        <li class="capitalize">one number</li>
                        <li class="capitalize">one special character, e.g., ! @ # ?</li>
                    </ul>
                </div>
                <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 
            hover:bg-red-200 inline-flex items-center justify-center h-8 w-8" data-dismiss-target="#error-password" aria-label="Close">
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
        <!-- alerts -->

        <section class="container px-3 sm:px-0 mx-auto mt-5 h-auto flex flex-col justify-start items-center md:flex-row md:justify-between md:items-start">
            <div class="w-full md:w-2/5 h-auto">
                <div class="w-full min-h-max h-full bg-white rounded-lg">
                    <div class="flex flex-col items-center pb-10 mt-5">
                        <div class="profile-image w-48 aspect-square rounded-lg flex justify-center items-center overflow-hidden relative">
                            <?php
                            $profile_picture_resultset = Database::search("SELECT * FROM `profile_picture` WHERE `user_id`=?", [$user["id"]]);
                            $profile_picture_data = $profile_picture_resultset->fetch_assoc();
                            $profile_picture_num = $profile_picture_resultset->num_rows;
                            ?>
                            <img id="profile-picture" class="shadow-lg min-h-full min-w-full object-cover" src="../assets/images/user/<?php
                                                                                                                                        if ($profile_picture_num == 0) {
                                                                                                                                            if ($user["gender_id"] == 1) {
                                                                                                                                                echo ("default-user-male.png");
                                                                                                                                            } else if ($user["gender_id"] == 2) {
                                                                                                                                                echo ("default-user-female.png");
                                                                                                                                            } else if ($user["gender_id"] == 3) {
                                                                                                                                                echo ("default-user-other.png");
                                                                                                                                            }
                                                                                                                                        } else if ($profile_picture_num == 1) {
                                                                                                                                            echo $profile_picture_data["profile_picture"];
                                                                                                                                        } else {
                                                                                                                                            if ($user["gender_id"] == 1) {
                                                                                                                                                echo ("default-user-male.png");
                                                                                                                                            } else if ($user["gender_id"] == 2) {
                                                                                                                                                echo ("default-user-female.png");
                                                                                                                                            } else if ($user["gender_id"] == 3) {
                                                                                                                                                echo ("default-user-other.png");
                                                                                                                                            }
                                                                                                                                        }
                                                                                                                                        ?>" alt="Bonnie image" />
                            <label for="update-image" class="flex justify-center items-center update-image w-full h-full absolute z-10 top-0 left-0 bg-black/30 opacity-0  text-[var(--text-white-high)] transition-all duration-100 ease-linear">
                                <span class="material-symbols-outlined !text-3xl">
                                    edit
                                </span>
                            </label>
                            <input type="file" accept="image/*" id="update-image" class="hidden">
                        </div>
                        <h5 class="mb-1 mt-2 text-xl font-medium text-gray-900"><?php echo $user["first_name"] . " " . $user["last_name"]; ?></h5>
                        <span class="text-sm text-gray-500"><?php echo $user["email"]; ?></span>
                    </div>
                </div>
            </div>
            <div class="w-full md:w-1/2 flex flex-wrap justify-between items-start">
                <div class="w-[48%] my-4">
                    <label for="first-name" class="block mb-2 text-sm font-medium text-gray-900 font-fm-inter capitalize">first name</label>
                    <input type="text" value="<?php echo $user["first_name"]; ?>" id="first-name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg 
                    focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 font-fm-inter" placeholder="John">
                </div>
                <div class="w-[48%] my-4">
                    <label for="last-name" class="block mb-2 text-sm font-medium text-gray-900 font-fm-inter capitalize">last name</label>
                    <input type="text" value="<?php echo $user["last_name"]; ?>" id="last-name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg 
                    focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 font-fm-inter" placeholder="Doe">
                </div>
                <div class="w-full sm:w-[48%] my-4">
                    <label for="address-line-1" class="block mb-2 text-sm font-medium text-gray-900 font-fm-inter capitalize">address line 01</label>
                    <input type="text" value="<?php echo $user["address_line_1"]; ?>" id="address-line-1" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg 
                    focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 font-fm-inter" placeholder="No.162">
                </div>
                <div class="w-full sm:w-[48%] my-4">
                    <label for="address-line-2" class="block mb-2 text-sm font-medium text-gray-900 font-fm-inter capitalize">address line 02</label>
                    <input type="text" value="<?php echo $user["address_line_2"]; ?>" id="address-line-2" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg 
                    focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 font-fm-inter" placeholder="Example road">
                </div>
                <div class="w-full sm:w-[48%] my-4">
                    <label for="city" class="block mb-2 text-sm font-medium text-gray-900 font-fm-inter capitalize">city</label>
                    <input type="text" value="<?php echo $user["city"]; ?>" id="city" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg 
                    focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 font-fm-inter" placeholder="City">
                </div>
                <div class="w-full sm:w-[48%] my-4">
                    <label for="zip-code" class="block mb-2 text-sm font-medium text-gray-900 font-fm-inter capitalize">zip code</label>
                    <input type="text" value="<?php echo $user["zip_code"]; ?>" id="zip-code" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg 
                    focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 font-fm-inter" placeholder="11111">
                </div>
                <?php
                $country_resultset = Database::search("SELECT * FROM `country`", []);
                $country_num = $country_resultset->num_rows;
                ?>
                <div class="w-full my-4">
                    <label for="country" class="block w-full mb-2 text-sm font-medium text-gray-900 font-fm-inter truncate capitalize">select your country</label>
                    <select id="country" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 
                    focus:border-blue-500 block w-full p-2.5 font-fm-inter capitalize">
                        <option class="font-fm-inter capitalize truncate" value="0">select your country</option>
                        <?php
                        for ($i = 0; $i < $country_num; $i++) {
                            $country_data = $country_resultset->fetch_assoc();
                            $country_id = $country_data["id"];
                            $country = $country_data["country"];
                            if ($country_id == $user["country_id"]) {
                        ?>
                                <option class="font-fm-inter capitalize truncate" value="<?php echo $country_id; ?>" selected><?php echo $country; ?></option>
                            <?php
                            } else {
                            ?>
                                <option class="font-fm-inter capitalize truncate" value="<?php echo $country_id; ?>"><?php echo $country; ?></option>
                        <?php
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="w-1/4 my-4">
                    <label for="country-code" class="block w-full mb-2 text-sm font-medium text-gray-900 font-fm-inter truncate capitalize">country code</label>
                    <select id="country-code" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 
                    focus:border-blue-500 block w-full p-2.5 font-fm-inter capitalize">
                        <option class="font-fm-inter capitalize truncate" value="0">select your country code</option>
                        <?php
                        $country_code_resultset = Database::search("SELECT * FROM `country_code`", []);
                        $country_code_num = $country_code_resultset->num_rows;
                        for ($i = 0; $i < $country_code_num; $i++) {
                            $country_code_data = $country_code_resultset->fetch_assoc();
                        ?>
                            <option class="font-fm-inter capitalize" value="<?php echo $country_code_data["id"]; ?>" <?php
                                                                                                                        if ($user["country_code_id"] == $country_code_data["id"]) {
                                                                                                                        ?>selected<?php
                                                                                                                                }
                                                                                                                                    ?>><?php echo $country_code_data["country_code"]; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="w-[71%] my-4">
                    <label for="mobile-number" class="block mb-2 text-sm font-medium text-gray-900 font-fm-inter capitalize">mobile number</label>
                    <input type="text" value="<?php echo $user["mobile"]; ?>" id="mobile-number" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg 
                    focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 font-fm-inter" placeholder="111111111">
                </div>
                <div class="w-full my-4 relative">
                    <label for="old-password" class="block mb-2 text-sm font-medium text-gray-900 font-fm-inter capitalize">old password</label>
                    <input type="password" id="old-password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg 
                    focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 font-fm-inter">
                    <button data-password-toggle="old-password" class="absolute right-0 bottom-0 w-max h-10 overflow-hidden flex items-center pr-3 cursor-default select-none border-none">
                        <span data-password-toggle-eye class="material-symbols-outlined !text-xl password-toggle-eye">
                            visibility
                        </span>
                    </button>
                </div>
                <div class="w-full my-4 relative">
                    <label for="new-password" class="block mb-2 text-sm font-medium text-gray-900 font-fm-inter capitalize">new password</label>
                    <input type="password" id="new-password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg 
                    focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 font-fm-inter">
                    <button data-password-toggle="new-password" class="absolute right-0 bottom-0 w-max h-10 overflow-hidden flex items-center pr-3 cursor-default select-none border-none">
                        <span data-password-toggle-eye class="material-symbols-outlined !text-xl password-toggle-eye">
                            visibility
                        </span>
                    </button>
                </div>
                <div class="w-full my-4 relative">
                    <label for="retype-new-password" class="block mb-2 text-sm font-medium text-gray-900 font-fm-inter capitalize">retype new password</label>
                    <input type="password" id="retype-new-password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg 
                    focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 font-fm-inter">
                    <button data-password-toggle="retype-new-password" class="absolute right-0 bottom-0 w-max h-10 overflow-hidden flex items-center pr-3 cursor-default select-none border-none">
                        <span data-password-toggle-eye class="material-symbols-outlined !text-xl password-toggle-eye">
                            visibility
                        </span>
                    </button>
                </div>
                <div class="w-full my-8">
                    <button id="save-changes-btn" class="text-[var(--text-white-high)] bg-[var(--main-bg-high)] transition-all duration-200 
                ease-linear hover:bg-[var(--main-bg-low)] 
                    font-medium text-[15px] w-full py-2 capitalize font-fm-inter">save changes</button>
                </div>
            </div>
        </section>

        <script src="../assets/js/accountAccess.js"></script>
        <script type="module" src="../assets/js/updateProfile.js"></script>
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
?>