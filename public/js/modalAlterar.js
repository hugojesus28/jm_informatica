// modais de serviço, irei separar todos para ficar mais organizado

let idAlteracao = null;
const modalAlterar = document.getElementById('modal-editar');

function abrirModalAlterar(id, description, price) {

    idAlteracao = id;
    document.getElementById('description').value = description;
    document.getElementById('price').value = price;
    document.getElementById('id_service').textContent = "#" + id;
    document.getElementById('modal-editar').style.display = 'flex';
    modalAlterar.classList.remove('ocultar');
    modalAlterar.classList.remove('animacao');

    void modalAlterar.offsetWidth;

    modalAlterar.classList.add('animacao');


}

document.getElementById('form-editar').addEventListener('submit', function (event) {

    event.preventDefault();
    const description = document
        .getElementById('description')
        .value
        .trim();

    const priceInput = document
        .getElementById('price')
        .value
        .trim();
        
    // validações
    if (description === '') {
        alert('O campo de descrição é obrigatório!!!');
        return;
    }

    if (description.length > 45) {
        alert('O campo de descrição não pode ser maior que 45 caracteres!!!');
        return;
    }

    if (priceInput === '') {
        alert('O campo de preço é obrigatório!!!');
        return;
    }

    // mudando de virgula para ponto
    const price = Number(priceInput.replace(',', '.'));

    if (isNaN(price)) {
        alert('O preço deve ser um número decimal!!!');
        return;
    }

     // preço deve ser maior que zero
    if (price <= 0) {
        alert('O preço deve ser maior que zero!!!');
        return;
    }

    // limite do banco
    if (price > 99999999.999) {
        alert('O preço informado é muito grande!!!');
        return;
    }
    const form = this;

    const formData = new FormData(form);

    formData.append('id_service', idAlteracao);

    fetch('/jm_informatica/index.php?action=update_service', {
        method: 'POST',
        body: formData
    })
        .then(response => {

            if (response.ok) {
                window.location.href =
                    '/jm_informatica/index.php?action=dashboard';
            }

        });

});
modalAlterar.addEventListener('click', function (event) {
    if (event.target === modalAlterar) {
        fecharModalAlterar();
    }
});


function fecharModalAlterar() {

    modalAlterar.classList.add('ocultar');

    modalAlterar.addEventListener('animationend', function () {
        modalAlterar.style.display = 'none';
        modalAlterar.classList.remove('ocultar');
    }, { once: true });
}


