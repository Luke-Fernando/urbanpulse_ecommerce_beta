<?php
$admin_data = $_SESSION["admin"];
$admin_id = $admin_data["users_id"];
$admin_contacts_resultset = Database::search("SELECT `from`,`to` FROM `message` WHERE `from`=? OR `to`=?;", [$admin_id, $admin_id]);
$admin_contacts_num = $admin_contacts_resultset->num_rows;
$contacts = array();
?>

<section class="w-full flex justify-between items-start relative 
before:content-[''] before:pointer-events-none before:hidden before:sm:block before:w-full before:lg:w-3/5 before:xl:w-3/4 before:h-[80vh] before:absolute before:top-0 before:right-0 
before:bg-[url('/assets/images/empty-bg.svg')] before:bg-contain before:bg-center before:bg-no-repeat before:-z-10">
    <section id="contacts-window" class="w-full flex sm:flex lg:flex xl:flex sm:w-full lg:w-2/5 xl:w-1/4 h-auto cursor-pointer">
        <!-- contacts -->
        <?php
        for ($i = 0; $i < $admin_contacts_num; $i++) {
            $admin_contacts_data = $admin_contacts_resultset->fetch_assoc();
            if ($admin_contacts_data["from"] != $admin_id && $admin_contacts_data["to"] == $admin_id) {
                $user = $admin_contacts_data["from"];
            } else if ($admin_contacts_data["from"] == $admin_id && $admin_contacts_data["to"] != $admin_id) {
                $user = $admin_contacts_data["to"];
            }
            if (!in_array($user, $contacts)) {
                array_push($contacts, $user);
                // 
                // 
                $user_resultset = Database::search("SELECT * FROM `users` WHERE `id`=?", [$user]);
                $user_data = $user_resultset->fetch_assoc();
                $first_name = $user_data["first_name"];
                $last_name = $user_data["last_name"];
                $profile_picture_resultset = Database::search("SELECT * FROM `profile_picture` WHERE `user_id`=?", [$user_data["id"]]);
                $profile_picture_num = $profile_picture_resultset->num_rows;
                if ($profile_picture_num == 0) {
                    $gender_resultset = Database::search("SELECT * FROM `gender` WHERE `id`=?", [$user_data["gender_id"]]);
                    $gender_data = $gender_resultset->fetch_assoc();
                    $gender = $gender_data["gender"];
                    if ($gender == "male") {
                        $profile_picture = "default-user-male.png";
                    } else if ($gender == "female") {
                        $profile_picture = "default-user-female.png";
                    } else if ($gender == "other") {
                        $profile_picture = "default-user-other.png";
                    }
                } else if ($profile_picture_num == 1) {
                    $profile_picture_data = $profile_picture_resultset->fetch_assoc();
                    $profile_picture = $profile_picture_data["profile_picture"];
                }
                $admin_messages_resultset = Database::search("SELECT * FROM `message` WHERE `from`=? OR `to`=? 
            ORDER BY `datetime_added` DESC;", [$user_data["id"], $user_data["id"]]);
                $admin_messages_data = $admin_messages_resultset->fetch_assoc();
                $last_message = $admin_messages_data["message"];
                $datetime_object = new DateTime($admin_messages_data["datetime_added"]);
                $message_status_resultset = Database::search("SELECT * FROM `message_status` WHERE `message_status`='unread'", []);
                $message_status_data = $message_status_resultset->fetch_assoc();
                $unread_messages_resultset = Database::search("SELECT COUNT(`id`) FROM `message` WHERE `message_status_id`=? AND `from`=?", [$message_status_data["id"], $user_data["id"]]);
                $unread_messages_data = $unread_messages_resultset->fetch_assoc();
        ?>
                <!-- contact  -->
                <div data-contact-user="<?php echo $user_data["id"]; ?>" class="w-full h-20 box-border p-3 border-t border-b transition-all 
                duration-100 ease-in-out hover:bg-gray-200 flex items-center justify-between">
                    <div class="h-4/5 aspect-square rounded-full overflow-hidden flex justify-center items-center">
                        <img src="../assets/images/user/<?php echo $profile_picture; ?>" alt="" class="min-w-full min-h-full object-cover">
                    </div>
                    <div class="flex-1 h-full box-border px-2 flex flex-col justify-between items-start">
                        <div class="w-full h-auto">
                            <p class="font-fm-inter text-sm text-gray-800 font-medium capitalize line-clamp-1"><?php echo $first_name . " " . $last_name; ?></p>
                        </div>
                        <div class="w-full h-auto">
                            <p id="last-message" class="font-fm-inter text-sm text-gray-600 font-normal line-clamp-1"><?php echo $last_message; ?></p>
                        </div>
                    </div>
                    <div class="w-max h-full flex flex-col justify-between items-end">
                        <p class="font-fm-inter text-xs text-[var(--active-bg)]"><?php echo $datetime_object->format('Y') . "/" . $datetime_object->format('m') . "/" . $datetime_object->format('d'); ?></p>
                        <?php
                        if ($unread_messages_data["COUNT(`id`)"] != 0) {
                        ?>
                            <div id="unread-count" class="w-max aspect-square flex justify-center items-center bg-[var(--active-bg)]">
                                <p class="font-fm-inter text-sm font-bold text-[var(--text-white-high)] px-2"><?php echo $unread_messages_data["COUNT(`id`)"]; ?></p>
                            </div>
                        <?php
                        }
                        ?>

                    </div>
                </div>
                <!-- contact  -->
        <?php
                // 
                // 
            }
        }
        ?>
        <!-- contacts -->
    </section>
    <section id="chat-window" class="w-full sm:w-full lg:w-3/5 xl:w-3/4 h-[80vh] border box-border p-4 xl:hidden lg:hidden sm:hidden hidden flex-col bg-white">
        <!-- close btn  -->
        <div class="w-full h-auto flex justify-end items-center pb-4">
            <button id="close-chat" class="w-max aspect-square overflow-hidden flex justify-center items-center transition-all duration-100 ease-in-out hover:bg-gray-200">
                <span class="material-symbols-outlined !text-[var(--main-bg-high)]">
                    close
                </span>
            </button>
        </div>
        <!-- close btn  -->
        <div id="chat" class="w-full h-full flex flex-col justify-start items-center overflow-y-auto">
        </div>
        <div class="w-full h-12 flex justify-center items-center mt-4">
            <div class="w-max sm:w-1/4 h-full flex justify-end items-center">
                <label for="img-input" class="cursor-pointer h-full w-max flex justify-center items-center overflow-hidden bg-[var(--active-bg)] rounded-md mr-1">
                    <span class="material-symbols-outlined !text-gray-50 !text-3xl px-2">
                        add
                    </span>
                    <input class="hidden" type="file" id="img-input" accept="image/*" multiple>
                </label>
            </div>
            <div class="flex-1 sm:flex-none sm:w-2/5 h-full">
                <input type="text" id="message-box" class="w-full h-full bg-[var(--secondary-bg)] text-gray-50 border-0 font-fm-inter text-sm 
                rounded-md focus:ring-transparent focus:border-transparent">
            </div>
            <div class="w-max sm:w-1/4 h-full flex justify-start items-center">
                <button id="send-message" data-message-to="" class="h-full w-max flex justify-center items-center overflow-hidden bg-[var(--active-bg)] rounded-md ml-1">
                    <span class="material-symbols-outlined !text-gray-50 !text-3xl px-2">
                        send
                    </span>
                </button>
            </div>
        </div>
    </section>
    <!-- images  -->
    <div id="image-shower" class="fixed w-screen h-screen top-0 left-0 bg-black/20 z-40 hidden">
        <div class="w-full h-full flex flex-col justify-center items-center">
            <!-- close btn  -->
            <div class="w-[80%] h-auto flex justify-end items-center pb-4">
                <button id="close-image-shower" class="w-max aspect-square bg-gray-400 overflow-hidden flex justify-center items-center transition-all duration-100 ease-in-out hover:bg-gray-200">
                    <span class="material-symbols-outlined !text-[var(--main-bg-high)]">
                        close
                    </span>
                </button>
            </div>
            <!-- close btn  -->
            <!-- <div class="h-1/2 aspect-square mb-10">
                <img class="min-w-full min-h-full object-cover rounded-lg" src="https://flowbite.s3.amazonaws.com/docs/gallery/featured/image.jpg" alt="">
            </div> -->
            <div id="images" class="w-[80%] h-auto flex justify-center flex-wrap">

            </div>
            <div class="w-[80%] sm:w-max h-auto">
                <button id="send-images-btn" type="button" class="text-white bg-[var(--main-bg-high)] hover:bg-[var(--main-bg-low)] focus:outline-none focus:ring-0 font-medium 
                rounded-full text-[15px] w-full sm:w-auto sm:px-44 py-3 text-center my-5 font-fm-inter capitalize">send images</button>
            </div>
        </div>
    </div>
    <!-- images  -->
</section>