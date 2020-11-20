<?php

use Devbook\utility\CommonDate;

?>

<div class="box">
    <div class="box-body">

        <div class="user-info-mini">
            <img src="<?= BASE ?>/assets/images/calendar.png"  alt=""/>
            <?= CommonDate::brazilianDateConvert($profileUser->getBirthdate()) ?> (<?= CommonDate::getAge($profileUser->getBirthdate()) ?> anos)
        </div>

        <?php if (!empty($profileUser->getCity())): ?>
            <div class="user-info-mini">
                <img src="<?= BASE ?>/assets/images/pin.png"  alt=""/>
                <?= $profileUser->getCity() ?? '' ?>, Brasil
            </div>
        <?php endif; ?>

        <?php if (!empty($profileUser->getWork())): ?>
            <div class="user-info-mini">
                <img src="<?= BASE ?>/assets/images/work.png"  alt=""/>
                <?= $profileUser->getWork() ?? '' ?>
            </div>
        <?php endif; ?>

    </div>
</div>

<div class="box">
    <div class="box-header m-10">
        <div class="box-header-text">
            Seguindo
            <span>(<?= count($profileUser->followings) ?>)</span>
        </div>
        <div class="box-header-buttons">
            <a href="">ver todos</a>
        </div>
    </div>
    <div class="box-body friend-list">

        <?php foreach ($profileUser->followings as $following): ?>
            <div class="friend-icon">
                <a href="">
                    <div class="friend-icon-avatar">
                        <img src="<?= BASE ?>/media/avatars/<?= $following->user->getAvatar() ?>"  alt=""/>
                    </div>
                    <div class="friend-icon-name">
                        <?= $following->user->getName() ?>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>

    </div>
</div>
