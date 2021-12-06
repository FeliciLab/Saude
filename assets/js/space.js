$(function(){
   console.log('space.js')
});
$(document).ready(function () {
    var nameH = MapasCulturais.entity.object.name;
    //POR PADRÃO INICIA OCULTANDO A DIV DAS INFORMAÇÕES
    $("#infoIntegrasus").hide();
    $("#iframeBoxIntegrasus").hide();
    $("#boxComparativeIntegrasus").hide();
    $("#requiredMonthPermanence").hide();
    $("#requiredYearPermanence").hide();
    //NOME DO HOSPITAL VINDO DO PHP
  
    var sigla = '';
    //ARRAY COM HOSPITAIS VALIDOS
    var hospitalValidation = [
        'HGF HOSPITAL GERAL DE FORTALEZA',
        'HGCC HOSPITAL GERAL DR CESAR CALS',
        'HOSPITAL GERAL DR WALDEMAR ALCANTARA',
        'HOSPITAL REGIONAL DO SERTAO CENTRAL',
        'HOSPITAL SAO JOSE DE DOENCAS INFECCIOSAS',
        'HOSPITAL DE SAUDE MENTAL DE MESSEJANA',
        'HM HOSPITAL DE MESSEJANA DR CARLOS ALBERTO STUDART GOMES',
        'HOSPITAL REGIONAL NORTE'
    ]
    //VERIFICANDO QUAL A SIGLA PARA CONSULTA    
    
    switch (nameH) {
        case 'HGF HOSPITAL GERAL DE FORTALEZA':
        sigla = 'HGF';
        $("#iframeBoxIntegrasus").hide();
            $("#iframeBoxIntegrasus").show();
            $("#iframeBoxIntegrasus").append('<iframe src="https://indicadores.integrasus.saude.ce.gov.br/indicadores/indicadores-hospitalares/emergencia-maior-24-horas-filtro/'+sigla+'?modoExibicao=painel" width="100%" height="700px"></iframe>')
            break;
        case 'HGCC HOSPITAL GERAL DR CESAR CALS':
            sigla = 'HGCC';
            $("#iframeBoxIntegrasus").show();
            $("#iframeBoxIntegrasus").append('<iframe src="https://indicadores.integrasus.saude.ce.gov.br/indicadores/indicadores-hospitalares/emergencia-maior-24-horas-filtro/'+sigla+'?modoExibicao=painel" width="100%" height="700px"></iframe>')
            break;
        case 'HOSPITAL GERAL DR WALDEMAR ALCANTARA':
            sigla = 'HGWA';
            break;
        case 'HOSPITAL REGIONAL DO SERTAO CENTRAL':
            sigla = 'HRSC';
            break;
        case 'HOSPITAL SAO JOSE DE DOENCAS INFECCIOSAS':
            sigla = 'HSJ';
            $("#iframeBoxIntegrasus").show();
            $("#iframeBoxIntegrasus").append('<iframe src="https://indicadores.integrasus.saude.ce.gov.br/indicadores/indicadores-hospitalares/emergencia-maior-24-horas-filtro/'+sigla+'?modoExibicao=painel" width="100%" height="700px"></iframe>')
            break;
        case 'HOSPITAL DE SAUDE MENTAL DE MESSEJANA':
            sigla = 'HSM';
            $("#iframeBoxIntegrasus").show();
            $("#iframeBoxIntegrasus").append('<iframe src="https://indicadores.integrasus.saude.ce.gov.br/indicadores/indicadores-hospitalares/emergencia-maior-24-horas-filtro/'+sigla+'?modoExibicao=painel" width="100%" height="700px"></iframe>')
            break;
        case 'HM HOSPITAL DE MESSEJANA DR CARLOS ALBERTO STUDART GOMES':
            sigla = 'HM';
            break;
        case 'HOSPITAL REGIONAL NORTE':
            sigla = 'HRN';
            break;
    }
    //SE NO ARRAY DE HOSPITAIS EXISTIR O MESMO NOME QUE VEM DO PHP, CHAMA AS FUNCOES
    if (hospitalValidation.indexOf(nameH) == 0 || hospitalValidation.indexOf(nameH) > 0) {
        $("#infoIntegrasus").show();
        permanenceActual(sigla)
        txoccupationbed(sigla)
        txHospitalMortality(sigla)
        quantity_attendance_hospital(sigla)
        patientEmergencyBigger24hours(sigla)
    }

    $("#btnComparativeIntegraSus").click(function (e) { 
        e.preventDefault();
        $("#boxComparativeIntegrasus").hide();
        console.log($("#monthPermanence").val());
        console.log($("#yearPermanence").val());  
        console.log({sigla});
        if($("#monthPermanence").val() == '0' ||  $("#yearPermanence").val() == '0') {
            $("#requiredMonthPermanence").show(); 
            $("#boxComparativeIntegrasus").removeClass('animated', 'bounceInUp');
         
        }else{
            $("#boxComparativeIntegrasus").hide()
            $("#boxComparativeIntegrasus").show()
            permanenceActualSelect(sigla, $("#monthPermanence").val(), $("#yearPermanence").val())
            txoccupationbedSelected(sigla, $("#monthPermanence").val(), $("#yearPermanence").val())
            txHospitalMortalitySelect(sigla, $("#monthPermanence").val(), $("#yearPermanence").val())
            //$("#boxComparativeIntegrasus").removeClass('animated', 'bounceInUp');
         
        }
           
    });
});
function numberToReal(numero) {
    var numero = numero.toFixed(0).split('.');
    numero[0] = numero[0].split(/(?=(?:...)*$)/).join('.');
    return numero.join(',');
}


