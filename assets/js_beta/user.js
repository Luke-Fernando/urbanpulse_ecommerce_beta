import Connection from "./connection.js";
import Alert from "./alert.js";

class User {
  constructor() {
    this.connection = new Connection();
  }

  log() {
    this.connection.log();
    console.log("User");
  }

  async signup() {
    let firstName = document.getElementById("first-name");
    let lastName = document.getElementById("last-name");
    let email = document.getElementById("email");
    let password = document.getElementById("password");
    let confirmPassword = document.getElementById("confirm-password");
    let country = document.getElementById("country");
    let gender = document.getElementById("gender");
    let agreement = document.getElementById("agreement");
    let agreementState;

    if (agreement.checked) {
      agreementState = 1;
    } else {
      agreementState = 0;
    }
    let values = [
      { name: "first_name", data: firstName.value },
      { name: "last_name", data: lastName.value },
      { name: "email", data: email.value },
      { name: "password", data: password.value },
      { name: "confirm_password", data: confirmPassword.value },
      { name: "country", data: country.value },
      { name: "gender", data: gender.value },
      { name: "agreement_state", data: agreementState },
    ];

    try {
      let response = await this.connection.post(values, "../server/index.php?action=user&process=signup");
      let alert = new Alert("success");
      if (response == "successsuccess") {
        alert.success("Successfully signed up", () => {
          window.location.href = "/urbanpulse_ecommerce_beta/signin/";
        });
      } else {
        alert.error(response);
      }
    } catch (error) {
      console.error("Error:", error);
    }
  }

  async signin() {
    let email = document.getElementById("email");
    let password = document.getElementById("password");
    let remembermeBox = document.getElementById("rememberme");
    let remembermeState;

    if (remembermeBox.checked) {
      remembermeState = 1;
    } else {
      remembermeState = 0;
    }

    let values = [
      { name: "email", data: email.value },
      { name: "password", data: password.value },
      { name: "rememberme", data: remembermeState },
    ];
    try {
      let response = await this.connection.post(values, "../server/index.php?action=user&process=signin");
      console.log(response);
      let alert = new Alert("success");
      if (response == "success") {
        alert.success("Successfully signed in", () => {
          window.location.href = "/urbanpulse_ecommerce_beta/home/";
        });
      } else {
        // let error = document.getElementById("error-normal");
        // let errorContent = error.querySelector("#error-content");
        // errorContent.textContent = response;
        alert.error();
      }
    } catch (error) {
      console.error("Error:", error);
    }
  }

  async signout() {
    let values = [];
    try {
      let response = await this.connection.post(values, "../server/index.php?action=user&process=signout");
      if (response == "success") {
        window.location.reload();
      } else {
        console.error(response);
      }
    } catch (error) {
      console.error("Error:", error);
    }
  }

  async sendResetToken() {
    const email = document.getElementById("forgot-email");
    let values = [{ name: "email", data: email.value }];
    try {
      let response = await this.connection.post(values, "../server/index.php?action=user&process=send_reset_token");
      let alert = new Alert("success");
      if (response == "success") {
        alert.success("Please check your inbox");
      } else {
        alert.error(response);
      }
    } catch (error) {
      console.error("Error:", error);
    }
  }

  async resetPassword() {
    let newPassword = document.getElementById("new-password");
    let confirmPassword = document.getElementById("confirm-password");
    const params = new URLSearchParams(window.location.search);
    const id = params.get("id");
    const token = params.get("token");

    let selectedVals = [
      { name: "token", data: token },
      { name: "id", data: id },
      { name: "new_password", data: newPassword.value },
      { name: "confirm_password", data: confirmPassword.value },
    ];

    try {
      let response = await this.connection.post(selectedVals, "../server/index.php?action=user&process=reset_password");
      let alert = new Alert("success");
      if (response == "success") {
        alert.success("Password changed successfully", () => {
          window.location.href = "/urbanpulse_ecommerce_beta/signin/";
        });
      } else {
        alert.error(response);
      }
    } catch (error) {
      console.error("Error:", error);
    }
  }

  async updateProfile() {
    let firstName = document.getElementById("first-name");
    let lastName = document.getElementById("last-name");
    let addrLine1 = document.getElementById("address-line-1");
    let addrLine2 = document.getElementById("address-line-2");
    let country = document.getElementById("country");
    let city = document.getElementById("city");
    let zipCode = document.getElementById("zip-code");
    let countryCode = document.getElementById("country-code");
    let mobileNumber = document.getElementById("mobile-number");
    let oldPassword = document.getElementById("old-password");
    let newPassword = document.getElementById("new-password");
    let confirmPassword = document.getElementById("retype-new-password");

    let values = [
      { name: "first_name", data: firstName.value },
      { name: "last_name", data: lastName.value },
      { name: "address_line_1", data: addrLine1.value },
      { name: "address_line_2", data: addrLine2.value },
      { name: "country", data: country.value },
      { name: "city", data: city.value },
      { name: "zip_code", data: zipCode.value },
      { name: "country_code", data: countryCode.value },
      { name: "mobile_number", data: mobileNumber.value },
      { name: "old_password", data: oldPassword.value },
      { name: "new_password", data: newPassword.value },
      { name: "confirm_password", data: confirmPassword.value },
    ];
    try {
      let response = await this.connection.post(values, "../server/index.php?action=user&process=update_profile");
      let alert = new Alert("success");
      if (response == "success") {
        alert.success("Profile updated successfully", () => {
          window.location.reload();
        });
      } else {
        alert.error(response);
      }
    } catch (error) {
      console.error("Error:", error);
    }
  }

  async updateProfilePicture() {
    const pictureInput = document.getElementById("update-profile-picture-btn");
    const profilePicture = document.getElementById("profile-picture");
    let picture;

    picture = pictureInput.files[0];
    if (picture.type.startsWith("image/")) {
      const reader = new FileReader();
      reader.onload = async (event) => {
        let values = [{ name: "profile_picture", data: picture }];
        try {
          let response = await this.connection.post(values, "../server/index.php?action=user&process=update_profile_picture");
          let alert = new Alert("success");
          if (response == "success") {
            alert.success("Profile picture updated successfully");
          } else {
            alert.error(response);
          }
        } catch (error) {
          console.error("Error:", error);
        }
        let pictureDataURL = event.target.result;
        profilePicture.setAttribute("src", pictureDataURL);
      };
      reader.readAsDataURL(picture);
    }
  }
}

export default User;
