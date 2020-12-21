<div class="box feed-new">
    <div class="box-body">
        <div class="feed-new-editor m-10 row">
            <div class="feed-new-avatar">
                <img src="<?= BASE ?>/media/avatars/<?= $user->getAvatar() ?>" alt=""/>
            </div>
            <div class="feed-new-input-placeholder">O que você está pensando, <?= $user->getName() ?>?</div>
            <div class="feed-new-input" contenteditable="true"></div>
            <div class="feed-new-photo">
                <img src="<?= BASE ?>/assets/images/photo.png"  alt=""/>
                <input type="file" name="photo" class="feed-new-file" accept="image/jpeg, image/jpg, image/png, image/webp"/>
            </div>
            <div class="feed-new-send">
                <img src="<?= BASE ?>/assets/images/send.png"  alt=""/>
            </div>
            <form id="feed-new-post" method="post" action="<?= BASE ?>/post_action.php">
                <input type="hidden" name="body">
            </form>
        </div>
    </div>
</div>

<script src="<?= BASE ?>/assets/js/new-post.js"></script>