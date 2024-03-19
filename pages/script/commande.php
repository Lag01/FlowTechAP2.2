<?php
session_start();

// Vérifier si le panier est non vide
if (isset ($_SESSION['panier']) && !empty ($_SESSION['panier'])) {
    // Connexion à la base de données
    try {
        $pdo = new PDO("mysql:host=nc231.myd.infomaniak.com;dbname=nc231_flowtech", "nc231_flowtech", "Flowtech123");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die ("Erreur de connexion à la base de données : " . $e->getMessage());
    }

    // Récupérer l'utilisateur connecté
    $utilisateur = $_SESSION['user_data']['login'];

    // Insérer la commande dans la base de données
    $insertCommande = $pdo->prepare("INSERT INTO Commande (dateCommande, idUtilisateur) VALUES (NOW(), ?)");
    $insertCommande->execute([$utilisateur]);
    $lastInsertedId = $pdo->lastInsertId();

    // Insérer les détails de chaque produit dans la commande
    $insertDetailsCommande = $pdo->prepare("INSERT INTO AssociationPanier (idCommande, idPc, Quantite) VALUES (?, ?, ?)");
    foreach ($_SESSION['panier'] as $produit) {
        $produitId = $produit['id'];
        $produitQuantite = $produit['quantite'];
        $insertDetailsCommande->execute([$lastInsertedId, $produitId, $produitQuantite]);
    }

    // Effacer le panier une fois la commande passée
    unset($_SESSION['panier']);

    // Rediriger vers la page de confirmation
    header("Location: confirmation.php");
    exit();
} else {
    // Si le panier est vide, rediriger vers la page d'accueil
    header("Location: index.php");
    exit();
}
