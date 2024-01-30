<?php
session_start();

$login = filter_input(
    INPUT_POST,
    "login",
    FILTER_SANITIZE_STRING
);
$mdp = password_hash($_POST["pass"], PASSWORD_DEFAULT);

try {
    $pdo = new PDO("mysql:host=nc231.myd.infomaniak.com;dbname=nc231_flowtech", "nc231_flowtech", "Flowtech123");
} catch (Exception $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}



$errors = array();

if (empty($login) or empty($mdp)) {
    $errors[] = "Veuillez saisir un login et un mot de passe.";
} else {
    $checkUser = $pdo->prepare("SELECT * FROM Utilisateur WHERE login = ?");
    $checkUser->execute([$login]);

    $password = $_POST["pass"];
    if (strlen($password) < 8 || !preg_match("#[0-9]+#", $password) || !preg_match("#[a-zA-Z]+#", $password)) {
        $errors[] = "Le mot de passe ne respecte pas les critères de sécurité.";
    } else {
        if ($checkUser->rowCount() > 0) {
            $errors[] = "Ce nom d'utilisateur existe déjà.";
        } else {
            $ins = $pdo->prepare("INSERT INTO Utilisateur (login, pwd) VALUES(?, ?)");
            $ins->execute(array($login, $mdp));

            $_SESSION["user"] = $login;

            header("Location: ../profil.php");
            exit();
        }
    }
}

$_SESSION['errors'] = $errors;
header("Location: ../inscription.php");
exit();