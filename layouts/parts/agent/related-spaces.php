<?php

  $entities = $this->controller->requestedEntity;

  $groups = $entities->getGroupRelationsAgent();

    if(is_array($groups) && count($groups) > 0): ?>
    <?php $this->applyTemplateHook('related-spaces','before'); ?>
    <div id="related-spaces" class="aba-content">
        <?php $this->applyTemplateHook('related-spaces','begin'); ?>
        <div class="widget">
            <h3><?php \MapasCulturais\i::_e("Unidades de saúde que participa e suas funções");?></h3>
            <ul class="js-slimScroll widget-list">
                <?php foreach ($groups as $group): 
                //CONFERINDO SE É UM OBJETO DO TIPO ESPAÇO
                    if( $group['object_type'] instanceof \MapasCulturais\Entities\Space ) {
                    echo '<li class="widget-list-item">';
                        if($group['group'] == 'group-admin'){
                            \MapasCulturais\i::_e("Admininstrador(a)");
                        }else{
                            echo $group['group'];
                        }
                        \MapasCulturais\i::_e(" em");
                        ?> 
                        <a href="<?php echo $group['url']; ?>" style="display: initial; color: #4963ad;">
                            <?php echo $group['entitie']; ?>
                        </a>
                    </li>
                <?php } ?>
               <?php endforeach; ?>
                
            </ul>    
        </div>
        <?php $this->applyTemplateHook('related-spaces','end'); ?>
    </div>
    <?php $this->applyTemplateHook('related-spaces','after'); ?>
<?php endif; ?>

    