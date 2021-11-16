<?php 
   $labelCustomRulesDefault = 'Baixar o regulamento'; 
   $labelCustomRules = $entity->labelCustomRules;
?>
<p ng-if="!data.isEditable && data.entity.registrationRulesFile"><a class="btn btn-default download-rules" href="{{data.entity.registrationRulesFile.url}}" target="_blank" rel='noopener noreferrer'><?php echo !empty($labelCustomRules) ? $labelCustomRules : $labelCustomRulesDefault; ?> </a></p>
<?php if ($this->isEditable()): ?>
<div class="registration-fieldset">
<h4><?php \MapasCulturais\i::_e("Botão customizável para acesso ao regulamento");?></h4>
    <p class="registration-help"><?php \MapasCulturais\i::_e("Customize abaixo o botão que será exibido ao usuário para acessar o regulamento da oportunidade. Ex: Baixar o edital");?></p>
<label> <b>Botão customizável para acesso ao regulamento</b> <br>
   <span class="js-editable" 
      data-edit="labelCustomRules"
      data-type="text"
      data-original-title="Informe o texto do botão" 
      data-emptytext="Informe o texto do botão">
      <?php
         echo !empty($labelCustomRules) ? htmlspecialchars($entity->labelCustomRules) : $labelCustomRulesDefault;
      ?>
   </span>
</label> <br><br>
</div>
<?php endif; ?>
<script>
   $(function() {
      $(".download").hide();
   });
</script>