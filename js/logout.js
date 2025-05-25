document
  .getElementById("logout-button")
  .addEventListener("click", async (e) => {
    // Verhindert das Standardverhalten der Schaltfläche
    e.preventDefault();

    try {
      const response = await fetch("./API/logout.php", {
        method: "GET",
        credentials: "include",
      });

      const result = await response.json();

      if (result.status === "success") {
        // Nach erfolgreicher Abmeldung zur Anmeldeseite weiterleiten
        window.location.href = "login.html";
      } else {
        console.error("Logout failed");
        alert("Logout failed. Please try again.");
      }
    } catch (error) {
      console.error("Logout error:", error);
      alert("Something went wrong during logout!");
    }
  });