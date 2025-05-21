<?php
header('Content-Type: application/json; charset=UTF-8');
require_once('../system/config.php');

try {
    $sql = "SELECT 
                e.*, 
                e.Uhrzeit AS uhrzeit,         -- Alias für JS
                u.name AS organisator_name    -- Name des Organisators
            FROM EVENT e 
            JOIN USER u ON e.organisator_id = u.user_id";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($events);
} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()]);
}



