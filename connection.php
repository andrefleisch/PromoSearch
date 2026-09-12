<?php
    $host = getenv('DB_HOST') ?: 'localhost';
    $port = getenv('DB_PORT') ?: '3307';
    $username = getenv('DB_USER') ?: 'root';
    $password = getenv('DB_PASSWORD') ?: '';
    $dbname = getenv('DB_NAME') ?: 'PromoSearch';

    $conn = new mysqli($host, $username, $password, $dbname, (int) $port);
    if ($conn->connect_error) {
        die("Erro na conexão: " . $conn->connect_error);
    }
?>
