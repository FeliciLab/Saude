$(() => {
    if($('[data-original-title="CPF"]').length) $('[document-wrapper] input').mask('000.000.000-00')
    else $('[document-wrapper] input').mask('00.000.000/0000-00')
})
