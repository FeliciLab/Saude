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
            <small><strong>Inscrição da fase: <?php echo count($registration) == 0 ? 'Não inscrito' : $registration[0]->number ?></strong></small>
            <?php echo count($registration) > 0 ? '<small><strong>Status:</strong>'. RegistrationStatus::getStatusNameById($registration[0]->status) .'</small><br>' : '';?>
            <?php 
                if(count($registration) > 0 && $registration[0]->canUser('sendClaimMessage')){
                    if($resources == false && ($rec['open'] == 1 && $rec['close'] == 1)){
                        echo '<a data-remodal-target="modal-recurso" class="btn btn-primary" onclick="showModalResource('.$registration[0]->id.', '.$registration[0]->opportunity->id.','.$registration[0]->opportunity->id.', '.$registration[0]->opportunity->id.')">
                                    <i class="fa fa-edit"></i> Abrir Recurso
                                </a>';
                    }else if($resources == true){
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