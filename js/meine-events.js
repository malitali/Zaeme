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
      const eventWrapper = document.createElement("a");
      eventWrapper.href = `event-detail.html?id=${event.event_id}`;
      eventWrapper.className = "event-card";

      eventWrapper.innerHTML = `
        <div class="event-img-wrapper">
          <img src="uploads/${event.bild_url}" alt="${event.titel}" class="event-img" />
        </div>
        <div class="event-details">
          <h3>${event.titel}</h3>
          <p class="event-info">
            <span class="icon">📍</span> ${event.location}<br />
            <span class="icon">📅</span> ${event.datum}<br />
            <span class="icon">🕘</span> ${event.uhrzeit}
          </p>
          <div class="organizer">
            <span>Organisiert von ${event.organisator_name}</span>
          </div>
        </div>
      `;

      container.appendChild(eventWrapper);
    });
  } catch (err) {
    console.error("Fehler beim Laden:", err);
  }
}

fetchMyEvents();

