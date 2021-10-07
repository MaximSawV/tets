<?php
    session_start();

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
    if (isset($_GET['request'])) {
        $rid = $_GET['request'];
        $pid = $_SESSION['id'];
        $updateRequest = $conn->query("UPDATE `requests` SET `Status` = 'DONE' WHERE `R_ID` = '$rid'") or die($conn->error);
        var_dump($updateRequest);
    }
?>