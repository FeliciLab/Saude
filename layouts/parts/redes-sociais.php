<?php
    $app_mode = env('APP_MODE', 'production');
    $is_production = $app_mode == 'production';
    if($is_production){
?>
    <div class="widget">
    <h3><?php \MapasCulturais\i::_e("Compartilhar");?></h3>
    <!-- LinkedIn -->
    <div>
        <script src="https://platform.linkedin.com/in.js" type="text/javascript">lang: pt_BR</script>
        <script type="IN/Share" data-url="<?php echo $entity->singleUrl; ?>"></script>
    </div>
    <div id="fb-root"></div>
    <script>
        (function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0";
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
      <!-- Your share button code -->
    <div>
        <div class="fb-share-button" 
            data-href="<?php echo $entity->singleUrl; ?>" 
            data-layout="button">
        </div>
        <div class="btn-social-share">
        <br>
            <a href="https://twitter.com/share?url=<?php echo $entity->singleUrl; ?>" class="twitter-share-button" target="_blank" data-lang="en" ><?php \MapasCulturais\i::_e("Compartilhar");?></a>
            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
        </div>
    </div>
</div>

<?php
    }
?>

<div class="btn-social-share" data-href="<?php echo $entity->singleUrl; ?>" data-type="button_count"></div>
<?php if ($this->isEditable() || $entity->twitter || $entity->facebook || $entity->googleplus || $entity->instagram): ?>
<div class="widget">
    <h3><?php \MapasCulturais\i::_e("Seguir");?></h3>
    <?php if ($this->isEditable() || $entity->twitter): ?>
    <span <?php if($this->isEditable()):?> class="editable-social" <?php endif; ?> >
    <a class="icon icon-twitter js-editable btn" title="<?php \MapasCulturais\i::esc_attr_e("Perfil no Twitter");?>" target="_blank" data-edit="twitter" data-notext="true" data-original-title="<?php \MapasCulturais\i::esc_attr_e("Perfil no Twitter");?>"
        href="<?php echo $entity->twitter ? $entity->twitter : '#" onclick="return false; ' ?>"
        data-value="<?php echo $entity->twitter ?>"></a>
    </span>
    <?php endif; ?>
    <?php if ($this->isEditable() || $entity->facebook): ?>
    <span <?php if($this->isEditable()):?> class="editable-social" <?php endif; ?> >
    <a class="icon icon-facebook js-editable btn" title="<?php \MapasCulturais\i::esc_attr_e("Perfil no Facebook");?>"  target="_blank" data-edit="facebook" data-notext="true" data-original-title="<?php \MapasCulturais\i::esc_attr_e("Perfil no Facebook");?>"
        href="<?php echo $entity->facebook ? $entity->facebook : '#" onclick="return false; ' ?>"
        data-value="<?php echo $entity->facebook ?>"></a>
    </span>
    <?php endif; ?>
    <?php if ($this->isEditable() || $entity->instagram): ?>
    <span <?php if($this->isEditable()):?> class="editable-social" <?php endif; ?> >
    <a class="icon icon-instagram js-editable btn" title="<?php \MapasCulturais\i::esc_attr_e("Perfil no Instagram");?>" target="_blank" data-edit="instagram" data-notext="true" data-original-title="<?php \MapasCulturais\i::esc_attr_e("Perfil no Instagram");?>"
        href="<?php echo $entity->instagramUrl; ?>"
        data-value="<?php echo $entity->instagram; ?>">
    </a>
    </span>
    <?php endif; ?>
</div>
<?php endif; ?>