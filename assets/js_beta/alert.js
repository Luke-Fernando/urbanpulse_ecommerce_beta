class Alert {
  constructor(targetElementId) {
    this.flag = false;
    if (targetElementId) {
      this.targetElement = document.getElementById(`${targetElementId}`);
    } else {
      this.targetElement = null;
    }
  }

  createSuccessAlert(successText) {
    let successAlert = document.createElement("div");
    successAlert.id = "success-alert";
    successAlert.classList.add(
      "flex",
      "flex-wrap",
      "items-center",
      "text-green-800",
      "border-t-4",
      "border-green-300",
      "bg-green-50",
      "opacity-0",
      "transition-all",
      "ease-linear",
      "duration-100",
      "fixed",
      "z-[55]",
      "top-3",
      "left-1/2",
      "-translate-x-1/2",
      "-translate-y-8",
      "w-max",
      "max-w-[90vw]"
    );

    let textDiv = document.createElement("div");
    textDiv.classList.add("text-md", "font-medium", "py-3", "px-2", "w-max", "max-w-[90vw]", "box-border");

    let alertText = document.createElement("p");
    alertText.classList.add("px-3", "text-center");
    alertText.textContent = successText;

    textDiv.appendChild(alertText);

    successAlert.appendChild(textDiv);

    let body = document.body;

    body.appendChild(successAlert);
    return successAlert;
  }

  createErrorAlert(errorText) {
    let errorAlert = document.createElement("div");
    errorAlert.id = "success-alert";
    errorAlert.classList.add(
      "flex",
      "flex-wrap",
      "items-center",
      "text-red-800",
      "border-t-4",
      "border-red-300",
      "bg-red-50",
      "opacity-0",
      "transition-all",
      "ease-linear",
      "duration-100",
      "fixed",
      "z-[55]",
      "top-3",
      "left-1/2",
      "-translate-x-1/2",
      "-translate-y-8",
      "w-max",
      "max-w-[90vw]"
    );

    let textDiv = document.createElement("div");
    textDiv.classList.add("text-md", "font-medium", "py-3", "px-2", "w-max", "max-w-[90vw]", "box-border");

    let alertText = document.createElement("p");
    alertText.classList.add("px-3", "text-center");
    alertText.textContent = errorText;

    textDiv.appendChild(alertText);

    errorAlert.appendChild(textDiv);

    let body = document.body;

    body.appendChild(errorAlert);
    return errorAlert;
  }

  async success(successText, callback = null) {
    let successAlert = this.createSuccessAlert(successText);
    await new Promise((resolve) => setTimeout(resolve, 10));
    successAlert.classList.remove("opacity-0");
    await new Promise((resolve) => setTimeout(resolve, 10));
    successAlert.classList.remove("-translate-y-8");
    await new Promise((resolve) => setTimeout(resolve, 3000));
    successAlert.classList.add("-translate-y-8");
    await new Promise((resolve) => setTimeout(resolve, 20));
    successAlert.classList.add("opacity-0");
    await new Promise((resolve) => setTimeout(resolve, 10));
    successAlert.addEventListener(
      "transitionend",
      function () {
        document.body.removeChild(successAlert);
        if (callback && typeof callback === "function") {
          callback();
        }
      },
      { once: true }
    );
  }

  async error(errorText, callback = null) {
    let errorAlert = this.createErrorAlert(errorText);
    await new Promise((resolve) => setTimeout(resolve, 10));
    errorAlert.classList.remove("opacity-0");
    await new Promise((resolve) => setTimeout(resolve, 10));
    errorAlert.classList.remove("-translate-y-8");
    await new Promise((resolve) => setTimeout(resolve, 3000));
    errorAlert.classList.add("-translate-y-8");
    await new Promise((resolve) => setTimeout(resolve, 20));
    errorAlert.classList.add("opacity-0");
    await new Promise((resolve) => setTimeout(resolve, 10));
    errorAlert.addEventListener(
      "transitionend",
      function () {
        document.body.removeChild(errorAlert);
        if (callback && typeof callback === "function") {
          callback();
        }
      },
      { once: true }
    );
  }

  // deprecated
  show() {
    this.targetElement.classList.remove("hidden");
    this.targetElement.classList.add("flex");
  }

  // deprecated
  hide() {
    this.targetElement.classList.add("hidden"); // Add background color class after the "hidden" class is removed
    this.targetElement.classList.remove("flex");
  }
}

export default Alert;
