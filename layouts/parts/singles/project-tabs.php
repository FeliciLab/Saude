<?php $this->applyTemplateHook('tabs', 'before'); ?>
<ul class="abas clearfix">
    <?php $this->applyTemplateHook('tabs', 'begin'); ?>

    <!-- Verifica se o projeto não está em modo edição para exibir a aba inscrições -->
    <?php
    if (!$this->isEditable()) : ?>
        <li class="active"><a href="#inscricoes" rel='noopener noreferrer'><?php \MapasCulturais\i::_e("Inscrições"); ?></a></li>
    <?php endif; ?>


    <li class="active"><a href="#sobre" rel='noopener noreferrer'><?php \MapasCulturais\i::_e("Detalhes"); ?></a></li>

    <?php if (!$entity->isNew()) : ?>
        <li ng-if="data.entity.userHasControl && data.entity.events.length"><a href="#eventos" rel='noopener noreferrer'><?php \MapasCulturais\i::_e("Status dos eventos"); ?></a></li>
    <?php endif; ?>

    <?php if (!($this->controller->action === 'create')) : ?>
        <li><a href="#permissao" rel='noopener noreferrer'><?php \MapasCulturais\i::_e("Responsáveis"); ?></a></li>
    <?php endif; ?>
    <?php $this->applyTemplateHook('tabs', 'end'); ?>
</ul>
<?php $this->applyTemplateHook('tabs', 'after'); ?>