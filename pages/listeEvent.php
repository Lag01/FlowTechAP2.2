<?php
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