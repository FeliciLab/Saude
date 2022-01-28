$(document).ready(function () {
    let sucess = document.querySelector('.success');
    let registration_id = $('.registration-id')[0].outerText;
    sucess.innerHTML = "<b style='font-size: 14px;'>" + "Sua inscrição foi enviada com sucesso no dia" 
    + sucess.outerText.substring(sucess.outerText.indexOf('dia') + 3) + '<br> Número da Inscrição: ' + registration_id + "</b>";
});