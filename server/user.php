<?php
session_start();
require "./connection.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "./phpmailer/src/Exception.php";
require "./phpmailer/src/PHPMailer.php";
require "./phpmailer/src/SMTP.php";

require_once '../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable("../");
$dotenv->load();

class User
{
    public function __construct()
    {
    }

    private function get_current_datetime()
    {
        date_default_timezone_set('Asia/Colombo');
        $current_datetime = date('Y-m-d H:i:s');
        return $current_datetime;
    }

    private function manage_cookie($cookie_name, $cookie_value, $expire_time)
    {
        setcookie($cookie_name, $cookie_value, [
            'expires' => $expire_time,
            'path' => '/',
            'samesite' => 'Lax',
        ]);
    }

    private function check_session()
    {
        if (isset($_SESSION["user"])) {
            return true;
        } else if (!isset($_SESSION["user"])) {
            return false;
        }
    }

    private function validate_password($password)
    {
        $password_pattern = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@#$%^&+=!]).{8,15}$/';
        if (preg_match($password_pattern, $password)) {
            return true;
        } else {
            return false;
        }
    }

    public function signup()
    {
        if (isset($_POST["first_name"])) {
            if (isset($_POST["last_name"])) {
                if (isset($_POST["email"])) {
                    if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
                        $users_resultset_by_email = Database::search("SELECT * FROM `users` WHERE `email`=?", [$_POST["email"]]);
                        $users_resultset_num_by_email = $users_resultset_by_email->num_rows;
                        if ($users_resultset_num_by_email == 0) {
                            if (isset($_POST["password"])) {
                                if (isset($_POST["confirm_password"])) {
                                    if ($this->validate_password($_POST["password"])) {
                                        if ($_POST["password"] == $_POST["confirm_password"]) {
                                            if (isset($_POST["country"])) {
                                                if ($_POST["country"] != 0) {
                                                    if (isset($_POST["gender"])) {
                                                        if (isset($_POST["agreement_state"])) {
                                                            if ($_POST["agreement_state"] == 1) {
                                                                $first_name = $_POST["first_name"];
                                                                $last_name = $_POST["last_name"];
                                                                $email = $_POST["email"];
                                                                $password = $_POST["password"];
                                                                $country = $_POST["country"];
                                                                $gender = $_POST["gender"];
                                                                $datetime_joined = $this->get_current_datetime();
                                                                $user_status_resultset = Database::search("SELECT * FROM `status` WHERE `status`=?", ["active"]);
                                                                $user_status_data = $user_status_resultset->fetch_assoc();
                                                                $status_id = $user_status_data["id"];
                                                                Database::iud("INSERT INTO `users`(`first_name`,`last_name`,`email`,`password`,`country_id`,`gender_id`,`datetime_joined`,`status_id`) 
                                                    VALUES(?,?,?,?,?,?,?,?)", [$first_name, $last_name, $email, $password, $country, $gender, $datetime_joined, $status_id]);
                                                                $user_resultset = Database::search("SELECT * FROM `users` WHERE `email`=? AND `password`=?", [$email, $password]);
                                                                $user_data = $user_resultset->fetch_assoc();
                                                                $this->signout();
                                                                $_SESSION["user"] = $user_data;
                                                                echo ("success");
                                                            } else {
                                                                echo ("you must agree with our terms and conditions");
                                                            }
                                                        } else {
                                                            echo ("you must agree with our terms and conditions");
                                                        }
                                                    } else {
                                                        echo ("please select your gender");
                                                    }
                                                } else {
                                                    echo ("please select your country");
                                                }
                                            } else {
                                                echo ("please select your country");
                                            }
                                        } else {
                                            echo ("passwords doesn't match");
                                        }
                                    } else {
                                        echo ("password must be at least 8 characters long and must contain at least one uppercase letter, 
                                        one lowercase letter, one number and one special character");
                                    }
                                } else {
                                    echo ("please confirm your password");
                                }
                            } else {
                                echo ("please fill the password");
                            }
                        } else {
                            echo ("email already exist");
                        }
                    } else {
                        echo ("email is not valid");
                    }
                } else {
                    echo ("please fill the email");
                }
            } else {
                echo ("please fill the last name");
            }
        } else {
            echo ("please fill the first name");
        }
    }

    public function signin()
    {
        if (isset($_POST["email"])) {
            if (isset($_POST["password"])) {
                $email = $_POST["email"];
                $password = $_POST["password"];
                $user_resultset = Database::search("SELECT * FROM `users` WHERE `email`=? AND `password`=?", [$email, $password]);
                $user_num = $user_resultset->num_rows;
                if ($user_num == 1) {
                    $user_data = $user_resultset->fetch_assoc();
                    $_SESSION["user"] = $user_data;
                    if (isset($_POST["remember_me"])) {
                        $remember_me = $_POST["remember_me"];
                        if ($remember_me == "1") {
                            $this->manage_cookie("email", $email, time() + (60 * 60 * 24 * 30));
                            $this->manage_cookie("password", $password, time() + (60 * 60 * 24 * 30));
                            $this->manage_cookie("rememberme", true, time() + (60 * 60 * 24 * 30));
                        } else if ($remember_me == "0") {
                            $this->manage_cookie("email", $email, time() - (60 * 60 * 24 * 30));
                            $this->manage_cookie("password", $password, time() - (60 * 60 * 24 * 30));
                            $this->manage_cookie("rememberme", false, time() - (60 * 60 * 24 * 30));
                        }
                    }
                    echo ("success");
                } else if ($user_num > 1) {
                    echo ("something went wrong");
                } else if ($user_num == 0) {
                    echo ("invalid email or password");
                }
            } else {
                echo ("please fill the password");
            }
        } else {
            echo ("please fill the email");
        }
    }

    public function signout()
    {
        session_destroy();
        $this->manage_cookie("email", "", time() - (60 * 60 * 24 * 30));
        $this->manage_cookie("password", "", time() - (60 * 60 * 24 * 30));
        $this->manage_cookie("rememberme", "", time() - (60 * 60 * 24 * 30));
        echo ("success");
    }

    public function send_reset_token()
    {
        if (isset($_POST["email"]) || !empty($_POST["email"])) {
            if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
                $email = $_POST["email"];
                $user_resultset = Database::search("SELECT * FROM `users` WHERE `email`=?", [$email]);
                $user_num = $user_resultset->num_rows;
                if ($user_num == 1) {
                    $user_data = $user_resultset->fetch_assoc();
                    $user_id = $user_data["id"];
                    $reset_code = uniqid(true) . uniqid(true) . uniqid(true);
                    $token = substr($reset_code, 0, 20);
                    Database::iud("UPDATE `users` SET `token`=? WHERE `id`=?", [$token, $user_id]);
                    $mail = new PHPMailer(true);
                    $mail->isSMTP();
                    $mail->Host       = 'smtp.gmail.com';
                    $mail->SMTPAuth   = true;
                    $mail->Username   = $_ENV["MAIN_EMAIL_USERNAME"];
                    $mail->Password   = $_ENV["MAIN_EMAIL_PASSWORD"];
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                    $mail->Port       = $_ENV["MAIN_EMAIL_PORT"];

                    $mail->setFrom($_ENV["MAIN_EMAIL"], 'UrbanPulse Team');
                    $mail->addAddress($email);

                    $mail->isHTML(true);
                    $mail->Subject = 'Requesting a Password Reset';
                    $mail->Body    = '<a href="http://localhost/urbanpulse_ecommerce_beta/reset-password/?id=' . $user_id . '&token=' . $token . '" 
        style="color:#00b295;font-size:20px;text-decoration:none;">Click Here to Reset Your Password</a>';
                    $mail->send();
                    echo ("success");
                }
            } else {
                echo ("Invalid email address");
            }
        } else {
            echo ("Please enter your email");
        }
    }

