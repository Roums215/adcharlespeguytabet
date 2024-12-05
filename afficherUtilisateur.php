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
    <title>
        Liste des utilisateurs
    </title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin: 20px auto;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>

<body>
    <h1>
        Liste des utilisateurs
    </h1>
    <table>
        <thead>
            <thead>
                <tr>
                    <th>
                        ID
                    </th>
                    <th>
                        Prénom
                    </th>
                    <th>
                        Nom
                    </th>
                    <th>
                        Email
                    </th>
                    <th>
                        Mot de passe
                    </th>
                    <th>
                        Statut
                    </th>
                    <th>
                        Instructions
                    </th>
                    <th>
                        Unité Organisationnelle
                    </th>
                    <th>
                        Créé le
                    </th>
                    <th>
                        Mise à jour le
                    </th>
                </tr>
            </thead>
        <tbody
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
    <a href="index.php">Retour à la page d'inscription</a>
    </br>
    <a href="csv.html">CSV</a>
</body>

</html>