<?php
// INFOS BASE DE DONNEES
$servername = "mysql-hamdaouirayan.alwaysdata.net";
$username = "351256";
$password = "Rayan13k14";
$dbname = "hamdaouirayan_tabet";

// CONNECTION A LA BDD
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Traiter les données du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['validerInscrire'])) {
    $stmt = $conn->prepare("INSERT INTO users (id, first_name, last_name, email, password, organizational_unit) VALUES (?, ?, ?, ?, ?, ?)");

    // Vérifiez si la préparation a réussi
    if (!$stmt) {
        die("Erreur dans la requête : " . $conn->error);
    }

    // Récupérer les données envoyées par le formulaire
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $id = $nom . "." . $prenom;
    $email = $id . "@charlespeguy.org";
    $mot_de_passe = $_POST["motdepasse"];
    $organizational_unit = $_POST["typeUser"];

    $stmt->bind_param("ssssss", $id, $nom, $prenom, $email, $mot_de_passe, $organizational_unit);

    if ($stmt->execute()) {
        echo "Compte créé avec succès pour $prenom $nom.";
    } else {
        echo "Erreur : " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