    public function reset_password()
    {
        if (isset($_POST["token"])) {
            if (isset($_POST["id"])) {
                if (isset($_POST["new_password"]) || !empty($_POST["new_password"])) {
                    if (isset($_POST["confirm_password"]) || !empty($_POST["confirm_password"])) {
                        if ($this->validate_password($_POST["new_password"])) {
                            if ($_POST["new_password"] == $_POST["confirm_password"]) {
                                $token = $_POST["token"];
                                $id = $_POST["id"];
                                $new_password = $_POST["new_password"];
                                $user_resultset = Database::search("SELECT * FROM `users` WHERE `id`=? AND `token`=?", [$id, $token]);
                                $user_num = $user_resultset->num_rows;
                                if ($user_num == 1) {
                                    $user_data = $user_resultset->fetch_assoc();
                                    $old_password = $user_data["password"];
                                    if ($new_password != $old_password) {
                                        Database::iud("UPDATE `users` SET `password`=? WHERE `id`=? AND `token`=?", [$new_password, $id, $token]);
                                        Database::iud("UPDATE `users` SET `token`=NULL WHERE `id`=? AND `password`=?", [$id, $new_password]);
                                        echo ("success");
                                    } else {
                                        echo ("New password cannot be same as old password");
                                    }
                                } else {
                                    echo ("Something went wrong!");
                                }
                            } else {
                                echo ("Passwords don't match");
                            }
                        } else {
                            echo ("Password must be at least 8 characters long and must contain at least one uppercase letter, one lowercase letter, one number and one special character");
                        }
                    } else {
                        echo ("Please enter your confirm password");
                    }
                } else {
                    echo ("Please enter your new password");
                }
            } else {
                echo ("Something went wrong!");
            }
        } else {
            echo ("Something went wrong!");
        }
    }

