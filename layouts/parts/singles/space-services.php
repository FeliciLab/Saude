<div class="ficha-spcultura">
    <h3>Serviços</h3>
    <div class="servico">
        <?php if ($this->isEditable() || $entity->instituicao_tipos_unidades) : ?>
            <p><span class="label"><?php \MapasCulturais\i::_e("Tipos de unidade"); ?>: </span><span class="js-editable" data-edit="instituicao_tipos_unidades" data-original-title="<?php \MapasCulturais\i::esc_attr_e('Tipos de unidade'); ?>"><?php echo $entity->instituicao_tipos_unidades; ?></span></p>
        <?php endif; ?>

        <?php if ($this->isEditable() || $entity->instituicao_tipos_gestao) : ?>
            <p><span class="label"><?php \MapasCulturais\i::_e("Tipo de gestão"); ?>: </span><span class="js-editable" data-edit="instituicao_tipos_gestao" data-original-title="<?php \MapasCulturais\i::esc_attr_e('Tipo de gestão'); ?>"><?php echo $entity->instituicao_tipos_gestao; ?></span></p>
        <?php endif; ?>

        <?php if ($this->isEditable() || $entity->instituicao_servicos) : ?>
            <p>
                <span class="label"><?php \MapasCulturais\i::_e("Serviços"); ?>: </span>
                <editable-multiselect entity-property="instituicao_servicos" empty-label="<?php \MapasCulturais\i::esc_attr_e('Selecione'); ?>" allow-other="true" box-title="<?php \MapasCulturais\i::esc_attr_e('Serviços:'); ?>"></editable-multiselect>
            </p>
        <?php endif; ?>
    </div>
</div>