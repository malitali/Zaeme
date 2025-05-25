<?php
require_once('../system/config.php');

header('Content-Type: application/json; charset=UTF-8');

$user_id = $_GET['user_id'] ?? '';

if (!$user_id) {
    echo json_encode(["error" => "Kein Benutzer angegeben"]);
    exit;
}

$sql = "SELECT 
            e.*, 
            e.Uhrzeit AS uhrzeit,
            u.name AS organisator_name
        FROM EVENT e
        JOIN EVENT_TEILNEHMER et ON e.event_id = et.event_id
        JOIN USER u ON e.organisator_id = u.user_id
        WHERE et.user_id = :user_id AND et.status = 'ja'
        ORDER BY e.created_at DESC";  // 🔁 Neueste Events zuerst

$stmt = $pdo->prepare($sql);
$stmt->execute(['user_id' => $user_id]);

$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($events);





