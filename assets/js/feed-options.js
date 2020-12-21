function closeFeedWindow() {
    document.querySelectorAll('.feed-item-more-window').forEach(item => {
        item.style.display = 'none';
    });

    document.removeEventListener('click', closeFeedWindow);
}

document.querySelectorAll('.feed-item-head-btn').forEach(item => {
    item.addEventListener('click', () => {
        closeFeedWindow();

        item.querySelector('.feed-item-more-window').style.display = 'block';
        setTimeout(() => {
            document.addEventListener('click', closeFeedWindow);
        }, 500);
    });
});