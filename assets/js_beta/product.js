import Connection from "./connection.js";
import Alert from "./alert.js";
import Spinner from "./spinners.js";

class Product {
  constructor() {
    this.connection = new Connection();
    this.colorsArray = [];
    this.locationsArray = [];
    this.shippingCostsArray = [];
    this.imagesArray = [];
  }

  generateUniqueId(prefix = "item-id") {
    const timestamp = new Date().getTime();
    return prefix + "-" + timestamp;
  }

  createPropertyElement(name, id) {
    let item = document.createElement("span");
    item.id = id;
    item.classList.add(
      "inline-flex",
      "w-max",
      "items-center",
      "px-2",
      "py-1",
      "mr-2",
      "text-sm",
      "font-medium",
      "text-gray-800",
      "bg-gray-100",
      "rounded",
      "capitalize"
    );
    let itemName = name;
    item.textContent = itemName;

    let removeButton = document.createElement("button");
    removeButton.type = "button";
    removeButton.classList.add(
      "inline-flex",
      "items-center",
      "p-1",
      "ml-2",
      "text-sm",
      "text-gray-400",
      "bg-transparent",
      "rounded-sm",
      "hover:bg-gray-200",
      "hover:text-gray-900"
    );
    removeButton.setAttribute("data-remove-tag", `${id}`);

    let svg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
    svg.setAttribute("class", "w-2 h-2 pointer-events-none");
    svg.setAttribute("aria-hidden", "true");
    svg.setAttribute("xmlns", "http://www.w3.org/2000/svg");
    svg.setAttribute("fill", "none");
    svg.setAttribute("viewBox", "0 0 14 14");

    let path = document.createElementNS("http://www.w3.org/2000/svg", "path");
    path.setAttribute("stroke", "currentColor");
    path.setAttribute("stroke-linecap", "round");
    path.setAttribute("stroke-linejoin", "round");
    path.setAttribute("stroke-width", "2");
    path.setAttribute("d", "m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6");

    svg.appendChild(path);
    removeButton.appendChild(svg);
    item.appendChild(removeButton);
    return item;
  }

  createPropertyArrayItem(id, name, value) {
    console.log({
      id: id,
      name: name,
      value: value,
    });
    return {
      id: id,
      name: name,
      value: value,
    };
  }

  addProperty(parentId, baseArray, propertyType, propertyName, propertyValue, elementText = null) {
    // [{ id: "id", name: "name", value: "value" }];
    if (elementText == null) {
      elementText = propertyName;
    }
    if (propertyName.length != 0 && propertyName != null && propertyValue.length != 0 && propertyValue != null && propertyValue != 0) {
      let parent = document.getElementById(parentId);
      if (baseArray.length == 0) {
        let id = this.generateUniqueId(propertyType);
        baseArray.push(this.createPropertyArrayItem(id, propertyName, propertyValue));
        parent.appendChild(this.createPropertyElement(elementText, id));
        console.log(this.createPropertyElement(elementText, id));
      } else if (!baseArray.some((item) => item.name == propertyName || item.value == propertyValue)) {
        let id = this.generateUniqueId(propertyType);
        baseArray.push(this.createPropertyArrayItem(id, propertyName, propertyValue));
        parent.appendChild(this.createPropertyElement(elementText, id));
        console.log(this.createPropertyElement(elementText, id));
      }
    }
  }

  removeProperty(event, baseArray) {
    if (event.target.matches("[data-remove-tag]")) {
      let itemId = event.target.getAttribute("data-remove-tag");
      let element = document.getElementById(itemId);
      let index = baseArray.findIndex((item) => item.id === itemId);
      if (index !== -1) {
        baseArray.splice(index, 1);
      }
      element.parentNode.removeChild(element);
    }
  }

