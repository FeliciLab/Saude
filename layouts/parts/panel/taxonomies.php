<?php
use MapasCulturais\i;
?>
<section id="taxonomies-panel" class="clearfix">
    <h2><?php i::_e('Menu Taxonomia'); ?></h2>
    <div class="panel-body">
        <section id="" class="clearfix menu-stats">
            <div>
                <div class="clearfix">
                    <a href="<?php echo $app->createUrl('taxonomias', 'info') ?>" class="btn btn-secound" title="<?php i::_e('Taxonomia de agente'); ?>">
                        <i class="fa fa-user alignleft icon-fa" aria-hidden="true"></i>
                        <?php i::_e('Agente'); ?></a>
                </div>
            </div>
            <!-- spaces -->
            <div>
                <div class="clearfix">
                    <a href="<?php echo $app->createUrl('taxonomias', 'spaces') ?>" class="btn btn-secound" title="<?php i::_e('Taxonomia de espaço'); ?>">
                        <i class="fa fa-map-marker alignleft icon-fa" aria-hidden="true"></i>
                        <?php i::_e('Espaco'); ?></a>
                </div>
            </div>
            <!-- Project -->
            <div>
                <div class="clearfix">
                    <a href="<?php echo $app->createUrl('taxonomias', 'projects') ?>" class="btn btn-secound" title="<?php i::_e('Taxonomia de projeto'); ?>">
                        <i class="fa fa-th-list alignleft icon-fa" aria-hidden="true"></i>
                        <?php i::_e('Projeto'); ?></a>
                </div>
            </div>
            <!-- Oportunidades -->
            <div>
                <div class="clearfix">
                    <a href="<?php echo $app->createUrl('taxonomias', 'opportunity') ?>" class="btn btn-secound" title="<?php i::_e('Taxonomia da oportunidade'); ?>">
                        <i class="fa fa-pencil-square alignleft icon-fa" aria-hidden="true"></i>
                        <?php i::_e('Oportunidade'); ?></a>
                </div>
            </div>
            <!-- Àrea101 -->
            <div>
                <div class="clearfix">
                    <a href="<?php echo $app->createUrl('taxonomias', 'area') ?>" class="btn btn-secound" title="<?php i::_e('Taxonomia da área'); ?>">
                        <i class="fa fa-area-chart alignleft icon-fa" aria-hidden="true"></i>
                        <?php i::_e('Área'); ?></a>
                </div>
            </div>
        </section>
    </div>
</section>