<?php
require_once('../system/config.php');

header('Content-Type: text/plain; charset=UTF-8');

$event_id = $_POST['event_id'] ?? '';
$user_id = $_POST['user_id'] ?? '';
$status = $_POST['status'] ?? '';

// prüfen ob schon existiert
$stmt = $pdo->prepare("SELECT * FROM EVENT_TEILNEHMER WHERE event_id = :event_id AND user_id = :user_id");
$stmt->execute(['event_id' => $event_id, 'user_id' => $user_id]);
$exists = $stmt->fetch();

if ($exists) {
    // Update
    $stmt = $pdo->prepare("UPDATE EVENT_TEILNEHMER SET status = :status WHERE event_id = :event_id AND user_id = :user_id");
    $stmt->execute(['status' => $status, 'event_id' => $event_id, 'user_id' => $user_id]);
    echo "Status aktualisiert.";
} else {
    // Insert
    $stmt = $pdo->prepare("INSERT INTO EVENT_TEILNEHMER (event_id, user_id, status) VALUES (:event_id, :user_id, :status)");
    $stmt->execute(['event_id' => $event_id, 'user_id' => $user_id, 'status' => $status]);
    echo "Teilnahme gespeichert.";
}


