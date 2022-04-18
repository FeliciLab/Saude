<?php

use MapasCulturais\Entities\Registration;

use Saude\Utils\RegistrationStatus;

$app = MapasCulturais\App::i();

$url = $registration->status == Registration::STATUS_DRAFT ? $registration->editUrl : $registration->singleUrl;
$proj = $registration->opportunity;
$styleDestaque = "";

if (isset($_GET['id']) && $_GET['id'] == $registration->id) {
    $styleDestaque = "border:2px solid green;border-radius: 5px;";
}

?>

<article class="objeto clearfix" style="<?php echo $styleDestaque; ?>" id="<?php echo $registration->id; ?>" name="<?php echo $registration->id; ?>">
    <?php if ($avatar = $proj->avatar) : ?>
        <div class="thumb">
            <img src="<?php echo $avatar->transform('avatarSmall')->url ?>">
        </div>
    <?php endif; ?>
    <h1 style="margin-top: 5px;"><?php echo $proj->name ?></h1>
    <div style="display: flex; justify-content: space-between;">
        <small>
            <strong>Inscrição:</strong> <?php echo $registration->number; ?>
        </small>
        <div style="display:flex;">
        
            <?php $this->applyTemplateHook('pdf-registrations-edit', 'before', ['registration' =>  $registration]); ?>
            <?php 
                if($registration->status == Registration::STATUS_DRAFT){ ?>
                    <a style="margin-right:5px;" href="<?php echo $url; ?>" class="btn btn-success">Editar Inscrição</a>
                <?php }
            ?>
            <a href="<?php echo $url; ?>" class="btn btn-primary">Acessar inscrição</a>
        </div>
    </div> 
    <br>
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