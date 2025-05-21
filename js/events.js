console.log("Hello from events.js");

async function fetchEvents() {
  try {
    const res = await fetch("./API/getEvents.php");
    const events = await res.json();
    console.log("Events:", events);
    return events;
  } catch (err) {
    console.error("Fehler beim Laden der Events:", err);
  }
}

async function displayEvents() {
  const events = await fetchEvents();
  const eventList = document.getElementById("event-list");
  eventList.innerHTML = "";

  if (events && events.length > 0) {
    events.forEach((event) => {
      const eventItem = document.createElement("div");
      eventItem.className = "event-card-wrapper";
      eventItem.innerHTML = `
        <a href="event-detail.html?id=${event.event_id}">
          <div class="event-card">
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
          </div>
        </a>
      `;
      eventList.appendChild(eventItem);
    });
  } else {
    eventList.innerHTML = "<p>Keine Events gefunden.</p>";
  }
}

displayEvents();


