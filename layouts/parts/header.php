<?php
$site_name = $this->dict('site: name', false);
$title = isset($entity) ? $this->getTitle($entity) : $this->getTitle();
?>
<!DOCTYPE html>
<html lang="<?php echo $app->getCurrentLCode(); ?>" dir="ltr">
    <head>
        <meta charset="UTF-8" />
        <title><?php echo $title == $site_name ? $title : "{$site_name} - {$title}"; ?></title>
        <link rel="profile" href="http://gmpg.org/xfn/11" />
        <link rel="shortcut icon" href="<?php $this->asset('img/favicon.ico') ?>" />
        <?php $this->head(isset($entity) ? $entity : null); ?>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" media="all" rel="stylesheet" type="text/css">
        <!--[if lt IE 9]>
        <script src="<?php $this->asset('js/html5.js'); ?>" type="text/javascript"></script>
        <![endif]-->

        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-PMH98YHPTC"></script>
        <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-PMH98YHPTC');
        </script>
    </head>

    <body <?php $this->bodyProperties() ?> >
        <div id="blockdiv" style="background-color: rgba(0,0,0,0.6);width: 100%;height: 100%;position: absolute;z-index: 1800;top: 0;display: none;"></div>
        <?php $this->bodyBegin(); ?>
        <header id="main-header" class="clearfix"  ng-class="{'sombra':data.global.viewMode !== 'list'}">
        <?php $this->applyTemplateHook('main-header','begin'); ?>
            <?php $this->part('header-logo') ?>
            <?php $this->part('header-about-nav') ?>
            <?php $this->part('header-main-nav') ?>
        <?php $this->applyTemplateHook('main-header','end'); ?>    
        </header>
        <section id="main-section" class="clearfix">
            <?php if ($this->isEditable()): ?>
                <div id="ajax-response-errors" class="js-dialog" title="<?php \MapasCulturais\i::esc_attr_e("Corrija os erros abaixo e tente novamente.");?>">
                    <div class="js-dialog-content"></div>
                </div>
            <?php endif; ?>
