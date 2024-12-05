<?php
// Activer l'affichage des erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// INFOS BASE DE DONNEES
$servername = "mysql-hamdaouirayan.alwaysdata.net";
$username = "351256";
$password = "Rayan13k14";
$dbname = "hamdaouirayan_tabet";

// CONNECTION A LA BDD
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Traiter le fichier CSV
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['csvFile'])) {
    $fileTmpPath = $_FILES['csvFile']['tmp_name'];

    // Ouvrir le fichier CSV
    if (($handle = fopen($fileTmpPath, 'r')) !== false) {
        // Lire l'en-tête (première ligne)
        $headers = fgetcsv($handle, 1000, ',');

        // Vérifier si l'application AD existe
        $appSql = "SELECT id FROM applications WHERE name = 'AD'";
        $appResult = $conn->query($appSql);
        $adApplicationId = $appResult->fetch_assoc()['id'] ?? null;

        if (!$adApplicationId) {
            echo "Erreur : L'application AD n'existe pas.";
            exit;
        }

        echo "<h2>Instructions pour créer les comptes AD</h2>";

        // Lire chaque ligne du fichier CSV
        while (($data = fgetcsv($handle, 1000, ',')) !== false) {
            $nom = trim($data[0]);
            $prenom = trim($data[1]);
            $organizationalUnit = trim($data[2]); // Par exemple : Classe ou Département
            $id = strtolower($nom . "." . $prenom);
            $email = $id . "@charlespeguy.org";
            $motDePasse = password_hash("defaultPassword123", PASSWORD_BCRYPT); // Mot de passe par défaut

            // Insérer l'utilisateur dans la table `users`
            $stmt = $conn->prepare("INSERT INTO users (id, first_name, last_name, email, password, organizational_unit) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $id, $prenom, $nom, $email, $motDePasse, $organizationalUnit);

            if ($stmt->execute()) {
                // Assigner l'utilisateur à l'application AD
                $userId = $id;
                $assignStmt = $conn->prepare("INSERT INTO user_applications (user_id, application_id, permissions) VALUES (?, ?, ?)");
                $permissions = "student"; // Permissions par défaut pour les élèves
                $assignStmt->bind_param("sis", $userId, $adApplicationId, $permissions);
                $assignStmt->execute();

                // Générer l'instruction AD
                $adCommand = "dsadd user \"cn={$prenom} {$nom},OU={$organizationalUnit},DC=example,DC=com\" "
                    . "-samid \"{$id}\" -pwd \"defaultPassword123\" -disabled no -fn \"{$prenom}\" -ln \"{$nom}\" "
                    . "-display \"{$prenom} {$nom}\"";

                // Afficher l'instruction AD
                echo "<p>Utilisateur <strong>{$prenom} {$nom}</strong> :</p>";
                echo "<pre>$adCommand</pre>";
            } else {
                echo "<p>Erreur lors de l'ajout de l'utilisateur : {$prenom} {$nom}.</p>";
            }
        }

        fclose($handle);
    } else {
        echo "Erreur lors de l'ouverture du fichier CSV.";
    }
} else {
    echo "Aucun fichier CSV téléchargé.";
}

$conn->close();
?>
