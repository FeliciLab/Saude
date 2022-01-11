<?php 
if($app->user->is('admin')){
    $nameHook = $data['nameHook'];
    $this->applyTemplateHook($nameHook,'begin'); ?>
        <div class="panel panel-primary" >
            <div class="panel-heading">
                <label style="color: #fff;">
                    <?php echo $data['titleTaxo']; ?>
                </label>
            </div>
            <div class="panel-body">
                <div>
                    <p class="registration-help">
                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                        <?php echo $data['descriptionTaxo']; ?>
                    </p>
                    <a class="btn btn-default" 
                    ng-click="SyncTaxo('<?php echo $data['taxonomy']; ?>', '<?php echo $data['entity']; ?>')">
                        <i class="fa fa-refresh" aria-hidden="true"></i>
                        Sincronizar Taxonomia
                    </a>
                </div>
            </div>
        </div>
    <?php $this->applyTemplateHook($nameHook,'end');
}
?>
    