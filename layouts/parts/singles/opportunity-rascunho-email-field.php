
<div class="registration-fieldset">
    <h4><?php \MapasCulturais\i::_e("E-mail de alerta do prazo");?></h4>
    <div style="padding-bottom: 10px">
        <input type="checkbox" id="scales" name="scales">
        <label for="scales">Programar o envio de um e-mail para alertar aos agentes que não finalizaram a inscrição que o prazo está próximo do final.</label>
    </div>
    <div class="highlighted-message clearfix">
        <label><?php \MapasCulturais\i::_e("Enviar e-mail");?> 
        <span class="js-editable" 
            data-edit="sendDraftEmail" 
            data-original-title="Gênero" 
            data-emptytext="Selecione o gênero">
                2
        </span>
            <?php \MapasCulturais\i::_e("dias antes do prazo final de inscrição.");?> 
        </label>
    </div>
</div>