console.log("Hello from Register JS!");

document.getElementById("registerForm").addEventListener("submit", async (e) => {
  e.preventDefault(); // Formular-Reload verhindern

  // Eingabewerte holen
  const username = document.querySelector("#username").value.trim();
  const email = document.querySelector("#email").value.trim();
  const password = document.querySelector("#password").value;

  if (!username || !email || !password) {
    alert("Bitte fülle alle Felder aus");
    return;
  }

  if (password.length < 8) {
    alert("Passwort muss mindestens 8 Zeichen lang sein");
    return;
  }

  const formData = new FormData();
  formData.append("username", username);
  formData.append("email", email);
  formData.append("password", password);

  try {
    const res = await fetch("./API/register.php", {
      method: "POST",
      body: formData,
    });

    const result = await res.json(); // Server gibt jetzt JSON zurück
    console.log("Antwort vom Server:", result);

    alert(result.message);

    if (result.success) {
      // ✅ Weiterleitung nach erfolgreicher Registrierung
      window.location.href = "index.html";
    }

  } catch (err) {
    console.error("Fehler beim Senden:", err);
    alert("Technischer Fehler bei der Registrierung.");
  }
});

