$(document).ready(function() {
    //Pegando a URL atual
    var url_atual = window.location.href;
    //Verificando se é a página de inscrições
    //OBS: verificar o link nos ambientes de homologação e produção
    if(url_atual.includes('http://localhost/inscricao/')){
        $("a").click(function(event) {
            //Salvando o link da variável href
            var href = $(this).attr('href');
            //Usando um regex para verificar se um texto está contido dentro do outro. Neste caso, verificando se uma dessas expressões está dentro da variável href.
            //OBS: verificar os links nos ambientes de homologação e produção
            if(href.match(/http:\/\/localhost\/agente\//) || href.match(/http:\/\/localhost\/oportunidade\//)){
                event.preventDefault();
                $('body').append('<div class="remodal modal-border" data-remodal-id="modal-information-message"><button data-remodal-action="close" class="remodal-close"></button><h3>Você está saindo da seção de inscrição</h3><div><h4 style="color: #F26822; font-weight: bold;">Você tem certeza disso?</h4></div><div><p>Ao sair desta página, <b>você não perde sua inscrição,</b><br>ela ficará salva para depois:</p><p>Você poderá continuar esta inscrição em: <br><b>Meu Perfil -> Minhas Inscrições. </b></p></div><br><div style="float: right;"><button data-remodal-action="cancel" class="btn btn-default" title="Sair da resposta" style="margin-right: 15px;"> Voltar</button><a class="btn btn-primary" id="dataComfirmOK" href="'+href+'" >Confirmar</a></form></div></div>');
                $('[data-remodal-id=modal-information-message]').remodal().open();
            }
        });
    }
    
});