$(document).ready(function () {
    //OCULTANDO CAMPO NO FORMULÁRIO DE RESPOSTA
    $("#divDeferido").hide();

    getAllResource();
    $("#formSendResource").submit(function (e) { 
        e.preventDefault();
        var form = $("#formSendResource").serialize();
        $.ajax({
            type: "POST",
            url: MapasCulturais.baseURL+'recursos/store',
            data: form,
            dataType: "json",
            success: function (response) {   
                new PNotify({
                    title: response.title,
                    text: response.message,
                    type: response.type
                });
                setTimeout(() => {
                    location.href = MapasCulturais.baseURL+'painel/inscricoes';                    
                }, 2000);
            }
        }).fail(function(error) {
            new PNotify({
                title: error.responseJSON.title,
                text: error.responseJSON.message,
                type: error.responseJSON.type

            });
        });
    });
    // adicionando link no botão ir para recurso na página de oportunidade
    $("#btn-recurso").attr('href', MapasCulturais.baseURL+'painel/inscricoes/#tab=enviadas');
    // ENVIO DE RESPOSTA DA BANCA
    $("#formReplyResource").submit(function (event) {
        event.preventDefault();
        var form = $("#formReplyResource").serialize();
        var idResource = $("#resource_id").val();
        $.ajax({
            type: "PUT",
            url: MapasCulturais.baseURL+'recursos/replyResource/'+idResource,
            data: form,
            dataType: "json",
            success: function (response) {
                new PNotify({
                    title: response.title,
                    text: response.message,
                    type: response.type    
                });
                var inst = $('[data-remodal-id=modal-resposta-recurso]').remodal();
                setTimeout(() => {
                    // $( "#resource_status option:selected" ).text('--Selecione--');
                    inst.close();
                    location.reload();
                }, 1000);
                
                
            }
        }).fail(function(error) {
            new PNotify({
                title: error.responseJSON.title,
                text: error.responseJSON.message,
                type: error.responseJSON.type

            });
        });
    });
    //habilitando div para nota
    $('#resource_status').on('change', function() {
        var type = this.value;
        if(type == 'Deferido' || type == 'ParcialmenteDeferido') {
            $("#divDeferido").show();
        }else{
            $("#divDeferido").hide();
        }
    });
});



function showModalResource(reg, opp, age, oppName) {
    $("#registration_id").val(reg)
    $("#opportunity_id").val(opp)
    $("#agent_id").val(age)
    $("#opportunityNameLabel").html(oppName)
}

function showModalReply(resourceId, opportunity, oppName, note) {
    $("#replyOpportunityNameLabel").html('');
    $("#resourceText").html('');
    $("#resource_id").val(0);
    $("#replyOpportunityNameLabel").html(oppName);
    $("#consolidated_result").val(note);
    var data = {
        id: resourceId
    }
    $.get(MapasCulturais.baseURL+'recursos/inforesourceReply', data,
        function (response) {
            console.log('status' , response);
            $("#resource_reply").val(response.resourceReply)
            $("#resourceText").html('<strong>Recurso: </strong>'+response.resourceText);
            $("#resource_id").val(response.id);
            if(response.resourceStatus == 'Aguardando'){
                //$( "#resource_status option:selected" ).text('--Selecione--');
                $('#resource_status option[value=Aguardando]').attr('selected','selected');
            }else{
                $('#resource_status option[value='+response.resourceStatus+']').attr('selected','selected');
                // $( "#resource_status option:selected" ).text(response.resourceStatus);
            }
            
        }
    );
    var inst = $('[data-remodal-id=modal-resposta-recurso]').remodal();
    //ABRE MODAL
    inst.open();

}

// para mudar a cor da class na tr > td
function infoColorStatus(status) {
    var classStatus = '';
    switch (status) {
        case 'Aguardando':
        classStatus = '';
        break;
        case 'Deferido':
        classStatus = 'text-success';
        break;
        case 'Indeferido':
            classStatus = 'text-danger';
        break;
    }

    return classStatus;
}

function eyeContent(text, type) {

    if(type == "resource") {
        $("#titleRemodal").html('Seu recurso.');
    }else{
        $("#titleRemodal").html('Sua resposta.');
    }
    $("#contentMain").html(text);
}

