<?php
session_start();

include_once '../pages/script/authentification.inc.php';

//verification utilisateur connecté
if (!isset($_SESSION['user'])) {
	header("Location: ../login-form.php");
	exit();
}
logout();
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
			<h1 class="text-center">Bienvenue
				<?php echo $_SESSION["user"]; ?>!
			</h1>
		</div>
	</header>
	<!-- FOOTER -->
	<?php include 'components/footer.php'; ?>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>