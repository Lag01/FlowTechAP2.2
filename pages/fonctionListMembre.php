<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <fieldset>
        <label for="genre"> Genre :</label>
        <select name="genre">
            <?php
            require_once('fonction.php');
            // On établit la connexion seulement si elle n'a pas déjà été établie
            $cnx = connect_bd('cinema');

            if ($cnx) {
                // On prépare la requête
                $result = $cnx->prepare('SELECT idGenre, nomGenre FROM Genre;');
                // On execute la requête
                $result->execute();

                // Si la requête renvoie une ligne
                if ($result->rowCount() > 0) {
                    // Boucle d'alimentation des options de la liste déroulante
                    while ($donnees = $result->fetch()) {
                        $selected = ($donnees['idGenre'] == $genreId) ? 'selected' : '';
                        echo "<option value=" . $donnees['idGenre'] . " $selected>" . $donnees['nomGenre'] . "</option>";
                    }
                }
            }
            ?>
        </select>

        <input type="submit" value="Filtrer" />
    </fieldset>
</form>

<?php
// Récupération de la valeur du genre sélectionné
$genreId = isset($_POST['genre']) ? $_POST['genre'] : null;

// Établissement de la connexion
require_once('fonction.php');
$cnx = connect_bd('cinema');

if ($cnx) {
    // Modification de la requête pour inclure la clause WHERE
    $query = 'SELECT * FROM film F, genre G WHERE G.idGenre = F.idGenre';

    if (!empty($genreId)) {
        $query .= ' AND G.idGenre = :genreId';
    }

    $result = $cnx->prepare($query);

    // Liaison des paramètres si le genre est sélectionné
    if (!empty($genreId)) {
        $result->bindParam(':genreId', $genreId, PDO::PARAM_INT);
    }

    // Exécution de la requête
    $result->execute();

    // Affichage des résultats
    if ($result->rowCount() > 0) {
        echo "<table border='1'>";
        echo "<tr>";
        echo "<th>Visa</th>";
        echo "<th>Titre</th>";
        echo "<th>Année sortie</th>";
        echo "<th>Lien affiche</th>";
        echo "<th>Affiche</th>";
        echo "<th>Genre</th>";
        echo "</tr>";

        while ($donnees = $result->fetch()) {
            echo "<tr>";
            echo "<td>" . $donnees['idFilm'] . "</td>";
            echo "<td>" . $donnees['titre'] . "</td>";
            echo "<td>" . $donnees['anneeSortie'] . "</td>";
            echo "<td>" . $donnees['affiche'] . "</td>";
            echo "<td><img src='images/" . $donnees['affiche'] . "'/></td>";
            echo "<td>" . $donnees['nomGenre'] . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "Aucun enregistrement, désolé";
    }

    deconnect_bd('cinema');
}
?>

<a href="index.html">Accueil</a>

<?php

// Fonction de connexion à la BD 
function connect_bd($nomBd)
{
    $nomServeur = 'localhost';
    //nom du seveur
    $login = 'root';
    //login de l'utilisateur
    $passWd = "root";
    // mot de passe
    try {
        // Connexion à la BD et définition du jeu de caractères UTF-8
        $cnx = new PDO("mysql:host=localhost; dbname=$nomBd", $login, $passWd);

        // PDO génére une erreur fatale si un problème survient. 
        $cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Jeu de caractères
        $cnx->exec("SET CHARACTER SET utf8");

        echo "connecté !";
        return $cnx;

    } catch (PDOException $e) {

        print "Erreur!" . $e->getMessage() . "<br/>";
        die();
        return 0;
    }
}

// Fonction de deconnexion de la BD 
function deconnect_bd($nomBd)
{
    $nomBd = null;
}

?>
<a href="index.html">Accueil </a>