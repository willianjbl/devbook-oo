let feedInput = document.querySelector('.feed-new-input');
let feedSendBtn = document.querySelector('.feed-new-send');
let feedForm = document.querySelector('#feed-new-post');

function enviarPost() {
    feedForm.querySelector('input[name="body"]').value = feedInput.innerText.trim();
    feedForm.submit();
}

feedSendBtn.addEventListener('click', () => {
    enviarPost();
});
feedInput.addEventListener('keyup', e => {
    if (e.key === 'Enter' && e.ctrlKey) {
        enviarPost();
    }
})