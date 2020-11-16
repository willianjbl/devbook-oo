<?php
require 'config/config.php';

$flash = \Devbook\functions\Common::getFlash();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8" />
    <title>Devbook | Sign-Up</title>
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1"/>
    <link rel="stylesheet" href="<?= BASE ?>/assets/css/login.css" />
</head>
<body>
<header>
    <div class="container">
        <a href="<?= BASE ?>"><img src="<?= BASE ?>/assets/images/devsbook_logo.png" alt="Logo" /></a>
    </div>
</header>
<section class="container main">

    <div class="flash-box" <?= !empty($flash['message']) ? 'style="display:block"' : '' ?>>
        <div class="flash <?= !empty($flash['type']) ? "{$flash['type']}" : '' ?>">
            <?= $flash['message'] ?? '' ?>
        </div>
    </div>

    <form method="POST" action="<?= BASE ?>/signup_action.php">

        <input placeholder="Digite seu Nome Completo" class="input" type="password" name="password" />

        <input placeholder="Digite seu E-mail" class="input" type="email" name="email" />

        <input placeholder="Digite sua Senha" class="input" type="password" name="password" />

        <input placeholder="Digite sua Senha Novamente" class="input" type="password" name="repassword" />

        <input placeholder="Digite sua Data de Nascimento" class="input" type="text" name="birthdate" id="birthdate" />

        <input class="button" type="submit" value="Cadastrar" />

        <a href="<?= BASE ?>/login.php">Já tem conta? Faça seu Login</a>
    </form>
</section>

<script src="https://unpkg.com/imask"></script>
<script src="<?= BASE ?>/assets/js/flash.js"></script>
<script src="<?= BASE ?>/assets/js/signup.js"></script>
</body>
</html>
