let idServicoExcluir = null;
const modalExcluir = document.getElementById('modal-excluir');


function abrirModalExcluir(id) {

    idServicoExcluir = id;

    document.getElementById('id-servico-excluir').textContent = "#" + id;

    modalExcluir.style.display = 'flex';
     // implementando a animação do modal
    modalExcluir.classList.remove('ocultar');
    modalExcluir.classList.remove('animacao');

    void modalExcluir.offsetWidth;

    modalExcluir.classList.add('animacao');
}

// Fechar ao clicar fora do conteúdo do modal
modalExcluir.addEventListener('click', function(event) {

    if (event.target === modalExcluir) {
        fecharModalExcluir();
    }

});

function fecharModalExcluir() {

    idServicoExcluir = null;

     modalExcluir.classList.add('ocultar');

    modalExcluir.addEventListener('animationend', function() {
        modalExcluir.style.display = 'none';
        modalExcluir.classList.remove('ocultar');
    }, { once: true });
}


function confirmarExclusao() {

    if (idServicoExcluir === null) {
        return;
    }

    const formData = new FormData();

    formData.append('id_service', idServicoExcluir);

    fetch('/jm_informatica/index.php?action=delete_service', {

        method: 'POST',

        body: formData

    })
        .then(response => {

            if (!response.ok) {
                throw new Error('Erro ao excluir o serviço.');
            }

            window.location.href =
                '/jm_informatica/index.php?action=dashboard';

        })
        .catch(error => {

            console.error(error);

            alert('Não foi possível excluir o serviço.');

        });

}