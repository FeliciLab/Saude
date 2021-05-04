<?php
$this->layout = 'panel';
?>
<?php $this->applyTemplateHook('content','before'); ?>
<div class="panel-main-content">
<?php $this->applyTemplateHook('content','begin'); ?>
   
    <div class="panel panel-default">
        <div class="panel-heading">Categoria Profissional</div>
        <div class="panel-body">
            <div class="form-group">
                <label>Nome: </label> <span class="required_form">Obrigatório</span><br>
                <input type="text" ng-model="" id="catPro" class="form-control" placeholder="Ex: Comunicação">
            </div>
            <div class="form-group">
                <button id="btn-taxonomy-form" ng-click="saveTaxo(data)" class="btn btn-primary"> 
                    <i class="fa fa-save"></i>
                    Cadastrar 
                </button>
                <a href="<?php echo $app->createUrl('panel') ?>" id="btn-taxonomy-form" class="btn btn-default alignright" title="<?php \MapasCulturais\i::_e('Voltar para o painel'); ?>" > 
                    <i class="fa fa-times-circle" aria-hidden="true"></i>
                    Voltar 
                </a>
            </div>
        </div>
    </div>
    
</div>
