<?php 
    use Saude\Entities\Resources;

    $resources = Resources::validateOnlyResource($registration->id, $registration->opportunity->id, $registration->owner->id);
    $rec = Resources::getEnabledResource($registration->opportunity->id, 'period');
    
    $phases = $app->repo('Opportunity')->findBy([
        'parent' => $registration->opportunity,
        'status' => $registration->opportunity->canUser('@control') ? [0,-1] : -1 
    ],['createTimestamp' => 'ASC', 'id' => 'ASC']);

    $phases = array_filter($phases, function($item) {
        if($item->isOpportunityPhase){
            return $item;
        }
    });

    if($registration->canUser('sendClaimMessage')){
        if($resources == false && ($rec['open'] == 1 && $rec['close'] == 1)){ ?>
            <div style="justify-content: space-between;display: flex;">
                <a data-remodal-target="modal-recurso" class="btn btn-primary" onclick="showModalResource('<?php echo $registration->id; ?>', '<?php echo $registration->opportunity->id; ?>', '<?php echo $registration->owner->id; ?>', '<?php echo $registration->opportunity->name; ?>')">
                    <i class="fa fa-edit"></i> Abrir Recurso
                </a>
                <label id="button-<?php echo $registration->id; ?>" style="color: green; cursor: pointer" onclick="phaseStatus('<?php echo $registration->id; ?>')" >Exibir fases <i class="fa fa-angle-down"></i> </label>
            </div>
        <?php }else if($resources == true){
            echo '<div style="justify-content: space-between;display: flex;">
                    <label class="text-info">Recurso enviado</label>
                    <label id="button-'. $registration->id .'" style="color: green; cursor: pointer" onclick="phaseStatus('. $registration->id .')" >Exibir fases <i class="fa fa-angle-down"></i> </label>
                </div>';
        }else if ($rec['open'] != 1 || $rec['close'] != 1){
            echo '<div style="justify-content: space-between;display: flex;">
                    <label class="text-danger">Fora do período do recurso</label>
                    <label id="button-'. $registration->id .'" style="color: green; cursor: pointer" onclick="phaseStatus('. $registration->id .')" >Exibir fases <i class="fa fa-angle-down"></i> </label>
                </div>';
        }else{
            echo '<div style="text-align: right;">
                    <label id="button-'. $registration->id .'" style="color: green; cursor: pointer" onclick="phaseStatus('. $registration->id .')" >Exibir fases <i class="fa fa-angle-down"></i> </label>
                </div>';
        }
    }else{
        echo '<div style="text-align: right;">
            <label id="button-'. $registration->id .'" style="color: green; cursor: pointer" onclick="phaseStatus('. $registration->id .')" >Exibir fases <i class="fa fa-angle-down"></i> </label>
        </div>';
    }
?>
<div style="margin-top: 20px; display: none" id="phases-<?php echo $registration->id; ?>" class="wrapper-show">
    <div id="sub-div-<?php echo $registration->id; ?>">
        <h4>Fases</h4>
        <?php 
            foreach($phases as $phase){
                $this->part('registration/opportunity-phases-details.php', 
                    ['phase' => $phase, 'next_phase' => $registration->nextPhaseRegistrationId]
                );
            }
            if(!$phases){ ?>
                <div class="alert info"><?php \MapasCulturais\i::_e("Esta oportunidade não possui fases.");?></div>
            <?php }
        ?>
    </div>
</div>