<div class="clearfix"></div>
<?php if (is_object($_evaluation_type) && property_exists($_evaluation_type, "id") && $_evaluation_type->id === "technical"): ?> 
    <a class="btn btn-warning" title="Atualiza o status do candidato com base na nota da oportunidade" ng-click="editStatusNote()">
        <i class="fa fa-refresh" aria-hidden="true"></i>  Atualizar status dos candidatos com base na nota mínima
    </a>
<?php endif; ?>
<a class="btn btn-success" title="Atualiza o status do candidato com base na nota da oportunidade" ng-click="setStatusToSelected()">
    <i class="fa fa-refresh" aria-hidden="true"></i>  Atualizar status dos candidatos para SELECIONADOS
</a>