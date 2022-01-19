$(document).ready(function () {
    let sucess = document.querySelector('.success');
    let registration_id = $('.registration-id')[0].outerText;
    sucess.innerHTML = "<b style='font-size: 14px;'>" + sucess.innerHTML + '<br> Número da Inscrição: ' + registration_id + "</b>";
});