<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
    use MapasCulturais\Entities\Registration;
    $this->layout = 'panel';
    
    $drafts = $app->repo('Registration')->findByUser($app->user, Registration::STATUS_DRAFT);
    $sent = $app->repo('Registration')->findByUser($app->user, 'sent');
    
  // ORDENANDO O ARRAY POR DATA DE ENVIO DA INSCRIÇÃO EM ORDEM DECRESCENTE
  if($sent):
    if (isset($dateTime)):
    foreach ($sent as $key => $value){
    $dateTime[] = $value->sentTimestamp->format('d-m-Y H:i:s');
    }
    array_multisort($dateTime,SORT_DESC,SORT_STRING,$sent);   
    endif;
  endif;
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
        <?php foreach($sent as $registration): ?>
        <?php $this->part('panel-registration', array('registration' => $registration)); ?>
        <?php endforeach; ?>
        <?php if(!$sent): ?>
        <div class="alert info"><?php \MapasCulturais\i::_e("Você não enviou nenhuma inscrição.");?></div>
        <?php endif; ?>
    </div>

<!-- MODAL COM O FORM DE ENVIO DE RECURSO -->
<?php $this->part('modals/form-resource') ?>
<?php $this->part('modals/open-modal') ?>



