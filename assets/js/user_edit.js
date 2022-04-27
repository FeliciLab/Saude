$(document).ready(function () {
    let cpf = $("#user_cpf");
    let cpf_value = cpf.text().replace(/\D/g, "");
    if(cpf_value.match( /(^\d{3}\d{3}\d{3}\d{2}$)|(^\d{2}\d{3}\d{3}\d{4}\d{2}$)/)){
        cpf.editable('toggleDisabled');
    }
});