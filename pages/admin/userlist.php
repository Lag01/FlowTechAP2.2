<?php
session_start();
// Vérifier si l'utilisateur est un administrateur
if ($_SESSION['user_data']['Admin'] != 1) {
    // Redirige vers la page de profil s'il n'est pas un administrateur
    header("Location: /pages/profil.php");
    exit();
} elseif ($_SESSION['user_data']['Admin'] = 1) {
    header("redirect: userlist.php");
}

?>

<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Liste utilisateurs - FlowTech</title>
    <link rel="icon" type="image/x-icon" href="/img/logos/logo-min-rounded.png" />
    <!-- CSS CUSTOM + BOOTSTRAP -->
    <link href="/css/custom.css" rel="stylesheet" />
    <!-- BOOTSTRAP ICONS-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
</head>

<body class="bg-dark text-light">
    <?php include '../components/navbar.php'; ?>
    <?php
    require_once ('fonction.php');

    //recup du nombre d'homme / femme pour les stats
    $donneesGenre = nombreHommesFemmes();
    $nbFemmes = $donneesGenre['Femmes'];
    $nbHommes = $donneesGenre['Hommes'];

    //recup du nombre de pc vendu pour les graphiques
    $pcVendus = nombrePcVendu();
    $nbAtlas = $pcVendus['Atlas'];
    $nbSavana = $pcVendus['Savana'];
    $nbKraken = $pcVendus['Kraken'];
    $nbFractal = $pcVendus['Fractal-North'];
    $nbTracer = $pcVendus['Tracer'];
    $nbFreezer = $pcVendus['Freezer'];
    $nbOrion = $pcVendus['Orion'];
    $nbOmega = $pcVendus['Omega'];



    // Récupération de la valeur du genre sélectionné
    $genreId = isset($_POST['sexe']) ? $_POST['sexe'] : null;
    $genreAdmin = isset($_POST['Admin']) ? $_POST['Admin'] : null;

    // Établissement de la connexion
    $cnx = connect_bd('Utilisateur');
    // Traitement de l'inscription
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['inscription'])) {
        $Nom = $_POST['Nom'];
        $Prenom = $_POST['Prenom'];
        $email = $_POST['email'];
        $dateNaissance = $_POST['dateNaissance'];
        $Sexe = $_POST['Sexe'];
        $Admin = $_POST['Admin'];
        $Adresse = $_POST['Adresse'];
        $login = $_POST['login'];
        $numTelephone = $_POST['numTelephone'];

        if ($cnx) {
            $result = $cnx->prepare("INSERT INTO Utilisateur (Nom, Prenom, email, dateNaissance, Sexe, Admin, Adresse, login, numTelephone) VALUES (:Nom, :Prenom, :email, :dateNaissance, :Sexe, :Admin, :Adresse, :login, :numTelephone)");
            $result->bindParam(':Nom', $Nom, PDO::PARAM_STR);
            $result->bindParam(':Prenom', $Prenom, PDO::PARAM_STR);
            $result->bindParam(':email', $email, PDO::PARAM_STR);
            $result->bindParam(':dateNaissance', $dateNaissance, PDO::PARAM_STR);
            $result->bindParam(':Sexe', $Sexe, PDO::PARAM_INT);
            $result->bindParam(':Admin', $Admin, PDO::PARAM_INT);
            $result->bindParam(':Adresse', $Adresse, PDO::PARAM_STR);
            $result->bindParam(':login', $login, PDO::PARAM_STR);
            $result->bindParam(':numTelephone', $numTelephone, PDO::PARAM_STR);
            $result->execute();

            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "Erreur de connexion à la base de données.";
        }
    }

    if ($cnx) {
        if (isset($_REQUEST['delete'])) {
            $result = $cnx->prepare("DELETE FROM Utilisateur WHERE idUtilisateur = :cle");
            $idUtilisateur = isset($_REQUEST['cle']) ? $_REQUEST['cle'] : null;
            if ($idUtilisateur !== null) {
                $result->bindParam(':cle', $idUtilisateur, PDO::PARAM_INT);
                $result->execute();
            } else {
                echo "Erreur: idUtilisateur non spécifié.";
            }
        } elseif (isset($_REQUEST['update'])) {
            $result = $cnx->prepare("UPDATE Utilisateur SET Nom=:Nom, Prenom=:Prenom, email=:email, dateNaissance=:dateNaissance, Sexe=:Sexe, Admin=:Admin, Adresse=:Adresse, login=:login, numTelephone=:numTelephone WHERE idUtilisateur=:cle");
            $idUtilisateur = isset($_REQUEST['cle']) ? $_REQUEST['cle'] : null;
            if ($idUtilisateur !== null) {
                $Nom = $_REQUEST['Nom'];
                $Prenom = $_REQUEST['Prenom'];
                $email = $_REQUEST['email'];
                $dateNaissance = $_REQUEST['dateNaissance'];
                $Sexe = $_REQUEST['Sexe'];
                $Admin = $_REQUEST['Admin'];
                $Adresse = $_REQUEST['Adresse'];
                $login = $_REQUEST['login'];
                $numTelephone = $_REQUEST['numTelephone'];

                $result->bindParam(':cle', $idUtilisateur, PDO::PARAM_INT);
                $result->bindParam(':Nom', $Nom, PDO::PARAM_STR);
                $result->bindParam(':Prenom', $Prenom, PDO::PARAM_STR);
                $result->bindParam(':email', $email, PDO::PARAM_STR);
                $result->bindParam(':dateNaissance', $dateNaissance, PDO::PARAM_STR);
                $result->bindParam(':Sexe', $Sexe, PDO::PARAM_INT);
                $result->bindParam(':Admin', $Admin, PDO::PARAM_INT);
                $result->bindParam(':Adresse', $Adresse, PDO::PARAM_STR);
                $result->bindParam(':login', $login, PDO::PARAM_STR);
                $result->bindParam(':numTelephone', $numTelephone, PDO::PARAM_STR);

                $result->execute();
            } else {
                echo "Erreur: idUtilisateur non spécifié.";
            }
        }
        // Debut container
        echo '<section class="container">';
        // Affichage du formulaire d'inscription
        echo '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">';
        ?>
        <div class="row mx-5 px-5 mt-3">
            <h4>Insérer un utilisateur</h4>

            <input type="text" name="Nom" placeholder="Nom" required class="mt-1">
            <input type="text" name="Prenom" placeholder="Prénom" required class="mt-1">
            <input type="email" name="email" placeholder="Email" required class="mt-1">
            <input type="date" name="dateNaissance" placeholder="Date de naissance" required class="mt-1">
            <select name="Sexe" required class="mt-1">
                <option value="0">Homme</option>
                <option value="1">Femme</option>
            </select>
            <select name="Admin" required class="mt-1">
                <option value="0">User</option>
                <option value="1">Admin</option>
            </select>
            <input type="text" name="Adresse" placeholder="Adresse" required class="mt-1">
            <input type="text" name="login" placeholder="Pseudo" required class="mt-1">
            <input type="text" name="numTelephone" placeholder="Téléphone" required class="mt-1">
            <input type="submit" name="inscription" value="Inscription" class="mt-2 btn btn-flowtech btn-sm mt-1">
        </div>
        </form>

        <?php
        // Affichage des résultats USER
        $query = 'SELECT * FROM Utilisateur WHERE 1';

        if ($genreId !== null && $genreId !== '') {
            $query .= ' AND Sexe = :sexe';
        }

        $result = $cnx->prepare($query);

        if ($genreId !== null && $genreId !== '') {
            $result->bindParam(':sexe', $genreId, PDO::PARAM_INT);
        }

        $result->execute();

        // Affichage des résultats ADMIN
        $query = 'SELECT * FROM Utilisateur WHERE 1';

        if ($genreAdmin !== null && $genreAdmin !== '') {
            $query .= ' AND Admin = :Admin';
        }

        $result = $cnx->prepare($query);

        if ($genreAdmin !== null && $genreAdmin !== '') {
            $result->bindParam(':Admin', $genreAdmin, PDO::PARAM_INT);
        }

        $result->execute();


        // Affichage du formulaire de filtrage SEXE
        echo '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">';
        echo '<fieldset>';
        echo '<label for="sexe">Filtrer par sexe :</label>';
        echo '<select name="sexe">';
        echo '<option value="">Tous</option>'; // Option par défaut
        echo '<option value="0"' . ($genreId === '0' ? ' selected' : '') . '>Homme</option>';
        echo '<option value="1"' . ($genreId === '1' ? ' selected' : '') . '>Femme</option>';
        echo '</select>';
        echo '<input type="submit" value="Filtrer" class="btn btn-sm btn-flowtech" />';
        echo '</fieldset>';
        echo '</form>';

        // Affichage du formulaire de filtrage ADMIN
        echo '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">';
        echo '<fieldset>';
        echo '<label for="Admin">Filtrer par Role :</label>';
        echo '<select name="Admin">';
        echo '<option value="">Tous</option>'; // Option par défaut
        echo '<option value="0"' . ($genreAdmin === '0' ? ' selected' : '') . '>User</option>';
        echo '<option value="1"' . ($genreAdmin === '1' ? ' selected' : '') . '>Admin</option>';
        echo '</select>';
        echo '<input type="submit" value="Filtrer" class="btn btn-sm btn-flowtech" />';
        echo '</fieldset>';
        echo '</form>';

        echo "<div style='overflow: auto;'>";
        if ($result->rowCount() > 0) {
            echo "<table border='1'>";
            echo '<thead>';
            echo "<tr>";
            echo "<th>idUtilisateur</th>";
            echo "<th>Nom</th>";
            echo "<th>Prenom</th>";
            echo "<th>email</th>";
            echo "<th>dateNaissance</th>";
            echo "<th>Sexe</th>";
            echo "<th>Role</th>";
            echo "<th>Adresse</th>";
            echo "<th>Pseudo</th>";
            echo "<th>numTelephone</th>";
            echo "<th>Modifier</th>";
            echo "<th>Supprimer</th>";
            echo "</tr>";
            echo '</thead>';

            while ($donnees = $result->fetch()) {
                echo '<tbody>';
                echo "<form action=" . $_SERVER['PHP_SELF'] . " method='post'>";
                echo "<input type='hidden' name='cle' value='" . $donnees['idUtilisateur'] . "'>";
                echo "<tr>";
                echo "<td>" . $donnees['idUtilisateur'] . "</td>";
                echo "<td><input type='text' name='Nom'size='20' value='" . $donnees['Nom'] . "'></td>";
                echo "<td><input type='text' name='Prenom'size='20' value='" . $donnees['Prenom'] . "'></td>";
                echo "<td><input type='text' name='email'size='20' value='" . $donnees['email'] . "'></td>";
                echo "<td><input type='text' name='dateNaissance'size='20' value='" . $donnees['dateNaissance'] . "'></td>";
                echo "<td>";
                echo "<select name='Sexe'>";
                echo "<option value='0'" . ($donnees['Sexe'] == 0 ? ' selected' : '') . ">Homme</option>";
                echo "<option value='1'" . ($donnees['Sexe'] == 1 ? ' selected' : '') . ">Femme</option>";
                echo "</select>";
                echo "</td>";
                echo "<td>";
                echo "<select name='Admin'>";
                echo "<option value='0'" . ($donnees['Admin'] == 0 ? ' selected' : '') . ">User</option>";
                echo "<option value='1'" . ($donnees['Admin'] == 1 ? ' selected' : '') . ">Admin</option>";
                echo "</select>";
                echo "</td>";
                echo "<td><input type='text' name='Adresse'size='20' value='" . $donnees['Adresse'] . "'></td>";
                echo "<td><input type='text' name='login'size='20' value='" . $donnees['login'] . "'></td>";
                echo "<td><input type='text' name='numTelephone'size='20' value='" . $donnees['numTelephone'] . "'></td>";
                echo "<td><input type='submit' name='update' class='btn btn-primary btn-sm' value='Modifier'></td>";
                echo "<td><input type='submit' name='delete' class='btn btn-danger btn-sm' value='Supprimer'></td>";
                echo "</tr>";
                echo "</form>";
                echo '</tbody>';
            }
            echo "</table>";
            echo "</div>";


            // Affichage de la moyenne d'âge de tous les acteurs
            echo '<div class="my-2">';
            $moyenneAge = round(moyenneAge());
            echo "<label class='my-5'>Moyenne d'âge de tous les Utilisateur : $moyenneAge ans<label>";
            echo '</div>';
            echo '<div class="my-2">';
            echo '<form method="post" action="">';
            echo '<label for="anneeChoisit">Nombre d\'utilisateur née à partir de l\'année :</label>';
            echo '<input type="text" class="form-control" name="anneeChoisit" size="4" value="' . (isset($_POST['anneeChoisit']) ? $_POST['anneeChoisit'] : '') . '">';
            echo '<input class="btn btn-flowtech btn-sm" type="submit" value="Calculer">';
            echo '</form>';
            echo '</div>';


            // fin container
            echo '<div>';
            // Vérifie si le formulaire a été soumis
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Vérifier si la clé 'anneeChoisit' est définie dans $_POST
                if (isset($_POST['anneeChoisit'])) {
                    // Récupérer l'année choisie par l'utilisateur
                    $anneeChoisit = $_POST['anneeChoisit'];
                    // Appeler la fonction pour obtenir le nombre d'utilisateurs nés à partir de cette année
                    $nbUtilisateur = nbUtilisateurAnnee($anneeChoisit);
                    // Afficher le résultat
                    echo "Nombre d'utilisateurs nés à partir de l'année <b>$anneeChoisit</b>: $nbUtilisateur<br><br>";
                }
            }
            echo '</div>';

            // fin container
            echo '<div>';
            $nbUtilisateur = nbUtilisateur();
            // Afficher le résultat
            echo "Nombre d'utilisateurs Admin: $nbUtilisateur<br><br>";
            echo '</div>';


            $pcChoisi = isset($_POST['pc']) ? $_POST['pc'] : 'Atlas'; // Par défaut, 'Atlas'
            $chiffreAffaires = chiffreAffairesTotal($pcChoisi);

            // Affichage du chiffre d'affaires total
    
            echo '<form method="post" action="">';
            echo '<label for="pc">Sélectionner le PC :</label>';
            echo '<select name="pc">';
            echo '<option value="Atlas">Atlas</option>';
            echo '<option value="Kraken">Kraken</option>';
            echo '<option value="Savana">Savana</option>';
            echo '<option value="Fractal-North">Fractal-North</option>';
            echo '<option value="Tracer">Tracer</option>';
            echo '<option value="Freezer">Freezer</option>';
            echo '<option value="Orion">Orion</option>';
            echo '<option value="Omega">Omega</option>';
            // Ajoutez d'autres options PC ici si nécessaire
            echo '</select>';
            echo '<input class="btn btn-flowtech btn-sm" type="submit" value="Afficher le chiffre d\'affaires">';
            echo '</form>';
            echo "Le chiffre d'affaires total pour le PC $pcChoisi est : $chiffreAffaires";


            // Affichage de tous les achats avec leur utilisateur
            $utilisateurAvecPc = listerUtilisateursAvecCommande();
            echo "<h2>Liste des utilisateurs avec leur commande et la quantité :</h2>";
            echo "<table class='table' border='1'>";
            echo "<tr><th>Pc</th><th>Utilisateur</th><th>Quantité</th></tr>";
            foreach ($utilisateurAvecPc as $pcCommande) {
                echo "<tr>";
                echo "<td>{$pcCommande['NomArticle']}</td>";
                echo "<td>{$pcCommande['Nom']} {$pcCommande['Prenom']}</td>";
                echo "<td>{$pcCommande['quantite']}</td>";
                echo "</tr>";
            }
            echo "</table>";

        } else {
            echo "Aucun enregistrement, désolé";
        }
        deconnect_bd('Utilisateur');
    }
    ?>
    <div id="ajoutEvenement">
        <h2>Ajouter un événement</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="nom">Nom de l'événement :</label>
            <input type="text" name="nom" class="form-control" placeholder="Nom événement" required>
            <label for="date">Date de l'événement :</label>
            <input type="date" name="date" class="form-control" placeholder="Date" required>
            <input type="submit" name="ajoutEvenement" value="Ajouter l'événement">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ajoutEvenement'])) {
                $nom = $_POST['nom'];
                $date = $_POST['date'];
                $cnx = connect_bd('Evenement');
                if ($cnx) {
                    $result = $cnx->prepare("INSERT INTO Evenement (nomEvenement, dateEvenement) VALUES (:nom, :date)");
                    $result->bindParam(':nom', $nom, PDO::PARAM_STR);
                    $result->bindParam(':date', $date, PDO::PARAM_STR);
                    $result->execute();
                    deconnect_bd('Evenement');
                    exit();
                } else {
                    echo "Erreur de connexion à la base de données.";
                }
            }
            ?>
        </form>
    </div>
    <div class="row pt-5">
        <div class="col-4">
            <h3>Nombres de ventes de chaque pc</h3>
            <canvas id="GraphiquePC" class=""></canvas>
        </div>
        <div class="col-4">
            <h3>Nombres d'hommes et de femmes</h3>
            <canvas id="GraphiqueGenre" class=""></canvas>
        </div>
        <div class="col-4">
            <h3>Nombres d'utilisateur par tranches d'ages</h3>
            <canvas id="Graphiqueage" class=""></canvas>
        </div>
    </div>
    <?php
    echo '</section>';
    ?>



    <?php include '../components/footer.php'; ?>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!--===========================LES GRAPHIQUES========================-->
    <script>
        // Mettre à jour les données du graphique d'âge
        const moins18 = <?php echo nombrePersonnesParTrancheAge(0, 17); ?>;
        const plus18 = <?php echo nombrePersonnesParTrancheAge(18, 59); ?>;
        const plus60 = <?php echo nombrePersonnesParTrancheAge(60, 150); ?>;

        const ctxage = document.getElementById("Graphiqueage");

        new Chart(ctxage, {
            type: "pie",
            data: {
                labels: ["Moins de 18 ans", "De 18 à 59 ans", "Plus de 60 ans"],
                datasets: [
                    {
                        label: "Nombre de personnes par tranche d'âge",
                        data: [moins18, plus18, plus60],
                        borderWidth: 1,
                    },
                ],
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },
            },
        });
    </script>
    <script>
        // Mettre à jour les données du graphique de genre
        const nbHommes = <?php echo $nbHommes; ?>;
        const nbFemmes = <?php echo $nbFemmes; ?>;

        const ctxgenre = document.getElementById("GraphiqueGenre");

        new Chart(ctxgenre, {
            type: "pie",
            data: {
                labels: ["Hommes", "Femmes"],
                datasets: [
                    {
                        label: "Nombre personne du genre",
                        data: [nbHommes, nbFemmes],
                        borderWidth: 1,
                    },
                ],
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },
            },
        });
    </script>
    <script>
        const nbAtlas = <?php echo $nbAtlas; ?>;
        const nbSavana = <?php echo $nbSavana; ?>;
        const nbKraken = <?php echo $nbKraken; ?>;
        const nbFractal = <?php echo $nbFractal; ?>;
        const nbTracer = <?php echo $nbTracer; ?>;
        const nbFreezer = <?php echo $nbFreezer; ?>;
        const nbOrion = <?php echo $nbOrion; ?>;
        const nbOmega = <?php echo $nbOmega; ?>;


        const ctx = document.getElementById("GraphiquePC");

        new Chart(ctx, {
            type: "pie",
            data: {
                labels: ["Atlas", "Savana", "Kraken", "Fractal-North", "Tracer", "Freezer", "Orion", "Omega"],
                datasets: [
                    {
                        label: "Nombre de ventes",
                        data: [nbAtlas, nbSavana, nbKraken, nbFractal, nbTracer, nbFreezer, nbOrion, nbOmega],
                        borderWidth: 1,
                    },
                ],
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },
            },
        });

    </script>
</body>

</html>