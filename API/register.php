<?php
require_once('../system/config.php');

header('Content-Type: text/plain; charset=UTF-8');

// ► Daten aus $_POST abgreifen
$username = $_POST['username'] ?? '';
$email    = $_POST['email']    ?? '';
$password = $_POST['password'] ?? '';

// check if fields are filled
if (empty($username) || empty($email) || empty($password)) {
    echo "Bitte fülle alle Felder aus";
    exit;
}

// check if password is at least 8 characters long
if (strlen($password) < 8) {
    echo "Passwort muss mindestens 8 Zeichen lang sein";
    exit;
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// check if user already exists
$stmt = $pdo->prepare("SELECT * FROM USER WHERE email = :email OR name = :username");
$stmt->execute([
    ':email' => $email,
    ':username' => $username
]);
$user = $stmt->fetch();

if ($user) {
    echo "Username oder E-Mail bereits vergeben";
    exit;

} else {
    // insert new user
    $insert = $pdo->prepare("INSERT INTO USER (email, name, passwort) VALUES (:email, :user, :pass)");
    $insert->execute([
        ':email' => $email,
        ':user' => $username,
        ':pass'  => $hashedPassword
    ]);

    if ($insert) {
        echo "Registrierung erfolgreich";
    } else {
        echo "Registrierung fehlgeschlagen";
    }
}
