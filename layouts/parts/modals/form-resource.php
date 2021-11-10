<div class="remodal" data-remodal-id="modal-recurso">
    <button data-remodal-action="close" class="remodal-close"></button>
    <h1>Formulário de recurso</h1>
    <p>
        <label id="opportunityNameLabel"></label>
    </p>
    <form id="formSendResource">
        <textarea name="resource_text" id="" cols="30" rows="20" class="form-control" style="height: 322px !important"></textarea>
        <input type="hidden" id="registration_id" name="registration_id">
        <input type="hidden" name="opportunity_id" id="opportunity_id">
        <input type="hidden" name="agent_id" id="agent_id" >
        <br>
        <button data-remodal-action="cancel" class="btn btn-default" title="Desistir de enviar o recurso">
        <i class="fa fa-close" aria-hidden="true"></i>
        Fechar
        </button>
        <button class="btn btn-primary" type="submit" title="Enviar o seu recurso para essa oportunidade" style="margin-left: 20px;"
            id="">
        <i class="fa fa-paper-plane" aria-hidden="true"></i>
        Enviar
        </button>
    </form>
</div>