//todos os recursos do agente que está logado
function getAllResource() {
    $.get(MapasCulturais.baseURL+'recursos/allResource',
        function (data, textStatus, jqXHR) {
            $.each(data, function (indexInArray, value) { 
                console.log(value)
                getNameOpportunity(value.opportunity_id); 
                //formatando a data padrão pt-br
                var dtFormat = moment(value.resource_send).format('DD/MM/YYYY HH:mm:ss');
                var dtReply = "--";
                //mudando a cor do status
                var textStatus = "";
                var buttonReply = "--";
                var reply = "";
                var resource = "resource";
                var status = 'Aguardando';
                if(value.resource_reply !== null && value.resources_reply_publish == true){
                    buttonReply = value.resource_reply.substring(0, 20);
                    reply = 'reply';
                    buttonReply += '<br/><a href="#modal-main"  class="text-primary" onclick="eyeContent(`'+value.resource_reply+'`, `'+reply+'`)">Ver completo</a>';
                    dtReply = moment(value.resource_date_reply).format('DD/MM/YYYY HH:mm:ss');
                    status = value.resource_status;
                    textStatus = infoColorStatus(value.resource_status)
                }
                
                $("#bodyAllResource").append('<tr>'+
                    '<td id="tdNameOpportunity_'+value.opportunity_id+'"></td>'+
                    '<td>'+value.registration_id+'</td>'+
                    '<td class="text-long-table">'+value.resource_text.substring(0, 20)+
                    '<br/><small><a href="#modal-main"  class="text-primary" onclick="eyeContent(`'+value.resource_text+'`, `'+resource+'`)">Ver completo</a></small></td>'+
                    '<td>'+dtFormat+'</td>'+
                    '<td class="'+textStatus+'"><strong>'+status+'</strong></td>'+
                    '<td class="text-long-table">'+buttonReply+
                    '</td>'+
                    '<td>'+dtReply+'</td>'+
                    '<td><form action="'+MapasCulturais.baseURL+'recursos/candidateData" method="post"><input type="hidden" name="id" value="'+btoa(value.id)+'"><button type="submit" title="Imprimir Esse Recurso"><i class="fa fa-print"></i></button></form>'+
                '</tr>'+
                '</tbody>')
            });
        }
    );
}

function getNameOpportunity(id) {
    $.ajax({
        type: "GET",
        url: MapasCulturais.baseURL + 'recursos/getNameOpportunity?id=' + id,
        dataType: "json",
        success: function (response) {
            $("#tdNameOpportunity_" + id).html(response);
        }
    });
}
function clickPublish(opportunity) {
    var id = opportunity;
    new PNotify({
        title: 'Confirmação',
        text: 'Esta ação não poderá ser revertida! Deseja realmente publicar estas respostas?',
        icon: 'fa fa-question-circle',
        type: 'info',
        hide: false,
        animation: 'fade',
        confirm: {
            confirm: true,
            buttons: [
            {
                text: 'Publicar',
                addClass: 'btn btn-primary btn-confirm-notify',
                click: function(notice){
                    verifyResourceNotReply(id)
                    PNotify.removeAll();
                }
            },
            {
                text: 'Cancelar',
                addClass: 'btn btn-default',
                click: function(notice){
                  PNotify.removeAll();
                }
            },
          ]
        },
        buttons: {
          closer: false,
          sticker: false
        },
        history: {
          history: false
        },
        addclass: 'stack-modal',
        stack: {'dir1': 'down', 'dir2': 'right', 'modal': true}
      });
}
//publicando todos os recursos
function publishResource(opportunity) {
    $.ajax({
        type: "POST",
        url: MapasCulturais.baseURL + 'recursos/publishResource',
        data: {opportunity_id: opportunity},
        dataType: "json",
        success: function (response) {
            new PNotify({
                title: response.title,
                text: response.message,
                type: response.type    
            });
            $("#div-publish").hide();
            $("#div-alert-publish").show();
        }
    });
}

//VERIFICA SE EXISTE RECURSO SEM RESPOSTA
function verifyResourceNotReply(opportunity) {

    $.ajax({
        type: "POST",
        url: MapasCulturais.baseURL + 'recursos/verifyResource',
        data: {opportunityId: opportunity},
        dataType: "json",
        success: function (response) {
            publishResource(opportunity);
        }
    }).fail(function(error) {
        console.log(error)
        new PNotify({
            title: 'Ops!',
            text: error.responseJSON.message,
            type: 'notice',
            icon: 'fa fa-exclamation-triangle',
            shadow: true
        }); 
    });;
}
