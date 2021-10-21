<?php
    use MapasCulturais\i;
    $entities = $this->controller->requestedEntity;
    $type =  $entities->evaluationMethodConfiguration->getDefinition()->slug;
?>

<div class="remodal" data-remodal-id="modal-resposta-recurso">
    <button data-remodal-action="close" class="remodal-close"></button>
    <h1>Atualização do recurso.</h1>
    <!-- Utlização do nome da oportunidade dentro do modal. --> 
    <p><strong>Oportunidade: <label id="replyOpportunityNameLabel"></label></strong></p>
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
                            <label for="resource_status">Situação: </label>
                            <select name="resource_status" id="resource_status" class="form-control">
                                <option value="default">--Selecione--</option>
                                <option value="Deferido">Deferido</option>
                                <option value="ParcialmenteDeferido">Parcialmente Deferido</option>
                                <option value="Indeferido">Indeferido</option>
                            </select>
                        </td>
                        <?php 
                            if($type == 'technical'){ ?>
                                <td>
                                    <label for="consolidated_result">Nota Resultado Final</label>
                                </td>
                            <?php 
                            }
                        ?>
                </thead>
            </table>
        </div>
        <div id="divDeferido">
            <div class="alert info" style="text-align:center"> 
                <?php 
                    if($type == 'technical'){ ?>
                        <label infoNotaMaxima></label>
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
           <label for="candidate_status">Status do Candidato</label>
            <select name="status" id="candidate_status" class="form-control">
                <option value="0">--Selecione--</option>
                <option value="1">Habilitar próxima fase</option>
                <option value="2">Manter Status</option>
            </select>
        </div>
        <textarea placeholder="Resposta para a contestação do recurso: " name="resource_reply" id="resource_reply" cols="30" rows="20" class="form-control" style="height: 222px !important"></textarea>
        </hr>
        <br>
        <button data-remodal-action="cancel" class="btn btn-default" title="Sair da resposta">
            <i class="fa fa-close" aria-hidden="true"></i> Fechar
        </button>
        <button class="btn btn-primary" type="submit" title="Enviar o seu recurso para essa oportunidade" style="margin-left: 20px;">
            <i class="fa fa-paper-plane" aria-hidden="true"></i> Responder
        </button>
    </form>
</div>