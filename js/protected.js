console.log("protected.js geladen");

// fetch
fetch("./API/protected.php")
  .then((response) => response.json())
  .then((data) => {
    console.log(data);

    if (data.status === "error") {
      // redirect to login.html
      window.location.href = "login.html";
    } else {
      // write welcome message to html
      document.getElementById("welcome-message").innerHTML =
        "Willkommen " + data.username;
    }
  })
  .catch((error) => {
    console.error("Fehler beim Senden:",error);
  });
 