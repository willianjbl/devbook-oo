<?php

use Devbook\models\Session;

// CARREGANDO CONFIGURAÇÕES E REQUÍSITOS
require 'constants.php';
require 'MySql.php';
require 'vendor/autoload.php';

// INICIANDO A SESSÃO
Session::initialize();

// INICIANDO CONEXÃO COM O BANCO DE DADOS
$pdo = new MySql();

// DEFININDO A HORA LOCAL
date_default_timezone_set('America/Sao_Paulo');
