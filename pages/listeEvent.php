<?php
require_once ('Event.class.php');
session_start();
//var_dump($_SESSION['tableauEvent']);
echo "<table border=1>";
foreach ($_SESSION['tableauEvent'] as $f) {
    echo "<tr>";
    echo "<td><input type='text' name='nomEvenement' value='" . $f->getNomEvenement() . "'</td>";
    echo "<td><input type='text' name='dateEvenement' value='" . $f->getDateEvenement() . "'</td>";
    echo '</tr>';
}
echo "</table>";
?>