<?php

$host = 'localhost';
$dbname = 'shopee_clone';
$username = 'root';
$password = '';

try {

    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (PDOException $e) {

    die("Erro ao conectar com a Shopee pirata: " . $e->getMessage());
}

?>
