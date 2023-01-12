<div style="margin-top: 20px;" id='status-info' class="alert info">
    <span>ATENÇÃO!!! Ao clicar no botão "Enviar e-mail para o inscrito e alterar SITUAÇÃO para RASCUNHO" será realizado as seguintes ações: <br><br>
        - Ação de envio de e-mail para o inscrito contendo os campos/anexos invalidos pela avaliação. <br><br>
        - Ação de mudança de situação para RASCUNHO<br>    
    </span><br>
    <br>
    <a class="btn btn-default js-submit-button" rel="noopener noreferrer" onclick="return sendMailRegistrationEvaluation(<?= $registration->opportunity->id; ?>, <?= $registration->id; ?>, <?= $userId; ?>)"><?php \MapasCulturais\i::_e("Enviar e-mail e alterar SITUAÇÃO para RASCUNHO");?></a>
</div>
