<?php
$servername = "mysql-hamdaouirayan.alwaysdata.net";
$username = "351256";
$password = "Rayan13k14";
$dbname = "hamdaouirayan_tabet";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT * FROM users";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des utilisateurs</title>
    <style>
        body {
            background-color: black;
            color: white;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        h1 {
            margin: 20px 0;
        }

        table {
            border-collapse: collapse;
            width: 90%;
            margin: 20px auto;
            color: white;
        }

        th, td {
            border: 1px solid #444;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #222;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #333;
        }

        tr:hover {
            background-color: #444;
        }

        a {
            color: #fff;
            text-decoration: none;
            /* border: 1px solid #fff;
            padding: 5px 10px;
            border-radius: 5px; */
        }

        a:hover {
            font-weight: 500;
        }
    </style>
</head>

<body>
    <h1>Liste des utilisateurs</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Prénom</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Mot de passe</th>
                <th>Statut</th>
                <th>Instructions</th>
                <th>Unité Organisationnelle</th>
                <th>Créé le</th>
                <th>Mise à jour le</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= htmlspecialchars($user['id']) ?></td>
                <td><?= htmlspecialchars($user['first_name']) ?></td>
                <td><?= htmlspecialchars($user['last_name']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td><?= htmlspecialchars($user['password']) ?></td>
                <td><?= htmlspecialchars($user['ad_status']) ?></td>
                <td>
                    <a href="afficherCommandeAD.php?prenom=<?= urlencode($user['first_name']) ?>&nom=<?= urlencode($user['last_name']) ?>&ou=<?= urlencode($user['organizational_unit']) ?>">
                        Afficher les instructions
                    </a>
                </td>
                <td><?= htmlspecialchars($user['organizational_unit']) ?></td>
                <td><?= htmlspecialchars($user['created_at']) ?></td>
                <td><?= htmlspecialchars($user['updated_at']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div>
        <a href="index.php">Retour à la page d'inscription</a>
        <br><br>
        <a href="csv.html">CSV</a>
    </div>
</body>

</html>
