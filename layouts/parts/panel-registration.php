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

$phases = $app->repo('Opportunity')->findBy([
    'parent' => $registration->opportunity,
    'status' => $registration->opportunity->canUser('@control') ? [0,-1] : -1 
],['registrationTo' => 'ASC', 'id' => 'ASC']);

$phases = array_filter($phases, function($item) {
    if($item->isOpportunityPhase){
        return $item;
    }
});
//dump($phases[0]->singleUrl);
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
    <?php if ($registration->canUser('sendClaimMessage')) { ?>
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
            echo '<div style="justify-content: space-between;display: flex;">
                <label class="text-info">Recurso enviado</label>
                <label style="color: green">Exibir fases</label>
            </div>';
        }
        //MENSAGEM FORA DO PERIODO
        if ($rec['open'] != 1 || $rec['close'] != 1) {
            echo '<div style="justify-content: space-between;display: flex;">
                <label class="text-danger">Fora do período do recurso</label>
                <label style="color: green">Exibir fases</label>
            </div>';
        }

        ?>
    <?php }else{
        echo '<div style="text-align: right;">
                <label style="color: green">Exibir fases</label>
            </div>';
    } ?>
    <div>
        <h4>Fases</h4>
            <?php foreach($phases as $phase){ ?>
                <div style="background-color: white; padding: 20px; padding-bottom: 0px; margin-bottom: 20px;">
                        <p style="margin-bottom: 0.5rem"><?php echo $phase->name; ?></p>
                        <div style="display: flex; justify-content: space-between;">
                            <div>
                                <small>Inscrição da fase: on-187897879898</small><br>
                                <small>Status: pedente</small>
                            </div>
                            <div style="margin-top: auto; margin-bottom: auto;">
                                <small style="color: blue; margin-bottom: 0.8rem">Acessar inscrição da fase</small>
                            </div>
                        </div>
                </div>
            <?php }?>
            <?php if(!$phases): ?>
                <div class="alert info"><?php \MapasCulturais\i::_e("Esta oportunidade não possui fases.");?></div>
            <?php endif; ?>
    </div>
</article>