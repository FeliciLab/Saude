$(document).ready(function () {
    //OS CAMPOS QUE SÃO OBRIGATÓRIOS
    var fields = [];
    // A PROPRIEDADE SO EXISTE SE TIVER UMA SESSÃO CRIADA
    if(MapasCulturais.hasOwnProperty('errorsSendRegis')) {
        fields = MapasCulturais.errorsSendRegis;
    }
    //PARA O NOME DOS CAMPOS
    var nameFields = [];
    if(Object.keys(fields).length > 0) {
        Object.entries(fields).forEach(([key, value]) => {
            //todos os campos da oportunidade
            var regis = MapasCulturais.entity.registrationFieldConfigurations;
            Object.entries(regis).forEach(([chave, valor]) => {
                //COMPARANDO O NOME DOS CAMPOS COM OS ARQUIVOS EXISTENTES PARA PEGAR O NOME DO CAMPO
                if(valor.fieldName == key) {
                    nameFields.push(valor.title);
                }
            });
        });
    }
    //Populando com LI o nome dos campos
    Object.entries(nameFields).forEach(([key, value]) => {
        $("#info-erros-required-fields").append('<li>'+value+'</li>');
    });
    //chamando o modal
    var modal = $('[data-remodal-id=remodal_info_field_required]').remodal();
    modal.open();
});

$(function () {
    // LIMPANDO O ITENS
    $(document).on('closed', '.remodal', function (e) {
        $("#info-erros-required-fields").empty();
    });
});