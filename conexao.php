<?php
require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$host    = $_ENV['DB_HOST'];
$usuario = $_ENV['DB_USER'];
$senha   = $_ENV['DB_PASS'];
$banco   = $_ENV['DB_NAME'];
$charset = "utf8mb4";

$dsn = "mysql:host=$host;dbname=$banco;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
     $pdo = new PDO($dsn, $usuario, $senha, $options);
} catch (\PDOException $e) {
     die("Erro ao conectar com o banco de dados.");
}
?>