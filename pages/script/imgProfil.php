<?php
session_start();

if (!isset($_SESSION['user_data'])) {
    header("Location: ../pages/connexion.php");
    exit();
} else {
    // Pour le moment, je définis une session manuellement (à remplacer par vos données utilisateur)
    $_SESSION['prenom'] = 'Martin';
    $_SESSION['nom'] = 'Pêcheur';
    $_SESSION['pseudo'] = 'Pêcheur';
    $_SESSION['email'] = 'martinpecheur@gmail.com';
    $_SESSION['telephone'] = '0123456789';
    $_SESSION['Adresse'] = '4 rue de la rue';
}

$prenom = $_SESSION['user_data']['Prenom'];
$nom = $_SESSION['user_data']['Nom'];
$pseudonyme = $_SESSION['user_data']['login'];
$email = $_SESSION['user_data']['email'];
$telephone = $_SESSION['user_data']['numTelephone'];
$adresse = $_SESSION['user_data']['Adresse'];

// Traitement de la photo de profil
if ($_FILES['photo']['error'] == UPLOAD_ERR_OK) {
    $uploadDir = '../imgUser/';
    $uploadFile = $uploadDir . basename($_FILES['photo']['name']);
    $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));

    // Vérifiez le type de fichier (vous pouvez ajouter d'autres formats supportés)
    if ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif") {
        // Déplacez le fichier téléchargé vers le dossier imgUser
        move_uploaded_file($_FILES['photo']['tmp_name'], $uploadFile);

        // Insérez le lien du fichier dans la base de données
        $imgProfilLink = 'imgUser/' . basename($_FILES['photo']['name']);

        // Ajoutez votre code pour vous connecter à la base de données et effectuer la mise à jour
        try {
            $pdo = new PDO("mysql:host=nc231.myd.infomaniak.com;dbname=nc231_flowtech", "nc231_flowtech", "Flowtech123");
        } catch (Exception $e) {
            die("Erreur de connexion à la base de données : " . $e->getMessage());
        }

        $updateImgProfil = $pdo->prepare("UPDATE Utilisateur SET imgProfil = ? WHERE login = ?");
        $updateImgProfil->execute([$imgProfilLink, $pseudonyme]);

        // Redirection profil.php
        header("Location: profil.php");
        exit();
    } else {
        // Gestion d'un type de fichier non autorisé
        echo "Seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.";
    }
} else {
    // Gestion des erreurs lors du téléchargement du fichier
    echo "Erreur lors du téléchargement du fichier.";
}
