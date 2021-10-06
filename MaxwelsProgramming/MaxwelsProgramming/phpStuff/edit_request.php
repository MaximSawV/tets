<?php
    $servername = "db";
    $username = "maxim";
    $password = "maxim_password";
    $dbname ="maxwels";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }
    $newDeadline = $_GET['newDate'];
    $rid = $_GET['request'];
    $method = $_GET['method'];
    if ($_GET['method'] == "edit") {
        $updateDate = $conn->query("UPDATE `requests` SET `Deadline` = '$newDeadline' WHERE `R_ID` = '$rid'") or die($conn->error);
    }

    if ($_GET['method'] == "delete") {
        $deleteRequest = $conn->query("DELETE FROM `requests` WHERE `R_ID` = '$rid'") or die($conn->error);
    }
?>
