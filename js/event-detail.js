document.addEventListener("DOMContentLoaded", () => {
  loadEventDetails();

  document.getElementById("btn-yes").addEventListener("click", () => {
    respondToEvent("ja");
  });

  document.getElementById("btn-no").addEventListener("click", () => {
    respondToEvent("nein");
  });
});

async function loadEventDetails() {
  const params = new URLSearchParams(window.location.search);
  const eventId = params.get("id");
  if (!eventId) return;

  try {
    const res = await fetch(`API/getEventById.php?id=${eventId}`);
    const event = await res.json();

    const container = document.getElementById("event-details");

    if (event.error) {
      container.innerHTML = `<p>${event.error}</p>`;
      return;
    }

    container.innerHTML = `
    <div class="event-img-wrapper">
  <img src="uploads/${event.bild_url}" alt="${event.titel}" class="event-img" />
</div>

    <h2>${event.titel}</h2>
    <div class="event-info">
      <div class="icon-text"><span class="icon">📍</span> ${event.location}</div>
      <div class="icon-text"><span class="icon">📅</span> ${event.datum}</div>
      <div class="icon-text"><span class="icon">🕘</span> ${event.uhrzeit}</div>
    </div>
    <div class="event-note">${event.notizen}</div>
    <div class="organizer">
      Organisiert von ${event.organisator_name}
    </div>
    <div class="question"><strong>Bist du dabei?</strong></div>
  `;
  
  } catch (err) {
    console.error("Fehler beim Laden:", err);
  }
}

async function respondToEvent(status) {
  const eventId = new URLSearchParams(window.location.search).get("id");
  const userId = localStorage.getItem("user_id");

  const formData = new FormData();
  formData.append("event_id", eventId);
  formData.append("user_id", userId);
  formData.append("status", status);

  try {
    await fetch("API/respondEvent.php", {
      method: "POST",
      body: formData
    });
    alert("Antwort gespeichert!");
  } catch (err) {
    console.error("Fehler bei Antwort:", err);
  }
}



  