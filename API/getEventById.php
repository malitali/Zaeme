<?php
require_once('../system/config.php');
header('Content-Type: application/json; charset=UTF-8');

$eventId = $_GET['id'] ?? null;

if (!$eventId) {
  echo json_encode(["error" => "Kein Event ID übergeben."]);
  exit;
}

$sql = "SELECT 
            e.*, 
            e.Uhrzeit AS uhrzeit,              
            u.name AS organisator_name         
        FROM EVENT e 
        JOIN USER u ON e.organisator_id = u.user_id 
        WHERE e.event_id = :id";

$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $eventId]);
$event = $stmt->fetch(PDO::FETCH_ASSOC);

if ($event) {
  echo json_encode($event);
} else {
  echo json_encode(["error" => "Event nicht gefunden."]);
}






