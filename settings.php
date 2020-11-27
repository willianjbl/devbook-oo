<?php

use Devbook\models\Auth;
use Devbook\utility\{
    Common,
    CommonDate
};

require 'config/config.php';

$auth = new Auth($pdo);
$user = $auth->verifyToken();

Common::renderPartial('header', [
    'title' => 'Settings',
    'user' => $user
]);
Common::renderPartial('menu', ['activeMenu' => 'settings']);
Common::renderFlash();
?>
    <link rel="stylesheet" href="<?= BASE ?>/assets/css/settings.css">

    <section class="feed mt-10">
        <div class="row">
            <div class="column pr-5">

                <form action="<?= BASE ?>/settings_action.php" method="post" id="settings-form" enctype="multipart/form-data">
                    <h1>Configurações</h1>
                    <h3>Avatar</h3>
                    <input type="file" name="avatar" id="avatar">
                    <img class="settings-thumbnail" src="<?= BASE ?>/media/avatars/<?= $user->getAvatar() ?>" alt="avatar do usuário">
                    <hr>
                    <h3>Imagem de Fundo</h3>
                    <input type="file" name="cover" id="cover">
                    <img class="settings-thumbnail" src="<?= BASE ?>/media/covers/<?= $user->getCover() ?>" alt="fundo do perfil">
                    <hr>
                    <h3>Informações Pessoais</h3>
                    <label for="name">Nome:</label>
                    <input type="text" id="name" name="name" value="<?= $user->getName() ?>" required>
                    <label for="email">E-mail:</label>
                    <input type="email" id="email" name="email" value="<?= $user->getEmail() ?>" required>
                    <label for="birthdate">Data de Nascimento:</label>
                    <input type="text" id="birthdate" name="birthdate" value="<?=  CommonDate::brazilianDateConvert($user->getBirthDate()) ?>" required>
                    <label for="city">Cidade:</label>
                    <input type="text" id="city" name="city" value="<?= $user->getCity() ?>">
                    <label for="work">Trabalho:</label>
                    <input type="text" id="work" name="work" value="<?= $user->getWork() ?>">
                    <hr>
                    <h3>Alterar Senha</h3>
                    <label for="password">Senha:</label>
                    <input type="password" id="password" name="password">
                    <label for="repassword">Redigite sua Senha:</label>
                    <input type="password" id="repassword" name="repassword">

                    <button class="button" type="submit">Salvar</button>
                </form>

            </div>
            <div class="column side pl-5">

                <?php Common::renderPartial('notifications'); ?>

            </div>
        </div>
    </section>

    <script src="https://unpkg.com/imask"></script>
    <script src="<?= BASE ?>/assets/js/signup.js"></script>
<?php
Common::renderPartial('footer');
