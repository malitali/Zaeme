console.log("protected.js geladen");

fetch("./API/protected.php")
  .then((response) => response.json())
  .then((data) => {
    console.log(data);

    if (data.status === "error") {
      // Weiterleitung zu login.html
      window.location.href = "login.html";
    } else {
      // Willkommensnachricht in HTML schreiben
      document.getElementById("welcome-message").innerHTML =
        "Willkommen " + data.username;
    }
  })
  .catch((error) => {
    console.error("Fehler beim Senden:",error);
  });
 