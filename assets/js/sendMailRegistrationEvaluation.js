function sendMailRegistrationEvaluation(opportunityId, registrationId, userId) {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    });

    swalWithBootstrapButtons.fire({
        title: 'ATENÇÃO!!!',
        html: "- Você tem certeza que deseja enviar um e-mail contendo todos os <b>campos inválidos</b> na avaliação para o INSCRITO? <br><br> - Você tem certeza que deseja mudar a situação do inscrito para <b>RASCUNHO?</b>",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sim! Enviar e e-mail e mudar situação para RASCUNHO!',
        cancelButtonText: 'Não! Cancelar!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "GET",
                url:`${MapasCulturais.baseURL}EvaluationDocumental/sendMailRegistrationEvaluation/${registrationId}/uid:${userId}`,
                dataType: "json",
                success: function (response) {
                    if (response.type == 'success') {
                        swalWithBootstrapButtons.fire({
                            icon: 'success',
                            title: 'Sucesso!',
                            html: '- E-mail para o inscrito enviado com sucesso! <br><br> - Atualização do status para RASCUNHO atualizado com sucesso. ',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.replace( `${MapasCulturais.baseURL}oportunidade/${opportunityId}/#/tab=evaluations`);
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Não foi possível enviar o e-mail.',
                        });
                    }
                }
            }).fail(function(error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Não foi possível enviar o e-mail.',
                });
            });
        }
    });
}