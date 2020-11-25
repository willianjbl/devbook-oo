let flashTimeOut = 5 * 1000;

function dispararAlerta(body, status) {
    let box = document.querySelector('.flash-box');
    let flash = box.querySelector('.flash');
    box.style.display = 'block';

    flash.classList.forEach(item => {
        if (item.includes('flash-')) {
            flash.classList.remove(item);
        }
    });
    flash.classList.add(`flash-${status}`);
    flash.innerText = body;

    setTimeout(() => {
        flash.classList.add(`flash-open`);
    },1);
    setTimeout(() => {
        closeFlashComment(box);
    }, flashTimeOut);
}

function closeFlashComment(el) {
    let flash = el.querySelector('.flash');
    flash.classList.add('flash-close');

    setTimeout(() => {
        flash.classList.remove('flash-close');
        flash.classList.remove('flash-open');
        el.style.display = 'none';
    }, 1000);
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
