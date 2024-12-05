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

// Fonction pour générer un mot de passe aléatoire
function generateRandomPassword($length = 12)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()_+-=[]{}|;:,.<>?';
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $password .= $characters[random_int(0, strlen($characters) - 1)];
    }
    return $password;
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
    $id = $prenom . "." . $nom;
    $email = $id . "@charlespeguy.org";
    $mot_de_passe = generateRandomPassword(12);  // Génération d'un mot de passe aléatoire
    $organizational_unit = $_POST["typeUser"];

    // Préparer la requête avec les paramètres
    $stmt->bind_param("ssssss", $id, $nom, $prenom, $email, $mot_de_passe, $organizational_unit);

    // Exécution de la requête
    if ($stmt->execute()) {
        echo "Compte créé avec succès pour $prenom $nom. Le mot de passe généré est : $mot_de_passe";
    } else {
        echo "Erreur : " . $stmt->error;
    }

    // Fermer la déclaration
    $stmt->close();
}

// Fermer la connexion
$conn->close();
?>

