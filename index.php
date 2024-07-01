<?php
session_start();

// Debugging: Ausgabe der Session-Variablen
//echo "<pre>";
//var_dump($_SESSION);
//echo "</pre>";

// Check if user is logged in
$loggedIn = isset($_SESSION["nutzer_id"]);
$nutzer_id = $loggedIn ? $_SESSION["nutzer_id"] : "999999";
// Retrieve user's first name if logged in
$userName = $loggedIn ? $_SESSION["f_name"] : "";
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitness</title>
    <link rel="icon" href="fitnessstudio.png" type="image/png">
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <header>
        <?php if ($loggedIn): ?>
            <div class="user-info btn">
                <div class="user-name">Hallo, <?php echo htmlspecialchars(
                    $userName
                ); ?>. Du bist Angemeldet</div>
            </div>
            <a href="logout.php" class="btn">Abmelden</a>
        <?php else: ?>
            <a href="registrieren.php" class="btn">Registrieren</a>
            <!--<a href="anmelden.php" class="login-btn">Anmelden</a>-->
            <a href="login.php" class="btn">Anmelden</a>
        <?php endif; ?>
    </header>

    <section>
        <div id="rest" onclick="changeDisplay()"></div>
        <div id="info" onclick="changeDisplay()">
            <div id="gain"></div>
        </div>
    </section>

    <section>
        <?php if ($loggedIn): ?>
            <h2>Letzte Workouts</h2>
            <a href="add_workout.php" class="box">+</a>
            <div class="divider_line"></div>
            <div class="latest-workouts">
                <div id="latest-workouts-list"></div>
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
    </section>

    <section>
        <a href="impressum.php" class="box">Impressum und Kontakt</a>
    </section>

    <script src="fetch_workout.js"></script>
    <script src="change_display.js"></script>
    <script src="fetch_gain.js"></script>
    <script src="fetch_rest.js"></script>
    <script src="fetch_weight.js"></script>
</body>
</html>
