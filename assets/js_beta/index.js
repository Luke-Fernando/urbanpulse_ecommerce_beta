import Cart from "./cart.js";
import Product from "./product.js";
import User from "./user.js";


function callUserMethod(triggerId, method, event = "click") {
  let user = new User();
  let trigger = document.getElementById(triggerId);
  if (trigger != null) {
    trigger.addEventListener(event, () => {
      user[method]();
    });
  }
}

callUserMethod("signup-btn", "signup");
callUserMethod("signin-btn", "signin");
callUserMethod("signout-btn", "signout");
callUserMethod("reset-link-btn", "sendResetToken");
callUserMethod("reset-password-btn", "resetPassword");
callUserMethod("update-profile-btn", "updateProfile");
callUserMethod("update-profile-picture-btn", "updateProfilePicture", "change");

function addProduct() {
  let product;

  function callProductMethod(triggerId, method, event = "click") {
    let trigger = document.getElementById(triggerId);
    if (trigger != null) {
      trigger.addEventListener(event, () => {
        if (product != null || product instanceof Product) {
          product[method]();
        } else {
          product = new Product();
          product[method]();
        }
      });
    }
  }

  function removeTag(containerId, method) {
    let container = document.getElementById(containerId);
    if (container != null) {
      container.addEventListener("click", (event) => {
        product[method](event);
      });
    }
  }

  function removeImage(containerId, method) {
    let container = document.getElementById(containerId);
    if (container != null) {
      container.addEventListener("click", (event) => {
        product[method](event);
      });
    }
  }

  callProductMethod("add-color-btn", "addColor");
  callProductMethod("add-location-btn", "addLocations");
  callProductMethod("add-country-btn", "addShippingCosts");
  removeTag("colors", "removeColor");
  removeTag("locations", "removeLocations");
  removeTag("shipping-countries", "removeShippingCosts");
  callProductMethod("img-input", "addImages", "change");
  removeImage("added-images", "removeImages");
  callProductMethod("category", "loadBrands", "change");
  callProductMethod("brand", "loadModels", "change");
  callProductMethod("shipping-type", "manageShippingTypes", "change");
  callProductMethod("list-item-btn", "listProduct");
  callProductMethod("add-to-cart", "addToCart");
}

addProduct();


function cart() {
  let cart;

  function callCartMethod(triggerId, method, event = "click") {
    let trigger = document.querySelector(triggerId);
    if (trigger != null) {
      trigger.addEventListener(event, (e) => {
        if (cart != null || cart instanceof Cart) {
          cart[method](e);
        } else {
          cart = new Cart();
          cart[method](e);
        }
      });
    }
  }

  callCartMethod("#add-to-cart-btn", "addToCart");
  callCartMethod("[data-cart-delete]", "removeFromCart");
  callCartMethod("[data-cart-wishlist]", "cartToWishlist");
  callCartMethod("[data-cart-decrease]", "decreaseCartQuantity");
  callCartMethod("[data-cart-increase]", "increaseCartQuantity");
}

cart();