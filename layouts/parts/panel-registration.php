<?php

use MapasCulturais\Entities\Registration;
use Saude\Entities\Resources;

use Saude\Utils\RegistrationStatus;

$app = MapasCulturais\App::i();

$url = $registration->status == Registration::STATUS_DRAFT ? $registration->editUrl : $registration->singleUrl;
$proj = $registration->opportunity;
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
        <!-- verifica se o resultado já foi publicado antes de exibir o status -->
        <?php if ($registration->opportunity->publishedRegistrations) : ?>
            <td class="registration-status-col">
                <strong>Status: </strong><?php echo RegistrationStatus::getStatusNameById($registration->status); ?>

        <?php else : ?>
            <td class="registration-status-col statuspend">
                <strong>Status: </strong><?php echo RegistrationStatus::getStatusNameById($registration->status); ?>

        <?php endif; ?>
    </small><br>
    <?php if ($registration->canUser('sendClaimMessage')) : ?>
        <?php
        //VERIFICA SE ENVIOU O RECURSO
        if ($resources == false) {
            if ($rec['open'] == true && $rec['close'] == true) { ?>
                <a data-remodal-target="modal-recurso" onclick="showModalResource('<?php echo $registration->id; ?>', '<?php echo $registration->opportunity->id; ?>', '<?php echo $registration->owner->id; ?>', '<?php echo $registration->opportunity->name; ?>')" class="btn btn-primary">
                    <i class="fa fa-edit"></i> Abrir Recurso
                </a>
        <?php
            }
        } else {
            echo '<label class="text-info">Recurso enviado</label><br/>';
        }
        //MENSAGEM FORA DO PERIODO
        if ($rec['open'] != true || $rec['close'] != true) {
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
    <?php if ($registration->canUser('sendClaimMessage')) { 
        if($rec['open'] == 1 && $rec['close'] == 1){?>
            <a data-remodal-target="modal-recurso" onclick="showModalResource('<?php echo $registration->id; ?>', '<?php echo $registration->opportunity->id; ?>', '<?php echo $registration->owner->id; ?>', '<?php echo $registration->opportunity->name; ?>')" class="btn btn-primary">
                <i class="fa fa-edit"></i> Abrir Recurso
            </a>
        <?php }else if($rec['open'] != 1 || $rec['close'] != 1){
            echo '<div style="justify-content: space-between;display: flex;">
                <label class="text-danger">Fora do período do recurso</label>
                <label style="color: green" onclick="phaseStatus('. $registration->id .')" ><i class="fa fa-angle-down"> Exibir fases </i> </label>
            </div>';
        }else{
            echo '<div style="justify-content: space-between;display: flex;">
                <label class="text-info">Recurso enviado</label>
                <label style="color: green" onclick="phaseStatus('. $registration->id .')" ><i class="fa fa-angle-down"> Exibir fases </i> </label>
            </div>';
        }
    }else{
        echo '<div style="text-align: right;">
            <label style="color: green" onclick="phaseStatus('. $registration->id .')" ><i class="fa fa-angle-down"> Exibir fases </i> </label>
        </div>';
    } ?>
    <div style="margin-top: 20px; display: none" id="phases-<?php echo $registration->id; ?>">
        <h4>Fases</h4>
        <?php foreach($phases as $phase){
            $registration = $app->repo('Registration')->findByOpportunityAndUser($phase, $app->user);
        ?>
            <div style="background-color: white; padding: 20px; padding-bottom: 0px; margin-bottom: 20px;">
                <p style="margin-bottom: 0.5rem"><?php echo $phase->name; ?></p>
                    <div style="display: flex; justify-content: space-between;">
                        <div>
                            <small><strong>Inscrição da fase:</strong> <?php 
                                if(count($registration) == 0){
                                    echo "Não inscrito";
                                }else{
                                    echo $registration[0]->number;
                                }
                            ?></small><br>
                            <?php 
                            if(count($registration) > 0){ ?>
                                <small><strong>Status:</strong>
                                <?php 
                                    if(count($registration) > 0){
                                        echo RegistrationStatus::getStatusNameById($registration[0]->status);
                                    }
                                ?>
                            </small>
                            <?php }  ?>
                        </div>
                        <div style="margin-top: auto; margin-bottom: auto;">
                            <?php 
                                if(count($registration) > 0){ ?>
                                    <a style="color: blue; margin-bottom: 0.8rem" href="<?php echo $registration[0]->singleUrl; ?>">Acessar inscrição da fase</a>
                                <?php }else{ ?>
                                    <a style="color: blue; margin-bottom: 0.8rem" href="<?php echo $phase->singleUrl; ?>">Acessar inscrição da fase</a>
                                <?php } 
                            ?>
                        </div>
                    </div>
            </div>
        <?php }?>
        <?php if(!$phases): ?>
                <div class="alert info"><?php \MapasCulturais\i::_e("Esta oportunidade não possui fases.");?></div>
        <?php endif; ?>
    </div>
</article>

<script>
    function phaseStatus(id){
        let object = $(`#phases-${id}`);
        if(object.css('display') == 'none'){
            object.css( "display", "block" );
        }else if(object.css('display') == 'block'){
            object.css( "display", "none" );
        }
    }
</script>