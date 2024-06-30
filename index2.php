<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitness</title>
    <link rel="icon" href="fitnessstudio.png" type="image/png">
    <style>
        body {
            font-family: Verdana, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 10px;
        }
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            max-width: 600px;
            background-color: #fff;
            padding: 10px 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
            border-radius: 8px; 
        }
        header div {
            cursor: pointer;
            padding: 10px;
        }
        .user-name {
            font-size: 18px;
            color: #333;
        }
        .login-btn {
            background-color: #f39f18;
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
        }
        .login-btn:hover {
            background-color: #ec7c26;
        }
        section {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            max-width: 600px;
            margin-top: 20px;
        }
        a.workout {
            display: block;
            width: 100%;
            text-align: center;
            background-color: #f39f18;
            color: #fff;
            text-decoration: none;
            padding: 15px;
            margin: 10px 0;
            border-radius: 4px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
        }
        a.workout:hover {
            background-color: #ec7c26;
        }
        .chart-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            box-sizing: border-box;
            margin-top: 20px;
        }
        h1 {
            color: #333;
            font-size: 24px;
            text-align: center;
            margin: 0;
        }
        .latest-workouts {
            width: 100%;
            text-align: center;
            background-color: #fff;
            color: #333;
            padding: 10px;
            margin: 10px 0;
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
    </style>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</head>
<body>
    <?php
    session_start();
    $loggedIn = isset($_SESSION['nutzer_id']);
    $userName = $loggedIn ? $_SESSION['f_name'] : '';
    ?>

    <header>
        <div id="rest" onclick="changeDisplay()"></div>
        <div id="info" onclick="changeDisplay()">
            <div id="gain"></div>
        </div>
        <?php if ($loggedIn): ?>
            <div class="user-name"><?php echo htmlspecialchars($userName); ?></div>
            <a href="#" class="login-btn">Angemeldet</a>
        <?php endif; ?>
    </header>

    <section>
        <a href="add_workout.php" class="workout center">+</a>
        <div class="latest-workouts">
            <h2>Letzte Workouts</h2>
            <div id="latest-workouts-list"></div>
        </div>
        <a href="impressum.php" class="workout">Impressum und Kontakt</a>
        <div class="chart-container">
            <div id="chart"></div>
        </div>
    </section>

    <script src="fetch_workout.js"></script>
    <script src="change_display.js"></script>
    <script src="fetch_gain.js"></script>
    <script src="fetch_rest.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var options = {
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
            var chart = new ApexCharts(document.querySelector("#chart"), options);
            chart.render();

            // Fetch and display the latest workouts
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
        });
    </script>
</body>
</html>

