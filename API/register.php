<?php
require_once('../system/config.php');

header('Content-Type: application/json; charset=UTF-8');

// ► Daten aus $_POST abgreifen
$username = $_POST['username'] ?? '';
$email    = $_POST['email']    ?? '';
$password = $_POST['password'] ?? '';

// Eingabe prüfen
if (empty($username) || empty($email) || empty($password)) {
    echo json_encode(["success" => false, "message" => "Bitte fülle alle Felder aus."]);
    exit;
}

if (strlen($password) < 8) {
    echo json_encode(["success" => false, "message" => "Passwort muss mindestens 8 Zeichen lang sein."]);
    exit;
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// prüfen ob user existiert
$stmt = $pdo->prepare("SELECT * FROM USER WHERE email = :email OR name = :username");
$stmt->execute([
    ':email' => $email,
    ':username' => $username
]);
$user = $stmt->fetch();

if ($user) {
    echo json_encode(["success" => false, "message" => "Username oder E-Mail bereits vergeben."]);
    exit;
}

// neuen User speichern
$insert = $pdo->prepare("INSERT INTO USER (email, name, passwort) VALUES (:email, :user, :pass)");
$success = $insert->execute([
    ':email' => $email,
    ':user' => $username,
    ':pass'  => $hashedPassword
]);

if ($success) {
    echo json_encode(["success" => true, "message" => "Registrierung erfolgreich"]);
} else {
    echo json_encode(["success" => false, "message" => "Registrierung fehlgeschlagen"]);
}

