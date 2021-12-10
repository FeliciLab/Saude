<?php
$this->enqueueScript(
    'app', // grupo de scripts
    'ng-module-applyTechnicalResult',  // nome do script
    'js/ng.module.applyTechnicalResult.js', // arquivo do script
    [] // dependências do script
);
$this->jsObject['angularAppDependencies'][] = 'module.applyTechnicalResult';

?>
<div ng-controller="ApplyTechnicalResultController">

    <div class="clearfix"></div>
    <?php if (is_object($_evaluation_type) && property_exists($_evaluation_type, "id") && $_evaluation_type->id === "technical"): ?> 
        <a class="btn btn-warning" title="Atualiza o status do candidato com base na nota da oportunidade" ng-click="updateStatusNote()">
            <i class="fa fa-refresh" aria-hidden="true"></i>  Atualizar status dos candidatos com base na nota mínima
        </a>
    <?php endif; ?>
    <a class="btn btn-success" title="Atualiza o status do candidato com base na nota da oportunidade" ng-click="setAllStatusToApproved()">
        <i class="fa fa-refresh" aria-hidden="true"></i>  Atualizar status dos candidatos para SELECIONADOS
    </a>
</div>