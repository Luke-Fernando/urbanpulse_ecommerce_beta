<!-- users  -->
<div class="relative overflow-x-auto shadow-md sm:rounded-lg w-full">
    <div class="flex items-center justify-between flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-4 bg-white dark:bg-gray-900">
        <label for="table-search" class="sr-only">Search</label>
        <div class="relative">
            <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                </svg>
            </div>
            <input value="<?php echo $search_text; ?>" type="text" id="table-search-users" class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-[var(--active-bg)] focus:border-[var(--active-bg)]" placeholder="Search for users">
        </div>
    </div>
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Name
                </th>
                <th scope="col" class="px-6 py-3">
                    Joined
                </th>
                <th scope="col" class="px-6 py-3">
                    Status
                </th>
                <th scope="col" class="px-6 py-3">
                    Action
                </th>
            </tr>
        </thead>
        <tbody id="users">
            <?php
            $users_resultset = Database::search("SELECT * FROM `users` WHERE (`first_name` LIKE ? OR `last_name` LIKE ?) LIMIT ? OFFSET ?", [$search, $search, $users_per_page, $offset]);
            $users_num = $users_resultset->num_rows;
            for ($i = 0; $i < $users_num; $i++) {
                $user_data = $users_resultset->fetch_assoc();
                $user_name = $user_data["first_name"] . " " . $user_data["last_name"];
                $user_email = $user_data["email"];
                $user_img_resultset = Database::search("SELECT * FROM `profile_picture` WHERE `user_id`=?", [$user_data["id"]]);
                $user_img_num = $user_img_resultset->num_rows;
                $gender_resultset = Database::search("SELECT * FROM `gender` WHERE `id`=?", [$user_data["gender_id"]]);
                $gender_data = $gender_resultset->fetch_assoc();
                $gender = $gender_data["gender"];
                if ($user_img_num == 1) {
                    $user_img_data = $user_img_resultset->fetch_assoc();
                    $user_img = $user_img_data["profile_picture"];
                } else if ($user_img_num == 0) {
                    if ($gender == "male") {
                        $user_img = "default-user-male.png";
                    } else if ($gender == "female") {
                        $user_img = "default-user-female.png";
                    } else if ($gender == "other") {
                        $user_img = "default-user-other.png";
                    }
                }
                $datetime_joined = $user_data["datetime_joined"];
                $datetime_object = new DateTime($datetime_joined);
                $user_status_resultset = Database::search("SELECT * FROM `status` WHERE `id`=?", [$user_data["status_id"]]);
                $user_status_data = $user_status_resultset->fetch_assoc();
                $user_status = $user_status_data["status"];
            ?>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                        <img class="w-10 h-10 rounded-full" src="../assets/images/user/<?php echo $user_img; ?>" alt="Jese image">
                        <div class="ps-3">
                            <div class="text-base font-semibold"><?php echo $user_name; ?></div>
                            <div class="font-normal text-gray-500"><?php echo $user_email; ?></div>
                        </div>
                    </th>
                    <td class="px-6 py-4">
                        <?php echo $datetime_object->format('Y'); ?> <?php echo $datetime_object->format('M'); ?> <?php echo $datetime_object->format('d'); ?>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="h-2.5 w-2.5 rounded-full <?php
                                                                    if ($user_status == "Active") {
                                                                    ?>bg-green-500<?php
                                                                                } else if ($user_status == "Inactive") {
                                                                                    ?>bg-red-500<?php
                                                                                            } else if ($user_status == "Suspended") {
                                                                                                ?>bg-gray-300<?php
                                                                                                            }
                                                                                                                ?> me-2"></div> <?php echo $user_status; ?>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input data-user-toggle="<?php echo $user_data["id"]; ?>" type="checkbox" value="" class="sr-only peer" <?php
                                                                                                                                    if ($user_status != "Suspended") {
                                                                                                                                    ?>checked<?php
                                                                                                                                            }
                                                                                                                                                ?>>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-0 rounded-full peer 
                                                peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] 
                                                after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 
                                                after:h-5 after:transition-all peer-checked:bg-[var(--active-bg)]"></div>
                        </label>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>
<!-- users  -->
<section id="pagination-users" data-users-per-page="<?php echo $users_per_page; ?>" class="w-full flex justify-center items-center mt-10">
    <nav aria-label="Page navigation example">
        <ul class="flex items-center -space-x-px h-10 text-base">
            <?php
            $all_users_count_resultset = Database::search("SELECT COUNT(`id`) FROM `users`", []);
            $all_users_count_data = $all_users_count_resultset->fetch_assoc();
            $all_users_count = $all_users_count_data["COUNT(`id`)"];
            $number_of_pages = ceil($all_users_count / $users_per_page);
            ?>
            <?php
            if ($current_page == 1) {
            ?>
                <li class="cursor-not-allowed ">
                    <a href="" class="pointer-events-none flex items-center justify-center px-4 h-10 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        <span class="sr-only">Previous</span>
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4" />
                        </svg>
                    </a>
                </li>
            <?php
            } else {
            ?>
                <li>
                    <a href="<?php echo $static_link . "" . ($current_page - 1); ?>" class="flex items-center justify-center px-4 h-10 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        <span class="sr-only">Previous</span>
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4" />
                        </svg>
                    </a>
                </li>
            <?php
            }
            ?>

            <?php
            for ($i = 0; $i < $number_of_pages; $i++) {
                if ($current_page == $i + 1) {
            ?>
                    <li>
                        <a href="<?php echo $static_link . "" . ($i + 1); ?>" aria-current="page" class="z-10 pointer-events-none flex items-center justify-center px-4 h-10 leading-tight text-gray-50 border border-[var(--main-bg-low)] bg-[var(--main-bg-high)] hover:bg-[var(--main-bg-low)] hover:text-gray-200"><?php echo ($i + 1); ?></a>
                    </li>
                <?php
                } else {
                ?>
                    <li>
                        <a href="<?php echo $static_link . "" . ($i + 1); ?>" class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700"><?php echo ($i + 1); ?></a>
                    </li>
            <?php
                }
            }
            ?>
            <?php
            if ($current_page == $number_of_pages) {
            ?>
                <li class="cursor-not-allowed">
                    <a href="" class="pointer-events-none flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100 hover:text-gray-700">
                        <span class="sr-only">Next</span>
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                        </svg>
                    </a>
                </li>
            <?php
            } else if ($current_page < $number_of_pages) {
            ?>
                <li>
                    <a href="<?php echo $static_link . "" . ($current_page + 1); ?>" class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100 hover:text-gray-700">
                        <span class="sr-only">Next</span>
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                        </svg>
                    </a>
                </li>
            <?php
            }
            ?>
        </ul>
    </nav>
</section>