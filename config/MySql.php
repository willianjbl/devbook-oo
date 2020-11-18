<?php

class MySql extends PDO
{
    private const DB_NAME = 'devbook';
    private const DB_HOST = 'localhost';
    private const DB_USER = 'root';
    private const DB_PASS = '';

    public function __construct()
    {
        try {
            return parent::__construct(
                'mysql:dbname=' . self::DB_NAME . ';host=' . self::DB_HOST,
                self::DB_USER,
                self::DB_PASS, [
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'utf8\'',
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
                ]
            );
        } catch (PDOException $e) {
            $erro = utf8_encode($e->getMessage());

            echo '<pre>';
            echo "Falha ao conectar ao banco de dados\n";
            echo "Erro: $erro\n";
            echo "Código: {$e->getCode()}\n";
            exit;
        }
    }
}
