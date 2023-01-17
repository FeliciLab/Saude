<?php if ($this->isEditable()) : ?>
   <div class="registration-fieldset">
      <h4><?php \MapasCulturais\i::_e("Habilita a aba resultado após a publicação"); ?></h4>
    <p class="registration-help"><?php \MapasCulturais\i::_e("Por padrão a aba \"RASULTADO\" ficará disponível após a publicação do resultado.");?></p>
      <label> <b>Habilita a aba resultado após a publicação</b> <br>
          <span class="js-editable" data-edit="enableAbaResultAfterPublishToPublic" data-type="select" data-value="<?php echo $entity->enableAbaResultAfterPublishToPublic; ?>" data-original-title="<?php echo "Habilita a aba resultado após a publicação?"; ?>" data-emptytext="Sim"><?php echo $entity->enableAbaResultAfterPublishToPublic == '0' ? $entity->enableAbaResultAfterPublishToPublic : 'Sim'; ?></span>

      </label> <br><br>
   </div>
<?php endif; ?>