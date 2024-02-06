<!DOCTYPE html>
<html>
<head>
    <title>Liste des utilisateurs</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<h2>Liste des utilisateurs</h2>

<form id="filterForm" action="" method="get">
    <label for="sexe">Filtrer par sexe :</label>
    <select name="sexe" id="sexe">
        <option value="">Tous</option>
        <option value="1" <?php if (isset($_GET['sexe']) && $_GET['sexe'] == '1') echo 'selected'; ?>>Homme</option>
        <option value="0" <?php if (isset($_GET['sexe']) && $_GET['sexe'] == '0') echo 'selected'; ?>>Femme</option>
    </select>
    <input type="submit" value="Filtrer">
</form>

<table id="userTable">
    <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Email</th>
        <th>Date de Naissance</th>
        <th>Adresse</th>
        <th>Login</th>
        <th>Numéro de téléphone</th>
        <th>Sexe</th>
    </tr>
    <?php
    // Connexion à la base de données
    //    $servername = "nc231.myd.infomaniak.com";
    //    $username = "nc231_flowtech";
    //    $password = "Flowtech123";
    //    $dbname = "nc231_flowtech";
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "flowtechap2";

    // Connexion
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("Connexion échouée : " . $conn->connect_error);
    }

    // Requête pour récupérer les utilisateurs
    $sql = "SELECT idUtilisateur, Nom, Prenom, email, dateNaissance, Adresse, login, numTelephone, Sexe FROM Utilisateur";
    if (isset($_GET['sexe']) && ($_GET['sexe'] === '1' || $_GET['sexe'] === '0')) {
        $sexe = $_GET['sexe'];
        $sql .= " WHERE Sexe = $sexe";
    }
    $result = $conn->query($sql);

    // Afficher les données dans le tableau
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["idUtilisateur"] . "</td>";
            echo "<td>" . $row["Nom"] . "</td>";
            echo "<td>" . $row["Prenom"] . "</td>";
            echo "<td>" . $row["email"] . "</td>";
            echo "<td>" . $row["dateNaissance"] . "</td>";
            echo "<td>" . $row["Adresse"] . "</td>";
            echo "<td>" . $row["login"] . "</td>";
            echo "<td>" . $row["numTelephone"] . "</td>";
            echo "<td>" . ($row["Sexe"] == 1 ? "Homme" : "Femme") . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='9'>0 résultats</td></tr>";
    }
    ?>
</table>

</body>
</html>

<?php
// Fermer la connexion
$conn->close();
?>
