<!--
sudo /Applications/XAMPP/xamppfiles/bin/mysql.server start
sudo /Applications/XAMPP/xamppfiles/xampp startapache
-->
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style.css" />
    <title>fitness</title>
</head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <header>
        <div id="rest" onclick="changeDisplay()"></div>
        <div id="info" onclick="changeDisplay()">
            <div id="gain"></div>
        </div>
    </header>

    <section>
        <a href="add_workout.php" class="workout center">+</a>
        <div id="workout" class="dual">
            <a href="registrieren.php" class="center">Registrieren</a>
            <a href="login.php" class="center">Login</a>
        </div>
        <a href="impressum.php" class="workout center">Impressum</a>
    </section>

    <script src="change_display.js"></script>
    <script src="fetch_rest.js"></script>
    <script src="fetch_workout.js"></script>
    <script src="fetch_gain.js"></script>
</body>
</html>
