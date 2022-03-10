$(document).ready(function () {
    let cpf = $("#user_cpf");
    let cpf_value = cpf.text().replace(/\D/g, "");
    if(cpf_value.match( /(^\d{3}\d{3}\d{3}\d{2}$)|(^\d{2}\d{3}\d{3}\d{4}\d{2}$)/)){
        cpf.editable('toggleDisabled');
    }
    if(cpf_value){
        $('#user_cpf').mask(cpf_value.length > 11 ? '00.000.000/0000-00' : '000.000.000-00', {
            reverse: true
        });
    }
    $('.privado').on('keydown', 'input', function(e) {
        if($(this)[0].placeholder == "CPF ou CNPJ"){
            if($(this).val().length > 14){
                $(this).mask('00.000.000/0000-00')
            }else{
                $(this).mask('000.000.000-009');
            }
        }
    });
});