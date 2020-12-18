document.querySelectorAll('.fic-item-field').forEach(item => {
    item.addEventListener('keyup', async (e) => {
        if (e.key === 'Enter') {
            let id = item.closest('.feed-item').getAttribute('data-id');
            let txt = item.value;
            item.value = '';

            let data = new FormData();
            data.append('id', id);
            data.append('txt', txt);

            let req = await fetch('ajax_comment.php', {
                method: 'POST',
                body: data
            });
            let json = await req.json();

            if (!json.error) {
                let html = '<div class="fic-item row m-height-10 m-width-20">';
                html += '<div class="fic-item-photo">';
                html += '<a href="'+json.link+'"><img src="'+json.avatar+'" /></a>';
                html += '</div>';
                html += '<div class="fic-item-info">';
                html += '<a href="'+json.link+'">'+json.name+'</a>';
                html += json.body;
                html += '</div>';
                html += '</div>';

                item.closest('.feed-item')
                    .querySelector('.feed-item-comments-area')
                    .innerHTML += html;
                let commentCounterElement = item.closest('.feed-item')
                    .querySelector('.msg-btn');
                let counter = parseInt(commentCounterElement.innerHTML);

                commentCounterElement.innerHTML = (++counter).toString();
            }

        }
    });
});
