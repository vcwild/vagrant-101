<?php
    echo "Connection test <br/><br/>";
    $servername = "192.168.15.152";
    $username = "phpuser";
    $password = "pass";

    $conn = new mysqli($servername, $username, $password);

    if ($conn->connect_error) {
        die("Failed to connect to database: " . $conn->connect_error);
    }
    echo "Connection success!";
?>