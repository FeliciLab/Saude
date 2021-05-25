<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
    Use Saude\Entities\Resources;
    use MapasCulturais\Entities\Registration;
    $app = \MapasCulturais\App::i();
    $this->layout = 'panel';
    
 ?>

<div class="panel-list panel-main-content">
    <?php $this->applyTemplateHook('panel-header','before'); ?>
    <header class="panel-header clearfix">
    
        <h2><?php \MapasCulturais\i::_e("Meus Recursos");?></h2>

    </header>
    <?php $this->applyTemplateHook('panel-header','after'); ?>
    <div id="recurso">
        <?php $this->part('modals/table-resource') ?>
    </div>

    <!-- MODAL COM O FORM DE RESPOSTA DE RECURSO -->
    <?php $this->part('modals/open-modal') ?>
</div>