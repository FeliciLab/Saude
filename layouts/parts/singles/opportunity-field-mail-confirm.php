<div class="registration-fieldset">
<h4><?php \MapasCulturais\i::_e("Envios de e-mails nas inscrições");?></h4>
    <p class="registration-help"><?php \MapasCulturais\i::_e("Configurações para envios de e-mails nas inscrições. Caso título e mensagem não informado o sistema enviará o título e mensagem padrão.");?></p>
 
<label> <b>Titulo do e-mail</b> <br>
   <span class="js-editable" 
      data-edit="mailTitleSendConfirm"
      data-type="text"
      data-original-title="Informe o título de confirmação de inscrição" 
      data-emptytext="Informe o título de confirmação de inscrição">
      <?php
         $mailTitleFilled = $entity->mailTitleSendConfirm;
         echo !empty($mailTitleFilled) ? htmlspecialchars($entity->mailTitleSendConfirm) : $mailTitleSendConfirmDefault;
      ?>
   </span>
</label> <br><br>

<label> <b>Mensagem do e-mail</b> <br>
   <span style="width: 100%; white-space: initial;" class="js-editable" 
      data-edit="mailDescriptionSendConfirm"
      data-type="textarea"
      data-original-title="Informe a mensagem de confirmação de inscrição" 
      data-emptytext="Informe a mensagem de confirmação de inscrição">
      <?php
         $mailDescriptionFilled = $entity->mailDescriptionSendConfirm;
         echo !empty($mailDescriptionFilled) ? htmlspecialchars($entity->mailDescriptionSendConfirm) : $mailDescriptionSendConfirmDefault;
      ?>
   </span>
</label> <br><br>
</div>