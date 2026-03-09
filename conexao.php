<?php

$host = '142.93.181.222';
$db   = 'sgf_redeliceu_com_br';
$user = 'samuel_bd';
$pass = "A_#Samuel_2025";
$charset = 'utf8mb4';


$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // lança exceções em erros
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,        // resultados como array associativo
    PDO::ATTR_EMULATE_PREPARES   => false,                   // desativa emulação de prepared statements
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    echo "Conexão bem-sucedida!";
} catch (\PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage();
}
