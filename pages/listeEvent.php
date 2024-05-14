<!-- <?php
require_once ('Event.class.php');
session_start();
//var_dump($_SESSION['tableauEvent']);
echo "<table border=1>";
foreach ($_SESSION['tableauEvent'] as $f) {
    echo "<tr>";
    echo "<td><input type='text' name='nomEvenement' value='" . $f->getNomEvenement() . "'</td>";
    echo "<td><input type='text' name='dateEvenement' value='" . $f->getDateEvenement() . "'</td>";
    echo "</tr>";
}
echo "</table>";

// Ajouter un écouteur d'événement pour le bouton de modification
echo "<script>";
echo "let buttons = document.getElementsByName('modifier');";
echo "for (let i = 0; i < buttons.length; i++) {";
echo "  buttons[i].addEventListener('click', function() {";
echo "    let index = this.value;";
echo "    let nomEvenement = prompt('Nouveau nom de l'événement :', tableauEvent[index].getNomEvenement());";
echo "    let dateEvenement = prompt('Nouvelle date de l'événement :', tableauEvent[index].getDateEvenement());";
echo "    tableauEvent[index].setNomEvenement(nomEvenement);";
echo "    tableauEvent[index].setDateEvenement(dateEvenement);";
echo "    // Enregistrer les modifications dans la base de données";
echo "    // ...";
echo "  });";
echo "}";
echo "</script>";

// Ajouter un écouteur d'événement pour le bouton de suppression
echo "<script>";
echo "let buttons = document.getElementsByName('supprimer');";
echo "for (let i = 0; i < buttons.length; i++) {";
echo "  buttons[i].addEventListener('click', function() {";
echo "    let index = this.value;";
echo "    if (confirm('Êtes-vous sûr de vouloir supprimer cet événement ?')) {";
echo "      tableauEvent.splice(index, 1);";
echo "      // Supprimer l'événement de la base de données";
echo "      // ...";
echo "    }";
echo "  });";
echo "}";
echo "</script>";
?> -->

<?php
require_once ('Event.class.php');
session_start();
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
            echo "<td><input type='text' name='nomEvenement' value='" . $f->getNomEvenement() . "'</td>";
            echo "<td><input type='text' name='dateEvenement' value='" . $f->getDateEvenement() . "'</td>";
            echo "<td><button name='modifier' value='" . $index . "'>Modifier</button></td>";
            echo "<td><button name='supprimer' value='" . $index . "'>Supprimer</button></td>";
            echo "</tr>";
            $index++;
        }
        ?>
    </table>

    <script>
        let buttons = document.getElementsByName('modifier');
        for (let i = 0; i < buttons.length; i++) {
            buttons[i].addEventListener('click', function () {
                let index = this.value;
                let nomEvenement = prompt('Nouveau nom de l\'événement :', <?php echo json_encode($_SESSION['tableauEvent'][$index]->getNomEvenement()); ?>);
                let dateEvenement = prompt('Nouvelle date de l\'événement :', <?php echo json_encode($_SESSION['tableauEvent'][$index]->getDateEvenement()); ?>);
                <?php echo '$_SESSION["tableauEvent"][' . $index . ']->setNomEvenement('; ?>nomEvenement<?php echo ');'; ?>
                <?php echo '$_SESSION["tableauEvent"][' . $index . ']->setDateEvenement('; ?>dateEvenement<?php echo ');'; ?>
                // Enregistrer les modifications dans la base de données
                // ...";
            });
        }

        let deleteButtons = document.getElementsByName('supprimer');
        for (let i = 0; i < deleteButtons.length; i++) {
            deleteButtons[i].addEventListener('click', function () {
                let index = this.value;
                if (confirm('Êtes-vous sûr de vouloir supprimer cet événement ?')) {
                    <?php echo 'unset($_SESSION["tableauEvent"][' . $index . ']);'; ?>
                    <?php
                    // supprime l'événement de la table Evenement
                    $cnx = connect_bd('nc231_flowtech');
                    $req = $cnx->prepare("DELETE FROM Evenement WHERE idEvenement = :idEvenement");
                    $req->bindParam(':idEvenement', $_SESSION['tableauEvent'][$index]->getIdEvenement(), PDO::PARAM_INT);
                    $req->execute();
                    ?>
                }
            });
        }
    </script>
</body>

</html>