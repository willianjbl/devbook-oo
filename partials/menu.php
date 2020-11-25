<aside class="mt-10">
    <nav>
        <a href="<?= BASE ?>">
            <div class="menu-item <?= empty($activeMenu) || $activeMenu === 'home' ? 'active' : '' ?>">
                <div class="menu-item-icon">
                    <img src="<?= BASE ?>/assets/images/home-run.png" width="16" height="16"  alt=""/>
                </div>
                <div class="menu-item-text">
                    Home
                </div>
            </div>
        </a>
        <a href="<?= BASE ?>/profile.php">
            <div class="menu-item <?= $activeMenu === 'profile' ? 'active' : '' ?>">
                <div class="menu-item-icon">
                    <img src="<?= BASE ?>/assets/images/user.png" width="16" height="16"  alt=""/>
                </div>
                <div class="menu-item-text">
                    Meu Perfil
                </div>
            </div>
        </a>
        <a href="<?= BASE ?>/friends.php">
            <div class="menu-item <?= $activeMenu === 'friends' ? 'active' : '' ?>">
                <div class="menu-item-icon">
                    <img src="<?= BASE ?>/assets/images/friends.png" width="16" height="16"  alt=""/>
                </div>
                <div class="menu-item-text">
                    Amigos
                </div>
            </div>
        </a>
        <a href="<?= BASE ?>/photos.php">
            <div class="menu-item <?= $activeMenu === 'photos' ? 'active' : '' ?>">
                <div class="menu-item-icon">
                    <img src="<?= BASE ?>/assets/images/photo.png" width="16" height="16"  alt=""/>
                </div>
                <div class="menu-item-text">
                    Fotos
                </div>
            </div>
        </a>
        <div class="menu-splitter"></div>
        <a href="<?= BASE ?>/settings.php">
            <div class="menu-item <?= $activeMenu === 'settings' ? 'active' : '' ?>">
                <div class="menu-item-icon">
                    <img src="<?= BASE ?>/assets/images/settings.png" width="16" height="16"  alt=""/>
                </div>
                <div class="menu-item-text">
                    Configurações
                </div>
            </div>
        </a>
        <a href="<?= BASE ?>/logout.php">
            <div class="menu-item">
                <div class="menu-item-icon">
                    <img src="<?= BASE ?>/assets/images/power.png" width="16" height="16"  alt=""/>
                </div>
                <div class="menu-item-text">
                    Sair
                </div>
            </div>
        </a>
    </nav>
</aside>