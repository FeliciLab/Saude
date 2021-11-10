<?php
    use MapasCulturais\i;
    $entities = $this->controller->requestedEntity;
    $type =  $entities->evaluationMethodConfiguration->getDefinition()->slug;
?>

<div class="remodal" data-remodal-id="modal-resposta-recurso">

    <button data-remodal-action="close" class="remodal-close"></button>
    <h1>Responder recurso</h1>
    <!-- Utlização do nome da oportunidade dentro do modal. --> 
    <p><label id="replyOpportunityNameLabel"></label></strong></p>
    <!-- Utlização da informação enviada pelo usuário para contestação. --> 
    <p><small id="resourceText"></small></p>
    <!-- Formulario para envio da atualização da contestação do recurso. --> 
    
    <form id="formReplyResource">

        <input type="hidden" name="_METHOD" value="PUT"/>
        <input type="hidden" name="resource_id" id="resource_id">
        <input type="hidden" name="evaluationMethod" id="evaluationMethod" value="<?php echo $type; ?>">
        
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <td>
                            <label for="resource_status">Situação do recurso: </label>
                            <select name="resource_status" id="resource_status" class="form-control">
                                <option value="default">--Selecione--</option>
                                <option value="Deferido">Deferido</option>
                                <?php  if($type == 'technical'): ?>
                                <option value="ParcialmenteDeferido">Parcialmente Deferido</option>
                                <?php endif; ?>
                                <option value="Indeferido">Indeferido</option>
                            </select>
                        </td>
                        <?php 
                            if($type == 'technical'){ ?>
                        <td>
                            <label for="">Nota Resultado Final</label>
                            <input type="text" name="consolidated_result" id="consolidated_result" disabled class="form-control" style="background: #eaeaea;" >
                        </td>
                            <?php 
                            }
                        ?>
                    </tr>
                </thead>
            </table>
        </div>

        <div id="divDeferido" style="display: none">
            <div class="alert info" style="text-align:center"> 
                <?php 
                    if($type == 'technical'){ ?>
                        <label infoNotaMaxima>Atenção! Avalie o Recurso e Preencha os Campos Necessários</label>
                    <?php
                    }else{ ?>
                        <label>Preencha todos os campos abaixo: </label>
                    <?php
                    }
                ?>
            </div>
            <?php 
                if($type == 'technical'){ ?>
                    <label for="">Nova nota</label>
                    <input type="number"  min="0" step=".01" name="new_consolidated_result" id="new_consolidated_result" class="form-control">
                <?php
                }
            ?>
           <label for="decisao_recurso">Status do Candidato</label>
            <select name="status" id="decisao_recurso" class="form-control">
                <option value="0">--Selecione--</option>
                <option value="1">Alterar para selecionado</option>
                <option value="2">Manter Status</option>
            </select>
        </div>
        <textarea placeholder="Resposta para a contestação do recurso: " name="resource_reply" id="resource_reply" cols="30" rows="20" class="form-control" style="height: 222px !important; display: none;"></textarea>
        </hr>
        <br>
        <button data-remodal-action="cancel" class="btn btn-default" title="Sair da resposta">
            <i class="fa fa-close" aria-hidden="true"></i> Fechar
        </button>
        <button class="btn btn-primary" id="button-send-resource" type="submit" title="Enviar o seu recurso para essa oportunidade" style="margin-left: 20px;">
            <i class="fa fa-paper-plane" aria-hidden="true"></i> Responder
        </button>
    </form>
</div>