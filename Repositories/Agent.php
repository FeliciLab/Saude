<?php

namespace Saude\Repositories;

use MapasCulturais\App;
use MapasCulturais\Entities\User;

class Agent extends \MapasCulturais\Repository
{
    public static function checkCpfLinkedAnotherAgent($typed_cpf, $agent_id)
    {
        $app = App::i();

        $query = $app->em->createQuery(
            "SELECT IDENTITY(am.owner) AS agent_id FROM MapasCulturais\Entities\AgentMeta am
            INNER JOIN MapasCulturais\Entities\User u WITH am.owner = u.profile
            WHERE am.value = :cpf AND am.owner != :agentId AND u.status = :userStatus"
        );

        $query->setParameter('cpf', $typed_cpf);
        $query->setParameter('agentId', $agent_id);
        $query->setParameter('userStatus', User::STATUS_ENABLED);

        return $query->getResult();
    }
}
