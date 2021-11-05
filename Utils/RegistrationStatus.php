<?php

namespace Saude\Utils;

use MapasCulturais\Entities\Registration;

class RegistrationStatus{
    public static function statusTitleById($status) {
        $statuses =  [
            Registration::STATUS_DRAFT => 'O candidato poderá editar e reenviar a sua inscrição.',
            Registration::STATUS_SENT => 'Ainda não avaliada.',
            Registration::STATUS_INVALID => 'Em desacordo com o regulamento',
            Registration::STATUS_NOTAPPROVED => 'Avaliada, mas não selecionada.',
            Registration::STATUS_WAITLIST => 'Avaliada, mas aguardando vaga.',
            Registration::STATUS_APPROVED => 'Avaliada e selecionada.'

        ];
        return  $statuses[$status] ?? null;
    }
    
    public static function statusColorById($status) {
        
        $statuses =  [
            Registration::STATUS_DRAFT => 'statusrasc',
            Registration::STATUS_SENT => 'statuspend',
            Registration::STATUS_INVALID => 'statusinv',
            Registration::STATUS_NOTAPPROVED => 'statusrep',
            Registration::STATUS_WAITLIST => 'statusespera',
            Registration::STATUS_APPROVED => 'statusap'

        ];
        return  $statuses[$status] ?? null;
    }
}