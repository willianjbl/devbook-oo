<?php
    $flash = \Devbook\utility\Common::getFlash();
?>

<div class="flash-box" <?= !empty($flash['message']) ? 'style="display:block"' : '' ?>>
    <div class="flash <?= !empty($flash['type']) ? "{$flash['type']} flash-open" : '' ?>">
        <?= $flash['message'] ?? '' ?>
    </div>
</div>