    public function update_profile()
    {
        if ($this->check_session()) {
            if (isset($_POST["first_name"])) {
                if (isset($_POST["last_name"])) {
                    if (isset($_POST["country"])) {
                        if ($_POST["country"] != "0") {
                            $user = $_SESSION["user"];
                            $first_name = $_POST["first_name"];
                            $last_name = $_POST["last_name"];
                            $country = $_POST["country"];
                            $update_query = "UPDATE `users` SET ";
                            $query_values = array();
                            // first name 
                            if ($first_name != $user["first_name"]) {
                                $update_query .= "` first_name` = ?,";
                                $query_values[] = $first_name;
                            }
                            // first name 
                            // last name 
                            if ($last_name != $user["last_name"]) {
                                $update_query .= " `last_name` = ?,";
                                $query_values[] = $last_name;
                            }
                            // last name 
                            // Address line 1 
                            if (isset($_POST["address_line_1"])) {
                                $address_line_1 = $_POST["address_line_1"];
                                if ($address_line_1 != $user["address_line_1"]) {
                                    $update_query .= " `address_line_1` = ?,";
                                    $query_values[] = $address_line_1;
                                }
                            }
                            // Address line 1 
                            // Address line 2 
                            if (isset($_POST["address_line_2"])) {
                                $address_line_2 = $_POST["address_line_2"];
                                if ($address_line_2 != $user["address_line_2"]) {
                                    $update_query .= " `address_line_2` = ?,";
                                    $query_values[] = $address_line_2;
                                }
                            }
                            // Address line 2
                            // City 
                            if (isset($_POST["city"])) {
                                $city = $_POST["city"];
                                if ($city != $user["city"]) {
                                    $update_query .= " `city` = ?,";
                                    $query_values[] = $city;
                                }
                            }
                            // City
                            // Zip code 
                            if (isset($_POST["zip_code"])) {
                                $zip_code = $_POST["zip_code"];
                                if ($zip_code != $user["zip_code"]) {
                                    $update_query .= " `zip_code` = ?,";
                                    $query_values[] = $zip_code;
                                }
                            }
                            // Zip code
                            // Country 
                            if (isset($_POST["country_id"])) {
                                $country_id = $_POST["country_id"];
                                if ($country_id != $user["country_id"]) {
                                    $update_query .= " `country_id` = ?,";
                                    $query_values[] = $country_id;
                                }
                            }
                            // Country 
                            // Country code and Mobile 
                            if (isset($_POST["country_code"]) || isset($_POST["mobile"])) {
                                if (isset($_POST["country_code_id"]) && !isset($_POST["mobile"])) {
                                    echo ("please fill the mobile number");
                                } else if (!isset($_POST["country_code_id"]) && isset($_POST["mobile"])) {
                                    echo ("please select your country code");
                                } else if (isset($_POST["country_code_id"]) && isset($_POST["mobile"])) {
                                    // Country code
                                    $country_code_id = $_POST["country_code_id"];
                                    if ($country_code_id != $user["country_code_id"]) {
                                        $update_query .= " `country_code_id` = ?,";
                                        $query_values[] = $country_code_id;
                                    }
                                    // Country code
                                    // Mobile number
                                    $mobile = $_POST["mobile"];
                                    if ($mobile != $user["mobile"]) {
                                        $update_query .= " `mobile` = ?,";
                                        $query_values[] = $mobile;
                                    }
                                    // Mobile number
                                }
                            }
                            // Country code and Mobile 
                            // Password 
                            if (isset($_POST["new_password"]) || isset($_POST["confirm_password"])) {
                                if (isset($_POST["old_password"])) {
                                    if (isset($_POST["new_password"]) && !isset($_POST["confirm_password"])) {
                                        echo ("please retype your new password");
                                    } else if (!isset($_POST["new_password"]) && isset($_POST["confirm_password"])) {
                                        echo ("please fill the new password");
                                    } else if (isset($_POST["new_password"]) && isset($_POST["confirm_password"])) {
                                        $old_password = $_POST["old_password"];
                                        $new_password = $_POST["new_password"];
                                        $confirm_password = $_POST["confirm_password"];
                                        $current_password = $user["password"];
                                        if ($old_password == $current_password) {
                                            if ($new_password != $current_password) {
                                                if ($this->validate_password($new_password)) {
                                                    if ($new_password == $confirm_password) {
                                                        $password = $_POST["password"];
                                                        if ($password != $user["password"]) {
                                                            $update_query .= " `password` = ?,";
                                                            $query_values[] = $new_password;
                                                        }
                                                    } else {
                                                        echo ("new passwords doesn't match");
                                                    }
                                                }
                                            } else {
                                                echo ("new password cannot be same as old password");
                                            }
                                        } else {
                                            echo ("old password is incorrect");
                                        }
                                    }
                                } else {
                                    echo ("please fill the old password");
                                }
                            }
                            // Password 
                            $update_query = rtrim($update_query, ',');
                            $update_query .= " WHERE `id` = ? AND `email` = ?";
                            $query_values[] = $user["id"];
                            $query_values[] = $user["email"];
                            Database::iud($update_query, $query_values);
                            // Refresh session 
                            $user_resultset = Database::search("SELECT * FROM `users` WHERE `email`=? AND `password`=?", [$user["email"], $new_password]);
                            $user_data = $user_resultset->fetch_assoc();
                            $_SESSION["user"] = $user_data;
                            if (isset($_POST["remember_me"])) {
                                if ($_COOKIE["rememberme"]) {
                                    $this->manage_cookie("email", $user["email"], time() + (60 * 60 * 24 * 30));
                                    $this->manage_cookie("password", $new_password, time() + (60 * 60 * 24 * 30));
                                    $this->manage_cookie("rememberme", true, time() + (60 * 60 * 24 * 30));
                                } else {
                                    $this->manage_cookie("email", $user["email"], time() - (60 * 60 * 24 * 30));
                                    $this->manage_cookie("password", $new_password, time() - (60 * 60 * 24 * 30));
                                    $this->manage_cookie("rememberme", false, time() - (60 * 60 * 24 * 30));
                                }
                            }
                            // Refresh session 
                            echo ("success");
                        } else {
                            echo ("please select your country");
                        }
                    } else {
                        echo ("please select your country");
                    }
                } else {
                    echo ("please fill the last name");
                }
            } else {
                echo ("please fill the first name");
            }
        } else {
            echo ("please signin to account");
        }
    }

