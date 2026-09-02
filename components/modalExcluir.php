<!-- modal de exclusão, serve pra antes de excluir confirmar a exclusão -->
<div id="modal-excluir" class="modal-container animacao">

    <div class="modal-box">

    <div class="modal-header">
        <span
            class="close"
            onclick="fecharModalExcluir()"
        >
            &times;
        </span>
<div class="row">
        <h2>Excluir Serviço <span id="id-servico-excluir"></span></h2>

        <p>
            Tem certeza que deseja excluir este serviço?
        </p>
        </div>
</div>
        <div class="acoes-modal">

            <button
                type="button"
                onclick="fecharModalExcluir()"
            >
                Cancelar
            </button>

            <button
                type="button"
                style=" background-color: red;
        color: var(--text-padrao);
        border: 1px solid red;"
                onclick="confirmarExclusao()"
            >
                Excluir
            </button>

        </div>

    </div>

</div>