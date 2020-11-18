<div class="flash-box" <?= !empty($flash['message']) ? 'style="display:block"' : '' ?>>
    <div class="flash <?= !empty($flash['type']) ? "{$flash['type']}" : '' ?>">
        <?= $flash['message'] ?? '' ?>
    </div>
</div>