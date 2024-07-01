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
    <title>Workout</title>
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
        .anmelde-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 400px;
            box-sizing: border-box;
        }
        .anmelde-container h2 {
            margin-bottom: 20px;
            text-align: center;
            font-size: 1.5em;
        }
        .anmelde-container label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            font-size: 1em;
        }
        .anmelde-container select,
        .anmelde-container input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 1em;
        }
        .anmelde-container button {
            width: 100%;
            background-color: #f39f18;
            color: #fff;
            border: none;
            padding: 10px;
            cursor: pointer;
            border-radius: 4px;
            font-size: 1em;
            margin-bottom: 10px;
        }
        .anmelde-container button:hover {
            background-color: #ec7c26;
        }
        .exercise-block {
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 10px;
            margin-bottom: 10px;
        }
        .exercise-title {
            display: flex;
            justify-content: space-between;
            cursor: pointer;
        }
        .exercise-content {
            display: none;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="anmelde-container">
        <h2>Workout</h2>
        <form action="insert_exercise.php" method="post">
            <label for="split">Split:</label>
            <select id="split" name="split" required>
                <option value="Arme">Arme</option>
                <option value="Beine">Beine</option>
                <option value="Push">Push</option>
                <option value="Pull">Pull</option>
                <option value="Oberkörper">Oberkörper</option>
                <option value="Unterkörper">Unterkörper</option>
                <option value="Ganzkörper">Ganzkörper</option>
            </select>

            <div id="exercises">
                <div class="exercise-block">
                    <div class="exercise-title" onclick="toggleExercise(this)">
                        <span>Übung 1</span>
                        <span>+</span>
                    </div>
                    <div class="exercise-content">
                        <label for="exercise">Übung:</label>
                        <select id="exercise" name="exercises[]">
                            <?php
                            require_once "config.php";

                            $conn = new mysqli(
                                $servername,
                                $username,
                                $password,
                                $dbname
                            );

                            if ($conn->connect_error) {
                                die(
                                    "Verbindung fehlgeschlagen: " .
                                        $conn->connect_error
                                );
                            }

                            // Übungen abrufen
                            $sql = "SELECT übung_id, übung_b FROM übungen";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo '<option value="' .
                                        $row["übung_id"] .
                                        '">' .
                                        $row["übung_b"] .
                                        "</option>";
                                }
                            } else {
                                echo '<option value="">Keine Übungen verfügbar</option>';
                            }
                            ?>
                        </select>

                        <label for="sets">Sätze:</label>
                        <input type="number" id="sets" name="sets[]" required>

                        <label for="reps">Wiederholungen:</label>
                        <input type="number" id="reps" name="reps[]" required>

                        <label for="weight">Gewicht (kg):</label>
                        <input type="number" id="weight" name="weight[]" required>
                    </div>
                </div>
            </div>

            <button type="button" onclick="addExercise()">Weitere Übung hinzufügen</button>
            <button type="submit">Eintragen</button>
        </form>
    </div>

    <script>
        let exerciseCount = 1;

        function addExercise() {
            exerciseCount++;
            var exerciseBlock = document.querySelector('.exercise-block');
            var newExerciseBlock = exerciseBlock.cloneNode(true);
            newExerciseBlock.querySelector('.exercise-title span:first-child').innerText = "Übung " + exerciseCount;
            newExerciseBlock.querySelector('.exercise-content').style.display = "none";
            newExerciseBlock.querySelector('.exercise-title span:last-child').innerText = "+";
            document.getElementById('exercises').appendChild(newExerciseBlock);
        }

        function toggleExercise(element) {
            var content = element.nextElementSibling;
            if (content.style.display === "none") {
                content.style.display = "block";
                element.querySelector("span:last-child").innerText = "-";
            } else {
                content.style.display = "none";
                element.querySelector("span:last-child").innerText = "+";
            }
        }
    </script>
</body>
</html>