  async manageLocations() {
    this.manageShippingTypes();
    const locationSelect = document.getElementById("country");
    if (this.locationsArray.length == 1 && this.locationsArray.some((item) => item.value == "worldwide")) {
      let values = [{ name: "location", data: "worldwide" }];
      try {
        let response = await this.connection.post(values, "../server/index.php?action=product&process=manage_locations_worldwide");
        locationSelect.innerHTML = response;
      } catch (error) {
        console.error("Error:", error);
      }
    } else if (this.locationsArray.length == 1 && !this.locationsArray.some((item) => item.value == "worldwide")) {
      let countryValue = this.locationsArray[0].value;
      let values = [{ name: "location", data: countryValue }];
      try {
        let response = await this.connection.post(values, "../server/index.php?action=product&process=manage_locations_countries");
        locationSelect.innerHTML = response;
      } catch (error) {
        console.error("Error:", error);
      }
    } else if (this.locationsArray.length == 0) {
      let values = [{ name: "location", data: "none" }];
      try {
        let response = await this.connection.post(values, "../server/index.php?action=product&process=manage_locations_none");
        locationSelect.innerHTML = response;
      } catch (error) {
        console.error("Error:", error);
      }
    }
  }

  addColor() {
    let color = document.getElementById("color").options[document.getElementById("color").selectedIndex].text;
    let colorValue = document.getElementById("color").value;
    this.addProperty("colors", this.colorsArray, "color", color, colorValue);
  }

  removeColor(event) {
    this.removeProperty(event, this.colorsArray);
  }
  addLocations() {
    let location = document.getElementById("country").options[document.getElementById("country").selectedIndex].text;
    let locationValue = document.getElementById("country").value;
    this.addProperty("locations", this.locationsArray, "location", location, locationValue);
    this.manageLocations();
  }

  removeLocations(event) {
    this.removeProperty(event, this.locationsArray);
    this.manageLocations();
  }
  addShippingCosts() {
    // {id: id, name: {country:country, value: value}, value: value}
    let country = document.getElementById("ship-country").options[document.getElementById("ship-country").selectedIndex].text;
    let countryValue = document.getElementById("ship-country").value;
    let shippingCostVal = document.getElementById("shipping-cost").value;
    if (shippingCostVal != "" && shippingCostVal != null && shippingCostVal != 0) {
      let shippingCost = parseFloat(shippingCostVal).toFixed(2);
      console.log(shippingCost);
      if (!isNaN(shippingCost) && shippingCost != 0) {
        let shippingCountryPair = { country: country, value: shippingCost };
        this.addProperty(
          "shipping-countries",
          this.shippingCostsArray,
          "shipping-cost",
          shippingCountryPair,
          countryValue,
          `${country}-$${shippingCost}`
        );
      }
    }
  }

  removeShippingCosts(event) {
    this.removeProperty(event, this.shippingCostsArray);
  }

  createAddedImages(id, src) {
    const item = document.createElement("div");
    item.classList.add("relative", "aspect-square", "flex", "justify-center", "items-center", "overflow-hidden");
    item.id = id;

    const img = document.createElement("img");
    img.classList.add("h-auto", "max-w-full", "rounded-lg", "min-w-full", "min-h-full", "object-cover");
    img.src = src;
    item.appendChild(img);

    const buttonContainer = document.createElement("div");
    buttonContainer.classList.add(
      "absolute",
      "bottom-0",
      "inset-x-0",
      "flex",
      "justify-around",
      "items-center",
      "w-full",
      "h-max",
      "bg-black/30",
      "py-4"
    );
    item.appendChild(buttonContainer);

    const removeButton = document.createElement("button");
    removeButton.classList.add("text-gray-100", "hover:text-white", "transition-all", "duration-75", "ease-linear");
    removeButton.setAttribute("data-remove-img", id);
    buttonContainer.appendChild(removeButton);

    const removeIcon = document.createElement("span");
    removeIcon.classList.add("material-symbols-outlined", "pointer-events-none");
    removeIcon.innerText = "delete";
    removeButton.appendChild(removeIcon);

    return item;
  }

