<?php
$this->layout = 'panel';
$this->bodyProperties['ng-app'] = "professional.category";

?>
<?php $this->applyTemplateHook('content','before'); ?>
<div class="panel-main-content">
<?php $this->applyTemplateHook('content','begin'); ?>
   
    <div class="panel panel-default">
        <div class="panel-heading">Categoria Profissional</div>
        <div class="panel-body">
        <div ng-controller="professionalCategoryController">
            <div class="form-group">
                <label>Nome: </label> <span class="field-required">Obrigatório</span><br>
                <input type="text" ng-model="data.name" id="catPro" class="form-control" placeholder="Ex: Comunicação">
            </div>
            <div class="form-group">
                <button id="btn-taxonomy-form" ng-click="saveCatPro(data.name)" class="btn btn-primary"> 
                    <i class="fa fa-save"></i>
                    Cadastrar 
                </button>
                <a href="<?php echo $app->createUrl('panel') ?>" id="btn-taxonomy-form" class="btn btn-default alignright" title="<?php \MapasCulturais\i::_e('Voltar para o painel'); ?>" > 
                    <i class="fa fa-times-circle" aria-hidden="true"></i>
                    Voltar 
                </a>
            </div>

            <div class="form-group">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Categoria Profissional</th>
                        <th>Editar</th>
                        <th>Especialidade</th>
                        <th>Excluir</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="c in cat">
                        <td>
                            {{c.name}}
                            <input type="text" ng-model="c.name" class="form-control" id="input_{{c.id}}" style="display: none;">
                            <a href="#" class="btn btn-success" id="saveInput_{{c.id}}" data-cod="{{c.id}}" data-name="{{c.name}}" ng-click="alterCat($event)" style="display: none;">Salvar</a>
                            <button id="cancelarSave_{{c.id}}" class="btn-cancel-save" ng-click="cancelarSave(c.id)" style="display: none;"> Cancelar </button>
                        </td>
                        <td>
                            <a href="#" data-id="{{c.id}}" data-nome="{{c.nome}}" ng-click="editCatPro(c.id)" class="btn btn-default" title="Editar">
                                <i class="fa fa-edit"></i>
                            </a>
                        </td>
                        <td>
                            <a href="<?php echo $app->createUrl('categoria-profissional/especialidade'); ?>{{c.id}}" class="btn btn-primary" title="Cadastrar especialidade">
                                <i class="fa fa-save"></i>
                            </a>
                        </td>
                        <td>
                            <a href="#" ng-click="excluirCat(c.id)" class="btn btn-danger" title="Editar">
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
            </div>
        </div>
            
        </div>
    </div>
    
</div>
