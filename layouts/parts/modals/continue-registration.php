<div class="registration-btn-edit">
   <div class="remodal modal-border" data-remodal-id="modal-edit-registration-confirmation" id="modal-continue">
        <button data-remodal-action="close" class="remodal-close"></button>
        <h3>Você tem uma inscrição no rascunho</h3>
        <div>
            <h4 style="color: #F26822; font-weight: bold;">
                Antes de fazer uma nova inscrição,
                é preciso que você conclua
                a que está no rascunho
            </h4>
        </div>
        <div>
            <p>
                Ao confirmar essa ação, <strong>você continuará editando sua inscrição que está salva no rascunho.</strong>  Após isso, é possível realizar uma nova inscrição acessando a oportunidade.
            </p>

        </div>
        <br>
        <div>
            <a data-remodal-action="cancel" class="btn btn-default">Voltar</a>
            <a class="btn btn-primary btn-register-opportunity" id="continue-registration-modal-button" style="float: none !important;">Continuar inscrição</a>
        </div>
    </div>
</div>
<script>
$(document).ready(function () {
    $('#open-modal-continue').click(function() {
        $("#continue-registration-modal-button").attr("href", $("#open-modal-continue").data("url"));
    });
});
</script>