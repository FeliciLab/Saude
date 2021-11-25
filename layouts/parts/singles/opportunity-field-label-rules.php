<?php 
   $labelCustomRulesDefault = 'Baixar o regulamento'; 
   $labelCustomRules = $entity->labelCustomRules;
?>
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