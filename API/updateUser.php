<?php
require_once('../system/config.php');
header('Content-Type: text/plain; charset=UTF-8');
session_start();

$user_id = $_POST['user_id'] ?? '';
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$passwort = $_POST['passwort'] ?? null;
$geburtstag = $_POST['geburtstag'] ?? null;

if (!$user_id || !$name || !$email) {
    echo "Fehlende Daten.";
    exit;
}


// 📦 Passwort hashen (nur wenn ausgefüllt)
$updatePass = '';
$params = [
    ':user_id' => $user_id,
    ':name' => $name,
    ':email' => $email,
    ':geburtstag' => $geburtstag
];

if (!empty($passwort)) {
    $updatePass = ', passwort = :passwort';
    $params[':passwort'] = password_hash($passwort, PASSWORD_DEFAULT);
}


// 🛠️ Update ausführen
$sql = "UPDATE USER SET name = :name, email = :email, geburtstag = :geburtstag $updatePass $updateBild WHERE user_id = :user_id";
$stmt = $pdo->prepare($sql);
$success = $stmt->execute($params);

echo $success ? "Profil aktualisiert." : "Fehler beim Speichern.";
