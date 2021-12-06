<?php 
use MapasCulturais\i;

$app = MapasCulturais\App::i();
?>
<section class="clearfix">
    <h2><?php i::_e('Conta'); ?></h2>
    <div class="panel-body">
        <section class="clearfix menu-stats">
            <?php if($app->auth instanceof MapasCulturais\AuthProviders\OpauthKeyCloak): ?>
            <div>
                <div class="clearfix">
                    <a href="<?=$app->auth->changePasswordUrl?>" target="_blank" class="btn btn-secound" title="<?php i::_e('Trocar Senha'); ?>">
                        <i class="fa fa-lock alignleft icon-fa" aria-hidden="true"></i>
                        <?php i::_e('Trocar Senha'); ?></a>
                </div>
            </div>
            <?php endif; ?>
            <div>
                <div class="clearfix">
                    <a href="<?php echo $app->createUrl('panel', 'deleteAccount') ?>" class="btn btn-danger" title="<?php i::_e('Apagar Conta'); ?>">
                        <i class="fa fa-trash alignleft icon-fa" aria-hidden="true"></i>
                        <?php i::_e('Apagar Conta'); ?></a>
                </div>
            </div>
        </section>
    </div>

</section>