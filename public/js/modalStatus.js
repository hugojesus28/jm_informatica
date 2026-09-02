let idServicoStatus = null;
let servicoFinalizado = false;
const modalStatus = document.getElementById('modal-status');
const carregando = document.getElementById('carregando');



function abrirModalStatus(id, finalizado) {

    idServicoStatus = id;
    servicoFinalizado = finalizado;

    const textoStatus = document.getElementById('texto-status');
    const idToggle = document.getElementById('id-toggle');
    const mensagem = document.getElementById('mensagem-modal-status');
    const textoBotao = document.getElementById('texto-btn-status');
    const botao = document.getElementById('btn-confirmar-status');

    idToggle.textContent = `#${id}`;

    if (finalizado) {

        textoStatus.textContent = 'Reabrir Serviço';

        mensagem.textContent =
            'Deseja reabrir este serviço?';

        textoBotao.textContent = 'Reabrir';

    } else {

        textoStatus.textContent = 'Finalizar Serviço';

        mensagem.textContent =
            'Deseja finalizar este serviço?';

        textoBotao.textContent = 'Finalizar';
    }

    // Reseta o botão ao abrir
    carregando.style.display = 'none';
    textoBotao.style.display = 'inline';
    botao.disabled = false;

    modalStatus.style.display = 'flex';

    // Animação
    modalStatus.classList.remove('ocultar');
    modalStatus.classList.remove('animacao');

    void modalStatus.offsetWidth;

    modalStatus.classList.add('animacao');
}
// fecha modal status ao clicar fora
modalStatus.addEventListener('click', function(event) {
    if (event.target === modalStatus) {
        fecharModalStatus();
    }
}); 

function fecharModalStatus() {

    idServicoStatus = null;
    
     modalStatus.classList.add('ocultar');

    modalStatus.addEventListener('animationend', function() {
        modalStatus.style.display = 'none';
        modalStatus.classList.remove('ocultar');
    }, { once: true });
}

function confirmarStatus() {

    if (idServicoStatus === null) {
        return;
    }

    const formData = new FormData();

    const botao = document.getElementById('btn-confirmar-status');
    formData.append('id_service', idServicoStatus);

    // aqui estou exibindo o carregando
    carregando.style.display = 'flex';

    // escondendo texto
    document.getElementById('texto-btn-status').style.display = 'none';

    // evitar cliques repetidos
    botao.disabled = true;

    fetch('/jm_informatica/index.php?action=toggle_service', {
        method: 'POST',
        body: formData
    })
    .then(response => {

        if (!response.ok) {
            throw new Error('Erro ao alterar o status do serviço.');
        }

        window.location.href =
            '/jm_informatica/index.php?action=dashboard';

    })
    .catch(error => {

        console.error(error);

        alert(
            'Não foi possível alterar o status do serviço. ' +
            error.message
        );

         // sumir com loading
        carregando.style.display = 'none';

        // exibe o texto
        document.getElementById('texto-btn-status').style.display = 'inline';

        // botão liberado
        botao.disabled = false;
    });
}