<?php

use Saude\Entities\Resources;
use \MapasCulturais\Entities\RegistrationEvaluation;

$registrations = $app->repo('Registration')->findByOpportunityAndUser($entity, $app->user);

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
    <table class="my-registrations" style="width: 100%">
        <caption class="caption-table"><?php \MapasCulturais\i::_e("Minhas inscrições"); ?></caption>
        <thead>
            <tr>
                <th class="registration-status-col" style="text-align: center;width: 20%">
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
                <th class="registration-status-col" style="text-align: center;width: 20%">
                    <?php \MapasCulturais\i::_e("Status"); ?>
                </th>
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
                        <a href="<?php echo $registration->singleUrl ?>"><?php echo $registration->number ?></a>
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
                    <td class="registration-status-col" style="text-align: center;">
                        <?php $this->applyTemplateHook('user-registration-table--registration--status', 'begin', $reg_args); ?>
                        <?php if ($registration->status > 0) : ?>
                            <?php echo $registration->sentTimestamp ? $registration->sentTimestamp->format(\MapasCulturais\i::__('d/m/Y à\s H:i')) : ''; ?>.
                        <?php else : ?>
                            <?php \MapasCulturais\i::_e("Não enviada."); ?><br>
                            <a class="btn btn-small btn-primary" href="<?php echo $registration->singleUrl ?>"><?php \MapasCulturais\i::_e("Editar e enviar"); ?></a>
                        <?php endif; ?>
                        <?php $this->applyTemplateHook('user-registration-table--registration--status', 'end', $reg_args); ?>
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
                                //SE NÃO ENTROU EM RECURSO
                                if ($resource['text'] == 'Não existe texto' && $resource['publish'] == 'sem publicacao') {
                                    echo '<td>' . $registration->consolidatedResult . '</td>';
                                }
                        ?>
                    <?php endif; ?>
                    <?php $this->applyTemplateHook('user-registration-table--registration', 'end', $reg_args); ?>

                    <?php $this->applyTemplateHook('user-registration-table--registration--status', 'begin', $reg_args);

                    $status = '';
                    $color = '';
                    $title = '';
                    switch ($registration->status) {
                        case 0:
                            $status = 'Rascunho';
                            $colorStatus = 'statusrasc';
                            $title = 'O candidato poderá editar e reenviar a sua inscrição.';
                            break;
                        case 1:
                            $status = 'Pendente';
                            $colorStatus = 'statuspend';
                            $title = 'Ainda não avaliada.';
                            break;
                        case 2:
                            $status = 'Inválida';
                            $colorStatus = 'statusinv';
                            $title = 'Em desacordo com o regulamento.';
                            break;
                        case 3:
                            $status = 'Não selecionada';
                            $colorStatus = 'statusrep';
                            $title = 'Avaliada, mas não selecionada.';
                            break;
                        case 8:
                            $status = 'Suplente';
                            $colorStatus = 'statusespera';
                            $title = 'Avaliada, mas aguardando vaga.';
                            break;
                        case 10:
                            $status = 'Selecionada';
                            $colorStatus = 'statusap';
                            $title = 'Avaliada e selecionada.';
                            break;
                    }
                    ?>
                    <!-- Apenas mosta o status quando a oportinudade já foi publicada -->
                    <?php if ($registration->opportunity->publishedRegistrations) : ?>
                        <td class="registration-status-col <?php echo $colorStatus; ?>" style="text-align: center; font-size: 11px;">
                            <?php $this->part('singles/tooltip', ['title' => $title, 'chield' => $status]); ?>
                        </td>
                    <?php else : ?>
                        <td class="registration-status-col statusrasc" style="text-align: center; font-size: 11px;">
                            <?php $this->part('singles/tooltip', ['title' => 'Sua inscrição está sendo analisada', 'chield' => 'Em analise']); ?>
                        </td>
                    <?php endif; ?>

                    <?php $this->applyTemplateHook('user-registration-table--registration', 'end', $reg_args); ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>