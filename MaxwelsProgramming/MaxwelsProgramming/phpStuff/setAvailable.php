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

    $user = $_GET['user'];
    $setFree = $conn->query("UPDATE programmer p INNER JOIN user u ON u.ID = p.P_ID SET p.Status = 'AVAILABLE' WHERE u.Username = '$user'") or die($conn->error);
?>