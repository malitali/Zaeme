console.log("Hello from events.js");

async function fetchEvents() {
  try {
    const res = await fetch("./API/getEvents.php");
    const events = await res.json();
    console.log("Events:", events);
    return events;
  } catch (err) {
    console.error("Fehler beim Abrufen der Events:", err);
  }
}

async function displayEvents() {
  const events = await fetchEvents();
  const eventList = document.getElementById("event-list");
  eventList.innerHTML = ""; // Clear existing events

  if (events && events.length > 0) {
    events.forEach((event) => {
      const eventItem = document.createElement("div");
      eventItem.className = "event-details";
      eventItem.innerHTML = `
        <h3>${event.titel}</h3>
        <p>${event.beschreibung}</p>
        <p>Datum: ${event.datum}</p>
        <p>Uhrzeit: ${event.location}</p>
      `;
      eventList.appendChild(eventItem);
    });
  } else {
    eventList.innerHTML = "<p>Keine Events gefunden.</p>";
  }
}
displayEvents();

