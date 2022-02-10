$(document).ready(function () {
    $("#info_required_loading").hide();
    //OS CAMPOS QUE SÃO OBRIGATÓRIOS
    var fields = [];
    // A PROPRIEDADE SO EXISTE SE TIVER UMA SESSÃO CRIADA
    if(MapasCulturais.hasOwnProperty('errorsSendRegis')) {
        fields = MapasCulturais.errorsSendRegis;
    }
    console.log({fields})
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
    //chamando o modal se tiver campos
    if(Object.keys(nameFields).length > 0) {
        var modal = $('[data-remodal-id=remodal_info_field_required]').remodal();
        modal.open();
    }
});

$(function () {
    // LIMPANDO O ITENS
    $(document).on('closed', '.remodal', function (e) {
        $("#info-erros-required-fields").empty();
        //enviar requisição para rota opportunity.emptySession
        
    });

});

function fecharModal() {
    $("#info_required_loading").show();
    var ins = MapasCulturais.entity.id;
    let url = MapasCulturais.baseURL;
    console.log(url + 'opportunity/emptySession');
    console.log({ins});
    $.ajax({
        type: "GET",
        url: url + 'opportunity/emptySession',
        dataType: "json",
        success: function(response) {
            console.log(response)
            window.location.href = url + 'inscricao/' + ins;
        }
    });
}
/**.done(function(response) {
        console.log(response)
            window.location.href = url + 'inscricao/' + ins;
      })
      .fail(function(e) {
       console.log(e)
      })
      .always(function(res) {
        console.log(res )
            window.location.href = url + 'inscricao/' + ins;
      }) */