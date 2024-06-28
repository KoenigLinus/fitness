<!-- sudo /Applications/XAMPP/xamppfiles/bin/mysql.server start -->
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
            <script src="fetch_workout.js"></script>
            <a href="add_workout.php" class="workout center">+</a>
            <a href="impressum.php" class="workout center">Impressum und Kontakt</a>
            <a href="registrieren.php" class="workout center">Regitrieren</a>
            <a href="impressum.php" class="workout center">Login</a>
        </section>


        <a href=".php">Registieren</a>
        <a href="login.php">Login</a>

        <script src="change_display.js"></script>
        <script src="fetch_gain.js"></script>
        <script src="fetch_rest.js"></script>
    </body>
</html>
