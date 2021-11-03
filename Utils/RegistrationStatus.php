<?php

namespace Saude\Utils;

use MapasCulturais\Entities\Registration;

class RegistrationStatus{
    public static function statusSlugById($status, $status_slug = '') {
        switch ($status) {
            case Registration::STATUS_DRAFT:
                $status_slug = 'Rascunho';
                break;
            case Registration::STATUS_SENT:
                $status_slug = 'Pendente';
                break;
            case Registration::STATUS_INVALID:
                $status_slug = 'Inválida';
                break;
            case Registration::STATUS_NOTAPPROVED:
                $status_slug = 'Não selecionada';
                break;
            case Registration::STATUS_WAITLIST:
                $status_slug = 'Suplente';
                break;
            case Registration::STATUS_APPROVED:
                $status_slug = 'Selecionada';
                break;
        }
        return $status_slug;
    }
    public static function statusTitleById($status, $title = '') {
        switch ($status) {
            case Registration::STATUS_DRAFT:
                $title = 'O candidato poderá editar e reenviar a sua inscrição.';
                break;
            case Registration::STATUS_SENT:
                $title = 'Ainda não avaliada.';
                break;
            case Registration::STATUS_INVALID:
                $title = 'Em desacordo com o regulamento';
                break;
            case Registration::STATUS_NOTAPPROVED:
                $title = 'Avaliada, mas não selecionada.';
                break;
            case Registration::STATUS_WAITLIST:
                $title = 'Avaliada, mas aguardando vaga.';
                break;
            case Registration::STATUS_APPROVED:
                $title = 'Avaliada e selecionada.';
                break;
        }
        return $title;
    }
    public static function statusColorById($status, $color = '') {
        switch ($status) {
            case Registration::STATUS_DRAFT:
                $color = 'statusrasc';
                break;
            case Registration::STATUS_SENT:
                $color = 'statuspend';
                break;
            case Registration::STATUS_INVALID:
                $color = 'statusinv';
                break;
            case Registration::STATUS_NOTAPPROVED:
                $color = 'statusrep';
                break;
            case Registration::STATUS_WAITLIST:
                $color = 'statusespera';
                break;
            case Registration::STATUS_APPROVED:
                $color = 'statusap';
                break;
        }
        return $color;
    }
}