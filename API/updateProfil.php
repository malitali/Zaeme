<?php
require_once('../system/config.php');
session_start();
header('Content-Type: application/json; charset=UTF-8');

$userId = $_SESSION['user_id'] ?? null;
if (!$userId) {
    echo json_encode(['error' => 'Nicht eingeloggt']);
    exit;
}

$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$geburtstag = $_POST['geburtstag'] ?? '';

$sql = "UPDATE USER SET name = :name, email = :email, geburtstag = :geburtstag";
if ($profilbild_url) {
    $sql .= ", profilbild_url = :profilbild_url";
}
$sql .= " WHERE user_id = :user_id";

$stmt = $pdo->prepare($sql);

$params = [
    ':name' => $name,
    ':email' => $email,
    ':geburtstag' => $geburtstag,
    ':user_id' => $userId
];
if ($profilbild_url) {
    $params[':profilbild_url'] = $profilbild_url;
}

$stmt->execute($params);

echo json_encode(['success' => true]);
