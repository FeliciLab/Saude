<nav id="about-nav" class="alignright clearfix about-user-logo">
    <ul class="menu header-login">
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
                <a ng-click="setRedirectUrl()" <?php echo $this->getLoginLinkAttributes() ?>>

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
    <h1 id="organization-logo"
    class="menu-logo-esp"><a href="https://www.esp.ce.gov.br/" target="_blank"><img src="<?php $this->asset('img/logo-prefeitura.png'); ?>" /></a></h1>
    <ul id="secondary-menu">
        <li><a class="icon icon-about hltip" href="<?php echo $app->createUrl('site', 'page', array('sobre')) ?>" title="Sobre o Mapa da Saúde"></a></li> <br>
        <li><a class="icon icon-help hltip" href="<?php echo $app->createUrl('site', 'page', array('como-usar')) ?>" title="Como usar"></a></li>
    </ul>
</nav>