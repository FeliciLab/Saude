<?php
    use MapasCulturais\Entities\Registration;
    $this->layout = 'panel';
    
    $drafts = $app->repo('Registration')->findByUser($app->user, Registration::STATUS_DRAFT);
    $sent = $app->repo('Registration')->findByUser($app->user, 'sent');
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
        <li class="active">
            <a href="#enviadas" rel='noopener noreferrer'><?php \MapasCulturais\i::_e("Enviadas");?></a>
        </li>
        <li>
            <a href="#ativos" rel='noopener noreferrer'><?php \MapasCulturais\i::_e("Rascunhos");?></a>
        </li>
        <li>
            <a href="#recurso" rel='noopener noreferrer'><?php \MapasCulturais\i::_e("Recurso");?></a>
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
    <div id="recurso">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Inscrição</th>
                    <th>Recurso Solicitado</th>
                    <th>Enviado em</th>
                    <th>Situação</th>
                    <th>Resposta</th>
                </tr>
            </thead>
            <tbody id="bodyAllResource"></tbody>
        </table>
    </div>
    <!-- #lixeira-->
</div>
<div class="remodal" data-remodal-id="modal-recurso">
    <button data-remodal-action="close" class="remodal-close"></button>
    <h1>Formulário de recurso</h1>
    <p>
        <strong>Oportunidade: 
        <label id="opportunityNameLabel"></label>
        </strong>
    </p>
    <form id="formSendResource">
        <textarea name="resource_text" id="" cols="30" rows="20" class="form-control" style="height: 322px !important"></textarea>
        <input type="text" id="registration_id" name="registration_id">
        <input type="text" name="opportunity_id" id="opportunity_id">
        <input type="text" name="agent_id" id="agent_id" >
        <br>
        <button data-remodal-action="cancel" class="btn btn-default" title="Desistir de enviar o recurso">
        <i class="fa fa-close" aria-hidden="true"></i>
        Fechar
        </button>
        <button class="btn btn-primary" type="submit" title="Enviar o seu recurso para essa oportunidade" style="margin-left: 20px;"
            id="">
        <i class="fa fa-paper-plane" aria-hidden="true"></i>
        Enviar
        </button>
    </form>
</div>