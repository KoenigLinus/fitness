<?php
session_start();
if (isset($_SESSION["nutzer_id"])) {
} else {
    // header("location: index.html");
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dateneingabe</title>
    <style>
        body {
            font-family: Verdana, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .eingabe-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        .eingabe-container h2 {
            margin-bottom: 20px;
            text-align: center;
        }
        .eingabe-container label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .eingabe-container input {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .eingabe-container button {
            width: 100%;
            background-color: #f39f18;
            color: #fff;
            border: none;
            padding: 10px;
            cursor: pointer;
            border-radius: 4px;
        }
        .eingabe-container button:hover {
            background-color: #ec7c26;
        }
    </style>
</head>
<body>
    <div class="eingabe-container">
        <h2>Dateneingabe</h2>
        <form action="insert_data.php" method="post">
            <label for="datum">Datum (von Heute):</label>
            <input type="date" id="datum" name="datum" required>

            <label for="gewicht">Gewicht (in kg):</label>
            <input type="number" step="0.01" id="gewicht" name="gewicht" required>

            <button type="submit">Daten einreichen</button>
        </form>
    </div>
</body>
</html>
