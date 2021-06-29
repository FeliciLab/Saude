<?php
   use MapasCulturais\i;
   Use Saude\Entities\Resources;

   $can_edit = $entity->canUser('modifyRegistrationFields');
   
   $app->applyHookBoundTo($this, 'opportunity.blockedCategoryFields', [&$entity,&$can_edit]);
   
   $editable_class = $can_edit ? 'js-editable' : '';
   if ($can_edit) {
       $registration_categories = $entity->registrationCategories ? implode("\n", $entity->registrationCategories) : '';
   } else {
       $registration_categories = is_array($entity->registrationCategories) ? implode('; ', $entity->registrationCategories) : '';
   }
   // $valueDae = 0;
   // if(!empty($entity->value_dae)) {
   //    $valueDae = $entity->value_dae;
   // }

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
<div id="registration-categories" class="registration-fieldset">
   <h4><?php \MapasCulturais\i::_e("Opções");?></h4>
   <p ng-if="data.entity.canUserModifyRegistrationFields" class="registration-help"><?php \MapasCulturais\i::_e('É possível criar opções para os proponentes escolherem na hora de se inscrever, como, por exemplo, "categorias" ou "modalidades". Se não desejar utilizar este recurso, deixe em branco o campo "Opções".');?></p>
   <p ng-if="!data.entity.canUserModifyRegistrationFields" class="registration-help"><?php \MapasCulturais\i::_e("A edição destas opções estão desabilitadas porque agentes já se inscreveram neste projeto.");?> </p>
   <?php $this->applyTemplateHook('categories-messages','begin',[$entity]); ?>
   <p>
      <span class="label"><?php \MapasCulturais\i::_e("Título das opções");?></span><br>
      <span class="<?php echo $editable_class ?>" data-edit="registrationCategTitle" data-original-title="<?php \MapasCulturais\i::esc_attr_e("Título das opções");?>" data-emptytext="<?php \MapasCulturais\i::esc_attr_e("Insira um título para o campo de opções");?>"><?php echo $entity->registrationCategTitle ? $entity->registrationCategTitle : \MapasCulturais\i::__('Categoria'); ?></span>
   </p>
   <p>
      <span class="label"><?php \MapasCulturais\i::_e("Descrição das opções");?></span><br>
      <span class="<?php echo $editable_class ?>" data-edit="registrationCategDescription" data-original-title="<?php \MapasCulturais\i::esc_attr_e("Descrição das opções");?>" data-emptytext="<?php \MapasCulturais\i::esc_attr_e("Insira uma descrição para o campo de opções");?>"><?php echo $entity->registrationCategDescription ? $entity->registrationCategDescription : \MapasCulturais\i::__('Selecione uma categoria'); ?></span>
   </p>
   <p>
      <span class="label"><?php \MapasCulturais\i::_e("Opções");?></span><br>
      <span class="<?php echo $editable_class ?> js-categories-values" data-edit="registrationCategories" data-type="textarea" data-original-title="<?php \MapasCulturais\i::esc_attr_e("Opções de inscrição (coloque uma opção por linha)");?>" data-emptytext="<?php \MapasCulturais\i::esc_attr_e("Insira as opções de inscrição");?>"><?php echo $registration_categories; ?></span>
   </p>
   <p>
      <br>
      <span class="label">
      <?php \MapasCulturais\i::_e("Taxonomia");?>: 
      </span><br>
      <span class="js-editable" data-edit="opportunity_taxonomia" data-original-title="<?php \MapasCulturais\i::esc_attr_e('Tipos de unidade');?>"><?php echo $entity->opportunity_taxonomia; ?>
      </span>
   </p>
   <?php if($this->isEditable() || $entity->value_dae): ?>
   <p>
      <div style="margin-top: 15px; border-top: 2px solid #c3c3c3;">
         <br>
         <span class="label">Valor do dae.</span>
         <span class="registration-help">Nesse campo você deve digitar o valor do dae para pagamento de inscrição da oportunidade</span> <br>
         <span class="js-editable" data-edit="value_dae" data-original-title="Digitar o valor do dae. Ex: 100 ou 10.50" data-emptytext="Digite o valor do dae. Ex: 100 ou 10.50">
            <?php echo $entity->value_dae; ?>
         </span>
      </div>
   </p>
   <?php endif; ?>
   <p><hr>
      <h4><?php \MapasCulturais\i::_e("Recurso");?></h4>
   </p>
   <p class="registration-help">
      Espaço para configurar se a oportunidade receberá a modalidade de recurso.
   </p>
   <p>
   <div class="panel panel-default">
      <div class="panel-heading"> <label><?php i::_e("Formulário para recursos");?></label></div>
      <div class="panel-body">
         <form id="resourceFormData">
            <select id="resourceOptions" name="claimDisabled" class="form-control" name="resourceOptions">
               <option value="0" <?php echo $selectedDisabled; ?>>
                  <?php i::_e('Habilitar formulário de Recurso');?>
               </option>
               <option <?php echo $selectedEnabled; ?> value="1">
                  <?php i::_e('Desabilitar formulário de Recurso');?>
               </option>
            </select>
            <div id="insertData" class="<?php echo $enabledDiv; ?>">
               <div class="form-group">
                  <label for="hora-inicial">Data de início </label>
                  <input type="text" class="date form-control dateResource" name="date-initial" value="<?php echo $period['datIni']; ?>">
               </div>
               <div class="">
                  <label for="hora-inicial">Hora de início </label>
                  <input type="text" class="time form-control" name="hour-initial" value="<?php echo $period['horIni']; ?>">
               </div>
               <div class="form-group">
                  <label for="data-final">Data final </label>
                  <input type="text" class="date form-control dateResource" name="date-final" value="<?php echo $period['datFim']; ?>">
               </div>
               <div class="form-group">
                  <label for="hora-final">Hora final </label>
                  <input type="text" class="time form-control" name="hour-final" value="<?php echo $period['horFim']; ?>">
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
   </p>
</div>
<!-- #registration-categories -->