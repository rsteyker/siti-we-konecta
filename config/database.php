<!-- Conexión a la base de datos -->
<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "konecta_cafeteria";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }
?>