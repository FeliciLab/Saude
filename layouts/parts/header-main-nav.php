<?php if($app->getConfig('auth.provider') === 'Fake' && $app->user->id !== 1): ob_start(); ?>
    <style>
        span.fake-dummy{
            white-space:nowrap; padding: 0.5rem 0 0 0.5rem; cursor:default;
        }
        span.fake-dummy a{
            display:inline !important; font-weight:bold !important; vertical-align: baseline !important;
        }
    </style>
    <span class="fake-dummy">
        Admin:
        <a onclick="jQuery.get('<?php echo $app->createUrl('auth', 'fakeLogin') ?>/?fake_authentication_user_id=1',
            function(){
                console.info(<?php \MapasCulturais\i::_e('Logado como Admin');?>);
                MapasCulturais.Messages.success(<?php \MapasCulturais\i::_e('Logado como Admin.');?>);
            })">
            Login
        </a>
        <a onclick="jQuery.get('<?php echo $app->createUrl('auth', 'fakeLogin') ?>/?fake_authentication_user_id=1',
            function(){ location.reload();})">
            Reload
        </a>
    </span>
<?php $fake_options = ob_get_clean(); endif; ?>
<div class="main-nav-wrapper">
<nav id="main-nav" class="clearfix">
    <ul class="menu entities-menu clearfix entties-menu-border">
        <?php if($app->isEnabled('events')): ?>
            <?php $this->applyTemplateHook('nav.main.events','before'); ?>
            <li id="entities-menu-event"
                ng-click="tabClick('event')">
                <a class="a-color" href="<?php if ($this->controller->action !== 'search') echo $app->createUrl('site', 'search') . '##(global:(enabled:(event:!t),filterEntity:event))'; ?>">
                    <div class="fa fa-calendar-o fa-2x icon-event"></div>
                    <div class="menu-item-label"><?php $this->dict('entities: Events') ?></div>
                </a>
            </li>
            <?php $this->applyTemplateHook('nav.main.events','after'); ?>
        <?php endif; ?>

        <?php if($app->isEnabled('spaces')): ?>
            <?php $this->applyTemplateHook('nav.main.spaces','before'); ?>
            <li id="entities-menu-space"
                ng-click="tabClick('space')">
                <a class="a-color" href="<?php if ($this->controller->action !== 'search') echo $app->createUrl('site', 'search') . '##(global:(enabled:(space:!t),filterEntity:space))'; ?>">
                    <div class="fa fa-building fa-2x icon-space"></div>
                    <div class="menu-item-label"><?php $this->dict('entities: Spaces') ?></div>
                </a>
            </li>
            <?php $this->applyTemplateHook('nav.main.spaces','after'); ?>
        <?php endif; ?>

        <?php if($app->isEnabled('agents')): ?>
            <?php $this->applyTemplateHook('nav.main.agents','before'); ?>
            <li id="entities-menu-agent"
                ng-click="tabClick('agent')">
                <a class="a-color" href="<?php if ($this->controller->action !== 'search') echo $app->createUrl('site', 'search') . '##(global:(enabled:(agent:!t),filterEntity:agent))'; ?>">
                    <div class="fa fa-users fa-2x icon-agent"></div>
                    <div class="menu-item-label"><?php $this->dict('entities: Agents') ?></div>
                </a>
            </li>
            <?php $this->applyTemplateHook('nav.main.agents','after'); ?>
        <?php endif; ?>

        <?php if($app->isEnabled('projects')): ?>
            <?php $this->applyTemplateHook('nav.main.projects','before'); ?>
            <li id="entities-menu-project"
                ng-click="tabClick('project')">
                <a class="a-color" href="<?php if ($this->controller->action !== 'search') echo $app->createUrl('site', 'search') . '##(global:(enabled:(project:!t),filterEntity:project,viewMode:list),project:(filters:(\'@verified\':!t)))'; ?>">
                    <div class="fa fa-file-text fa-2x icon-project"></div>
                    <div class="menu-item-label"><?php \MapasCulturais\i::_e("Inscrições");?></div>
                </a>
            </li>
            <?php $this->applyTemplateHook('nav.main.projects','after'); ?>
        <?php endif; ?>
        <!--Criação de mais um item de menu-->
        <li id="entities-menu-indicadores">
                <a class="a-color" href="<?php echo $app->createUrl('indicadores')  ?>">
                <span class="div-icon">
                    <div class="fa fa-bar-chart fa-2x icon-indicadores"></div>
                    <div class="menu-item-label"><?php \MapasCulturais\i::_e("Indicadores");?></div>
                </span>
                </a>
            </li>
</nav>
</div>