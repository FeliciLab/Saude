<?php

use MapasCulturais\App;

$app = App::i();
$user = $app->user;

$usuario = $entity->evaluationMethodConfiguration->getUserRelation($user);
dump($entity->singleUrl);
$btnHideShow = false;
if ($entity instanceof \MapasCulturais\Entities\Opportunity) {
    echo "Oportunidade";
} else {
    echo "Nao é oportunidade";
}


if ($entity->isRegistrationOpen()) : ?>
    <?php if ($app->auth->isUserAuthenticated()) : ?>
        <?php if (empty($usuario)) : //SE CASO ESSE USUÁRIO FOI ALGUM AVALIADOR O FORM NAO APARECERÁ PARA ELE 
        ?>
            <form class="registration-form clearfix">
                <p class="registration-help white-top" style="font-size: 14px;"><?php \MapasCulturais\i::_e("Para iniciar sua inscrição, selecione o agente responsável. Ele deve ser um agente individual (pessoa física), com um CPF válido preenchido."); ?></p>
                <div class="registration-form-content">
                    <div class="registration-form-content-input">
                        <div id="select-registration-owner-button" class="input-text" ng-click="editbox.open('editbox-select-registration-owner', $event)">{{data.registration.owner ? data.registration.owner.name : data.registration.owner_default_label}}</div>
                        <edit-box id="editbox-select-registration-owner" position="top" title="<?php \MapasCulturais\i::esc_attr_e("Selecione o agente responsável pela inscrição."); ?>" cancel-label="<?php \MapasCulturais\i::esc_attr_e("Cancelar"); ?>" close-on-cancel='true' spinner-condition="data.registrationSpinner">
                            <find-entity id='find-entity-registration-owner' entity="agent" no-results-text="<?php \MapasCulturais\i::esc_attr_e("Nenhum agente encontrado"); ?>" select="setRegistrationOwner" api-query='data.relationApiQuery.owner' spinner-condition="data.registrationSpinner"></find-entity>
                            <strong><?php \MapasCulturais\i::_e("Apenas são visíveis os agentes publicados."); ?> <a target="_blank" href="<?php echo $app->createUrl('panel', 'agents') ?>"><?php \MapasCulturais\i::_e("Ver mais."); ?></a></strong>
                        </edit-box>
                        <a class="btn btn-primary btn-register-opportunity" style="color: #ffffff;" ng-click="register(<?php echo $entity->id; ?>)" rel='noopener noreferrer'><?php \MapasCulturais\i::_e("Fazer inscrição"); ?></a>
                    </div>
                    <div>
                        <a href="<?= $entity->singleUrl; ?>" class="btn btn-access-opportunity" style="color: #ffffff;" rel='noopener noreferrer' title="Acessar inscrições"><?php \MapasCulturais\i::_e("Acessar Inscrição"); ?></a>
                    </div>  
                </div>
         
                
                
                <!-- <div>
                    <div id="select-registration-owner-button" class="input-text" ng-click="editbox.open('editbox-select-registration-owner', $event)">{{data.registration.owner ? data.registration.owner.name : data.registration.owner_default_label}}</div>
                    <edit-box id="editbox-select-registration-owner" position="top" title="<?php \MapasCulturais\i::esc_attr_e("Selecione o agente responsável pela inscrição."); ?>" cancel-label="<?php \MapasCulturais\i::esc_attr_e("Cancelar"); ?>" close-on-cancel='true' spinner-condition="data.registrationSpinner">
                        <find-entity id='find-entity-registration-owner' entity="agent" no-results-text="<?php \MapasCulturais\i::esc_attr_e("Nenhum agente encontrado"); ?>" select="setRegistrationOwner" api-query='data.relationApiQuery.owner' spinner-condition="data.registrationSpinner"></find-entity>
                        <strong><?php \MapasCulturais\i::_e("Apenas são visíveis os agentes publicados."); ?> <a target="_blank" href="<?php echo $app->createUrl('panel', 'agents') ?>"><?php \MapasCulturais\i::_e("Ver mais."); ?></a></strong>
                    </edit-box>
                </div> -->
                <!-- <div>
                        <a class="btn btn-primary btn-register-opportunity" style="color: #ffffff;" ng-click="register(<?php echo $entity->id; ?>)" rel='noopener noreferrer'><?php \MapasCulturais\i::_e("Fazer inscrição"); ?></a>
                        <a href="<?= $entity->singleUrl; ?>" class="btn btn-access-opportunity" style="color: #ffffff;" rel='noopener noreferrer' title="Acessar inscrições"><?php \MapasCulturais\i::_e("Acessar Inscrição"); ?></a>
                    </div> -->

            </form>
        <?php endif; ?>
    <?php else : ?>
        <div class="alert danger" style="position: relative !important;">
            <p>
                <?php \MapasCulturais\i::_e("Para se inscrever é preciso ter uma conta e estar logado nesta plataforma. Clique no botão abaixo para criar uma conta ou fazer login."); ?>
            </p>
            <p>
                <a class="btn btn-primary" ng-click="setRedirectUrl()" <?php echo $this->getLoginLinkAttributes() ?>>
                    <?php \MapasCulturais\i::_e("Fazer login"); ?>
                </a>
            </p>
        </div>
    <?php endif; ?>
<?php endif; ?>