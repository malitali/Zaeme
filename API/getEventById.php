<?php
require_once('../system/config.php');
header('Content-Type: application/json; charset=UTF-8');

$eventId = $_GET['id'] ?? null;

if (!$eventId) {
  echo json_encode(["error" => "Kein Event ID übergeben."]);
  exit;
}

$stmt = $pdo->prepare("SELECT * FROM EVENT WHERE event_id = :id");
$stmt->execute([':id' => $eventId]);
$event = $stmt->fetch(PDO::FETCH_ASSOC);

if ($event) {
  echo json_encode($event);
} else {
  echo json_encode(["error" => "Event nicht gefunden."]);
}