//PERMANENCIA
function permanenceActual(sigla) {
    var dt2 = new Date();
    var current_month = (dt2.getMonth() + 1);
    var current_year = (dt2.getFullYear());
   
    $.ajax({
        type: "get",
        url: "https://indicadores.integrasus.saude.ce.gov.br/api/media-permanencia-geral",

        dataType: "json",
        success: function (response) {
            var permanence = response.content;
            $.each(permanence, function (indexInArray, permanence) {
                //console.log(permanence.hospital)
                if (permanence.hospital == sigla && permanence.mes == current_month && permanence.ano == current_year) {
                    //console.log('Tempo de permanencia : ' + permanence.mediaPermanenciaGeral)
                    $("#info_permanence_actual").html(permanence.mediaPermanenciaGeral)
                    $("#info_permanence_actual").attr('title', current_month + '/' + current_year)
                }
            });
        }
    });
}
function permanenceActualSelect(sigla, month, year) {
    var dt2 = new Date();
    var current_month = (dt2.getMonth() + 1);
    var current_year = (dt2.getFullYear());
    $.ajax({
        type: "get",
        url: "https://indicadores.integrasus.saude.ce.gov.br/api/media-permanencia-geral",
        dataType: "json",
        success: function (response) {
            var permanence = response.content;
            $.each(permanence, function (indexInArray, permanence) {
                //console.log(permanence.hospital)
                if (permanence.hospital == sigla && permanence.mes == month && permanence.ano == year) {
                    //console.log('Tempo de permanencia : ' + permanence.mediaPermanenciaGeral)
                    $("#info_permanence_actual_select").html(permanence.mediaPermanenciaGeral)
                    $("#info_permanence_actual_select").attr('title', month + '/' + year)
                }
            });
        }
    });
}
//TAXA DE OCUPAÇÃO DE LEITOS
function txoccupationbed(sigla) {
    var dt2 = new Date();
    var current_month = (dt2.getMonth() + 1);
    var current_year = (dt2.getFullYear());
    $.ajax({
        type: "get",
        url: "https://indicadores.integrasus.saude.ce.gov.br/api/taxa-ocupacao-leitos",

        dataType: "json",
        success: function (response) {
            var permanence = response.content;
            
            $.each(permanence, function (indexInArray, permanence) {
                //console.log(permanence.hospital)
                var mesAnterior = current_month - 1
                if (permanence.hospital == sigla && permanence.mes == mesAnterior && permanence.ano == current_year) {
                    //console.log('Taxa de Ocupação dos Leitos: ' + permanence.taxaOcupacaoLeitosMes)
                    $("#info_ocupation").html(permanence.taxaOcupacaoLeitosMes.toFixed(2) + '%')
                    $("#info_ocupation").attr('title', mesAnterior + '/' + current_year)
                }
            });
        }
    });
}
function txoccupationbedSelected(sigla, month, year) {
    var dt2 = new Date();
    var monthSelect = '';    
    if(month < 9) {
       monthSelect = '0'+month;
    }else{
        monthSelect = month;
    }   
    $.ajax({
        type: "get",
        url: "https://indicadores.integrasus.saude.ce.gov.br/api/taxa-ocupacao-leitos",

        dataType: "json",
        success: function (response) {
            var permanence = response.content;
            $.each(permanence, function (indexInArray, permanence) {
                if (permanence.hospital == sigla && permanence.mes == monthSelect && permanence.ano == year) {
                    console.log('Taxa de Ocupação dos Leitos - SELECT: ' + permanence.taxaOcupacaoLeitosMes)
                    $("#info_ocupation_select").html(permanence.taxaOcupacaoLeitosMes.toFixed(2) + '%')
                    $("#info_ocupation_select").attr('title', monthSelect + '/' + month)
                }
            });
        }
    });
}
//QUANTIDADE DE ATENDIMENTO
function quantity_attendance_hospital(sigla) {
    var dt2 = new Date();
    var current_month = (dt2.getMonth() + 1);
    var current_year = (dt2.getFullYear());
    $.ajax({
        type: "get",
        url: "https://indicadores.integrasus.saude.ce.gov.br/api/qtd-atendimento-hospital",
        dataType: "json",
        success: function (response) {
           
            var permanence = response.content;
            
            $.each(permanence, function (indexInArray, permanence) {
                //console.log(permanence.hospital)
                if (permanence.hospital == sigla && permanence.tipoAtendimento == 'AMBULATORIO') {
                    //console.log('Taxa de mortalidadeHospitalar: ' + permanence.mortalidadeHospitalar)
                    qtdAmb = numberToReal(permanence.qtd);
                    $("#quantity_attendance_hospital_amb").html(qtdAmb)
                    $("#quantity_attendance_hospital_amb").attr('title', 'ANO '+ current_year)
                }
                if (permanence.hospital == sigla && permanence.tipoAtendimento == 'EMERGÊNCIA') {
                    //console.log('Taxa de mortalidadeHospitalar: ' + permanence.mortalidadeHospitalar)
                    qtdEme = numberToReal(permanence.qtd);
                    $("#quantity_attendance_hospital_eme").html(qtdEme)
                    $("#quantity_attendance_hospital_eme").attr('title', 'ANO '+current_year)
                }
            });
        }
    });
}

