<?php
$editEntity = $this->controller->action === 'create' || $this->controller->action === 'edit';
?>

<div id="inscricoes" class="aba-content">
    <?php $this->applyTemplateHook('tab-inscricoes','begin'); ?>

    <div id="inscricoes">

        <?php $this->part('singles/project-list', ['entity' => $entity, 'projects' => $entity->children->toArray()]); ?>

    </div>

    <?php $this->applyTemplateHook('tab-inscricoes','end'); ?>
</div>