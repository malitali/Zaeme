<?php
header('Content-Type: application/json; charset=UTF-8');
require_once('../system/config.php');

try {
    $stmt = $pdo->prepare("SELECT * FROM EVENT");
    $stmt->execute();
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC); // wichtig!
    echo json_encode($events);
} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()]);
}

