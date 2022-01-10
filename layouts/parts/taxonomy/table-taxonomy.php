<div>
    <div class="alert info"  ng-if="totalTaxo > 0">
        <label>Mostrando um total de <strong>{{totalTaxo}}</strong> registro de <strong>{{data.nameTaxonomy}}</strong></label>
    </div>
    <table class="table table-bordered table-striped" id="" style="width: 100%;">
        <thead>
            <tr>
              <th>Nome</th>
              <th>Ação</th>
            </tr>
        </thead>
        <tbody>
        <tr ng-repeat="g in graus">
            <td  id="td_{{g.id}}">
                {{g.nome}}
                <input type="text" ng-model="g.nome" class="form-control" id="input_{{g.id}}" style="display: none;">
                <a href="#" class="btn btn-success" id="saveInput_{{g.id}}" data-cod="{{g.id}}" data-nome="{{g.nome}}" ng-click="alterTaxo($event, data.taxonomy)" style="display: none;">Salvar</a>
                <button id="cancelarSave_{{g.id}}" class="btn-cancel-save" ng-click="cancelarSave(g.id)" style="display: none;"> Cancelar </button>
            </td>
            <td>
                <button class="btn btn-default" data-id="{{g.id}}" data-nome="{{g.nome}}" ng-click="editarTaxo(g.id)">
                    <i class="fa fa-edit"></i> Editar
                </button>
                <a href="#" class="btn btn-danger" ng-click="excluirTaxo(g.id, data.taxonomy, g.nome)">
                    <i class="fa fa-trash"></i> Excluir
                </a>
            </td>
        </tr>
        </tbody>
    </table>

    <div>
       <a href="#" class="btn btn-default" ng-click="SyncTaxo()">Sincronizar Taxonomia</a>
    </div>
</div>