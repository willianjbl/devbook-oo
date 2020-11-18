IMask(
    document.getElementById('birthdate'), {
        mask : '00/00/0000'
    }
);

function verificarCampoSenha() {
    let senha = document.querySelector('input[name="password"]');
    let reSenha = document.querySelector('input[name="repassword"]');

    if (reSenha.value) {
        if (senha.value !== reSenha.value) {
            senha.value = '';
            reSenha.value = '';
            senha.focus();
            dispararAlerta('As senhas não coincidem!', 'warning');
        }
    }
}

document.querySelectorAll('input[name="repassword"], input[name="password"]').forEach(el => {
    el.addEventListener('blur', verificarCampoSenha);
});
