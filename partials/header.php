<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8" />
    <title>Devsbook | <?= !empty($title) ? $title : 'Home' ?></title>
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1"/>
    <link rel="stylesheet" href="<?= BASE ?>/assets/css/style.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">
</head>
<body>
    <header>
        <div class="container">
            <div class="logo">
                <a href="<?= BASE ?>"><img src="<?= BASE ?>/assets/images/devsbook_logo.png"  alt="Logo"/></a>
            </div>
            <div class="head-side">
                <div class="head-side-left">
                    <div class="search-area">
                        <form method="GET" action="<?= BASE ?>/search.php">
                            <input type="search" placeholder="Pesquisar" name="s" />
                        </form>
                    </div>
                </div>
                <div class="head-side-right">
                    <a href="" class="user-area">
                        <div class="user-area-text"><?= $user->getName() ?></div>
                        <div class="user-area-icon">
                            <img src="<?= BASE ?>/media/avatars/<?= $user->getAvatar() ?>" alt="Avatar"/>
                        </div>
                    </a>
                    <a href="<?= BASE ?>/logout.php" class="user-logout">
                        <img src="<?= BASE ?>/assets/images/power_white.png"  alt="Logout"/>
                    </a>
                </div>
            </div>
        </div>
    </header>
    <section class="container main">
