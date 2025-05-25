console.log("Hello from eventerstellen.js!");

window.addEventListener("DOMContentLoaded", () => {
  const imageInput = document.getElementById("image");
  const uploadBox = document.getElementById("uploadBox");

  uploadBox.addEventListener("click", () => imageInput.click());

  imageInput.addEventListener("change", (e) => {
    const file = e.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function (event) {
        uploadBox.innerHTML = `<img src="${event.target.result}" alt="Preview" style="width:100%; height:100%; object-fit:cover; border-radius:10px;">`;
      };
      reader.readAsDataURL(file);
    }
  });

  document.getElementById("eventForm").addEventListener("submit", async (e) => {
    e.preventDefault();

    const titel = document.querySelector("#titel").value.trim();
    const location = document.querySelector("#location").value.trim();
    const uhrzeit = document.querySelector("#uhrzeit").value.trim();
    const datum = document.querySelector("#datum").value.trim();
    const notizen = document.querySelector("#notizen").value.trim();
    const image = imageInput.files[0];

    if (!titel || !location || !uhrzeit || !datum || !image) {
      alert("Bitte fülle alle Pflichtfelder aus und lade ein Bild hoch.");
      return;
    }

    const formData = new FormData();
    formData.append("titel", titel);
    formData.append("location", location);
    formData.append("uhrzeit", uhrzeit);
    formData.append("datum", datum);
    formData.append("notizen", notizen);
    formData.append("image", image);

    try {
      const res = await fetch("./API/eventerstellen.php", {
        method: "POST",
        body: formData,
      });

      const reply = await res.text();
      console.log("Antwort vom Server:", reply);

      // Erfolgsmeldung anzeigen
      alert("Event wurde erfolgreich erstellt!");

      // Auf der Seite bleiben + Formular leeren
      document.getElementById("eventForm").reset();
      uploadBox.innerHTML = `<label for="image">📷</label>`;
    } catch (err) {
      console.error("Fehler beim Senden:", err);
      alert("Fehler beim Senden des Formulars.");
    }
  });
});




