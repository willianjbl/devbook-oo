let flashTimeOut = 3 * 1000;

function dispararAlerta(body, status) {
    let box = document.querySelector('.flash-box');
    let flash = box.querySelector('.flash');

    flash.classList.forEach(item => {
        if (item.includes('flash-')) {
            flash.classList.remove(item);
        }
    });

    box.style.display = 'block';
    flash.classList.add(`flash-${status}`);
    flash.innerText = body;

    setTimeout(() => {
        closeFlashComment(box);
    }, flashTimeOut);
}

function closeFlashComment(el) {
    el.style.display = 'none';
}

let flashBox = document.querySelector('.flash-box');
if (flashBox && flashBox.style.display === 'block') {
    flashBox.addEventListener('click', () => {
        closeFlashComment(flashBox);
    });
    setTimeout(() => {
        closeFlashComment(flashBox);
    }, flashTimeOut);
}
