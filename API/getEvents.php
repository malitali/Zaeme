<?php
header('Content-Type: application/json; charset=UTF-8');
require_once('../system/config.php');

try {
    $sql = "SELECT 
                e.*, 
                e.Uhrzeit AS uhrzeit,
                u.name AS organisator_name
            FROM EVENT e 
            JOIN USER u ON e.organisator_id = u.user_id
            ORDER BY e.created_at DESC";  

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($events);
} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()]);
}





