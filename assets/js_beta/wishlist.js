import Connection from "./connection.js";
import Alert from "./alert.js";
import Spinner from "./spinners.js";

class Wishlist {

    constructor() {
        this.connection = new Connection();
    }

    async addToWishlist(event) {
        let processLoadSpinner = new Spinner();
        processLoadSpinner.addProcessLoadSpinner();
        let currentUrl = window.location.search;
        let urlParams = new URLSearchParams(currentUrl);
        let productId = urlParams.get('id');
        let alert = new Alert("success");

        let values = [
            { name: "product_id", data: productId },
        ];

        try {
            let response = await this.connection.post(values, "../server/index.php?action=wishlist&process=add_to_wishlist");
            if (response == "success") {
                processLoadSpinner.removeProcessLoadSpinner(() => {
                    alert.success("Successfully added to the wishlist");
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

    async removeFromWishlist(event) {
        let processLoadSpinner = new Spinner();
        processLoadSpinner.addProcessLoadSpinner();
        let wishlistId = event.target.getAttribute("data-wishlist-delete");
        let alert = new Alert("success");
        let values = [
            { name: "wishlist_id", data: wishlistId },
        ];

        try {
            let response = await this.connection.post(values, "../server/index.php?action=wishlist&process=remove_from_wishlist");
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
}

export default Wishlist;