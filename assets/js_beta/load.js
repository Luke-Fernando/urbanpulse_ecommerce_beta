import Spinner from "./spinners.js";

function callSpinner() {
    let spinner;

    function pageLoadSpinner() {
        if (spinner == null && !(spinner instanceof Spinner)) {
            spinner = new Spinner();
        }
        spinner.addPageLoadSpinner();
        document.onreadystatechange = async () => {
            if (document.readyState === "complete") {
                spinner.removePageLoadSpinner();
            }
        };
    }

    pageLoadSpinner();
}

callSpinner();