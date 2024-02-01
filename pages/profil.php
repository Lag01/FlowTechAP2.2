<?php
session_start();

if (!isset($_SESSION['user_data'])) {
	header("Location: ../pages/connexion.php");
	exit();
} else {
	//header("Location: /pages/connexion.php");
	// pour le moment je définis une session manuellement
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
	</ul>
	<div class="w-50">
		<label for="photo" class="form-label text-light">Photo de profil :</label>
		<input type="file" class="form-control" id="photo" name="photo">
	</div>

	<!-- FOOTER -->
	<?php include 'components/footer.php'; ?>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>