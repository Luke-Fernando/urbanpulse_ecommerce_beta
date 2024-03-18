import User from "./user.js";

function callUserMethod(triggerId, method) {
  let user = new User();
  let trigger = document.getElementById(`${triggerId}`);
  if (trigger != null) {
    trigger.addEventListener("click", () => {
      user[method]();
    });
  }
}

callUserMethod("signup-btn", "signup");
callUserMethod("signin-btn", "signin");
callUserMethod("signout-btn", "signout");
callUserMethod("reset-link-btn", "sendResetToken");
callUserMethod("reset-password-btn", "resetPassword");
