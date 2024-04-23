<?php
// Include database connection here
$servername = "nc231.myd.infomaniak.com";
$username = "nc231_flowtech";
$password = "Flowtech123";
$dbname = "nc231_flowtech";
$conn = new mysqli($servername, $username, $password, $dbname);

// Test la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Je définis manuellement l'ID car il n'est pas dans la sessions
$_SESSION['id'] = '56';
$id = $_SESSION['id'];
// Query to fetch events from database
$sql = "SELECT idEvenement AS id, nomEvenement AS title, dateEvenement AS start FROM Evenement";
$result = $conn->query($sql);

$events = array();

// Fetch events from database and format them for FullCalendar
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
}

// Return events as JSON
echo json_encode($events);
?>