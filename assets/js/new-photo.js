let feedPhoto = document.querySelector('.feed-new-photo');
let feedFile = document.querySelector('.feed-new-file');

feedPhoto.addEventListener('click', () => {
    feedFile.click();
});
feedFile.addEventListener('change', async () => {
    let photo = feedFile.files[0];
    let formData = new FormData();

    formData.append('photo', photo);
    let req = await fetch('ajax_upload.php', {
        method: 'POST',
        body: formData
    });
    let json = await req.json();

    if(json.error) {
        alert(json.error);
    }

    location.reload();
});