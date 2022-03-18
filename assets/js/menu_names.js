$(document).ready(function () {
    let panel_icon = $('.icon-panel')[0].outerHTML;
    let panel_name = $('.icon-panel').parent();
    panel_name[0].innerHTML = panel_icon + "Painel de controle"; 

    let agent_icon = $('span.icon-agent')[0].outerHTML;
    let agent_name = $('span.icon-agent').parent();
    agent_name[0].innerHTML = agent_icon + "Meus Dados"; 

});