<?php
session_start();

$prenom = filter_input(INPUT_POST, "Prenom", FILTER_SANITIZE_STRING);
$nom = filter_input(INPUT_POST, "Nom", FILTER_SANITIZE_STRING);
$date_naissance = filter_input(INPUT_POST, "dateNaissance", FILTER_SANITIZE_STRING);
$adresse = filter_input(INPUT_POST, "Adresse", FILTER_SANITIZE_STRING);
$numero_telephone = filter_input(INPUT_POST, "numTelephone", FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
$login = filter_input(INPUT_POST, "login", FILTER_SANITIZE_STRING);
$mdp = password_hash($_POST["pwd"], PASSWORD_DEFAULT);

try {
    $pdo = new PDO("mysql:host=nc231.myd.infomaniak.com;dbname=nc231_flowtech", "nc231_flowtech", "Flowtech123");
} catch (Exception $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

$errors = array();

if (empty($prenom) || empty($nom) || empty($date_naissance) || empty($adresse) || empty($numero_telephone) || empty($email) || empty($login) || empty($mdp)) {
    $errors[] = "Veuillez remplir tous les champs.";
} else {
    $checkUser = $pdo->prepare("SELECT * FROM Utilisateur WHERE login = ?");
    $checkUser->execute([$login]);

    $password = $_POST["pwd"];
    if (strlen($password) < 8 || !preg_match("#[0-9]+#", $password) || !preg_match("#[a-zA-Z]+#", $password)) {
        $errors[] = "Le mot de passe ne respecte pas les critères de sécurité.";
    } else {
        if ($checkUser->rowCount() > 0) {
            $errors[] = "Ce nom d'utilisateur existe déjà.";
        } else {
            $ins = $pdo->prepare("INSERT INTO Utilisateur (Prenom, Nom, dateNaissance, Adresse, numTelephone, email, login, pwd) VALUES(?, ?, ?, ?, ?, ?, ?, ?)");
            $ins->execute(array($prenom, $nom, $date_naissance, $adresse, $numero_telephone, $email, $login, $mdp));

            $_SESSION["user"] = $login;

            header("Location: ../profil.php");
            exit();
        }
    }
}

$_SESSION['errors'] = $errors;
header("Location: ../inscription.php");
exit();