//TAXA DE MORTALIDADE HOSPITALAR
function txHospitalMortality(sigla) {
    var dt2 = new Date();
    var current_month = (dt2.getMonth() + 1);
    var current_year = (dt2.getFullYear());
    $.ajax({
        type: "get",
        url: "https://indicadores.integrasus.saude.ce.gov.br/api/taxa-mortalidade",
        dataType: "json",
        success: function (response) {
           
            var permanence = response.content;
            $.each(permanence, function (indexInArray, permanence) {
                //console.log(permanence.hospital)
                if (permanence.hospital == sigla && permanence.mes == current_month && permanence.ano == current_year) {
                    //console.log('Taxa de mortalidadeHospitalar: ' + permanence.mortalidadeHospitalar)
                    $("#info_hospital_mortality").html(permanence.mortalidadeHospitalar.toFixed(2) + '%')
                    $("#info_hospital_mortality").attr('title', current_month + '/' + current_year)
                }
            });
        }
    });
}
function txHospitalMortalitySelect(sigla, month, year) {
    var monthSelect = '';    
    if(month < 9) {
       monthSelect = '0'+month;
    }else{
        monthSelect = month;
    }
    $.ajax({
        type: "get",
        url: "https://indicadores.integrasus.saude.ce.gov.br/api/taxa-mortalidade",
        dataType: "json",
        success: function (response) {           
            var permanence = response.content;
            $.each(permanence, function (indexInArray, permanence) {
                if (permanence.hospital == sigla && permanence.mes == monthSelect && permanence.ano == year) {
                    //console.log('Taxa de mortalidadeHospitalar: ' + permanence.mortalidadeHospitalar)
                    $("#info_hospital_mortality_select").html(permanence.mortalidadeHospitalar.toFixed(2) + '%')
                    $("#info_hospital_mortality_select").attr('title', monthSelect + '/' + year)
                }
            });
        }
    });
}

