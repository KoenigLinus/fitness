<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "config.php";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Verbindung fehlgeschlagen: " . $conn->connect_error);
    }

    $datum = $_POST["datum"];
    $größe = $_POST["größe"];
    $gewicht = $_POST["gewicht"];

    $sql = "INSERT INTO nutzerapp (datum, größe, gewicht) VALUES (?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sdd", $datum, $größe, $gewicht);

        if ($stmt->execute()) {
            echo "Neuer Datensatz erfolgreich erstellt";
            header("location: index.php");
            //header("location: index2.php");
        } else {
            echo "Fehler: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Fehler bei der Vorbereitung des SQL-Statements: " . $conn->error;
    }

    $conn->close();
} else {
    echo "Ungültige Anforderung";
}
?>
