<style>
#editable-multiselect-instituicao_servicos .edit-box {
    top: 0px !important
}
</style>
<div class="servico">
    <?php $this->applyTemplateHook('tab-about-service','begin'); ?>

    <?php if($this->isEditable()): ?>
        <p style="display:none" class="privado"><span class="icon icon-private-info"></span><?php \MapasCulturais\i::_e("Virtual ou Físico? (se for virtual a localização não é obrigatória)");?></p>
    <?php endif; ?>

    <?php if($this->isEditable() || $entity->acessibilidade): ?>
    <p><span class="label"><?php \MapasCulturais\i::_e("Acessibilidade");?>: </span><span class="js-editable" data-edit="acessibilidade" data-original-title="<?php \MapasCulturais\i::esc_attr_e('Acessibilidade');?>"><?php echo $entity->acessibilidade; ?></span></p>
    <?php endif; ?>

    <?php if($this->isEditable() || $entity->acessibilidade_fisica): ?>
    <p>
        <span class="label"><?php \MapasCulturais\i::_e("Acessibilidade física");?>: </span>
        <editable-multiselect entity-property="acessibilidade_fisica" empty-label="<?php \MapasCulturais\i::esc_attr_e('Selecione');?>" allow-other="true" box-title="<?php \MapasCulturais\i::esc_attr_e('Acessibilidade física:');?>"></editable-multiselect>
    </p>
    <?php endif; ?>
    <?php $this->applyTemplateHook('acessibilidade','after'); ?>

    <?php if($this->isEditable() || $entity->capacidade): ?>
    <p><span class="label"><?php \MapasCulturais\i::_e("Capacidade");?>: </span><span class="js-editable" data-edit="capacidade" data-original-title="<?php \MapasCulturais\i::esc_attr_e('Capacidade');?>" data-emptytext="<?php \MapasCulturais\i::esc_attr_e('Especifique a capacidade');?> <?php $this->dict('entities: of the space');?>"><?php echo $entity->capacidade; ?></span></p>
    <?php endif; ?>

    <?php if($this->isEditable() || $entity->horario): ?>
    <p><span class="label"><?php \MapasCulturais\i::_e("Horário de funcionamento");?>: </span><span class="js-editable" data-edit="horario" data-original-title="<?php \MapasCulturais\i::esc_attr_e('Horário de Funcionamento');?>" data-emptytext="<?php \MapasCulturais\i::esc_attr_e('Insira o horário de abertura e fechamento');?>"><?php echo $entity->horario; ?></span></p>
    <?php endif; ?>

    <?php if($this->isEditable() || $entity->site): ?>
        <p><span class="label"><?php \MapasCulturais\i::_e("Site");?>:</span>
        <?php if($this->isEditable()): ?>
            <span class="js-editable" data-edit="site" data-original-title="<?php \MapasCulturais\i::esc_attr_e('Site');?>" data-emptytext="<?php \MapasCulturais\i::esc_attr_e('Insira a url de seu site');?>"><?php echo $entity->site; ?></span></p>
        <?php else: ?>
            <a class="url" href="<?php echo $entity->site; ?>"><?php echo $entity->site; ?></a>
        <?php endif; ?>
    <?php endif; ?>

    <?php if($this->isEditable() || $entity->emailPublico): ?>
    <p><span class="label"><?php \MapasCulturais\i::_e("Email Público");?>:</span> <span class="js-editable" data-edit="emailPublico" data-original-title="<?php \MapasCulturais\i::esc_attr_e('Email Público');?>" data-emptytext="<?php \MapasCulturais\i::esc_attr_e('Insira um email que será exibido publicamente');?>"><?php echo $entity->emailPublico; ?></span></p>
    <?php endif; ?>

    <?php if($this->isEditable()):?>
        <p class="privado"><span class="icon icon-private-info"></span><span class="label"><?php \MapasCulturais\i::_e("Email Privado");?>:</span> <span class="js-editable" data-edit="emailPrivado" data-original-title="<?php \MapasCulturais\i::esc_attr_e('Email Privado');?>" data-emptytext="<?php \MapasCulturais\i::esc_attr_e('Insira um email que não será exibido publicamente');?>"><?php echo $entity->emailPrivado; ?></span></p>
    <?php endif; ?>

    <?php if($this->isEditable() || $entity->telefonePublico): ?>
    <p><span class="label"><?php \MapasCulturais\i::_e("Telefone Público");?>:</span> <span class="js-editable" data-edit="telefonePublico" data-original-title="<?php \MapasCulturais\i::esc_attr_e('Telefone Público');?>" data-emptytext="<?php \MapasCulturais\i::esc_attr_e('Insira um telefone que será exibido publicamente');?>"><?php echo $entity->telefonePublico; ?></span></p>
    <?php endif; ?>

    <?php if($this->isEditable()):?>
        <p class="privado"><span class="icon icon-private-info"></span><span class="label"><?php \MapasCulturais\i::_e("Telefone Privado 1");?>:</span> <span class="js-editable" data-edit="telefone1" data-original-title="<?php \MapasCulturais\i::esc_attr_e('Telefone Privado');?>" data-emptytext="<?php \MapasCulturais\i::esc_attr_e('Insira um telefone que não será exibido publicamente');?>"><?php echo $entity->telefone1; ?></span></p>
        <p class="privado"><span class="icon icon-private-info"></span><span class="label"><?php \MapasCulturais\i::_e("Telefone Privado 2");?>:</span> <span class="js-editable" data-edit="telefone2" data-original-title="<?php \MapasCulturais\i::esc_attr_e('Telefone Privado');?>" data-emptytext="<?php \MapasCulturais\i::esc_attr_e('Insira um telefone que não será exibido publicamente');?>"><?php echo $entity->telefone2; ?></span></p>
    <?php endif; ?>

    <?php if($this->isEditable() || $entity->instituicao_tipos_unidades): ?>
        <p><span class="label"><?php \MapasCulturais\i::_e("Tipos de unidade");?>: </span><span class="js-editable" data-edit="instituicao_tipos_unidades" data-original-title="<?php \MapasCulturais\i::esc_attr_e('Tipos de unidade');?>"><?php echo $entity->instituicao_tipos_unidades; ?></span></p>
    <?php endif; ?>

    <?php if($this->isEditable() || $entity->instituicao_tipos_gestao): ?>
        <p><span class="label"><?php \MapasCulturais\i::_e("Tipo de gestão");?>: </span><span class="js-editable" data-edit="instituicao_tipos_gestao" data-original-title="<?php \MapasCulturais\i::esc_attr_e('Tipo de gestão');?>"><?php echo $entity->instituicao_tipos_gestao; ?></span></p>
    <?php endif; ?>

    <?php if($this->isEditable() || $entity->instituicao_servicos): ?>
    <p>
        <span class="label"><?php \MapasCulturais\i::_e("Serviços");?>: </span>
        <editable-multiselect entity-property="instituicao_servicos" empty-label="<?php \MapasCulturais\i::esc_attr_e('Selecione');?>" allow-other="true" box-title="<?php \MapasCulturais\i::esc_attr_e('Serviços:');?>"></editable-multiselect>
    </p>
    <?php endif; ?>
    <?php $this->applyTemplateHook('tab-about-service','end'); ?>
</div>