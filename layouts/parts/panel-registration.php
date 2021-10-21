<?php

use MapasCulturais\Entities\Registration;
use Saude\Entities\Resources;

$app = MapasCulturais\App::i();

$url = $registration->status == Registration::STATUS_DRAFT ? $registration->editUrl : $registration->singleUrl;
$proj = $registration->opportunity;
$resources = Resources::validateOnlyResource($registration->id, $registration->opportunity->id, $registration->owner->id);
$classeDestaque = "";

if (isset($_GET['id']) && $_GET['id'] == $registration->id) {
    $classeDestaque = "classeDestaque";
}

$rec = Resources::getEnabledResource($registration->opportunity->id, 'period');
?>

<article class="objeto clearfix <?php echo $classeDestaque; ?>" id="<?php echo $registration->id; ?>" name="<?php echo $registration->id; ?>">
    <?php if ($avatar = $proj->avatar) : ?>
        <div class="thumb">
            <img src="<?php echo $avatar->transform('avatarSmall')->url ?>">
        </div>
    <?php endif; ?>
    <a href="<?php echo $url; ?>" class="text-primary">Acessar inscrição</a>
    <h1 style="margin-top: 5px;"><?php echo $proj->name ?></h1>
    <small>
        <strong>Inscrição:</strong> <?php echo $registration->number; ?>
    </small> <br>

    <small>
        <?php
        $status = '';
        $title = '';
        switch ($registration->status) {
            case 0:
                $status = 'Rascunho';
                $title = 'O candidato poderá editar e reenviar a sua inscrição.';
                break;
            case 1:
                $status = 'Pendente';
                $title = 'Ainda não avaliada.';
                break;
            case 2:
                $status = 'Inválida';
                $title = 'Em desacordo com o regulamento.';
                break;
            case 3:
                $status = 'Não selecionada';
                $title = 'Avaliada, mas não selecionada.';
                break;
            case 8:
                $status = 'Suplente';
                $title = 'Avaliada, mas aguardando vaga.';
                break;
            case 10:
                $status = 'Selecionada';
                $title = 'Avaliada e selecionada.';
                break;
        }
        ?>
        <!-- verifica se o resultado já foi publicado antes de exibir o status -->
        <?php if ($registration->opportunity->publishedRegistrations) : ?>
            <td class="registration-status-col">
                <strong>Status: </strong><?php echo $status; ?>

            <?php else : ?>
            <td class="registration-status-col statuspend">
                <strong>Status: </strong><?php echo $status; ?>

            <?php endif; ?>

    </small><br>
    <?php if ($registration->canUser('sendClaimMessage')) : ?>
        <?php
        //VERIFICA SE ENVIOU O RECURSO
        if ($resources == false) {
            if ($rec['open'] == 1 && $rec['close'] == 1) { ?>
                <a data-remodal-target="modal-recurso" onclick="showModalResource('<?php echo $registration->id; ?>', '<?php echo $registration->opportunity->id; ?>', '<?php echo $registration->owner->id; ?>', '<?php echo $registration->opportunity->name; ?>')" class="btn btn-primary">
                    <i class="fa fa-edit"></i> Abrir Recurso
                </a>
        <?php
            }
        } else {
            echo '<label class="text-info">Recurso enviado</label><br/>';
        }
        //MENSAGEM FORA DO PERIODO
        if ($rec['open'] != 1 || $rec['close'] != 1) {
            echo '<label class="text-danger">Fora do período do recurso</label><br/>';
        }

        ?>
    <?php endif; ?>
    <div class="objeto-meta">
        <div><span class="label" <?php \MapasCulturais\i::esc_attr_e("Responsável:"); ?>></span> <?php echo $registration->owner->name ?></div>
        <?php
        foreach ($app->getRegisteredRegistrationAgentRelations() as $def) :
            if (isset($registration->relatedAgents[$def->agentRelationGroupName])) :
                $agent = $registration->relatedAgents[$def->agentRelationGroupName][0];
        ?>
                <div><span class="label"><?php echo $def->label ?>:</span> <?php echo $agent->name; ?></div>

        <?php
            endif;
        endforeach;
        ?>
        <?php if ($proj->registrationCategories) : ?>
            <div><span class="label"><?php echo $proj->registrationCategTitle ?>:</span> <?php echo $registration->category ?></div>
        <?php endif; ?>
    </div>
</article>