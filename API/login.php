<?php

require_once('../system/config.php');

header('Content-Type: application/json; charset=UTF-8');

$loginInfo = $_POST['loginInfo'] ?? '';
$password = $_POST['password'] ?? '';

// prüfen, ob Name oder E-Mail in der Datenbank vorhanden ist
$stmt = $pdo->prepare("SELECT * FROM USER WHERE email = :loginInfo OR name = :loginInfo");
$stmt->execute([':loginInfo' => $loginInfo]);
$user = $stmt->fetch();

if ($user) {
    // passwort prüfen
    if (password_verify($password, $user['passwort'])) {
        session_start();
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['name'];
        $_SESSION['email'] = $user['email'];

        echo json_encode([
            "status" => "success",
            "message" => "Login erfolgreich",
            "user_id" => $user['user_id']
        ]);
        exit;
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Passwort ist nicht korrekt"
        ]);
        exit;
    }
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Benutzername oder E-Mail nicht korrekt."
    ]);
    exit;
}



