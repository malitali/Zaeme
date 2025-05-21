console.log("profil.js geladen");

const userId = localStorage.getItem("user_id");

if (!userId) {
  alert("Nicht eingeloggt.");
  window.location.href = "login.html";
}

async function loadProfile() {
  try {
    const res = await fetch(`API/getUser.php?id=${userId}`);
    const user = await res.json();

    if (user.error) {
      alert(user.error);
      return;
    }

    document.getElementById("name").value = user.name;
    document.getElementById("email").value = user.email;
    document.getElementById("geburtstag").value = user.geburtstag || "";

    if (user.profilbild) {
      document.getElementById("profilbildPreview").src = `uploads/${user.profilbild}`;
    }
  } catch (err) {
    console.error("Fehler beim Laden des Profils:", err);
  }
}

document.getElementById("profilbild").addEventListener("change", (e) => {
  const file = e.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = function (event) {
      document.getElementById("profilbildPreview").src = event.target.result;
    };
    reader.readAsDataURL(file);
  }
});

document.getElementById("profilForm").addEventListener("submit", async (e) => {
  e.preventDefault();

  const formData = new FormData(e.target);
  formData.append("user_id", userId);

  try {
    const res = await fetch("API/updateUser.php", {
      method: "POST",
      body: formData
    });

    const reply = await res.text();
    alert(reply);
  } catch (err) {
    console.error("Fehler beim Speichern:", err);
  }
});

loadProfile();
