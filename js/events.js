console.log("Hello from events.js");

async function fetchEvents() {
  try {
    const res = await fetch("./API/getEvents.php");
    const events = await res.json();
    console.log("Events aus Datenbank:", events);
    return events;
  } catch (err) {
    console.error("Fehler beim Laden der Events:", err);
    return [];
  }
}

async function displayEvents() {
  const events = await fetchEvents();
  const eventList = document.getElementById("event-list");

  if (!eventList) {
    console.error("Fehler: #event-list nicht gefunden.");
    return;
  }

  eventList.innerHTML = ""; // leeren

  if (events.length > 0) {
    events.forEach((event) => {
      const eventItem = document.createElement("section");
      eventItem.className = "event-card";

      const bildPfad = event.bild_url ? `uploads/${event.bild_url}` : "assets/placeholder.jpg";

      eventItem.innerHTML = `
        <div class="event-img-wrapper">
          <img src="${bildPfad}" alt="${event.titel}" class="event-img" />
        </div>
        <div class="event-details">
          <h3>${event.titel}</h3>
          <p class="event-info">
            <span class="icon">📍</span> ${event.location}<br />
            <span class="icon">📅</span> ${event.datum}<br />
            <span class="icon">🕒</span> ${event.uhrzeit}
          </p>
          <div class="organizer">
            <span>Organisiert von Nutzer ${event.organisator_id}</span>
          </div>
        </div>
      `;

      eventList.appendChild(eventItem);
    });
  } else {
    eventList.innerHTML = "<p>Keine Events gefunden.</p>";
  }
}

displayEvents();

