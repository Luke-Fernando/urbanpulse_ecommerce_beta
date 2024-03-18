class Connection {
  constructor() {}

  log() {
    console.log("Connection");
  }

  post(values, location) {
    return new Promise((resolve) => {
      let request = new XMLHttpRequest();
      let form = new FormData();

      for (let value of values) {
        form.append(value["name"], value["data"]);
      }

      request.onreadystatechange = () => {
        if (request.status == 200 && request.readyState == 4) {
          let response = request.responseText;
          resolve(response);
        }
      };

      request.open("POST", location, true);
      request.send(form);
    });
  }
}

export default Connection;
