import Cart from "./cart.js";
import Order from "./order.js";
import Product from "./product.js";
import User from "./user.js";
import Wishlist from "./wishlist.js";


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

  // add product 
  function callProductMethod(triggerId, method, event = "click") {
    let triggers = document.querySelectorAll(triggerId);
    triggers.forEach((trigger) => {
      if (trigger != null) {
        trigger.addEventListener(event, (e) => {
          if (product != null || product instanceof Product) {
            product[method](e);
          } else {
            product = new Product();
            product[method](e);
          }
        });
      }
    });
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
  // add product 

  // update product
  function initializeData(triggerId) {
    let trigger = document.querySelector(triggerId);
    if (trigger != null) {
      document.addEventListener("DOMContentLoaded", (e) => {
        if (product != null || product instanceof Product) {
          product.loadProductData(e);
        } else {
          product = new Product();
          product.loadProductData(e);
        }
      });
    }
  }
  // update product

  // add product 
  callProductMethod("#add-color-btn", "addColor");
  callProductMethod("#add-location-btn", "addLocations");
  callProductMethod("#add-country-btn", "addShippingCosts");
  removeTag("colors", "removeColor");
  removeTag("locations", "removeLocations");
  removeTag("shipping-countries", "removeShippingCosts");
  callProductMethod("#img-input", "addImages", "change");
  removeImage("added-images", "removeImages");
  callProductMethod("#category", "loadBrands", "change");
  callProductMethod("#brand", "loadModels", "change");
  callProductMethod("#list-item-btn", "listProduct");
  callProductMethod("#add-to-cart", "addToCart");
  callProductMethod("[data-change-quantity]", "setProductQuantity");
  callProductMethod("#buy-now-btn", "getOrderDetails");
  // add product 

  // update product
  initializeData("#update-product", "loadProductData");
  removeImage("added-images", "removeLoadedImages");
  callProductMethod("update-item-btn", "updateProduct");
  // update product
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
  callCartMethod("#checkout-btn", "getOrderDetails");
}

cart();


function wishlist() {
  let wishlist;

  function callWishlistMethod(triggerId, method, event = "click") {
    let triggers = document.querySelectorAll(triggerId);
    triggers.forEach((trigger) => {
      if (trigger != null) {
        trigger.addEventListener(event, (e) => {
          if (wishlist != null || wishlist instanceof Wishlist) {
            wishlist[method](e);
          } else {
            wishlist = new Wishlist();
            wishlist[method](e);
          }
        });
      }
    });
  }

  callWishlistMethod("#add-to-wishlist-btn", "addToWishlist");
  callWishlistMethod("[data-wishlist-delete]", "removeFromWishlist");
  callWishlistMethod("[data-toggle-wishlist]", "toggleWishlist");
}

wishlist();


function order() {
  let order;

  function callOrderMethod(triggerId, method, event = "click") {
    let triggers = document.querySelectorAll(triggerId);
    triggers.forEach((trigger) => {
      if (trigger != null) {
        trigger.addEventListener(event, (e) => {
          if (prorderoduct != null || order instanceof Order) {
            order[method](e);
          } else {
            order = new Order();
            order[method](e);
          }
        });
      }
    });
  }

  function initializeData(triggerId, method) {
    let trigger = document.querySelector(triggerId);
    if (trigger != null) {
      document.addEventListener("DOMContentLoaded", (e) => {
        if (order != null || order instanceof Product) {
          order[method](e);
        } else {
          order = new Order();
          order[method](e);
        }
      });
    }
  }

  // callOrderMethod("#add-color-btn", "addColor");

  initializeData("#place-order", "generatePlacedProducts");
  // initializeData("#place-order", "generatePlacedProductsCosts");
}

order();