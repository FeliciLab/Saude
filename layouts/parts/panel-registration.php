<?php

use MapasCulturais\Entities\Registration;

use Saude\Utils\RegistrationStatus;

$app = MapasCulturais\App::i();

$url = $registration->status == Registration::STATUS_DRAFT ? $registration->editUrl : $registration->singleUrl;
$proj = $registration->opportunity;
$classeDestaque = "";

if (isset($_GET['id']) && $_GET['id'] == $registration->id) {
    $classeDestaque = "classeDestaque";
}

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
    <?php $this->part('registration/phases-and-resources.php', 
        ['registration' => $registration]
    ); ?>
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