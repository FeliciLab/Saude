<?php

use MapasCulturais\i;
use MapasCulturais\Entities\Opportunity;

if($this->controller->action === 'create'){ 
    return;
}

$editEntity = $this->controller->action === 'create' || $this->controller->action === 'edit';

$parent = $entity->parent;

?>

<div id="inscricoes" class="aba-content">
<?php if ($parent != null): ?>

    <?php foreach($entity->getOpportunities(Opportunity::STATUS_DRAFT) as $opportunity): ?>
        <?php $this->part('entity-opportunities--item', ['opportunity' => $opportunity, 'entity' => $entity]) ?>
        <br>
    <?php endforeach; ?>
    
    <?php else: ?>

        <?php $this->applyTemplateHook('tab-inscricoes', 'begin'); ?>
        <div id="inscricoes">
            <?php $this->part('singles/project-list', ['entity' => $entity, 'projects' => $entity->children->toArray()]); ?>
        </div>
        <?php $this->applyTemplateHook('tab-inscricoes', 'end'); ?>

    <?php endif ?>
</div>