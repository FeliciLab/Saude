<?php 
    use Saude\Entities\Resources;
    use Saude\Utils\RegistrationStatus;
    $rec = Resources::getEnabledResource($phase->id, 'period');
    $registration = $app->repo('Registration')->findByOpportunityAndUser($phase, $app->user);
    $resources = count($registration) > 0 ? Resources::validateOnlyResource($registration[0]->id, $phase->id, $registration[0]->owner->id) : [];
?>

<div style="background-color: white; padding: 20px; padding-bottom: 0px; margin-bottom: 20px;">
    <p style="margin-bottom: 0.5rem"><?php echo $phase->name; ?></p>
    <div class="user-oportunity-details">
        <div>
            <small><strong>Inscrição da fase: <?php echo count($registration) == 0 ? 'Não inscrito' : $registration[0]->number ?></strong></small><br>
            <?php 
                if(count($registration) > 0 && $registration[0]->canUser('sendClaimMessage')){
                    if($resources == false && ($rec['open'] == 1 && $rec['close'] == 1)){  ?>
                        <a data-remodal-target="modal-recurso" class="btn btn-primary" onclick="showModalResource('<?php echo $registration[0]->id; ?>', '<?php echo $registration[0]->opportunity->id; ?>', '<?php echo $registration[0]->owner->id; ?>', '<?php echo $registration[0]->opportunity->name; ?>')">
                            <i class="fa fa-edit"></i> Abrir Recurso
                        </a>
                    <?php }else if($resources == true){
                        echo '<label class="text-info">Recurso enviado</label>';
                    }else if ($rec['open'] != 1 || $rec['close'] != 1){
                        echo '<label class="text-danger">Fora do período do recurso</label>';
                    }
                }
            ?>
        </div>
        <div style="margin-top: auto; margin-bottom: auto;">
            <a style="margin-bottom: 0.8rem" class="text-primary" href="<?php echo count($registration) > 0 ? $registration[0]->singleUrl : $phase->singleUrl; ?>">Acessar inscrição da fase</a>
        </div>
    </div>
</div>