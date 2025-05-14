<?php
// php/eventerstellen.php

session_start();

$host = 'ny9kvf.myd.infomaniak.com';
$db   = 'ny9kvf_zaemae';
$user = 'ny9kvf_zaemae';
$pass = 'IK.1d91lb-RTq_';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    error_log('DB-Verbindung fehlgeschlagen: ' . $e->getMessage());
    die('Verbindung fehlgeschlagen.');
}

// Benutzer-ID aus der Session
if (!isset($_SESSION['user_id'])) {
    die('Nicht eingeloggt');
}
$user_id = $_SESSION['user_id'];

// Validierung der Pflichtfelder
$required_fields = ['titel', 'location', 'uhrzeit', 'datum'];
foreach ($required_fields as $field) {
    if (empty($_POST[$field])) {
        die('Bitte alle Pflichtfelder ausfüllen.');
    }
}

// Bild speichern
if (!empty($_FILES['image']['name'])) {
    $uploadDir = '../uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    $imageName = basename($_FILES['image']['name']);
    $imagePath = $uploadDir . time() . '_' . $imageName;
    if (!move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
        error_log('Bild konnte nicht hochgeladen werden.');
        die('Fehler beim Hochladen des Bildes.');
    }
} else {
    $imagePath = '';
}

$titel = $_POST['titel'];
$location = $_POST['location'];
$uhrzeit = $_POST['uhrzeit'];
$notizen = $_POST['notizen'] ?? '';
$datum = $_POST['datum'];
$emails = $_POST['emails'] ?? [];

// Event speichern inkl. organisator_id
try {
    $sql = "INSERT INTO EVENT (organisator_id, titel, location, uhrzeit, notizen, datum, image) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id, $titel, $location, $uhrzeit, $notizen, $datum, $imagePath]);
    $event_id = $pdo->lastInsertId();
} catch (PDOException $e) {
    error_log('Fehler beim Einfügen des Events: ' . $e->getMessage());
    die('Fehler beim Speichern des Events.');
}

// Teilnehmer speichern (wenn vorhanden)
if (!empty($emails)) {
    try {
        $sqlTeilnehmer = "INSERT INTO EVENT_TEILNEHMER (event_id, user_id, status) SELECT ?, user_id, 'eingeladen' FROM USER WHERE email = ?";
        $stmtTeilnehmer = $pdo->prepare($sqlTeilnehmer);
        foreach ($emails as $email) {
            if (!empty($email)) {
                $stmtTeilnehmer->execute([$event_id, $email]);
            }
        }
    } catch (PDOException $e) {
        error_log('Fehler beim Einfügen der Teilnehmer: ' . $e->getMessage());
    }
}

// Erfolgsmeldung anzeigen
header('Location: ../home.html?success=1');
exit;
?>