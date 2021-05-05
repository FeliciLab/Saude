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
                <label>Nome: </label> <span class="required_form">Obrigatório</span><br>
                <input type="text" ng-model="data.name" id="catPro" class="form-control" placeholder="Ex: Comunicação">
                <span>{{data.name}}</span>
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
                        <th>Excluir</th>
                    </tr>
                </thead>
                <tbody>
                    <tr  ng-repeat="g in graus">
                        <td>{{g.name}}</td>
                        <td>
                            <a href="#" class="btn btn-primary" title="Editar">
                                <i class="fa fa-edit"></i>
                            </a>
                        </td>
                        <td>
                            <a href="#" class="btn btn-danger" title="Editar">
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
