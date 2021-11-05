<div class="registration-fieldset">
<h4><?php \MapasCulturais\i::_e("Envios de e-mails nas inscrições");?></h4>
    <p class="registration-help"><?php \MapasCulturais\i::_e("Configurações para envios de e-mails nas inscrições. Caso título e mensagem não informado o sistema enviará o título e mensagem padrão.");?></p>
 
<label> <b>Titulo do e-mail</b> <br>
   <span class="js-editable" 
      data-edit="mailTitleSendConfirm"
      data-type="text"
      data-original-title="Informe o título de confirmação de inscrição" 
      data-emptytext="Informe o título de confirmação de inscrição">
      <?=htmlspecialchars($entity->mailTitleSendConfirm)?>
   </span>
</label> <br><br>

<label> <b>Mensagem do e-mail</b> <br>
   <span style="width: 100%;" class="js-editable" 
      data-edit="mailDescriptionSendConfirm"
      data-type="textarea"
      data-original-title="Informe a mensagem de confirmação de inscrição" 
      data-emptytext="Informe a mensagem de confirmação de inscrição">
      <?=htmlspecialchars($entity->mailDescriptionSendConfirm)?>
   </span>
</label> <br><br>
</div>