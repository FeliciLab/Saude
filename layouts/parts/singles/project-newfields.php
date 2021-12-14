<?php if ( $this->isEditable() ): ?>
<p>
    <span class="label <?php echo ($entity->isPropertyRequired($entity,"registrationLimitPerOwnerProject") && $editEntity? 'required': '');?>"><?php \MapasCulturais\i::_e("Número máximo de inscrições por agente responsável no projeto");?></span><br>
    <span class="registration-help"><?php \MapasCulturais\i::_e("Zero (0) significa sem limites");?></span><br>
    <span class="js-editable" data-edit="registrationLimitPerOwnerProject" data-original-title="<?php \MapasCulturais\i::esc_attr_e("Número máximo de inscrições por agente responsável no projeto");?>" data-emptytext="<?php \MapasCulturais\i::esc_attr_e("Insira o número máximo de inscrições por agente responsável por projeto");?>"><?php echo $entity->registrationLimitPerOwnerProject ? $entity->registrationLimitPerOwnerProject : '0'; ?></span>
</p>
<?php endif; ?>