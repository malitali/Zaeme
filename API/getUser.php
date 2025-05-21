<?php
require_once('../system/config.php');
header('Content-Type: application/json; charset=UTF-8');

$user_id = $_GET['id'] ?? null;
if (!$user_id) {
  echo json_encode(["error" => "Keine ID gegeben"]);
  exit;
}

$stmt = $pdo->prepare("SELECT user_id, name, email, geburtstag FROM USER WHERE user_id = :id");
$stmt->execute(['id' => $user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
  echo json_encode($user);
} else {
  echo json_encode(["error" => "Benutzer nicht gefunden"]);
}