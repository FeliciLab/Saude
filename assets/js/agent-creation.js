$(() => {
    $("input[name='documento']").on('keydown', function() {
        if ($(this).val().length > 14) $(this).mask('00.000.000/0000-00')
        else $(this).mask('000.000.000-009')
    })
})
