<?php 
use MapasCulturais\i;
?>
<p>
    <span class="label <?php echo ($entity->isPropertyRequired($entity,"registrationMinimumNote") ? 'required': '');?>"><?php i::_e("Informe o valor mínimo de aprovação da oportunidade");?></span><br>
    <span class="registration-help"><?php i::_e("Informe a nota mínima (a partir de 0) para classificação nesta oportunidade.");?></span><br>
    <span class="js-editable" 
        data-edit="registrationMinimumNote" 
        data-original-title="<?php i::esc_attr_e("Informe a nota mínima para aprovação");?>" 
        data-emptytext="<?php i::esc_attr_e("Informe a nota mínima para aprovação");?>"><?= $entity->registrationMinimumNote ?></span>
</p>