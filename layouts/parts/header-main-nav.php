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
                <a href="<?php if ($this->controller->action !== 'search') echo $app->createUrl('site', 'search') . '##(global:(enabled:(event:!t),filterEntity:event))'; ?>">
                    <i class="fa fa-calendar-o fa-2x" aria-hidden="true"></i>
                    <div class="menu-item-label"><?php $this->dict('entities: Events') ?></div>
                </a>
            </li>
            <?php $this->applyTemplateHook('nav.main.events','after'); ?>
        <?php endif; ?>

        <?php if($app->isEnabled('spaces')): ?>
            <?php $this->applyTemplateHook('nav.main.spaces','before'); ?>
            <li id="entities-menu-space"
                ng-click="tabClick('space')">
                <a href="<?php if ($this->controller->action !== 'search') echo $app->createUrl('site', 'search') . '##(global:(enabled:(space:!t),filterEntity:space))'; ?>">
                    <i class="fa fa-building fa-2x" aria-hidden="true"></i>
                    <div class="menu-item-label"><?php $this->dict('entities: Spaces') ?></div>
                </a>
            </li>
            <?php $this->applyTemplateHook('nav.main.spaces','after'); ?>
        <?php endif; ?>

        <?php if($app->isEnabled('agents')): ?>
            <?php $this->applyTemplateHook('nav.main.agents','before'); ?>
            <li id="entities-menu-agent"
                ng-click="tabClick('agent')">
                <a href="<?php if ($this->controller->action !== 'search') echo $app->createUrl('site', 'search') . '##(global:(enabled:(agent:!t),filterEntity:agent))'; ?>">
                    <i class="fa fa-users fa-2x" aria-hidden="true"></i>
                    <div class="menu-item-label"><?php $this->dict('entities: Agents') ?></div>
                </a>
            </li>
            <?php $this->applyTemplateHook('nav.main.agents','after'); ?>
        <?php endif; ?>

        <?php if($app->isEnabled('projects')): ?>
            <?php $this->applyTemplateHook('nav.main.projects','before'); ?>
            <li id="entities-menu-project"
                ng-click="tabClick('project')">
                <a href="<?php if ($this->controller->action !== 'search') echo $app->createUrl('site', 'search') . '##(global:(enabled:(project:!t),filterEntity:project,viewMode:list))'; ?>">
                    <i class="fa fa-file-text fa-2x" aria-hidden="true"></i>
                    <div class="menu-item-label"><?php \MapasCulturais\i::_e("Inscrições");?></div>
                </a>
            </li>
            <?php $this->applyTemplateHook('nav.main.projects','after'); ?>
        <?php endif; ?>
</nav>
</div>