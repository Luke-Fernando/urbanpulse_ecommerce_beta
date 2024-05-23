import Connection from "./connection.js";
import Alert from "./alert.js";
import Spinner from "./spinners.js";
import Order from "./order.js";

class Cart {

    constructor() {
        this.connection = new Connection();
    }

    async addToCart(event) {
        let processLoadSpinner = new Spinner();
        processLoadSpinner.addProcessLoadSpinner();
        let currentUrl = window.location.search;
        let urlParams = new URLSearchParams(currentUrl);
        let productId = urlParams.get('id');
        let color = document.getElementById("color").value;
        let quantity = document.getElementById("quantity").value;
        let alert = new Alert("success");
        if (color == 0 || color < 0) {
            processLoadSpinner.removeProcessLoadSpinner(() => {
                alert.error("Please select a color");
            });
        } else if (quantity == 0 || quantity < 0) {
            processLoadSpinner.removeProcessLoadSpinner(() => {
                alert.error("Please set your quantity");
            });
        } else {
            let values = [
                { name: "product_id", data: productId },
                { name: "quantity", data: quantity },
                { name: "color", data: color },
            ];

            try {
                let response = await this.connection.post(values, "../server/index.php?action=cart&process=add_to_cart");
                if (response == "success") {
                    processLoadSpinner.removeProcessLoadSpinner(() => {
                        alert.success("Successfully added to the cart");
                    });
                } else {
                    processLoadSpinner.removeProcessLoadSpinner(() => {
                        alert.error(response);
                    });
                }
            } catch (error) {
                console.error("Error:", error);
            }
        }
    }

    async removeFromCart(event) {
        let processLoadSpinner = new Spinner();
        processLoadSpinner.addProcessLoadSpinner();
        let cartId = event.target.getAttribute("data-cart-delete");
        let alert = new Alert("success");
        let values = [
            { name: "cart_id", data: cartId },
        ];

        try {
            let response = await this.connection.post(values, "../server/index.php?action=cart&process=remove_from_cart");
            if (response == "success") {
                processLoadSpinner.removeProcessLoadSpinner(() => {
                    alert.success("Item removed successfully", () => {
                        window.location.reload();
                    });
                });
            } else {
                processLoadSpinner.removeProcessLoadSpinner(() => {
                    alert.error(response);
                });
            }
        } catch (error) {
            console.error("Error:", error);
        }
    }

    async cartToWishlist(event) {
        let processLoadSpinner = new Spinner();
        processLoadSpinner.addProcessLoadSpinner();
        let cartId = event.target.getAttribute("data-cart-wishlist");
        let alert = new Alert("success");
        let values = [
            { name: "cart_id", data: cartId },
        ];

        try {
            let response = await this.connection.post(values, "../server/index.php?action=cart&process=cart_to_wishlist");
            if (response == "success") {
                processLoadSpinner.removeProcessLoadSpinner(() => {
                    alert.success("Item moved to wishlist", () => {
                        window.location.reload();
                    });
                });
            } else {
                processLoadSpinner.removeProcessLoadSpinner(() => {
                    alert.error(response);
                });
            }
        } catch (error) {
            console.error("Error:", error);
        }
    }

    async decreaseCartQuantity(event) {
        let processLoadSpinner = new Spinner();
        processLoadSpinner.addProcessLoadSpinner();
        let cartId = event.target.getAttribute("data-cart-decrease");
        let cartQuantity = document.querySelector(`[data-cart-quantity="${cartId}"]`);
        let values = [
            { name: "cart_id", data: cartId },
        ];

        try {
            let response = await this.connection.post(values, "../server/index.php?action=cart&process=decrease_cart_quantity");
            if (response == "success") {
                cartQuantity.textContent = parseInt(cartQuantity.textContent) - 1;
                processLoadSpinner.removeProcessLoadSpinner(() => {
                    window.location.reload();
                });
            } else {
                processLoadSpinner.removeProcessLoadSpinner();
            }
        } catch (error) {
            console.error("Error:", error);
        }
    }

    async increaseCartQuantity(event) {
        let cartId = event.target.getAttribute("data-cart-increase");
        let cartQuantity = document.querySelector(`[data-cart-quantity="${cartId}"]`);
        let values = [
            { name: "cart_id", data: cartId },
        ];

        try {
            let processLoadSpinner = new Spinner();
            processLoadSpinner.addProcessLoadSpinner();
            let response = await this.connection.post(values, "../server/index.php?action=cart&process=increase_cart_quantity");
            if (response == "success") {
                cartQuantity.textContent = parseInt(cartQuantity.textContent) + 1;
                processLoadSpinner.removeProcessLoadSpinner(() => {
                    window.location.reload();
                });
            } else {
                processLoadSpinner.removeProcessLoadSpinner();
            }
        } catch (error) {
            console.error("Error:", error);
        }
    }

    async getOrderDetails(event) {
        //
        let processLoadSpinner = new Spinner();
        processLoadSpinner.addProcessLoadSpinner();
        let values = [];
        try {
            let response = await this.connection.post(values, "../server/index.php?action=cart&process=get_order_details");
            let products = JSON.parse(response);
            processLoadSpinner.removeProcessLoadSpinner(() => {
                let order = new Order();
                for (let i = 0; i < products.length; i++) {
                    let currentProduct = products[i];
                    let productId = currentProduct.product_id;
                    let quantity = currentProduct.quantity;
                    let color = currentProduct.color;
                    order.setProducts(productId, quantity, color);
                }
                order.sendToPlaceOrder("../");
            });
        } catch (error) {
            console.error("Error:", error);
        }
        //
    }
}

export default Cart;