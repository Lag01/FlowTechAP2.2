<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>FlowTech, Connexions</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <meta name="description" content="FlowTech, surement les meilleurs PC du marché!" />
    <link rel="icon" type="image/x-icon" href="../img/logos/logo-min-rounded.png" />
    <!-- CSS CUSTOM + BOOTSTRAP -->
    <link rel="stylesheet" href="../css/custom.css">
</head>

<body>
    <div class="login-form">

        <?php if (isset($_SESSION["errorMessage"]) && !empty($_SESSION["errorMessage"])): ?>
            <p class="text-center text-danger">
                <?php echo $_SESSION["errorMessage"]; ?>
            </p>
            <?php unset($_SESSION["errorMessage"]); ?>
        <?php endif; ?>

        <form action="login-script.php" method="post">
            <h2 class="text-center">Connexion</h2>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Username" name="login" required="required">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" placeholder="Password" name="pass" required="required">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-flowtech btn-block">Se connecter</button>
            </div>
            <div class="clearfix text-center">
                <a href="../index.php" class="btn-close-hover btn-danger">Retour à l'accueil</a>
            </div>
        </form>
        <p class="text-center"><a href="../pages/inscription.php">Créer un compte</a></p>
    </div>
</body>

</html>