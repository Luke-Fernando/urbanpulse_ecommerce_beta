import Client from "./client.js";

function clientFunctions() {
    let client = new Client();

    client.scrollProducts();
    client.changeBannerHome();
    client.changeProductImage();
}

clientFunctions();