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
                    <label for="">Nome da Especialidade</label>
                    <input type="text" class="form-control" id="" placeholder="Ex: Bioquímica">
                    <button type="submit" class="btn btn-default">
                        Cadastrar <i class="fa fa-save"></i>
                    </button>
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
                        <tr>
                            
                            <td>Mark Auditoria Auditoria</td>
                            <td>
                                <a class="btn btn-default" href="#" role="button">Link</a>
                            </td>
                            <td>
                                <a class="btn btn-danger" href="#" role="button">Link</a>
                            </td>
                        </tr>
                        <tr>
                            <td>Jacob Auditoria</td>
                            <td>
                                <a class="btn btn-default" href="#" role="button">Link</a>
                            </td>
                            <td>
                                <a class="btn btn-danger" href="#" role="button">Link</a>
                            </td>
                        </tr>
                        <tr>
                            <td>Larry Auditoria</td>
                            <td>
                                <a class="btn btn-default" href="#" role="button">Link</a>
                            </td>
                            <td>
                                <a class="btn btn-danger" href="#" role="button">Link</a>
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