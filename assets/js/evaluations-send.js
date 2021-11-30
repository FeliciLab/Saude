function confirmSendEvaluation(url) {
    new PNotify({
        title: 'Enviar avaliações',
        text: 'Tem certeza que deseja enviar as avaliações? Após o envio, as notas não poderão ser alteradas',
        icon: 'fa fa-question-circle-o fa-3x',
        hide: false,
        type: 'error',
        confirm: {
          confirm: true,
          buttons: [
            {
                text: 'Enviar',
                addClass: 'btn btn-primary',
                click: function(notice){
                  console.log(notice)
                  window.location.href = url
                }
            },
            {
                text: 'Cancelar',
                addClass: 'btn btn-default',
                click: function(notice){
                    PNotify.removeAll();
                }
            }
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

$(function (){ 
  var $btn = $('#evaluation-committee-buttons a.btn-primary');
  if($btn.length && $btn.prop('href')) {
    $btn.data('href', $btn.prop('href'));
    $btn.prop('href', '#');
    $btn.click(function () {
      confirmSendEvaluation($(this).data('href'));
    });
  }
});