    public function change_profile_picture()
    {
        if (isset($_SESSION["user"])) {
            $user = $_SESSION["user"];
            if (isset($_FILES["profile_picture"])) {
                $image = $_FILES["profile_picture"];
                $target_directory = "../assets/images/user/";
                $original_file_name = $image["name"];
                $custom_file_name = $user["first_name"] . "_" . $user["last_name"] . "_" . $user["id"] . "." . pathinfo($original_file_name, PATHINFO_EXTENSION);
                $target_file = $target_directory . $custom_file_name;
                $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                $allowed_extensions = array("jpg", "jpeg", "png", "svg", "webp", "avif");

                if (in_array($image_file_type, $allowed_extensions)) {
                    if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
                        $profile_picture_resultset = Database::search("SELECT * FROM `profile_picture` WHERE `user_id`=?", [$user["id"]]);
                        $profile_picture_num = $profile_picture_resultset->num_rows;
                        if ($profile_picture_num == 1) {
                            Database::iud("UPDATE `profile_picture` SET `profile_picture`=? WHERE `user_id`=?", [$custom_file_name, $user["id"]]);
                        } else if ($profile_picture_num == 0) {
                            Database::iud(
                                "INSERT INTO `profile_picture`(`user_id`,`profile_picture`) VALUES (?,?)",
                                [$user["id"], $custom_file_name]
                            );
                        }
                    }
                }
            }
        }
    }
}
