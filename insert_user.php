<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
     require_once("config.php");

  
    $conn = new mysqli($servername, $username, $password, $dbname);


    if ($conn->connect_error) {
        die("Verbindung fehlgeschlagen: " . $conn->connect_error);
    }

    $email = $conn->real_escape_string($_POST['email']);
    $vorname = $conn->real_escape_string($_POST['vorname']);
    $nachname = $conn->real_escape_string($_POST['nachname']);
    $geburtstag = $conn->real_escape_string($_POST['geburtstag']);
    $password = ($_POST['password']);

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO nutzer (e_mail, f_name, l_name, geb_datum, pas) VALUES (?, ?, ?, ?, ?)";


    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sssss", $email, $vorname, $nachname, $geburtstag, $hashed_password);


        if ($stmt->execute()) {
            $_SESSION["user_id"] = mysqli_insert_id($conn);
            echo "Neuer Datensatz erfolgreich erstellt";
            header("location: nutzer_app_data.php");
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
