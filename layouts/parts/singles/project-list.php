<?php

use MapasCulturais\i;
use MapasCulturais\Entities\Opportunity;

if ($this->controller->action === 'create') {
    return;
}

$is_project = false;
$label = 'Projetos';

if ($entity instanceof MapasCulturais\Entities\Project) {
    $is_project = true;
    $label = 'Subprojetos';
}

?>

<div class="widget">
    <?php 
    foreach ($projects as $project) : 
        $opportunities = $project->getOpportunities(Opportunity::STATUS_DRAFT);
        $opportunities = array_filter($opportunities, function($opportunity) {
            if($opportunity->status > 0 || $opportunity->canUser('modify')) {
                return $opportunity;
            }
        });

        if(count($opportunities) == 0) {
            continue;
        }
    ?>
        <h2 style="color: black;">
            <span><?php echo $project->name; ?></span>
        </h2>
        <span>
            <?php $this->applyTemplateHook('entity-opportunities', 'before'); ?>

            <?php $this->applyTemplateHook('entity-opportunities', 'begin'); ?>
            <?php
            foreach ($opportunities as $opportunity) : 
            ?>
                <?php $this->part('entity-opportunities--item', ['opportunity' => $opportunity, 'entity' => $entity]) ?>
                <br>
            <?php 
            endforeach; ?>


            <?php $this->applyTemplateHook('entity-opportunities', 'end'); ?>

            <?php $this->applyTemplateHook('entity-opportunities', 'after'); ?>
        </span>
    <?php endforeach; ?>
</div>