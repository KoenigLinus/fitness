<?php
session_start();
$loggedIn = isset($_SESSION["nutzer_id"]);
$userName = $loggedIn ? $_SESSION["f_name"] : "";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitness</title>
    <link rel="icon" href="fitnessstudio.png" type="image/png">
    <style>
        html {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        body {
            font-family: Verdana, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh;
            margin: 0;
            width: 60vw;
        }
        * {
            font-family: Helvetica, sans-serif;
        }
        section {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        header, section {
            width: 100%;
            margin-top: 20px;

            width: 100%;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
            border-radius: 8px;
        }
        .register-btn, .login-btn {
            background-color: #f39f18;
            color: #fff;
            text-decoration: none;
            padding: 10px 10px;
            border-radius: 20px;
        }
        .register-btn:hover, .login-btn:hover {
            background-color: #ec7c26;
        }
        .box {
            display: block;
            width: 100%;
            text-align: center;
            background-color: #f39f18;
            color: #fff;
            text-decoration: none;
            padding: 15px 0;
            border-radius: 4px;
        }
        .box:hover {
            background-color: #ec7c26;
        }
        .chart-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            box-sizing: border-box;
        }
        h1 {
            color: #333;
            font-size: 24px;
            text-align: center;
            margin: 0;
        }
        .latest-workouts{
            display: <?php echo $loggedIn ? "block" : "none"; ?>;
            width: 100%;
            text-align: center;
            background-color: #fff;
            color: #333;
            padding: 10px;
            margin: 10px 10px;
            border-radius: 4px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
        }
        .latest-workouts h2 {
            margin: 0;
            padding: 10px 0;
        }
        .latest-workouts p {
            margin: 0;
            padding: 5px 0;
        }
        .divider_line {
            width: 100%;
            height: 2px;
            background-color: #f39f18;
            margin: 10px 0;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</head>
<body>

    <header>
        <a href="registrieren.php" class="register-btn">Registrieren</a>
        <a href="anmelden.php" class="login-btn">Anmelden</a>
        <?php if ($loggedIn): ?>
            <div class="user-name"><?php echo htmlspecialchars(
                $userName
            ); ?></div>
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
            <div id="weigthChart"></div>
        </div>
    </section>

    <section>
        <a href="impressum.php" class="box">Impressum und Kontakt</a>
    </section>

    <script src="fetch_workout.js"></script>
    <script src="change_display.js"></script>
    <script src="fetch_gain.js"></script>
    <script src="fetch_rest.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var weigthOptions = {
                chart: {
                    type: 'line',
                    height: '100%'
                },
                series: [{
                    name: 'Weight',
                    data: [30, 40, 35, 50, 49, 60, 70, 91, 125]
                }],
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep']
                },
                responsive: [{
                    breakpoint: 600,
                    options: {
                        chart: {
                            width: '100%'
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            };
            var weigthChart = new ApexCharts(document.querySelector("#weigthChart"), weigthOptions);
            weigthChart.render();


            <?php if ($loggedIn): ?>
            fetch('fetch_latest_workouts.php')
                .then(response => response.json())
                .then(data => {
                    const workoutsList = document.getElementById('latest-workouts-list');
                    data.forEach(workout => {
                        const workoutItem = document.createElement('p');
                        workoutItem.textContent = `${workout.date}: ${workout.description}`;
                        workoutsList.appendChild(workoutItem);
                    });
                });
            <?php endif; ?>
        });
    </script>
</body>
</html>
