<?php 
use MapasCulturais\i;
use MapasCulturais\Entities\Opportunity;

if($this->controller->action === 'create'){ 
    return;
}


$is_project = false;
$label = 'Projetos';

if($entity instanceof MapasCulturais\Entities\Project){
    $is_project = true;
    $label = 'Subprojetos';
}

?>

<div class="widget">
    <?php if ($projects): ?>
        <?php foreach ($projects as $project): ?>
            <h2 style="color: black;">
                <span><?php echo $project->name; ?></span>
            </h2>
            <span>
                <?php $this->applyTemplateHook('entity-opportunities','before'); ?>

                <?php $this->applyTemplateHook('entity-opportunities','begin'); ?>
                <?php 
                foreach($project->getOpportunities(Opportunity::STATUS_DRAFT) as $opportunity): ?>
                
                    <?php $this->part('entity-opportunities--item', ['opportunity' => $opportunity, 'entity' => $entity]) ?>
                    <br>
                <?php endforeach; ?>
                <?php $this->applyTemplateHook('entity-opportunities','end'); ?>

                <?php $this->applyTemplateHook('entity-opportunities','after'); ?>
            </span>
        <?php endforeach; ?>
    <?php endif; ?>
</div>