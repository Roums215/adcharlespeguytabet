<?php
// Récupérer les paramètres depuis l'URL
$prenom = isset($_GET['prenom']) ? htmlspecialchars($_GET['prenom']) : null;
$nom = isset($_GET['nom']) ? htmlspecialchars($_GET['nom']) : null;
$ou = isset($_GET['ou']) ? htmlspecialchars($_GET['ou']) : null;

if ($prenom && $nom && $ou) {
    // Générer l'identifiant et la commande AD
    $id = strtolower("{$nom}.{$prenom}");
    $adCommand = "dsadd user \"cn={$prenom} {$nom},OU={$ou},DC=example,DC=com\" "
        . "-samid \"{$id}\" -pwd \"defaultPassword123\" -disabled no -fn \"{$prenom}\" -ln \"{$nom}\" "
        . "-display \"{$prenom} {$nom}\"";
} else {
    $adCommand = "Paramètres manquants pour générer la commande.";
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Commandes AD</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            line-height: 1.6;
        }

        pre {
            background-color: #f9f9f9;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <h1>Commande AD pour <?= htmlspecialchars("{$prenom} {$nom}") ?></h1>
    <pre><?= $adCommand ?></pre>
    <a href="afficherUtilisateur.php">Retour à la liste des utilisateurs</a>
</body>

</html>