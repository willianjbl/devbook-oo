<?php

use Devbook\models\Session;

// CARREGANDO CONFIGURAÇÕES
require 'constants.php';
require 'db.php';
require 'vendor/autoload.php';

// INICIANDO A SESSÃO
Session::initialize();

// INICIANDO CONEXÃO COM O BANCO DE DADOS
$pdo = new Sql();

// DEFININDO A HORA LOCAL
date_default_timezone_set('America/Sao_Paulo');
