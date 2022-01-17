
<div class="registration-fieldset">
    <h4><?php \MapasCulturais\i::_e("E-mail de alerta do prazo");?></h4>
    <div style="padding-bottom: 10px">
        <span class="js-editable"
            style="display:none;"
            id="checkboxDraftEmail"
            data-edit="checkboxDraftEmail" 
            data-original-title="Gênero" 
            data-emptytext="Selecione o gênero">
                <?php echo $entity->checkboxDraftEmail ?>
        </span>
        <input type="checkbox" id="checkEmailDraft" name="checkEmailDraft" <?php echo $entity->checkboxDraftEmail ? 'checked' : '' ?> >
        <label for="scales"><?php \MapasCulturais\i::_e("Programar o envio de um e-mail para alertar aos agentes que não finalizaram a inscrição que o prazo está próximo do final.");?></label>
    </div>
    <div class="highlighted-message clearfix">
        <label><?php \MapasCulturais\i::_e("Enviar e-mail");?> 
        <span class="js-editable" 
            data-disabled="<?php echo $entity->checkboxDraftEmail ? false : true?>"
            id="sendDraftEmail"
            data-edit="sendDraftEmail" 
            data-original-title="Gênero" 
            data-emptytext="Selecione o gênero">
                <?php echo $entity->sendDraftEmail ?>
        </span>
            <?php \MapasCulturais\i::_e("dias antes do prazo final de inscrição.");?> 
        </label>
    </div>
</div>
<script>
    $( document ).ready(function() {
        $('#checkEmailDraft').change(function() {
            $('#checkboxDraftEmail').editable('setValue', this.checked ? 1 : 0);
            $('#sendDraftEmail').editable('option', 'disabled', this.checked ? false : true);
        });
    });
</script>