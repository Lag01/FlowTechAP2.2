<form method="post" action="filmAjouter.php">
    <fieldset>
        <legend>Inscription Evénement</legend>

        <label for="Nom">Nom :</label>
        <input type="text" name="Nom" />

        <label for="Prénom">Prénom :</label>
        <input type="text" name="Prénom" />

        <label for="DateNaissance">Date de Naissance :</label>
        <input type="text" name="DateNaissance" />

        <label for="genre">Genre :</label>
        <select name="genre">

            <?php
            require_once('fonction.php');
            $cnx = connect_bd('nc231_flowtech');

            if ($cnx) {
                $result = $cnx->prepare('SELECT idGenre, nomGenre FROM Genre;');
                $result->execute();

                if ($result->rowCount() > 0) {
                    while ($donnees = $result->fetch()) {
                        echo "<option value=" . $donnees['idGenre'] . ">" . $donnees['nomGenre'] . "</option>";
                    }
                }
            }
            ?>
        </select>

        <label for="event">Evénement :</label>
        <select name="event">

            <?php
            require_once('fonction.php');
            $cnx = connect_bd('nc231_flowtech');

            if ($cnx) {
                $result = $cnx->prepare('SELECT idEvent, nomEvent FROM Event;');
                $result->execute();

                if ($result->rowCount() > 0) {
                    while ($donnees = $result->fetch()) {
                        echo "<option value=" . $donnees['idEvent'] . ">" . $donnees['nomEvent'] . "</option>";
                    }
                }
            }
            ?>
        </select>

        <input type="submit" value="envoyer" />
    </fieldset>
</form>
<a href="index.html">Accueil</a>

<?php
if (isset($_POST['genre'])) {
    include("fonction.php");

    $cnx = connect_bd('nc231_flowtech');

    if ($cnx) {
        $result = $cnx->prepare('INSERT INTO Evenement (Nom, dateNaissance, prenom, idGenre) VALUES (:titre, :anneeSortie, :affiche, :idGenre)');

        $nom = filter_input(INPUT_POST, "Nom", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $dateNaissance = filter_input(INPUT_POST, "DateNaissance");
        $prenom = filter_input(INPUT_POST, "Prénom", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $idGenre = filter_input(INPUT_POST, "genre");


        $result->bindParam(':titre', $nom, PDO::PARAM_STR);
        $result->bindParam(':anneeSortie', $dateNaissance, PDO::PARAM_INT);
        $result->bindParam(':affiche', $prenom, PDO::PARAM_STR);
        $result->bindParam(':idGenre', $idGenre, PDO::PARAM_INT);

        $result->execute();

        echo '<p>' . $result->rowCount() . ' Adhérent a été ajouté dans la table Film</p>';
        echo "<p>Il s'agit de l'adhérent $nom née le $dateNaissance</p>";
        echo '<p>Son identifiant est : ' . $cnx->lastInsertId() . '</p>';
    } else {
        echo "erreur";
    }
    deconnect_bd('nc231_flowtech');
}
?>