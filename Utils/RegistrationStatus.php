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
}