$(() => {
    $('input[name="documento"]').on('keyup', function() {
        if ($(this).val().length > 14) $(this).mask('00.000.000/0000-00')
        else $(this).mask('000.000.000-009')
    })

    if ($('[data-original-title="CPF"]').length) $('[document-wrapper] input').mask('000.000.000-00')
    else $('[document-wrapper] input').mask('00.000.000/0000-00')
})
