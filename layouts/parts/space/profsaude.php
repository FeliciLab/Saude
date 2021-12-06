<?php $this->applyTemplateHook('profsaude', 'before'); ?>
<div id="profsaude" class="aba-content">
    <?php $this->applyTemplateHook('profsaude', 'begin'); ?>
    <?php $this->part('related-agents', ['entity' => $entity, 'profsaude' => true]); ?>
    <?php $this->applyTemplateHook('profsaude', 'end'); ?>
</div>
<?php $this->applyTemplateHook('profsaude', 'after'); ?>