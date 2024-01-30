<form method="post" action="filmAjouter.php">
    <fieldset>
        <legend>Films</legend>

        <label for="nom">Nom :</label>
        <input type="text" name="nom" />

        <label for="prenom">Prénom :</label>
        <input type="text" name="prenom" />

        <label for="dateNaissance"> Date de naissance :</label>
        <input type="text" name="dateNaissance" />

        <label for="genre"> Genre :</label>
        <select name="genre">
            <?php
            require_once('fonction.php');
            // On établit la connexion seulement si elle n'a pas déjà été établie
            
            $cnx = connect_bd('nc231_flowtech');

            if ($cnx) {
                // On prépare la requête
                $result = $cnx->prepare('SELECT idGenre, nomGenre FROM Genre;');
                // On execute la requête
                $result->execute();

                // Si la requête renvoie une ligne
                if ($result->rowCount() > 0) {
                    // Boucle d'alimentation des options de la liste déroulante
                    while ($donnees = $result->fetch()) {
                        echo "<option value=" . $donnees['idGenre'] . ">" . $donnees['nomGenre'] . "</option>";
                    }
                }
            }
            ?>
        </select>

        <input type="submit" value="envoyer" />
    </fieldset>
</form>

<?php
// Fermeture de la connexion si elle a été établie
if (isset($cnx)) {
    deconnect_bd('nc231_flowtech');
}
?>

<!--FUNCTION AJOUTER MEMBRE-->
<?php
include("fonction.php");

$cnx = connect_bd('nc231_flowtech');

if ($cnx) {


    $result = $cnx->prepare('INSERT INTO film (nom, prenom, dateNaissance, idGenre)
                            VALUES (:nom, :prenom, :dateNaissance, :idGenre)');
    $titre = filter_input(INPUT_POST, "titre", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $anneeSortie = filter_input(INPUT_POST, "anneeSortie");
    $affiche = filter_input(INPUT_POST, "affiche", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $idGenre = filter_input(INPUT_POST, "genre");
    echo $idGenre;
    $result->bindParam(':nom', $nom, PDO::PARAM_STR);
    $result->bindParam(':prenom', $prenom, PDO::PARAM_STR);
    $result->bindParam(':dateNaissance', $dateNaissance, PDO::PARAM_INT);
    $result->bindParam(':idGenre', $idGenre, PDO::PARAM_INT);

    $result->execute();

    echo '<p>' . $result->rowCount() . ' film a été ajouté dans la table Film</p>';
    echo "<p>Il s'agit du film $titre sorti en $anneeSortie</p>";
    echo '<p>Son identifiant est : ' . $cnx->LastInsertId() . '</p>';
} else {
    echo "erreur";
}
deconnect_bd('cinema');
?>

<?php
//Affichage de l'id de la personne sélectionnée
if (isset($_POST['genre'])) {
    $idG = $_POST['genre'];
    echo $idG;
}
?>