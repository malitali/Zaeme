console.log("Hello from login.js");

document.getElementById("loginForm").addEventListener("submit", async (e) => {
  e.preventDefault(); // Formular‑Reload verhindern

  const loginInfo = document.querySelector("#username-email").value.trim();
  const password = document.querySelector("#password").value;

  console.log("loginInfo ist:", loginInfo);
  console.log("passwort ist:", password);

  if (!loginInfo || !password) {
    alert("Bitte fülle alle Felder aus");
    return;
  }

  if (password.length < 8) {
    alert("Passwort muss mindestens 8 Zeichen lang sein");
    return;
  }

  const formData = new FormData();
  formData.append("loginInfo", loginInfo);
  formData.append("password", password);

  try {
    const res = await fetch("./API/login.php", {
      method: "POST",
      body: formData,
    });

    const result = await res.json(); // JSON-Antwort verarbeiten
    console.log("Antwort vom Server:\n", result);
    alert(result.message);

    if (result.user_id) {
      localStorage.setItem("user_id", result.user_id);
      window.location.href = "index.html";
    } else {
      alert("Login fehlgeschlagen");
    }

  } catch (err) {
    console.error("Fehler beim Senden:", err);
    alert("Technischer Fehler beim Login");
  }
});



