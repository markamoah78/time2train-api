<?php
header("Content-Type: application/json");

include "index.php";

$user = $_POST['nomdutilisateur'] ?? '';
$pass = $_POST['password'] ?? '';

if (!$user || !$pass) {
    echo json_encode(["success" => false, "message" => "Champs manquants"]);
    exit;
}

$req = $bdd->prepare("SELECT * FROM users WHERE nomdutilisateur = :user");
$req->execute(['user' => $user]);
$rep = $req->fetch(PDO::FETCH_ASSOC);

if ($rep && $rep['password'] === $pass) {
    echo json_encode([
        "success" => true,
        "message" => "Connexion réussie",
        "user" => [
            "id" => $rep["id"],
            "role" => $rep["role"]
        ]
    ]);
} else {
    echo json_encode(["success" => false, "message" => "Identifiants incorrects"]);
}