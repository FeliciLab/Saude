<?php

  $entities = $this->controller->requestedEntity;

  $groups = $entities->getGroupRelationsAgent();

    if(is_array($groups) && count($groups) > 0): ?>
    
        <div class="widget">
            <h3><?php \MapasCulturais\i::_e("Unidades de saúde que participa e suas funções");?></h3>
            <ul class="js-slimScroll widget-list">
                <?php foreach ($groups as $group): ?>
                    
                    <li class="widget-list-item">
                        <?php 
                        
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
                    
                <?php endforeach; ?>
            </ul>    
        </div>
    
<?php endif; ?>

    