//PACIENTES QUE TIVERAM TEMPO DE PERMANÊNCIA SUPERIOR A 24H NA EMERGÊNCIA
function patientEmergencyBigger24hours(sigla) {
    var dt2 = new Date();
    var current_month = (dt2.getMonth() + 1);
    var current_year = (dt2.getFullYear());
    var countGeneral = 0;
    var countMale = 0;
    var countFeminine = 0;
    var valMale = 0;
    var valFamile = 0;
    $.ajax({
        type: "get",
        url: "https://indicadores.integrasus.saude.ce.gov.br/api/paciente-tempo-perm-maior-24/search/sexo?ano="+current_year+"&mes="+current_month+"&hospital=HGF",
        dataType: "json",
        success: function (response) {
            
            var permanence = response;
          
            $.each(permanence, function (indexInArray, permanence) {
                if (permanence.hospital == sigla && permanence.mes == current_month && permanence.ano == current_year) {
                    // console.log('Taxa de mortalidadeHospitalar: ' + permanence.sexo + '%')
                    countGeneral = countGeneral + permanence.qtd;                   
                    if(permanence.sexo == 'Feminino') {
                        countFeminine = permanence.qtd                        
                    }else{
                        countMale = permanence.qtd
                    }
                   
                }
            });
           

            valMale = countPercent(countGeneral , countFeminine)
            valFemile = countPercent(countGeneral , countMale)
            $("#permanenceBigger24Male").html(valMale.toFixed(2) + ' %')
            $("#permanenceBigger24Male").attr('title' , current_month+'/'+current_year)
            $("#permanenceBigger24Feminile").html(valFemile.toFixed(2) + ' %')
            $("#permanenceBigger24Feminile").attr('title' , current_month+'/'+current_year)
        }
    });
   
}
function countPercent(countGeneral , quant) {
    var percent = 0;
    mult = quant * 100;    
    percent = (mult / countGeneral);
    return percent;
}
function SelectPermanence(current_month, current_year) {
    var dt2 = new Date();
    var current_month = (dt2.getMonth() + 1);
    var current_year = (dt2.getFullYear());
    $.ajax({
        type: "get",
        url: "https://indicadores.integrasus.saude.ce.gov.br/api/media-permanencia-geral",

        dataType: "json",
        success: function (response) {
            //console.log('hgcc');
            // console.log(response.content.hospital);
            //console.log(response.content[0]);
            var permanence = response.content;
            // $.getJSON("url", data,
            //     function (data, textStatus, jqXHR) {

            //     }
            // );
            $.each(permanence, function (indexInArray, permanence) {
                //console.log(permanence.hospital)
                if (permanence.hospital == "HGF" && permanence.mes == current_month && permanence.ano == current_year) {
                    //console.log('Tempo de permanencia selecionado: ' + permanence.mediaPermanenciaGeral);
                }
            });
        }
    });
}