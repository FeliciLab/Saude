<?php

use Saude\Entities\Resources;
use \MapasCulturais\Entities\RegistrationEvaluation;
use Saude\Utils\RegistrationStatus;
use MapasCulturais\Entities\Registration;

$registrations = $app->repo('Registration')->findByOpportunityAndUser($entity, $app->user);
$now = new DateTime('now');

if (!empty($registrations)) {
    $resource = Resources::checkPublishOpportunity($entity->id, $registrations[0]->id);
    $allResults = $app->repo('RegistrationEvaluation')->findBy(['registration' => $registrations[0]->id]);
    $verifyPublish = $app->repo('Opportunity')->find($registrations[0]->opportunity->id);
    $typeEvaluation = $app->repo('EvaluationMethodConfiguration')->findBy(
        ['opportunity' => $registrations[0]->opportunity->id]
    );
}
?>

</style>
<?php if ($registrations) : ?>
    <div style="overflow-x:auto;">
        <table class="my-registrations" style="width: 100%">
            <caption class="caption-table"><?php \MapasCulturais\i::_e("Minhas inscrições"); ?></caption>
            <thead>
                <tr>
                    <th class="registration-status-col" style="text-align: center;width: 30%">
                        <?php \MapasCulturais\i::_e("Inscrição"); ?>
                    </th>
                    <th class="registration-agents-col" style="text-align: center;">
                        <?php \MapasCulturais\i::_e("Agentes"); ?>
                    </th>
                    <th class="registration-status-col" style="text-align: left; text-align: center;">
                        <?php \MapasCulturais\i::_e("Data de Envio"); ?>
                    </th>
                    <?php if (
                        $verifyPublish->publishedRegistrations == true
                        && $typeEvaluation[0]->type->id == 'technical'
                    ) : ?>
                        <th class="registration-status-col" style="text-align: center;">
                            <?php \MapasCulturais\i::_e("Nota preliminar"); ?>
                        </th>
                        <th class="registration-status-col" style="text-align: center; width: 20%;">
                            <?php \MapasCulturais\i::_e("Nota final"); ?>
                        </th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($registrations as $registration) :
                    $reg_args = ['registration' => $registration, 'opportunity' => $entity];
                ?>
                    <tr>
                        <?php $this->applyTemplateHook('user-registration-table--registration', 'begin', $reg_args); ?>
                        <td class="registration-status-col" style="text-align: center;">
                            <?php $this->applyTemplateHook('user-registration-table--registration--number', 'begin', $reg_args); ?>
                            <a href="<?php echo $registration->singleUrl ?>"><?php echo $registration->number ?> </a>
                            <?php if($registration->status == Registration::STATUS_DRAFT){ ?> 
                                <p style="color:#f00;"><?php \MapasCulturais\i::_e("Inscrição em rascunho"); ?></p>
                            <?php } ?>
                            <?php $this->applyTemplateHook('user-registration-table--registration--number', 'end', $reg_args); ?>
                        </td>
                        <td class="registration-agents-col" style="text-align: center;">
                            <?php $this->applyTemplateHook('user-registration-table--registration--agents', 'begin', $reg_args); ?>
                            <p>
                                <span class="label"><?php \MapasCulturais\i::_e("Responsável"); ?></span><br>
                                <?php echo htmlentities($registration->owner->name); ?>
                            </p>
                            <?php
                            foreach ($app->getRegisteredRegistrationAgentRelations() as $def) :
                                if (!$entity->useRegistrationAgentRelation($def))
                                    continue;
                            ?>
                                <?php if ($agents = $registration->getRelatedAgents($def->agentRelationGroupName)) : ?>
                                    <p>
                                        <span class="label"><?php echo $def->label ?></span><br>
                                        <?php echo htmlentities($agents[0]->name); ?>
                                    </p>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            <?php $this->applyTemplateHook('user-registration-table--registration--agents', 'end', $reg_args); ?>
                        </td>
                        <td class="registration-status-col" style="text-align: center; vertical-align: middle;">
                            <?php $this->applyTemplateHook('user-registration-table--registration--status', 'begin', $reg_args); ?>
                            <?php if ($registration->status > 0) : ?>
                                <?php echo $registration->sentTimestamp ? $registration->sentTimestamp->format(\MapasCulturais\i::__('d/m/Y à\s H:i')) : ''; ?>.
                                <div class="div-to-show-button" style="justify-content: center;">
                                    <?php if ($now < $entity->registrationTo && $entity->select_edit_registration == '1') : ?>
                                        <?php $this->applyTemplateHook('modal-edit-registration','before', ['registration' => $registration]); ?>
                                        <a href="#" class="btn btn-small btn-primary mt-auto" data-remodal-target="modal-edit-registration" title="Edite a sua inscrição"  style="width: 113.81px;margin:1px;" href="<?php echo $registration->singleUrl ?>"><?php \MapasCulturais\i::_e("Editar inscrição"); ?></a>
                                    <?php endif; ?>
                                    <a class="btn btn-small btn-primary mt-auto button-ver" style="margin:1px;" href="<?php echo $registration->singleUrl ?>"><?php \MapasCulturais\i::_e("Ver comprovante"); ?></a>
                                </div>
                            <?php else : ?>
                                <?php if ($now < $entity->registrationTo && $entity->select_edit_registration == '1') : ?>
                                    <a class="btn btn-small btn-primary mt-auto" style="width: 113.81px;margin:1px;" href="<?php echo $registration->singleUrl ?>"><?php \MapasCulturais\i::_e("Editar inscrição"); ?></a>
                                <?php endif; ?>
                            <?php endif; ?>
                            <?php if($entity->claimDisabled != null): ?>
                                <?php $this->applyTemplateHook('user-registration-table--registration--status', 'end', $reg_args); ?>
                            <?php endif; ?>

                            
                        </td>
                        <?php if (
                            $verifyPublish->publishedRegistrations == true
                            && $typeEvaluation[0]->type->id == 'technical'
                        ) : ?>
                            <td>
                                <?php echo $registration->preliminaryResult; ?>
                            </td>

                            <?php
                            //ENTROU COM RECURSO E JA FOI PUBLICADO
                            if ($resource['text'] !== "" && $resource['publish'] == true) {
                                echo '<td>' . $registration->consolidatedResult . '</td>';
                            } else
                                //SE ENTROU EM RECURSO MAS AINDA NAO FOI PUBLICADO
                                if ($resource['text'] !== "" && $resource['publish'] == false) {
                                    echo '<td>Recurso enviado. Aguarde!</td>';
                                } else
                                    //SE NÃO ENTROU EM RECURSO.
                                    if ($resource['text'] == 'Não existe texto' && $resource['publish'] == 'sem publicacao') {
                                        echo '<td>' . $registration->consolidatedResult . '</td>';
                                    }
                            ?>
                        <?php endif; ?>
                        <?php $this->applyTemplateHook('user-registration-table--registration', 'end', $reg_args); ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>