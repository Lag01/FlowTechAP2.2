<?php
session_start();

if (!isset($_SESSION['user_data']) || empty($_SESSION['user_data']['Admin'])) {
    // Redirige vers la page de connexion si l'utilisateur n'est pas connecté ou s'il n'est pas un administrateur
    header("Location: ../pages/connexion.php");
    exit();
}


//if (!isset($_SESSION['user_data'])) {
//    header("Location: ../pages/connexion.php");
//    exit();
//} else {
//    exit();
//};

// Connexion à la DB
// $servername = "nc231.myd.infomaniak.com";
// $username = "nc231_flowtech";
// $password = "Flowtech123";
// $dbname = "nc231_flowtech";
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "nc231_flowtech";
$conn = new mysqli($servername, $username, $password, $dbname);

// Test la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Je définis manuellement l'ID car il n'est pas dans la sessions
$_SESSION['id'] = '56';
$id = $_SESSION['id'];

// Récupère les evenements
$sql = "SELECT idEvenement, dateEvenement, nomEvenement FROM Evenement";
$result = $conn->query($sql);

// Inscrit l'utilisateur aux évenements
if (isset($_POST['submit'])) {
    if (!empty($_POST['evenement'])) {
        $selected = $_POST['evenement'];
        echo 'Vous êtes inscrit à l\'evenement: ' . $selected;
        $selected = $conn->real_escape_string($selected);
        $sql = "INSERT INTO Inscription (idUtilisateur, idEvenement, present) VALUES ('$id', '$selected', '1')";
        if ($conn->query($sql) === TRUE) {
            echo 'L\'événement a été ajouté à la base de données avec succès.';
        } else {
            echo 'Erreur lors de l\'ajout de l\'événement à la base de données : ' . $conn->error;
        }
    } else {
        echo 'Choisissez une valeur';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title> Évènements - FlowTech</title>
    <meta name="description" content="FlowTech, surement les meilleurs PC du marché!" />
    <link rel="icon" type="image/x-icon" href="../img/logos/logo-min-rounded.png" />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>
    <!--CSS CUSTOM + BOOTSTRAP-->
    <link href="/css/custom.css" rel="stylesheet" />
    <!-- BOOTSTRAP ICONS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css" />

    <script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: {
            url: 'getEvent.php',
            method: 'POST',
            extraParams: {
                custom_param: 'something'
            },
            failure: function() {
                alert('Une erreur durant la récupération !');
            }
        }
    });
    calendar.render();
    calendar.setOption('locale', 'fr');
});
</script>
</head>

<body>
    <section class="container">
        <form action="" method="post">
            <select name="evenement">
                <option disabled selected>Choisissez</option>
                <?php
                // Affiche les champs de la table Evenement
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["idEvenement"] . "'>" . $row["nomEvenement"] . "</option>";
                    }
                } else {
                    echo "0 results";
                }
                ?>
            </select>
            <input type="submit" name="submit" value="Envoyer">
        </form>
        <table>
            <tr>
                <th>Vous êtes inscrit à</th>
            </tr>

        </table>

    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <div id='calendar'></div>

</body>

</html>