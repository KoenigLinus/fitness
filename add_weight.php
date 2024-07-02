<?php
session_start();

require_once "config.php";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//Datum für die Gewichtsaktualisierung
$currentDate = date("Y-m-d");

if (isset($_POST["weight"]) && is_numeric($_POST["weight"])) {
    $weight = $_POST["weight"];

    $sqlInsertWeight = "INSERT INTO nutzerapp (gewicht, datum) VALUES ($weight, '$currentDate')";

    if ($conn->query($sqlInsertWeight) === true) {
        $nutzerappId = $conn->insert_id;

        // Aktuelle Nutzer-ID aus der Session erhalten
        $nutzerId = isset($_SESSION["nutzer_id"])
            ? $_SESSION["nutzer_id"]
            : null;

        if ($nutzerId) {
            $sqlUpdateUserNutzerapp = "INSERT INTO nutzer_nutzerapp (nutzer_id, nutzerapp_id) VALUES ($nutzerId, $nutzerappId)";

            if ($conn->query($sqlUpdateUserNutzerapp) === true) {
                // Erfolgreich aktualisiert, Weiterleitung zur index.php
                header("Location: index.php");
                exit();
            } else {
                echo "Error: " .
                    $sqlUpdateUserNutzerapp .
                    "<br>" .
                    $conn->error;
            }
        } else {
            echo "Nutzer-ID nicht verfügbar.";
        }
    } else {
        echo "Error: " . $sqlInsertWeight . "<br>" . $conn->error;
    }
} else {
    echo "Ungültiges Gewicht.";
}

$conn->close();
?>
