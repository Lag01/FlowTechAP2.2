<?php
session_start();

$login = filter_input(INPUT_POST, "login", FILTER_SANITIZE_STRING);
$mdp = password_hash($_POST["pass"], PASSWORD_DEFAULT);

try {
    $pdo = new PDO("mysql:host=nc231.myd.infomaniak.com;dbname=nc231_flowtech", "nc231_flowtech", "Flowtech123");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Pour activer les exceptions en cas d'erreur
} catch (Exception $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

$errors = array();

if (empty($login) or empty($mdp)) {
    $errors[] = "Veuillez saisir un login et un mot de passe.";
} else {
    // Requête SQL pour sélectionner l'utilisateur
    $sql = "SELECT * FROM Utilisateur WHERE login = :login";

    // Préparation de la requête
    $stmt = $pdo->prepare($sql);

    // Liaison des paramètres
    $stmt->bindParam(':login', $login, PDO::PARAM_STR);

    // Exécution de la requête
    try {
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Utilisateur trouvé, vous pouvez utiliser les données ici
            // Par exemple, pour afficher les données :
            echo "Nom d'utilisateur : " . $user['login'];
            // Vous pouvez accéder à d'autres champs de la même manière
        } else {
            $errors[] = "Utilisateur non trouvé.";
        }
    } catch (PDOException $e) {
        $errors[] = "Erreur lors de la recherche de l'utilisateur : " . $e->getMessage();
    }
}

// Traitement des erreurs
if (!empty($errors)) {
    foreach ($errors as $error) {
        echo $error . "<br>";
    }
}
?>
