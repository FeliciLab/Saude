<?php
   use MapasCulturais\i;
   Use Saude\Entities\Resources;

   $entity =  $this->controller->requestedEntity;

   $can_edit = $entity->canUser('modifyRegistrationFields');
   
   $editable_class = $can_edit ? 'js-editable' : '';

   //VERIFICANDO SE TEM RECURSO HABILITADO
   $enabledDiv = 'hidden';
   $selectedEnabled  = 'selected';
   $selectedDisabled = '';
   $resource = $app->repo('OpportunityMeta')->findBy([
      'key' => 'claimDisabled',
      'owner' => $entity->id
   ]);
   if(isset($resource[0]) && $resource[0]->value == 0){
      $enabledDiv = 'visible';
      $selectedEnabled  = '';
      $selectedDisabled = 'selected';
   }
   $period = Resources::getTimeOpportunityResource($entity->id);
?>

<p>
    <hr>
<h4><?php i::_e("Recurso"); ?></h4>
</p>
<p class="registration-help">
    Espaço para configurar se a oportunidade receberá a modalidade de recurso.
</p>
<div class="panel panel-default">
    <div class="panel-heading"> <label><?php i::_e("Formulário para recursos"); ?></label></div>
    <div class="panel-body">
        <form id="resourceFormData">
            <select id="resourceOptions" name="claimDisabled" class="form-control" name="resourceOptions">
                <option value="0" <?php echo $selectedDisabled; ?>>
                    <?php i::_e('Habilitar formulário de Recurso'); ?>
                </option>
                <option <?php echo $selectedEnabled; ?> value="1">
                    <?php i::_e('Desabilitar formulário de Recurso'); ?>
                </option>
            </select>
            <div id="insertData" class="<?php echo $enabledDiv; ?>">
                <div class="form-group">
                    <label for="hora-inicial">Data de início </label>
                    <input type="text" class="date form-control dateResource" name="date-initial" value="<?php echo $period['datIni']; ?>">
                </div>
                <div class="">
                    <label for="hora-inicial">Hora de início </label>
                    <input type="time" class="form-control" name="hour-initial" value="<?php echo $period['horIni']; ?>">
                </div>
                <div class="form-group">
                    <label for="data-final">Data final </label>
                    <input type="text" class="date form-control dateResource" name="date-final" value="<?php echo $period['datFim']; ?>">
                </div>
                <div class="form-group">
                    <label for="hora-final">Hora final </label>
                    <input type="time" class="form-control" name="hour-final" value="<?php echo $period['horFim']; ?>">
                </div>
                <div class="form-group">
                    <input type="hidden" name="opportunity" id="opportunityIdResources">
                    <button class="btn btn-primary" id="buttonSendData">
                        <i class="fa fa-save"></i> Salvar
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>