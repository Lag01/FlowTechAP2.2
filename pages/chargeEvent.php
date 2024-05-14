<?php
require_once ('admin/fonction.php');
require_once ('Event.class.php');
session_start();
$nomBd = 'nc231_flowtech';
$cnx = connect_bd($nomBd);

if ($cnx == true) {
    // On prépare la requête (une seule fois)
    $result = $cnx->prepare('SELECT idEvenement, nomEvenement, dateEvenement FROM Evenement ORDER BY nomEvenement;');
    // On exécute la requête
    $result->execute();
    // Si la requête renvoie au moins 1 ligne
    if ($result->rowCount() > 0) {
        // Création du tableau de films
        $lesEvents = array();
        // On parcours les résultats
        while ($donnees = $result->fetch()) {
            $unEvent = new Event($donnees['idEvenement'], $donnees['nomEvenement'], $donnees['dateEvenement']);
            $lesEvents[] = $unEvent;
        }

        // Test du contenu du tableau d'objets
        //var_dump($lesFilms);
        // Création d'une variable de session de type tableau d'objets
        $_SESSION['tableauEvent'] = $lesEvents;
        // Test du contenu du tableau d'objets dans la variable de session
        var_dump($_SESSION['tableauEvent']);
        //Affichage des données du tableau des objets film
        ?>
                                <form method='post' action='listeEvent.php'>
                                    <input type='submit' name='afficher' value='Afficher'>
                                </form>
                                <?php
    } else {
        echo "Aucun enregistrement, désolé";
    }
}
deconnect_bd('nc231_flowtech');
?>