  createImageArrayItem(id, file) {
    console.log({
      id: id,
      file: file,
    });
    return {
      id: id,
      file: file,
    };
  }

  addImages() {
    const imageInput = document.getElementById("img-input");
    let imageFiles = imageInput.files;
    const imageContainer = document.getElementById("added-images");
    for (let i = 0; i < imageFiles.length; i++) {
      let file = imageFiles[i];
      if (file.type.startsWith("image/")) {
        const reader = new FileReader();
        reader.onload = (event) => {
          let id = this.generateUniqueId("product-image");
          const src = event.target.result;
          imageContainer.appendChild(this.createAddedImages(id, src));
          this.imagesArray.push(this.createImageArrayItem(id, file));
          // }
          // imageElement.src = src;
        };
        reader.readAsDataURL(file);
        console.log(this.imagesArray);
        console.log(this.imagesArray.length);
      }
    }
  }

  removeImages(event) {
    if (event.target.matches("[data-remove-img]")) {
      let itemId = event.target.getAttribute("data-remove-img");
      let element = document.getElementById(itemId);
      let index = this.imagesArray.findIndex((item) => item.id === itemId);
      if (index !== -1) {
        this.imagesArray.splice(index, 1);
      }
      element.parentNode.removeChild(element);
    }
  }

  async loadBrands() {
    let processLoadSpinner = new Spinner();
    processLoadSpinner.addProcessLoadSpinner();
    const categorySelect = document.getElementById("category");
    const category = categorySelect.value;
    const brandSelect = document.getElementById("brand");
    const modelSelect = document.getElementById("model");
    if (category >= 0) {
      let values = [{ name: "category", data: category }];
      try {
        let response = await this.connection.post(values, "../server/index.php?action=product&process=load_brands");
        brandSelect.innerHTML = response;
        modelSelect.innerHTML = '<option value="0" selected>Pleass select your brand first</option>';
        processLoadSpinner.removeProcessLoadSpinner();
      } catch (error) {
        console.error("Error:", error);
      }
    } else {
      processLoadSpinner.removeProcessLoadSpinner();
    }
  }

  async loadModels() {
    let processLoadSpinner = new Spinner();
    processLoadSpinner.addProcessLoadSpinner();
    const brandSelect = document.getElementById("brand");
    const brand = brandSelect.value;
    const modelSelect = document.getElementById("model");
    if (brand >= 0) {
      let values = [{ name: "brand", data: brand }];
      try {
        let response = await this.connection.post(values, "../server/index.php?action=product&process=load_models");
        modelSelect.innerHTML = response;
        processLoadSpinner.removeProcessLoadSpinner();
      } catch (error) {
        console.error("Error:", error);
      }
    } else {
      processLoadSpinner.removeProcessLoadSpinner();
    }
  }

