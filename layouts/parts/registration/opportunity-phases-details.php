<?php 
    use Saude\Entities\Resources;
    use Saude\Utils\RegistrationStatus;
    $rec = Resources::getEnabledResource($phase->id, 'period');
    $registration = null;
    if($next_phase != null){
        $registration = $app->repo('Registration')->find($next_phase);
        $resources = is_null($registration) ? Resources::validateOnlyResource($registration->id, $phase->id, $registration->owner->id) : null;
    }
?>

<div style="background-color: white; padding: 20px; padding-bottom: 0px; margin-bottom: 20px;">
    <p style="margin-bottom: 0.5rem"><?php echo $phase->name; ?></p>
    <div class="user-oportunity-details" style="display: flex;justify-content: space-between;">
        <div>
            <small><strong>Inscrição da fase: <?php echo is_null($registration) ? 'Não inscrito' : $registration->number ?></strong></small><br>
            <?php 
                if(!is_null($registration) && $registration->canUser('sendClaimMessage')){
                    if($resources == false && ($rec['open'] == 1 && $rec['close'] == 1)){  ?>
                        <a data-remodal-target="modal-recurso" class="btn btn-primary" onclick="showModalResource('<?php echo $registration->id; ?>', '<?php echo $registration->opportunity->id; ?>', '<?php echo $registration->owner->id; ?>', '<?php echo $registration->opportunity->name; ?>')">
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
            <a style="margin-bottom: 0.8rem;" class="btn btn-primary" href="<?php echo !is_null($registration) ? $registration->singleUrl : $phase->singleUrl; ?>">Acessar inscrição da fase</a>
        </div>
    </div>
</div>