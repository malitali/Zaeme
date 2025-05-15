<?php
// Fehler anzeigen (nur für Entwicklung – später entfernen!)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('../system/config.php');
session_start();
header('Content-Type: text/plain; charset=UTF-8');

// 🔒 Nutzer-Check: nur eingeloggte dürfen Events erstellen
$organisator_id = $_SESSION['user_id'] ?? null;
if (!$organisator_id) {
    echo "Fehler: Du musst eingeloggt sein.";
    exit;
}

// 📥 Eingabedaten aus Formular
$titel    = $_POST['titel']     ?? '';
$location = $_POST['location']  ?? '';
$uhrzeit  = $_POST['uhrzeit']   ?? '';
$datum    = $_POST['datum']     ?? '';
$notizen  = $_POST['notizen']   ?? '';
$image_id  = $_POST['image_id']   ?? '';

// ❗Pflichtfeld-Check
if (empty($titel) || empty($location) || empty($uhrzeit) || empty($datum)) {
    echo "Bitte fülle alle Pflichtfelder aus.";
    exit;
}

// 📷 Bild speichern
$bildName = null;
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = '../uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true); // Ordner erstellen, falls er nicht existiert
    }

    $originalName = basename($_FILES['image']['name']);
    $bildName = uniqid("event_") . "_" . $originalName;
    $zielPfad = $uploadDir . $bildName;

    if (!move_uploaded_file($_FILES['image']['tmp_name'], $zielPfad)) {
        echo "Bild konnte nicht gespeichert werden.";
        exit;
    }
}

// 🛠️ Optional: Wenn du das Bild später anzeigen willst → auch in DB speichern
// Du brauchst dann eine Spalte `bild_url` in der Tabelle EVENT
// Beispiel: ALTER TABLE EVENT ADD bild_url VARCHAR(255);

// 📤 In Datenbank speichern
$sql = "INSERT INTO EVENT (titel, datum, location, notizen, organisator_id, uhrzeit, bild_url)
        VALUES (:titel, :datum, :location, :notizen, :organisator_id, :uhrzeit, :bild_url)";
$stmt = $pdo->prepare($sql);

$erfolg = $stmt->execute([
    ':titel' => $titel,
    ':datum' => $datum,
    ':location' => $location,
    ':notizen' => $notizen,
    ':organisator_id' => $organisator_id,
    ':uhrzeit' => $uhrzeit,
    ':bild_url' => $bildName
]);


if ($erfolg) {
    echo "Event wurde erfolgreich erstellt.";
} else {
    $errorInfo = $stmt->errorInfo();
    echo "Fehler beim Erstellen des Events: " . $errorInfo[2];
}

