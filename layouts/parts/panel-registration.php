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

$resources = Resources::validateOnlyResource($registration->id, $registration->opportunity->id, $registration->owner->id);

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
    <?php if ($registration->canUser('sendClaimMessage')) { 
        if($resources == false){
            if($rec['open'] == 1 && $rec['close'] == 1){?>
                <a data-remodal-target="modal-recurso" onclick="showModalResource('<?php echo $registration->id; ?>', '<?php echo $registration->opportunity->id; ?>', '<?php echo $registration->owner->id; ?>', '<?php echo $registration->opportunity->name; ?>')" class="btn btn-primary">
                    <i class="fa fa-edit"></i> Abrir Recurso
                </a>
        <?php }
        }
        if($rec['open'] != 1 || $rec['close'] != 1){
            echo '<div style="justify-content: space-between;display: flex;">
                <label class="text-danger">Fora do período do recurso</label>
                <label id="button-'. $registration->id .'" style="color: green; cursor: pointer" onclick="phaseStatus('. $registration->id .')" >Exibir fases <i class="fa fa-angle-down"></i> </label>
            </div>';
        }else{
            echo '<div style="justify-content: space-between;display: flex;">
                <label class="text-info">Recurso enviado</label>
                <label id="button-'. $registration->id .'" style="color: green; cursor: pointer" onclick="phaseStatus('. $registration->id .')" >Exibir fases <i class="fa fa-angle-down"></i> </label>
            </div>';
        }
    }else{
        echo '<div style="text-align: right;">
        <label id="button-'. $registration->id .'" style="color: green; cursor: pointer" onclick="phaseStatus('. $registration->id .')" >Exibir fases <i class="fa fa-angle-down"></i> </label>
        </div>';
    } ?>
    <div style="margin-top: 20px; display: none" id="phases-<?php echo $registration->id; ?>" class="wrapper-show">
        <div id="sub-div-<?php echo $registration->id; ?>">
            <h4>Fases</h4>
            <?php foreach($phases as $phase){
                $registration = $app->repo('Registration')->findByOpportunityAndUser($phase, $app->user);
            ?>
                <div style="background-color: white; padding: 20px; padding-bottom: 0px; margin-bottom: 20px;">
                    <p style="margin-bottom: 0.5rem"><?php echo $phase->name; ?></p>
                        <div class="user-oportunity-details">
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
                                        <a style="margin-bottom: 0.8rem" class="text-primary" href="<?php echo $registration[0]->singleUrl; ?>">Acessar inscrição da fase</a>
                                    <?php }else{ ?>
                                        <a style="margin-bottom: 0.8rem" class="text-primary" href="<?php echo $phase->singleUrl; ?>">Acessar inscrição da fase</a>
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
    </div>
</article>

<script>
    function phaseStatus(id){
        let object = $(`#phases-${id}`);
        object.height($(`#sub-div-${id}`).outerHeight(true));
        if(object.css('display') == 'none'){
            object.css( "display", "block" );
        }else if(object.css('display') == 'block'){
            object.css( "display", "none" );
        }
        let div_name = $(`#button-${id}`);
        div_name[0].innerHTML = div_name[0].innerText == 'Exibir fases ' ? 'Esconder fases <i class="fa fa-angle-up"></i> ' : 'Exibir fases <i class="fa fa-angle-down"></i> '
        if(object.hasClass('animation-expanded')){
            object.removeClass('animation-expanded')
            object.height($(`#sub-div-${id}`).outerHeight(false));
        }else{
            object.addClass('animation-expanded')
            object.height($(`#sub-div-${id}`).outerHeight(true));
        }
    }   
</script>