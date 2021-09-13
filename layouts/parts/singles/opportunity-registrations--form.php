<?php

use MapasCulturais\App;

$url_atual = $app->view->controller->id;

$app = App::i();

$user = $app->user;

$userRelation = $entity->evaluationMethodConfiguration->getUserRelation($user);

$btnHideShow = false;

if (strpos($url_atual, 'opportunity') !== false) {
	$btnHideShow = true;
} else {
	$btnHideShow = false;
}

if ($entity->isRegistrationOpen()): ?>
    <?php if ($app->auth->isUserAuthenticated()): ?>

        <!-- // SE O USUARIO TIVER PERMISSÃO PARA MODIFICAR A ENTIDADE  -->
        <?php if (!($entity->canUser('modify')) && empty($userRelation)): ?>

            <form class="registration-form clearfix">
                <p class="registration-help white-top" style="font-size: 14px;"><?php \MapasCulturais\i::_e("Para iniciar sua inscrição, selecione o agente responsável. Ele deve ser um agente individual (pessoa física), com um CPF válido preenchido.");?></p>
                <div class="registration-form-content">
                    <div class="registration-form-content-input">
                        <div id="select-registration-owner-button_<?php echo $entity->id; ?>" class="input-text" ng-click="editbox.open('editbox-select-registration-owner_<?php echo $entity->id; ?>', $event)">{{data.registration.owner ? data.registration.owner.name : data.registration.owner_default_label}}</div>
                        <edit-box class="editbox-select-registration-owner" id="editbox-select-registration-owner_<?php echo $entity->id; ?>" position="top" title="<?php \MapasCulturais\i::esc_attr_e("Selecione o agente responsável pela inscrição.");?>" cancel-label="<?php \MapasCulturais\i::esc_attr_e("Cancelar");?>" close-on-cancel='true' spinner-condition="data.registrationSpinner">
                            <find-entity id='find-entity-registration-owner_<?php echo $entity->id; ?>' entity="agent" no-results-text="<?php \MapasCulturais\i::esc_attr_e("Nenhum agente encontrado");?>" select="setRegistrationOwner" opportunityid="<?php echo $entity->id; ?>" api-query='data.relationApiQuery.owner' spinner-condition="data.registrationSpinner"></find-entity>
                            <strong><?php \MapasCulturais\i::_e("Apenas são visíveis os agentes publicados.");?> <a target="_blank" href="<?php echo $app->createUrl('panel', 'agents') ?>"><?php \MapasCulturais\i::_e("Ver mais.");?></a></strong>
                        </edit-box>
                        <a class="btn btn-primary btn-register-opportunity" style="color: #ffffff;" ng-click="register(<?php echo $entity->id; ?>)" rel='noopener noreferrer'><?php \MapasCulturais\i::_e("Fazer inscrição");?></a>
                    </div>
                    <div style="visibility: <?php echo $btnHideShow ? 'hidden' : 'visible' ?>">
                        <a href="<?=$entity->singleUrl;?>" class="btn btn-access-opportunity" style="color: #ffffff;" rel='noopener noreferrer' title="Acessar inscrições"><?php \MapasCulturais\i::_e("Acessar Inscrição");?></a>
                    </div>
                </div>
            </form>
        <?php endif;?>
    <?php else: ?>
        <div class="alert danger" style="position: relative !important;">
            <p>
                <?php \MapasCulturais\i::_e("Para se inscrever é preciso ter uma conta e estar logado nesta plataforma. Clique no botão abaixo para criar uma conta ou fazer login.");?>
            </p>
            <p>
                <a class="btn btn-primary" ng-click="setRedirectUrl()" <?php echo $this->getLoginLinkAttributes() ?>>
                    <?php \MapasCulturais\i::_e("Fazer login");?>
                </a>
            </p>
        </div>
    <?php endif;?>
<?php endif;?>