<?php
session_start();
$loggedIn = isset($_SESSION["nutzer_id"]);
$nutzer_id = $loggedIn ? $_SESSION["nutzer_id"] : "999999";
$userName = $loggedIn ? $_SESSION["f_name"] : "";
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitness-Tracker</title>
    <link rel="icon" href="gewichtheben.png" type="image/png">
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <header>
        <?php if ($loggedIn): ?>
            <div class="user-info btn">
                <div class="user-name">Hallo, <?php echo htmlspecialchars(
                    $userName
                ); ?></div>
            </div>
            <a href="logout.php" class="btn">Abmelden</a>
        <?php else: ?>
            <a href="registrieren.php" class="btn">Registrieren</a>
            <a href="login.php" class="btn">Anmelden</a>
        <?php endif; ?>
    </header>
    <section>
        <h2>Rest-Time
            <span class="info-icon" onclick="showPopup()">i</span>
        </h2>
        <div id="rest"></div>
        <div id="popup" class="popup">
            <p>Die angezeigte "Rest-Time" zeigt die Zeit an, die die Muskelgruppen benötigen, um sich vollständig zu erholen, damit sie erneut trainiert werden können.</p>
            <button onclick="hidePopup()">Schließen</button>
        </div>
    </section>
    <section>
        <?php if ($loggedIn): ?>
            <h2>Letzte Workouts</h2>
            <a href="add_workout.php" class="box">+</a>
            <div class="divider_line"></div>
            <div class="latest-workouts">
                <!-- Insert workouts here -->
            </div>
        <?php else: ?>
            <h2>Letzte Workouts</h2>
            <a href="add_workout.php" class="box">+</a>
            <div class="divider_line"></div>
            <div class="box">Not logged in</div>
        <?php endif; ?>
    </section>
    <section>
        <h2>Gewichtsverlauf</h2>
        <div class="chart-container">
            <div id="weight"></div>
        </div>
        <form id="weightForm" action="add_weight.php" method="POST">
            <input type="number" name="weight" step="0.1" placeholder="Gewicht (kg)" required>
            <button type="submit">Gewicht aktualisieren</button>
        </form>
    </section>
    <section>
        <h2>Volumenverlauf</h2>
        <div class="chart-container">
            <div id="gain"></div>
        </div>
    </section>
    <section>
        <a href="impressum.php" class="box">Impressum und Kontakt</a>
    </section>
    <script src="fetch_workout.js"></script>
    <script src="fetch_gain.js"></script>
    <script src="fetch_rest.js"></script>
    <script src="fetch_weight.js"></script>
    <script>
        function showPopup() {
            document.getElementById("popup").style.display = "block";
        }
        function hidePopup() {
            document.getElementById("popup").style.display = "none";
        }
    </script>
</body>
</html>
