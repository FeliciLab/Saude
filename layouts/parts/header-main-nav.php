<div class="main-nav-wrapper">
    <nav id="main-nav" class="clearfix">
        <ul class="menu entities-menu clearfix entties-menu-border">
            <?php if ($app->isEnabled('events')) : ?>
                <?php $this->applyTemplateHook('nav.main.events', 'before'); ?>
                <li id="entities-menu-event" ng-click="tabClick('event')">
                    <a class="a-color" href="<?php if ($this->controller->action !== 'search') echo $app->createUrl('site', 'search') . '##(global:(enabled:(event:!t),filterEntity:event))'; ?>">
                        <div class="fa fa-calendar-o fa-2x icon-event"></div>
                        <div class="menu-item-label"><?php $this->dict('entities: Events') ?></div>
                    </a>
                </li>
                <?php $this->applyTemplateHook('nav.main.events', 'after'); ?>
            <?php endif; ?>

            <?php if ($app->isEnabled('spaces')) : ?>
                <?php $this->applyTemplateHook('nav.main.spaces', 'before'); ?>
                <li id="entities-menu-space" ng-click="tabClick('space')">
                    <a class="a-color" href="<?php if ($this->controller->action !== 'search') echo $app->createUrl('site', 'search') . '##(global:(enabled:(space:!t),filterEntity:space))'; ?>">
                        <div class="fa fa-building fa-2x icon-space"></div>
                        <div class="menu-item-label"><?php $this->dict('entities: Spaces') ?></div>
                    </a>
                </li>
                <?php $this->applyTemplateHook('nav.main.spaces', 'after'); ?>
            <?php endif; ?>

            <?php if ($app->isEnabled('agents')) : ?>
                <?php $this->applyTemplateHook('nav.main.agents', 'before'); ?>
                <li id="entities-menu-agent" ng-click="tabClick('agent')">
                    <a class="a-color" href="<?php if ($this->controller->action !== 'search') echo $app->createUrl('site', 'search') . '##(global:(enabled:(agent:!t),filterEntity:agent))'; ?>">
                        <div class="fa fa-users fa-2x icon-agent"></div>
                        <div class="menu-item-label"><?php $this->dict('entities: Agents') ?></div>
                    </a>
                </li>
                <?php $this->applyTemplateHook('nav.main.agents', 'after'); ?>
            <?php endif; ?>

            <?php if ($app->isEnabled('projects')) : ?>
                <?php $this->applyTemplateHook('nav.main.projects', 'before'); ?>
                <li id="entities-menu-project" ng-click="tabClick('project')">
                    <a class="a-color" href="<?php if ($this->controller->action !== 'search') echo $app->createUrl('site', 'search') . '##(global:(enabled:(project:!t),filterEntity:project,viewMode:list),project:(filters:(\'@verified\':!t)))'; ?>">
                        <div class="fa fa-file-text fa-2x icon-project"></div>
                        <div class="menu-item-label"><?php \MapasCulturais\i::_e("Inscrições"); ?></div>
                    </a>
                </li>
                <?php $this->applyTemplateHook('nav.main.projects', 'after'); ?>
            <?php endif; ?>
            <ul style="display: none" class="menu header-login menu entities-menu clearfix entties-menu-border">
                <?php if ($app->auth->isUserAuthenticated()) : ?>
                    <?php $this->applyTemplateHook('nav.main.notifications', 'before'); ?>
                    <li class="notifications" ng-controller="NotificationController" style="display:none" ng-class="{'visible': data.length > 0}">
                        <a class="js-submenu-toggle" data-submenu-target="$(this).parent().find('.submenu')">
                            <div class="icon icon-notifications"></div>
                            <div class="menu-item-label"><?php \MapasCulturais\i::_e("Notificações"); ?></div>
                        </a>
                        <ul class="submenu hidden">
                            <li>
                                <div class="clearfix">
                                    <h6 class="alignleft"><?php \MapasCulturais\i::_e("Notificações"); ?></h6>
                                    <a href="#" style="display:none" class="staging-hidden hltip icon icon-check_alt" title="<?php \MapasCulturais\i::esc_attr_e("Marcar todas como lidas"); ?>"></a>
                                </div>
                                <ul>
                                    <li ng-repeat="notification in data" on-last-repeat="adjustScroll();">
                                        <p class="notification clearfix">
                                            <span ng-bind-html="notification.message"></span>
                                            <br>

                                            <a ng-if="notification.request.permissionTo.approve" class="btn btn-small btn-success" ng-click="approve(notification.id)"><?php \MapasCulturais\i::_e("aceitar"); ?></a>

                                            <span ng-if="notification.request.permissionTo.reject">
                                                <span ng-if="notification.request.requesterUser === MapasCulturais.userId">
                                                    <a class="btn btn-small btn-default" ng-click="reject(notification.id)"><?php \MapasCulturais\i::_e("cancelar"); ?></a>
                                                    <a class="btn btn-small btn-success" ng-click="delete(notification.id)"><?php \MapasCulturais\i::_e("ok"); ?></a>
                                                </span>
                                                <span ng-if="notification.request.requesterUser !== MapasCulturais.userId">
                                                    <a class="btn btn-small btn-danger" ng-click="reject(notification.id)"><?php \MapasCulturais\i::_e("rejeitar"); ?></a>
                                                </span>
                                            </span>

                                            <span ng-if="!notification.request">
                                                <a class="btn btn-small btn-success" ng-click="delete(notification.id)"><?php \MapasCulturais\i::_e("ok"); ?></a>
                                            </span>

                                        </p>
                                    </li>
                                </ul>
                                <a href="<?php echo $app->createUrl('panel'); ?>">
                                    <?php \MapasCulturais\i::_e("Ver todas atividades"); ?>
                                </a>
                            </li>
                        </ul>
                        <!--.submenu-->
                    </li>
                    <!--.notifications-->
                    <?php $this->applyTemplateHook('nav.main.notifications', 'after'); ?>

                    <?php $this->part('nav-main-user') ?>

                <?php else : ?>
                    <?php $this->applyTemplateHook('nav.main.login', 'before'); ?>
                    <li class="login menu-header-login">
                        <a class="a-color" ng-click="setRedirectUrl()" <?php echo $this->getLoginLinkAttributes() ?>>

                            <i class="fa fa-user-circle fa-2x" aria-hidden="true"></i>
                            <div class="menu-item-label"><?php \MapasCulturais\i::_e("Entrar"); ?></div>
                        </a>
                        <?php if (!empty($fake_options)) : ?>
                            <ul class="submenu" style="margin: 2px 0 0 -12px">
                                <li><?php echo str_ireplace("Login\n </a>", 'Login</a> |', $fake_options) ?></li>
                            </ul>
                        <?php endif; ?>
                    </li>
                    <!--.login-->
                    <?php $this->applyTemplateHook('nav.main.login', 'after'); ?>
                <?php endif; ?>
            </ul>
    </nav>
</div>