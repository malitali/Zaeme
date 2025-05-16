<?php
require_once('../system/config.php');

header('Content-Type: application/json; charset=UTF-8');

$user_id = $_GET['user_id'] ?? '';

if (!$user_id) {
    echo json_encode(["error" => "Kein Benutzer angegeben"]);
    exit;
}

$sql = "SELECT e.* 
        FROM EVENT e 
        JOIN EVENT_TEILNEHMER et ON e.event_id = et.event_id 
        WHERE et.user_id = :user_id AND et.status = 'ja'";

$stmt = $pdo->prepare($sql);
$stmt->execute(['user_id' => $user_id]);

$events = $stmt->fetchAll(PDO::FETCH_ASSOC);  // 👈 assoziatives Array für Zugriff via event['bild_url']

echo json_encode($events);

