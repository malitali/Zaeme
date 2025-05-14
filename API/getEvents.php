<?php

require_once('../system/config.php');

header('Content-Type: text/plain; charset=UTF-8');


// check if name or email is in database
$sql = "SELECT * FROM EVENT";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$events = $stmt->fetchAll();

echo json_encode($events);

