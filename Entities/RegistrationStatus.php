<?php

namespace Saude\Entities;

use MapasCulturais\Entities\Registration;

class RegistrationStatus extends \MapasCulturais\Entities\Registration{
    public static function statusSlugById($status, $status_slug = '') {
        switch ($status) {
            case 0:
                $status_slug = 'Rascunho';
                break;
            case 1:
                $status_slug = 'Pendente';
                break;
            case 2:
                $status_slug = 'Inválida';
                break;
            case 3:
                $status_slug = 'Não selecionada';
                break;
            case 8:
                $status_slug = 'Suplente';
                break;
            case 10:
                $status_slug = 'Selecionada';
                break;
        }
        return $status_slug;
    }
}