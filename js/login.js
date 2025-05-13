console.log("Hello from login.js");

document.getElementById("loginForm").addEventListener("submit", async (e) => {
  e.preventDefault(); // Formular‑Reload verhindern

  // ► Eingabewerte aus den Feldern holen
  const loginInfo = document.querySelector("#username-email").value.trim();
  const password = document.querySelector("#password").value;

  console.log("loginInfo ist:", loginInfo);
  console.log("passwort ist:", password);

  // validate if fields are filled
  if (!loginInfo || !password) {
    alert("Bitte fülle alle Felder aus");
    return;
  }

  // check password length
  if (password.length < 8) {
    alert("Passwort muss mindestens 8 Zeichen lang sein");
    return;
  }

  // FormData füllt PHPs $_POST automatisch
  const formData = new FormData();
  formData.append("loginInfo", loginInfo);
  formData.append("password", password);

  // Fetch
  try {
    const res = await fetch("./API/login.php", {
      method: "POST",
      body: formData,
    });
    const reply = await res.text(); // login.php schickt nur Klartext zurück
    console.log("Antwort vom Server:\n" + reply);
    alert(reply);

    if (reply === "Login erfolgreich") {
      // redirect to protected.html
      window.location.href = "protected.html";
    }
  } catch (err) {
    console.error("Fehler beim Senden:", err);
  }
});
