<!-- modal para confirmar a alteração do status do serviço(finalizado, pendente) -->
<div id="modal-status" class="modal-container">

    <div class="modal-box">
        <div class="modal-header">
        <span
            class="close"
            onclick="fecharModalStatus()"
        >
            &times;
        </span>
        <div class="row">
        <h2 id="titulo-modal-status">
            <span id="texto-status" style="color: #000;"></span>
            <span id="id-toggle"></span>
        </h2>

        <p id="mensagem-modal-status">
            Deseja finalizar este serviço?
        </p>
        </div>
        </div>

        <div class="acoes-modal">

            <button
                type="button"
                onclick="fecharModalStatus()"
            >
                Cancelar
            </button>

            <button
                type="button"
                class="valor-modal"
                id="btn-confirmar-status"
                onclick="confirmarStatus()"
            >
                <span id="texto-btn-status">Finalizar</span>
                <div id="carregando" class="carregando">
                    <div class="spinner"></div>
                    <span>Alterando finalização...</span>
                </div>
            </button>

        </div>

    </div>

</div>