import Alert from "./alert.js";
import Connection from "./connection.js";

class Order {
    constructor() {
        this.products = [];
        this.productsCosts;
        this.connection = new Connection();
    }

    setProducts(id, quantity, color) {
        this.products.push({
            "product": id,
            "quantity": quantity,
            "color": color
        });
    }

    sendToPlaceOrder(rootPath) {
        let initialLink = `${rootPath}product/place-order/`;
        let alert = new Alert("success");
        if (this.products.length >= 1) {
            localStorage.setItem("products", JSON.stringify(this.products));
            window.location.href = initialLink;
        } else {
            alert.error("Something went wrong!");
        }
    }

    async generatePlacedProducts(event) {
        //
        const productsContainer = document.getElementById("products-container");
        let alert = new Alert("success");
        this.products = localStorage.getItem("products");
        if (this.products != null) {
            let values = [
                { name: "products", data: this.products },
                { name: "root_path", data: "../../" }
            ];
            try {
                let response = await this.connection.post(values, "../../server/index.php?action=order&process=generate_placed_products");
                productsContainer.innerHTML = response;
                this.generatePlacedProductsCosts(event);
            } catch (error) {
                console.error("Error:", error);
            }
        } else {
            alert.error("Session is over", () => {
                window.location.href = "../../home/";
            });
        }
        //
    }

    async generatePlacedProductsCosts(event) {
        //
        const items = document.querySelector("#items");
        const itemsTotal = document.querySelector("#items-total");
        const shippingTotal = document.querySelector("#shipping-total");
        const subtotal = document.querySelector("#subtotal");
        let alert = new Alert("success");
        this.products = localStorage.getItem("products");
        if (this.products != null) {
            let values = [
                { name: "products", data: this.products },
                { name: "root_path", data: "../../" }
            ];
            try {
                let response = await this.connection.post(values, "../../server/index.php?action=order&process=generate_placed_products_costs");
                let detailsArray = JSON.parse(response);
                this.productsCosts = detailsArray;
                items.textContent = detailsArray.items;
                itemsTotal.textContent = detailsArray.items_total;
                shippingTotal.textContent = detailsArray.shipping_total;
                subtotal.textContent = detailsArray.subtotal;
                localStorage.removeItem("products");
            } catch (error) {
                console.error("Error:", error);
            }
        } else {
            alert.error("Session is over", () => {
                window.location.href = "../../home/";
            });
        }
        //
    }
}

export default Order;