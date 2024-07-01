<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database configuration file
    require_once "config.php";

    // Establish database connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare user input for database query
    $email = $conn->real_escape_string($_POST["email"]);
    $password = $_POST["password"];

    // SQL query to fetch user from database based on email
    $sql = "SELECT nutzer_id, f_name, pas FROM nutzer WHERE e_mail = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $email);

        // Execute the prepared statement
        if ($stmt->execute()) {
            // Store result
            $stmt->store_result();

            // Check if email exists in database
            if ($stmt->num_rows == 1) {
                // Bind result variables
                $stmt->bind_result($nutzer_id, $f_name, $hashed_password);
                if ($stmt->fetch()) {
                    // Verify hashed password
                    if (password_verify($password, $hashed_password)) {
                        // Password correct, set session variables
                        $_SESSION["nutzer_id"] = $nutzer_id;
                        $_SESSION["f_name"] = $f_name;

                        var_dump($_SESSION);

                        // Redirect to authenticated user's page
                        header("location: index.php");
                        exit();
                    } else {
                        // Password incorrect
                        $error_message = "Falsches Passwort.";
                    }
                }
            } else {
                // No user found with given email
                $error_message = "Kein Benutzer mit dieser E-Mail gefunden.";
            }
        } else {
            // SQL execution error
            $error_message = "SQL-Fehler: " . $stmt->error;
        }

        // Close statement
        $stmt->close();
    } else {
        // SQL statement preparation error
        $error_message =
            "Fehler bei der Vorbereitung des SQL-Statements: " . $conn->error;
    }

    // Close connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
        }
        .anmelde-container button:hover {
            background-color: #ec7c26;
        }
        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }
        .user-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #fff;
            padding: 10px 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            width: 90%;
            max-width: 400px;
            box-sizing: border-box;
        }
        .user-info span {
            font-size: 1em;
        }
        .user-info form {
            margin: 0;
        }
        .user-info button {
            background-color: #f39f18;
            color: #fff;
            border: none;
            padding: 10px;
            cursor: pointer;
            border-radius: 4px;
            font-size: 1em;
        }
        .user-info button:hover {
            background-color: #ec7c26;
        }
    </style>
</head>
<body>
    <div class="anmelde-container">
        <h2>Login</h2>
        <?php if (isset($error_message)) { ?>
            <p style="color: red;"><?php echo $error_message; ?></p>
        <?php } ?>
        <form action="<?php echo htmlspecialchars(
            $_SERVER["PHP_SELF"]
        ); ?>" method="post">
            <label for="email">E-Mail:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Passwort:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
