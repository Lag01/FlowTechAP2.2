<?php
require_once ('Event.class.php');
require_once ('admin/fonction.php');
session_start();

if (isset($_POST['modifier'])) {
    $index = intval($_POST['index']);
    $nomEvenement = $_POST['nomEvenement'];
    $dateEvenement = $_POST['dateEvenement'];
    $_SESSION['tableauEvent'][$index]->setNomEvenement($nomEvenement);
    $_SESSION['tableauEvent'][$index]->setDateEvenement($dateEvenement);
    // Enregistrer les modifications dans la base de données
    // ...
} elseif (isset($_POST['supprimer'])) {
    $index = intval($_POST['index']);
    var_dump($_SESSION['tableauEvent']);
    // supprime l'événement de la table Evenement
    $cnx = connect_bd('nc231_flowtech');
    $req = $cnx->prepare("DELETE FROM Evenement WHERE idEvenement = :idEvenement");
    $req->bindParam(':idEvenement', $_SESSION['tableauEvent'][$index]->getIdEvenement(), PDO::PARAM_INT);
    $req->execute();

    // Rediriger vers la page chargeEvent.php
    header('Location: chargeEvent.php');
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Liste des événements</title>
</head>

<body>
    <table border=1>
        <?php
        $index = 0;
        foreach ($_SESSION['tableauEvent'] as $f) {
            echo "<tr>";
            echo "<td><form method='post' action=''>";
            echo "<input type='hidden' name='index' value='" . $index . "'>";
            echo "<input type='text' name='nomEvenement' value='" . $f->getNomEvenement() . "'>";
            echo "<input type='text' name='dateEvenement' value='" . $f->getDateEvenement() . "'>";
            echo "<input type='submit' name='modifier' value='Modifier'>";
            echo "</form></td>";
            echo "<td><form method='post' action=''>";
            echo "<input type='hidden' name='index' value='" . $index . "'>";
            echo "<input type='submit' name='supprimer' value='Supprimer' onclick=\"return confirm('Êtes-vous sûr de vouloir supprimer cet événement ?')\">";
            echo "</form></td>";
            echo "</tr>";
            $index++;
        }
        ?>
    </table>
</body>

</html>
