<?php

require_once('../system/config.php');

header('Content-Type: text/plain; charset=UTF-8');

$loginInfo = $_POST['loginInfo'] ?? '';
$password = $_POST['password'] ?? '';

// check if name or email is in database
$stmt = $pdo->prepare("SELECT * FROM USER WHERE email = :loginInfo OR name = :loginInfo");
$stmt->execute([':loginInfo' => $loginInfo]);
$user = $stmt->fetch();

if ($user) {

    // passwort prüfen
    if (password_verify($password, $user['passwort'])) {
        echo "Login erfolgreich";

        // session starten
        session_start();
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['name'];
        $_SESSION['email'] = $user['email'];

    } else {
        echo "Passwort ist nicht korrekt";
    }

} else {
    echo "Benutzername oder E-Mail nicht korrekt.";
}


