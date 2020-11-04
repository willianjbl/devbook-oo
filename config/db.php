<?php

try {
    $pdo = new PDO('mysql:dbname=' . DB_NAME . ';host=' . DB_HOST, DB_USER, DB_PASS);
} catch (PDOException $e) {
    $erro = utf8_encode($e->getMessage());

    echo '<pre>';
    echo "Falha ao conectar ao banco de dados\n";
    echo "Erro: $erro\n";
    echo "Código: {$e->getCode()}\n";
    exit;
}
