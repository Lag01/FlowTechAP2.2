<?php
require_once('fonction.php');

// Récupération de la valeur du genre sélectionné
$genreId = isset($_POST['sexe']) ? $_POST['sexe'] : null;

// Établissement de la connexion
$cnx = connect_bd('Utilisateur');

if ($cnx) {
    if (isset($_REQUEST['delete'])) {
        $result = $cnx->prepare("DELETE FROM Utilisateur WHERE idUtilisateur = :cle");
        $idUtilisateur = isset($_REQUEST['cle']) ? $_REQUEST['cle'] : null;
        if ($idUtilisateur !== null) {
            $result->bindParam(':cle', $idUtilisateur, PDO::PARAM_INT);
            $result->execute(); // Exécution de la requête DELETE
        } else {
            echo "Erreur: idUtilisateur non spécifié.";
        }
    }
    // L'utilisateur a cliqué sur "Modifier"
    elseif (isset($_REQUEST['update'])) {
        // Préparation de la requête UPDATE
        $result = $cnx->prepare("UPDATE Utilisateur SET Nom=:Nom, Prenom=:Prenom, email=:email, dateNaissance=:dateNaissance, Sexe=:Sexe, Adresse=:Adresse, login=:login, numTelephone=:numTelephone WHERE idUtilisateur=:cle");
        // On récupère les valeurs postées dans une variable
        $idUtilisateur = isset($_REQUEST['cle']) ? $_REQUEST['cle'] : null;
        if ($idUtilisateur !== null) {
            $Nom = $_REQUEST['Nom'];
            $Prenom = $_REQUEST['Prenom'];
            $email = $_REQUEST['email'];
            $dateNaissance = $_REQUEST['dateNaissance'];
            $Sexe = $_REQUEST['Sexe'];
            $Adresse = $_REQUEST['Adresse'];
            $login = $_REQUEST['login'];
            $numTelephone = $_REQUEST['numTelephone'];

            // On lie chaque marqueur à sa variable
            $result->bindParam(':cle', $idUtilisateur, PDO::PARAM_INT);
            $result->bindParam(':Nom', $Nom, PDO::PARAM_STR);
            $result->bindParam(':Prenom', $Prenom, PDO::PARAM_STR);
            $result->bindParam(':email', $email, PDO::PARAM_STR);
            $result->bindParam(':dateNaissance', $dateNaissance, PDO::PARAM_STR);
            $result->bindParam(':Sexe', $Sexe, PDO::PARAM_INT); // Utiliser PARAM_INT pour le sexe
            $result->bindParam(':Adresse', $Adresse, PDO::PARAM_STR);
            $result->bindParam(':login', $login, PDO::PARAM_STR);
            $result->bindParam(':numTelephone', $numTelephone, PDO::PARAM_STR);

            $result->execute(); // Exécution de la requête UPDATE
        } else {
            echo "Erreur: idUtilisateur non spécifié.";
        }
    }

    // Affichage du formulaire de filtrage
    echo '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">';
    echo '<fieldset>';
    echo '<label for="sexe">Filtrer par sexe :</label>';
    echo '<select name="sexe">';
    echo '<option value="">Tous</option>'; // Option par défaut
    echo '<option value="0"' . ($genreId === '0' ? ' selected' : '') . '>Homme</option>';
    echo '<option value="1"' . ($genreId === '1' ? ' selected' : '') . '>Femme</option>';
    echo '</select>';
    echo '<input type="submit" value="Filtrer" />';
    echo '</fieldset>';
    echo '</form>';

    // Modification de la requête pour inclure la clause WHERE
    $query = 'SELECT * FROM Utilisateur WHERE 1';

    if ($genreId !== null && $genreId !== '') {
        $query .= ' AND Sexe = :sexe';
    }

    $result = $cnx->prepare($query);

    // Liaison des paramètres si le genre est sélectionné
    if ($genreId !== null && $genreId !== '') {
        $result->bindParam(':sexe', $genreId, PDO::PARAM_INT);
    }

    // Exécution de la requête
    $result->execute();

    // Affichage des résultats
    if ($result->rowCount() > 0) {
        echo "<table border='1'>";
        echo "<thead>";
        echo "<tr class='table-flowtech'>";
        echo "<th scope='col'>idUtilisateur</th>";
        echo "<th scope='col'>Nom</th>";
        echo "<th scope='col'>Prenom</th>";
        echo "<th scope='col'>email</th>";
        echo "<th scope='col'>dateNaissance</th>";
        echo "<th scope='col'>Sexe</th>";
        echo "<th scope='col'>Adresse</th>";
        echo "<th scope='col'>Pseudo</th>";
        echo "<th scope='col'>numTelephone</th>";
        echo "<th scope='col'>Modifier</th>";
        echo "<th scope='col'>Supprimer</th>";
        echo "</tr>";
        echo "<thead>";


        while ($donnees = $result->fetch()) {
            echo "<tbody >";
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
            echo "<td><input type='text' name='Adresse'size='20' value='" . $donnees['Adresse'] . "'></td>";
            echo "<td><input type='text' name='login'size='20' value='" . $donnees['login'] . "'></td>";
            echo "<td><input type='text' name='numTelephone'size='20' value='" . $donnees['numTelephone'] . "'></td>";
            echo "<td><input type='submit' name='update' value='Modifier'></td>";
            echo "<td><input type='submit' name='delete' value='Supprimer'></td>";
            echo "</tr>";
            echo "</form>";
            echo "<tbody>";
        }
        echo "</table>";
    } else {
        echo "Aucun enregistrement, désolé";
    }
    deconnect_bd('Utilisateur');
}
?>