<?php
switch ($feed->getType()) {
    case 'text':
        $type = 'fez um post';
        break;
    case 'photo':
        $type = 'publicou uma foto';
        break;
}
?>

<div class="box feed-item" data-id="<?= $feed->getId() ?>">
    <div class="box-body">
        <div class="feed-item-head row mt-20 m-width-20">
            <div class="feed-item-head-photo">
                <a href="<?= BASE ?>/profile.php?id=<?= $feed->getAuthor()->getId() ?>">
                    <img src="<?= BASE ?>/media/avatars/<?= $feed->getAuthor()->getAvatar() ?>"  alt="avatar do usuário"/>
                </a>
            </div>
            <div class="feed-item-head-info">
                <a href="<?= BASE ?>/profile.php?id=<?= $feed->getAuthor()->getId() ?>"><span class="fidi-name"><?= $feed->getAuthor()->getName() ?></span></a>
                <span class="fidi-action"><?= $type ?></span>
                <br/>
                <span class="fidi-date">
                    <?= \Devbook\utility\CommonDate::brazilianDateTimeConvert($feed->getCreatedAt()) ?>
                </span>
            </div>

            <?php if ($feed->isAuthor): ?>
                <div class="feed-item-head-btn">
                    <img src="<?= BASE ?>/assets/images/more.png"  alt="opções"/>
                    <div class="feed-item-more-window">
                        <a href="<?= BASE ?>/excluir_post_action.php?id=<?= $feed->getId() ?>">Excluir</a>
                    </div>
                </div>
            <?php endif; ?>

        </div>
        <div class="feed-item-body mt-10 m-width-20">

            <?php if ($feed->getType() === 'text'): ?>
                <?= nl2br($feed->getBody()) ?>
            <?php elseif($feed->getType() === 'photo'): ?>
                <a href="<?= BASE ?>/media/uploads/<?= $feed->getBody() ?>" class="glightbox" data-gallery="<?= $feed->getBody() ?>">
                    <img src="<?= BASE ?>/media/uploads/<?= $feed->getBody() ?>"  alt="photo"/>
                </a>
            <?php endif; ?>

        </div>
        <div class="feed-item-buttons row mt-20 m-width-20">
            <div class="like-btn <?= $feed->liked ? 'on' : '' ?>"><?= $feed->likeCount ?></div>
            <div class="msg-btn"><?= count($feed->comments) ?></div>
        </div>
        <div class="feed-item-comments">
            <div class="feed-item-comments-area">

                <?php foreach ($feed->comments as $comment): ?>
                    <div class="fic-item row m-height-10 m-width-20">
                        <div class="fic-item-photo">
                            <a href="<?= BASE . "/profile.php?id={$comment->user->getId()}" ?>"><img src="<?= BASE ?>/media/avatars/<?= $comment->user->getAvatar() ?>"  alt="avatar do usuário"/></a>
                        </div>
                        <div class="fic-item-info">
                            <a href="<?= BASE . "/profile.php?id={$comment->user->getId()}" ?>"><?= $comment->user->getName() ?></a>
                            <?= $comment->getBody() ?>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>
            <div class="fic-answer row m-height-10 m-width-20">
                <div class="fic-item-photo">
                    <a href="<?= BASE ?>/profile.php">
                        <img src="<?= BASE ?>/media/avatars/<?= $user->getAvatar() ?>" alt="avatar do usuário"/>
                    </a>
                </div>
                <input type="text" class="fic-item-field" placeholder="Escreva um comentário" />
            </div>

        </div>
    </div>
</div>