  async listProduct() {
    let processLoadSpinner = new Spinner();
    processLoadSpinner.addProcessLoadSpinner();
    let title = document.getElementById("title").value;
    let description = document.getElementById("description").value;
    let category = document.getElementById("category").value;
    let brand = document.getElementById("brand").value;
    let model = document.getElementById("model").value;
    let condition = document.getElementById("condition").value;
    let price = document.getElementById("price").value;
    let quantity = document.getElementById("quantity").value;
    let alert = new Alert("success");
    if (this.imagesArray.length < 3) {
      processLoadSpinner.removeProcessLoadSpinner(() => {
        alert.error("Please add at least 3 images");
      });
    } else if (title == "") {
      processLoadSpinner.removeProcessLoadSpinner(() => {
        alert.error("Please add your title");
      });
    } else if (description == "") {
      processLoadSpinner.removeProcessLoadSpinner(() => {
        alert.error("Please add your description");
      });
    } else if (category == 0) {
      processLoadSpinner.removeProcessLoadSpinner(() => {
        alert.error("Please select your category");
      });
    } else if (brand == 0) {
      processLoadSpinner.removeProcessLoadSpinner(() => {
        alert.error("Please select your brand");
      });
    } else if (model == 0) {
      processLoadSpinner.removeProcessLoadSpinner(() => {
        alert.error("Please select your model");
      });
    } else if (this.colorsArray.length < 1) {
      processLoadSpinner.removeProcessLoadSpinner(() => {
        alert.error("Please add at least 1 color");
      });
    } else if (condition == 0) {
      processLoadSpinner.removeProcessLoadSpinner(() => {
        alert.error("Please select your condition");
      });
    } else if (price == "") {
      processLoadSpinner.removeProcessLoadSpinner(() => {
        alert.error("Please add your price");
      });
    } else if (quantity == "") {
      processLoadSpinner.removeProcessLoadSpinner(() => {
        alert.error("Please add your quantity");
      });
    } else if (this.locationsArray.length < 1) {
      processLoadSpinner.removeProcessLoadSpinner(() => {
        alert.error("Please add your shipping location(s)");
      });
    } else if (this.shippingCostsArray.length < 1) {
      processLoadSpinner.removeProcessLoadSpinner(() => {
        alert.error("Please add your shipping cost(s)");
      });
    } else {
      let values = [
        { name: "title", data: title },
        { name: "description", data: description },
        { name: "category", data: category },
        { name: "brand", data: brand },
        { name: "model", data: model },
        { name: "colors", data: JSON.stringify(this.colorsArray) },
        { name: "condition", data: condition },
        { name: "price", data: price },
        { name: "quantity", data: quantity },
        { name: "shipping_locations", data: JSON.stringify(this.locationsArray) },
        { name: "shipping_cost", data: JSON.stringify(this.shippingCostsArray) },
      ];
      for (let image of this.imagesArray) {
        let imageNum = this.imagesArray.indexOf(image);
        values.push({ name: `image-${imageNum}`, data: image.file });
        console.log(image.file);
      }
      try {
        let response = await this.connection.post(values, "../server/index.php?action=product&process=list_product");
        if (response == "success") {
          processLoadSpinner.removeProcessLoadSpinner(() => {
            alert.success("Product listed successfully", () => {
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

  // update product
  async loadProductData(event) {
    let currentUrl = window.location.search;
    let urlParams = new URLSearchParams(currentUrl);
    let productId = urlParams.get('id');
    let values = [
      { name: "product_id", data: productId }
    ];
    try {
      let response = await this.connection.post(values, "../server/index.php?action=update_product&process=load_product_data");
      let receivedData = JSON.parse(response);
      console.log(receivedData);
      // load colors
      let colors = receivedData.colors;
      colors.forEach(element => {
        let color = element.name;
        let colorValue = element.value;
        this.addProperty("colors", this.colorsArray, "color", color, colorValue);
      });
      // load colors
      // load locations 
      let locations = receivedData.locations;
      locations.forEach(element => {
        let location = element.name;
        let locationValue = element.value;
        this.addProperty("locations", this.locationsArray, "location", location, locationValue);
        this.manageLocations();
      })
      // load locations
      // load costs 
      let costs = receivedData.costs;
      costs.forEach(element => {
        let country = element.name.country;
        let countryValue = element.value;
        let shippingCostVal = element.name.value;
        if (shippingCostVal != "" && shippingCostVal != null && shippingCostVal != 0) {
          let shippingCost = parseFloat(shippingCostVal).toFixed(2);
          console.log(shippingCost);
          if (!isNaN(shippingCost) && shippingCost != 0) {
            let shippingCountryPair = { country: country, value: shippingCost };
            this.addProperty(
              "shipping-countries",
              this.shippingCostsArray,
              "shipping-cost",
              shippingCountryPair,
              countryValue,
              `${country}-$${shippingCost}`
            );
          }
        }
      });
      console.log(this.shippingCostsArray);
      // load costs 
    } catch (error) {
      console.error("Error:", error);
    }
  }
  // update product 
}

export default Product;
