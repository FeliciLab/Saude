<div class="remodal" data-remodal-id="modal-resposta-recurso">
    <button data-remodal-action="close" class="remodal-close"></button>
    <h1>Responder Recurso</h1>
    <p>
        <strong>Oportunidade: 
        <label id="replyOpportunityNameLabel"></label>
        </strong>
    </p>
    <p>
        <small id="resourceText"></small>
    </p>
    <form id="formReplyResource">
        <textarea name="resource_reply" id="resource_reply" cols="30" rows="20" class="form-control" style="height: 222px !important"></textarea>
        <br>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <td>
                            <label for="">Situação</label>
                            <select name="resource_status" id="resource_status" class="form-control">
                                <option value="">--Selecione--</option>
                                <option value="Deferido">Deferido</option>
                                <option value="ParcialmenteDeferido">Parcialmente Deferido</option>
                                <option value="Indeferido">Indeferido</option>
                            </select>
                        </td>
                        <td>
                            <label for="">Nota Resultado Final</label>
                            <input type="text" name="consolidated_result" id="consolidated_result" disabled class="form-control" style="background: #eaeaea;" >
                        </td>
                        <td>
                            
                        </td>
                    </tr>
                </thead>
            </table>
        </div>
        <br>
        <div id="divDeferido" style="display: inline-table !important;">
            <div class="alert info">
                <label id="infoNotaMaxima"></label>
            </div>
            <label for="">Nova nota</label>
            <input type="number" 
            min="0"
            step=".01"
            name="new_consolidated_result" id="new_consolidated_result"
            class="form-control">
            <label for="">Status do Candidato</label>
            <select name="status" id="" class="form-control">
                <option value="0">--Selecione--</option>
                <option value="1">Habilitar próxima fase</option>
                <option value="2">Manter Status</option>
            </select>
        </div>
        <hr>
        <button data-remodal-action="cancel" class="btn btn-default" title="Sair da resposta">
        <i class="fa fa-close" aria-hidden="true"></i>
        Fechar
        </button>
        <input type="hidden" name="_METHOD" value="PUT"/>
        <input type="hidden" name="resource_id" id="resource_id">
        <button class="btn btn-primary" type="submit" title="Enviar o seu recurso para essa oportunidade" style="margin-left: 20px;">
        <i class="fa fa-paper-plane" aria-hidden="true"></i>
        Responder
        </button>
    </form>
</div>