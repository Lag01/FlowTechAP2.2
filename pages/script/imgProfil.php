<?php
session_start();

// Vérification de la session
if (!isset ($_SESSION['user_data'])) {
    header("Location: ../pages/connexion.php");
    exit();
} else {
    // Utilisez les données de session existantes au lieu de définir manuellement
    $pseudonyme = $_SESSION['user_data']['login'];
}

try {
    $pdo = new PDO("mysql:host=nc231.myd.infomaniak.com;dbname=nc231_flowtech", "nc231_flowtech", "Flowtech123");
} catch (Exception $e) {
    die ("Erreur de connexion à la base de données : " . $e->getMessage());
}

// Récupération de l'ancien nom de l'image profil
$getOldImgProfil = $pdo->prepare("SELECT imgProfil FROM Utilisateur WHERE login = ?");
$getOldImgProfil->execute([$pseudonyme]);
$oldImgProfilName = $getOldImgProfil->fetchColumn();

if ($oldImgProfilName) {
    echo "Nom de l'ancienne image récupéré depuis la base de données : " . $oldImgProfilName . "<br>";

    $uploadDir = realpath(dirname(__FILE__)) . '/imgUser/';
    $absolutePath = $uploadDir . $oldImgProfilName;
    if (!empty ($absolutePath) && file_exists($absolutePath)) {
        unlink($absolutePath);
        echo "Ancienne image supprimée avec succès.<br>";
    } else {
        echo "Aucune ancienne image à supprimer ou lien incorrect.<br>";
    }
} else {
    echo "Aucune ancienne image à supprimer, car le nom n'a pas été trouvé dans la base de données.<br>";
}

// Traitement de la photo de profil
if ($_FILES['photo']['error'] == UPLOAD_ERR_OK) {
    $uploadDir = realpath(dirname(__FILE__)) . '/imgUser/';
    $uploadFilename = basename($_FILES['photo']['name']);
    $uploadFile = $uploadDir . $uploadFilename;
    $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));

    // Vérifiez le type de fichier (vous pouvez ajouter d'autres formats supportés)
    if ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif") {
        // Déplacez le fichier téléchargé vers le dossier imgUser
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadFile)) {
            // Le fichier a été téléchargé avec succès
            echo "Le fichier a été déplacé avec succès.";

            $imgProfilName = $uploadFilename;
            echo "Nom du fichier image avant la mise à jour de la base de données : " . $imgProfilName . "<br>";

            // Mise à jour de la base de données avec le nouveau nom
            $updateImgProfil = $pdo->prepare("UPDATE Utilisateur SET imgProfil = ? WHERE login = ?");
            $updateImgProfil->execute([$imgProfilName, $pseudonyme]);

            echo "Mise à jour de la base de données effectuée avec succès.<br>";

            header("Location: ../profil.php?success=1&message=Mise à jour de la photo de profil réussie");
            exit();
        } else {
            // Il y a une erreur lors du déplacement du fichier
            echo "Erreur lors du déplacement du fichier. ";
            echo "Erreur PHP : " . $_FILES['photo']['error'];
        }
    } else {
        // Gestion d'un type de fichier non autorisé
        echo "Seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.";
    }
} else {
    // Gestion des erreurs lors du téléchargement du fichier
    echo "Erreur lors du téléchargement du fichier.";
}
