<!-- componente de modal, exibe informações do serviço para alterar -->
<div id="modal-editar" class="modal-container">

    <div class="modal-box">
        <div class="modal-header">
            <span class="close" onclick="fecharModalAlterar()">&times;</span>
            <h2>Alterar Serviço <span id="id_service"> # </span></h2>
        </div>

        <form action="/jm_informatica/index.php?action=update_service" method="POST" id="form-editar" class="modal-form">


            <div class="box-input">
                <label for="description">
                    Descrição
                </label>

                <input type="text" name="description" id="description" >
            </div>

            <div class="box-input">
                <label for="price">
                    Valor
                </label>

                <input type="number" name="price" id="price" step="0.01" min="0" >
            </div>

            <button type="submit" name="action" value="update">
                Salvar alterações
            </button>

        </form>

    </div>

</div>