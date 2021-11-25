<form id="taxonomiaForm">
    <div>
    <ul class="nav nav-taxo">
    <?php foreach ($taxo as $key => $value) { ?>
        <li role="presentation">
            <a href="#" class="item-taxo" ng-click="chamaTabela('<?php echo $key; ?>','<?php echo $value; ?>')"  id="btn-taxo_<?php echo $key; ?>">
                <?php echo $value; ?>
            </a>
        </li>
            <input type="hidden" ng-model="data.taxonomy" value="<?php echo $key; ?>">  
    <?php } ?> <span class="field-required">Obrigatório escolher uma taxonomia</span><br>
    </ul>
    <br>
    </div>
    <div class="clearfix">
    <hr>
        <div class="form-group">
            <label>Nome: </label> <span class="field-required">Obrigatório</span><br>
            <input type="text" ng-model="data.termName" id="term" class="form-control" placeholder="Taxomonias Escrita">
        </div>
    </div>
    <div class="form-group">
        <!-- <label for="">Descrição: </label>
        <input type="text" name="description"  ng-model="data.termDescription" class="form-control" placeholder="Descrição do termo da taxonomia"> -->
        <button id="btn-taxonomy-form" ng-click="saveTaxo(data)" class="btn btn-primary"> 
            <i class="fa fa-save"></i>
            Cadastrar 
        </button>
        <a href="<?php echo $app->createUrl('panel') ?>" id="btn-taxonomy-form" class="btn btn-default alignright" title="<?php \MapasCulturais\i::_e('Voltar para o painel'); ?>" > 
            <i class="fa fa-times-circle" aria-hidden="true"></i>
            Voltar 
        </a>
    </div>
</form>