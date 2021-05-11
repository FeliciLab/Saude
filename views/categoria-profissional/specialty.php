<?php
$this->layout = 'panel';
$this->bodyProperties['ng-app'] = "category.meta";

?>
<?php $this->applyTemplateHook('content','before'); ?>
<div class="panel-main-content">
<?php $this->applyTemplateHook('content','begin'); ?>
    <div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title"> Especialidade Profissional</h3>
    </div>
        <div class="panel-body" ng-controller="CategoryMetaController">
            <div>
                <label>Nome da categoria profissional: 
                    <strong><?php echo $cat->name; ?></strong>
                </label>
                <p>
                    <a href="<?php echo $app->createUrl('categoria-profissional'); ?>" class="btn btn-default">Trocar categoria</a>
                </p>
            </div>
            <div>
                <div class="form-group">
                    <form id="createSpecialtyProfessional">
                        <label for="">Nome da Especialidade</label>
                        <input type="text" name="nameSpecialty" class="form-control" id="nameSpecialty" placeholder="Ex: Bioquímica" ng-model="data.name">
                        <input type="hidden" name="idProfessional" id="idProfessional" value="<?php echo $cat->id; ?>">
                        <input type="hidden" name="nameProfessional" value="especialidade">
                        <button type="button" ng-click="saveCatMeta()" class="btn btn-primary">
                            Cadastrar <i class="fa fa-save"></i>
                        </button>
                    </form>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Editar</th>
                            <th>Excluir</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="c in catPro">
                            
                            <td>{{c.value}}
                                <input type="text" ng-model="c.value" class="form-control" id="input_{{c.id}}" style="display: none;">
                                <a href="#" class="btn btn-success" id="saveInput_{{c.id}}" data-cod="{{c.id}}" data-name="{{c.value}}" ng-click="alterCatMeta($event)" style="display: none;">Salvar</a>
                                <button id="cancelarSave_{{c.id}}" class="btn-cancel-save" ng-click="cancelarSave(c.id)" style="display: none;"> Cancelar </button>
                            </td>
                            <td>
                                <a href="#" data-id="{{c.id}}" data-nome="{{c.nome}}" ng-click="editCatMeta(c.id)" class="btn btn-default" title="Editar">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                            <td>
                                <a href="#" ng-click="excluirCatMeta(c.id)" class="btn btn-danger" title="Excluir">
                                <i class="fa fa-trash"></i>
                            </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php $this->applyTemplateHook('content','end'); ?>
</div>
<?php $this->applyTemplateHook('content','after'); ?>