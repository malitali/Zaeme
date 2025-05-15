console.log("Hello from meine-events.js");

async function fetchMyEvents() {
  const userId = localStorage.getItem("user_id");
  if (!userId) {
    alert("Kein Benutzer angemeldet.");
    return;
  }

  try {
    const res = await fetch(`API/getMyEvents.php?user_id=${userId}`);
    const events = await res.json();

    const container = document.getElementById("event-list");
    container.innerHTML = "";

    if (events.length === 0) {
      container.innerHTML = "<p>Du hast noch keine Events zugesagt.</p>";
      return;
    }

    events.forEach((event) => {
      const eventCard = document.createElement("div");
      eventCard.className = "event-card";
      eventCard.innerHTML = `
        <h3>${event.titel}</h3>
        <p><strong>Ort:</strong> ${event.location}</p>
        <p><strong>Datum:</strong> ${event.datum}</p>
        <p><strong>Uhrzeit:</strong> ${event.uhrzeit}</p>
        <p><strong>Notizen:</strong> ${event.notizen}</p>
      `;
      container.appendChild(eventCard);
    });
  } catch (err) {
    console.error("Fehler beim Laden:", err);
  }
}

fetchMyEvents();

