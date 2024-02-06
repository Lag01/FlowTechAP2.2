<?php
session_start();

if (!isset($_SESSION['user_data'])) {
    header("Location: ../pages/connexion.php");
    exit();
}

$prenom = $_SESSION['user_data']['Prenom'];
$nom = $_SESSION['user_data']['Nom'];
$pseudonyme = $_SESSION['user_data']['login'];
$email = $_SESSION['user_data']['email'];
$telephone = $_SESSION['user_data']['numTelephone'];
$adresse = $_SESSION['user_data']['Adresse'];
$sexe = $_SESSION['user_data']['Sexe']; // Récupération du sexe de l'utilisateur

try {
    // Connexion à la base de données
    $pdo = new PDO("mysql:host=nc231.myd.infomaniak.com;dbname=nc231_flowtech", "nc231_flowtech", "Flowtech123");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupérer l'ID de l'utilisateur à partir de la session
    $idUtilisateur = $_SESSION['user_data']['idUtilisateur'];

    // Requête pour récupérer les commandes de l'utilisateur avec les détails de quantité
    $getCommandes = $pdo->prepare("
        SELECT 
            Commande.*, 
            AssociationPanier.quantite 
        FROM 
            Commande 
        INNER JOIN 
            AssociationPanier 
        ON 
            Commande.idCommande = AssociationPanier.idCommande
        WHERE 
            Commande.idUtilisateur = ?");
    $getCommandes->execute([$idUtilisateur]);
    $commandes = $getCommandes->fetchAll(PDO::FETCH_ASSOC);

    // Requête pour récupérer le chemin de la photo de profil
    $getImgProfil = $pdo->prepare("SELECT imgProfil FROM Utilisateur WHERE login = ?");
    $getImgProfil->execute([$pseudonyme]);
    $imgProfilLink = $getImgProfil->fetchColumn();
} catch (Exception $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}


?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Profile - FlowTech</title>
    <meta name="description" content="FlowTech, surement les meilleurs PC du marchÃ©!" />
    <link rel="icon" type="image/x-icon" href="../img/logos/logo-min-rounded.png" />
    <!-- CSS CUSTOM + BOOTSTRAP -->
    <link href="../css/custom.css" rel="stylesheet" />
    <!-- BOOTSTRAP ICONS-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css" />

    <style>
        .profile-image {
            max-width: 100%;
            max-height: 150px;
            width: 150px;
        }
    </style>
</head>

<body class="bg-dark">
    <header class="header-shop">
        <!-- NAVBAR -->
        <?php include 'components/navbar.php'; ?>
        <div class="px-4 pt-5 my-5 text-center">
            <h1 class="display-4 fw-bold text-flowtech">Profile</h1>
            <div class="col-lg-6 mx-auto">
                <p class="lead mb-4 text-light">Votre profile pour gérer vos informations</p>
            </div>
            <h1 class="diplay-1 text-light">
                <?php echo "Bienvenue  $prenom $nom"; ?>
            </h1>
            <div>
                <img src="../pages/script/imgUser/<?php echo $imgProfilLink; ?>" alt="Photo de profil" class="img-fluid rounded-circle profile-image">
            </div>

        </div>
    </header>

    <ul class="lead mb-4 text-light">
        <!-- J'affiche les variables -->
        <li>Nom:
            <?php echo $nom ?>
        </li>
        <li>Prenom:
            <?php echo $prenom ?>
        </li>
        <li>Pseudonyme:
            <?php echo $pseudonyme ?>
        </li>
        <li>Email:
            <?php echo $email ?>
        </li>
        <li>Téléphone:
            <?php echo $telephone ?>
        </li>
        <li>Adresse:
            <?php echo $adresse ?>
        </li>
        <!-- Affichage du sexe -->
        <li>Sexe:
            <?php echo ($sexe == 1) ? "Homme" : "Femme"; ?>
        </li>

        <div class="w-50 mt-2">
            <form action="../pages/script/imgProfil.php" method="post" enctype="multipart/form-data">
                <div class="w-50">
                    <label for="photo" class="form-label text-light">Modifier la photo de profil :</label>
                    <input type="file" class="form-control" id="photo" name="photo">
                </div>
                <button type="submit" class="btn btn-primary mt-2">Envoyer</button>
            </form>
        </div>
    </ul>

    <div class="container mt-5">
        <h1 class="text-light mb-4">Liste des commandes</h1>
        <?php if (count($commandes) > 0): ?>
            <table class="table table-light table-striped">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Date</th>
                        <th scope="col">Produit</th>
                        <th scope="col">Quantité</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($commandes as $commande): ?>
                        <tr>
                            <td>
                                <?php echo $commande['idCommande']; ?>
                            </td>
                            <td>
                                <?php echo $commande['dateCommande']; ?>
                            </td>
                            <td>
                                <?php echo $commande['idUtilisateur']; ?>
                            </td>
                            <td>
                                <?php echo $commande['quantite']; ?> <!-- Correction de la casse ici -->
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-light">Aucune commande trouvée.</p>
        <?php endif; ?>
    </div>
    <!-- FOOTER -->
    <?php include '../pages/components/cookies.php'; ?>
    <?php include 'components/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>