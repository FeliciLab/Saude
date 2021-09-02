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

<nav id="main-nav" class="clearfix">
    <ul class="menu entities-menu clearfix">
        <?php if($app->isEnabled('events')): ?>
            <?php $this->applyTemplateHook('nav.main.events','before'); ?>
            <li id="entities-menu-event"
                ng-click="tabClick('event')">
                <a href="<?php if ($this->controller->action !== 'search') echo $app->createUrl('site', 'search') . '##(global:(enabled:(event:!t),filterEntity:event))'; ?>">
                    <i class="fa fa-calendar-o" aria-hidden="true"></i>
                    <div class="menu-item-label"><?php \MapasCulturais\i::_e("Eventos");?></div>
                </a>
            </li>
            <?php $this->applyTemplateHook('nav.main.events','after'); ?>
        <?php endif; ?>

        <?php if($app->isEnabled('spaces')): ?>
            <?php $this->applyTemplateHook('nav.main.spaces','before'); ?>
            <li id="entities-menu-space"
                ng-click="tabClick('space')">
                <a href="<?php if ($this->controller->action !== 'search') echo $app->createUrl('site', 'search') . '##(global:(enabled:(space:!t),filterEntity:space))'; ?>">
                    <i class="fa fa-building" aria-hidden="true"></i>
                    <div class="menu-item-label"><?php \MapasCulturais\i::_e("Unidades");?></div>
                </a>
            </li>
            <?php $this->applyTemplateHook('nav.main.spaces','after'); ?>
        <?php endif; ?>

        <?php if($app->isEnabled('agents')): ?>
            <?php $this->applyTemplateHook('nav.main.agents','before'); ?>
            <li id="entities-menu-agent"
                ng-click="tabClick('agent')">
                <a href="<?php if ($this->controller->action !== 'search') echo $app->createUrl('site', 'search') . '##(global:(enabled:(agent:!t),filterEntity:agent))'; ?>">
                    <i class="fa fa-users" aria-hidden="true"></i>
                    <div class="menu-item-label"><?php \MapasCulturais\i::_e("Pessoas");?></div>
                </a>
            </li>
            <?php $this->applyTemplateHook('nav.main.agents','after'); ?>
        <?php endif; ?>

        <?php if($app->isEnabled('projects')): ?>
            <?php $this->applyTemplateHook('nav.main.projects','before'); ?>
            <li id="entities-menu-project"
                ng-click="tabClick('project')">
<<<<<<< HEAD
                <a href="<?php if ($this->controller->action !== 'search') echo $app->createUrl('site', 'search') . '##(global:(enabled:(project:!t),filterEntity:project,viewMode:list))'; ?>">
                    <i class="fa fa-file" aria-hidden="true"></i>
=======
                <a href="<?php if ($this->controller->action !== 'search') echo $app->createUrl('site', 'search') . '##(global:(enabled:(project:!t),filterEntity:project,viewMode:list),project:(filters:(\'@verified\':!t)))'; ?>">
                    <div class="icon icon-project"></div>
>>>>>>> 74dc4c40f8644a68d5c33531bf509fe5d28f3b22
                    <div class="menu-item-label"><?php \MapasCulturais\i::_e("Inscrições");?></div>
                </a>
            </li>
            <?php $this->applyTemplateHook('nav.main.projects','after'); ?>
        <?php endif; ?>
<<<<<<< HEAD
=======
    </ul>
>>>>>>> 74dc4c40f8644a68d5c33531bf509fe5d28f3b22
    <!--.menu.entities-menu-->
    <ul class="menu session-menu clearfix">
        <?php if ($app->auth->isUserAuthenticated()): ?>
            <?php $this->applyTemplateHook('nav.main.notifications','before'); ?>
            <li class="notifications" ng-controller="NotificationController" style="display:none" ng-class="{'visible': data.length > 0}">
                <a class="js-submenu-toggle" data-submenu-target="$(this).parent().find('.submenu')">
                    <div class="icon icon-notifications"></div>
                    <div class="menu-item-label"><?php \MapasCulturais\i::_e("Notificações");?></div>
                </a>
                <ul class="submenu hidden">
                    <li>
                        <div class="clearfix">
                            <h6 class="alignleft"><?php \MapasCulturais\i::_e("Notificações");?></h6>
                            <a href="#" style="display:none" class="staging-hidden hltip icon icon-check_alt" title="<?php \MapasCulturais\i::esc_attr_e("Marcar todas como lidas");?>"></a>
                        </div>
                        <ul>
                            <li ng-repeat="notification in data" on-last-repeat="adjustScroll();">
                                <p class="notification clearfix">
                                    <span ng-bind-html="notification.message"></span>
                                    <br>

                                    <a ng-if="notification.request.permissionTo.approve" class="btn btn-small btn-success" ng-click="approve(notification.id)"><?php \MapasCulturais\i::_e("aceitar");?></a>

                                    <span ng-if="notification.request.permissionTo.reject">
                                        <span ng-if="notification.request.requesterUser === MapasCulturais.userId">
                                            <a class="btn btn-small btn-default" ng-click="reject(notification.id)"><?php \MapasCulturais\i::_e("cancelar");?></a>
                                            <a class="btn btn-small btn-success" ng-click="delete(notification.id)"><?php \MapasCulturais\i::_e("ok");?></a>
                                        </span>
                                        <span ng-if="notification.request.requesterUser !== MapasCulturais.userId">
                                            <a class="btn btn-small btn-danger" ng-click="reject(notification.id)"><?php \MapasCulturais\i::_e("rejeitar");?></a>
                                        </span>
                                    </span>

                                    <span ng-if="!notification.request">
                                        <a class="btn btn-small btn-success" ng-click="delete(notification.id)"><?php \MapasCulturais\i::_e("ok");?></a>
                                    </span>

                                </p>
                            </li>
                        </ul>
                        <a href="<?php echo $app->createUrl('panel'); ?>">
                            <?php \MapasCulturais\i::_e("Ver todas atividades");?>
                        </a>
                    </li>
                </ul>
                <!--.submenu-->
            </li>
            <!--.notifications-->
            <?php $this->applyTemplateHook('nav.main.notifications','after'); ?>

            <?php $this->part('nav-main-user') ?>

        <?php else: ?>
            <?php $this->applyTemplateHook('nav.main.login','before'); ?>
            <li class="login">
                <a ng-click="setRedirectUrl()" <?php echo $this->getLoginLinkAttributes() ?> >

                    <i class="fa fa-user-circle" aria-hidden="true"></i>
                    <div class="menu-item-label"><?php \MapasCulturais\i::_e("Entrar");?></div>
                </a>
                <?php if(!empty($fake_options)): ?>
                    <ul class="submenu" style="margin: 4px 0 0 -15px"><li><?php echo str_ireplace("Login\n</a>",'Login</a>|', $fake_options) ?></li></ul>
                <?php endif; ?>
            </li>
            <!--.login-->
            <?php $this->applyTemplateHook('nav.main.login','after'); ?>
        <?php endif; ?>
    </ul>
    <!--.menu.session-menu-->
</nav>