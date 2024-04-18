class Spinner {
  constructor() {
    this.pageLoadSpinner = false;
    this.processLoadSpinner = false;
  }

  createPageLoadSpinner() {
    const item = document.createElement("div");
    item.id = "page-load-spinner";
    item.classList.add(
      "w-screen",
      "h-screen",
      "fixed",
      "top-0",
      "left-0",
      "overflow-hidden",
      "flex",
      "justify-center",
      "items-center",
      "z-50",
      "bg-white"
    );

    const spinner = document.createElement("div");
    spinner.classList.add("spinner");
    item.appendChild(spinner);

    return item;
  }

  createProcessLoadSpinner() {
    const item = document.createElement("div");
    item.id = "process-load-spinner";
    item.classList.add("fixed", "w-screen", "h-screen", "top-0", "left-0", "bg-gray-500/30", "z-50", "flex", "justify-center", "items-center");

    const spinner = document.createElement("div");
    spinner.classList.add("lds-ripple");

    const div1 = document.createElement("div");
    spinner.appendChild(div1);

    const div2 = document.createElement("div");
    spinner.appendChild(div2);

    item.appendChild(spinner);

    return item;
  }

  addPageLoadSpinner() {
    this.pageLoadSpinner = true;
    const body = document.querySelector("body");
    body.style.overflow = "hidden";
    body.appendChild(this.createPageLoadSpinner());
  }

  async removePageLoadSpinner() {
    if (this.pageLoadSpinner) {
      await new Promise((resolve) => setTimeout(resolve, 1000));
      const spinner = document.getElementById("page-load-spinner");
      this.pageLoadSpinner = false;
      const body = document.querySelector("body");
      body.removeChild(spinner);
      body.style.overflow = "auto";
    }
  }

  addProcessLoadSpinner() {
    if (!this.pageLoadSpinner) {
      this.processLoadSpinner = true;
      const body = document.querySelector("body");
      body.style.overflow = "hidden";
      body.appendChild(this.createProcessLoadSpinner());
    }
  }

  async removeProcessLoadSpinner() {
    if (this.processLoadSpinner) {
      await new Promise((resolve) => setTimeout(resolve, 500));
      const spinner = document.getElementById("process-load-spinner");
      this.processLoadSpinner = false;
      const body = document.querySelector("body");
      body.removeChild(spinner);
      body.style.overflow = "auto";
    }
  }
}

export default Spinner;
