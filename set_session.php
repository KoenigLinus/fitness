<?php
// set_session.php

session_start();

if (isset($_POST["nutzer_id"])) {
    $_SESSION["nutzer_id"] = $_POST["nutzer_id"];
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "fail", "message" => "nutzer_id not set"]);
}
?>
