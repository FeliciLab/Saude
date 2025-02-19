<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
    use MapasCulturais\Entities\Registration;
    $this->layout = 'panel';
    
    $drafts = $app->repo('Registration')->findByUser($app->user, Registration::STATUS_DRAFT);
    
    $dql = "
            SELECT
                r
            FROM
                MapasCulturais\Entities\Registration r
                LEFT JOIN  MapasCulturais\Entities\RegistrationAgentRelation rar WITH rar.owner = r
            WHERE
                r.status > 0 AND
                (
                    r.owner IN (:agents) OR
                    rar.agent IN (:agents)
                )
            ORDER BY r.opportunity";
    
    $q = $app->em->createQuery($dql);
    $usuario = $app->user;
    $q->setParameter('agents', $usuario->agents ? $usuario->agents->toArray() : [-1]);
    $sent = $q->getResult();

    $unique_opportunities = [];
    foreach($sent as $s){
        if($s->opportunity->parent == null){
            $unique_opportunities[$s->id] = $s;
        }
    }

    $unique_opportunities = array_reverse($unique_opportunities);

 ?>

<div class="panel-list panel-main-content">
    <?php $this->applyTemplateHook('panel-header','before'); ?>
    <header class="panel-header clearfix">
        <?php $this->applyTemplateHook('panel-header','begin'); ?>
        <h2><?php \MapasCulturais\i::_e("Minhas inscrições");?></h2>
        <?php $this->applyTemplateHook('panel-header','end') ?>
    </header>
    <?php $this->applyTemplateHook('panel-header','after'); ?>
    <ul class="abas clearfix clear">
        <li>
            <a href="#enviadas" rel='noopener noreferrer'><?php \MapasCulturais\i::_e("Enviadas");?></a>
        </li>
        <li class="active">
            <a href="#ativos" rel='noopener noreferrer'><?php \MapasCulturais\i::_e("Rascunhos");?></a>
        </li>
    </ul>
    <div id="ativos">
        <?php foreach($drafts as $registration): ?>
        <?php $this->part('panel-registration', array('registration' => $registration)); ?>
        <?php endforeach; ?>
        <?php if(!$drafts): ?>
        <div class="alert info"><?php \MapasCulturais\i::_e("Você não possui nenhum rascunho de inscrição.");?></div>
        <?php endif; ?>
    </div>
    <!-- #ativos-->
    <div id="enviadas">
        <?php foreach($unique_opportunities as $registration): ?>
        <?php $this->part('panel-registration', array('registration' => $registration)); ?>
        <?php endforeach; ?>
        <?php if(!$sent): ?>
        <div class="alert info"><?php \MapasCulturais\i::_e("Você não enviou nenhuma inscrição.");?></div>
        <?php endif; ?>
    </div>

<!-- MODAL COM O FORM DE ENVIO DE RECURSO -->
<?php $this->part('modals/form-resource') ?>
<?php $this->part('modals/open-modal') ?>



