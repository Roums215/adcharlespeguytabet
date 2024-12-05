<?php
// INFOS BASE DE DONNEE
$servername = "mysql-hamdaouirayan.alwaysdata.net";
$username = "351256";
$password = "Rayan13k14";
$dbname = "hamdaouirayan_tabet";

// INFOS UTILISATEURS
$nom = $_POST["nom"];
$prenom = $_POST["prenom"];
$email = $nom . "." . $prenom . "@charlespeguy.org";
$mot_de_passe = $_POST["motdepasse"];
$organizational_unit = $_POST["typeUser"];

// CONNECTION A LA BDD
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if (isset($_POST['validerInscrire'])) {
    $sql = "INSERT INTO users (first_name, last_name, email, password, organizational_unit) 
    VALUES ('$nom', '$prenom', '$email', '$mot_de_passe', '$organizational_unit')";
    if ($conn->query($sql) === TRUE) {
        echo "New user created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}
?>

