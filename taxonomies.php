<?php
use MapasCulturais\i;

return array(
    1 => array(
       // 'slug' => i::__('tag'),
        'slug' => 'tag',
        'entities' => array(
            'MapasCulturais\Entities\Space',
            'MapasCulturais\Entities\Agent',
            'MapasCulturais\Entities\Event',
            'MapasCulturais\Entities\Project',
            'MapasCulturais\Entities\Opportunity',
        )
    ),

    2 => array(
        //'slug' => i::__('area'),
        'slug' => 'area',
        //'required' => i::__("Você deve informar ao menos uma área de atuação"),
        'entities' => array(
            'MapasCulturais\Entities\Space',
            'MapasCulturais\Entities\Agent'
        ),
        'restricted_terms' => array(
            \MapasCulturais\i::__("Saúde"),
        )
    ),

    3 => array(
        'slug' => 'linguagem',
        'entities' => array(
            'MapasCulturais\Entities\Event'
        ),

        'restricted_terms' => array()
    )
);
