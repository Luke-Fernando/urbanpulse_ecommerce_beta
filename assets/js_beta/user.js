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
      console.log(response);
      if (response == "successsuccess") {
        window.location.href = "/urbanpulse_ecommerce_beta/signin/";
      } else if (response == "Incorrect Password Format") {
        let alert = new Alert("error-password");
        alert.show();
        setTimeout(() => alert.hide(), 5000);
      } else {
        let error = document.getElementById("error-normal");
        let errorContent = error.querySelector("#alert-content");
        errorContent.textContent = response;
        let alert = new Alert("error-normal");
        alert.show();
        setTimeout(() => alert.hide(), 5000);
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
      if (response == "success") {
        window.location.href = "/urbanpulse_ecommerce_beta/home/";
      } else {
        let error = document.getElementById("error-normal");
        let errorContent = error.querySelector("#error-content");
        errorContent.textContent = response;
        let alert = new Alert("error-normal");
        alert.show();
        setTimeout(() => alert.hide(), 5000);
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
        alert.success("Password changed successfully");
        // window.location.href = "/urbanpulse_ecommerce_beta/signin/";
      } else {
        alert.error(response);
      }
    } catch (error) {
      console.error("Error:", error);
    }
  }
}

export default User;
