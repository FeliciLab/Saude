<?php
/**
 * See https://github.com/Respect/Validation to know how to write validations
 */
$app = MapasCulturais\App::i();
$termsUnidade = $app->repo('Term')->findBy(['taxonomy' => 'instituicao_tipos_unidades']);
$tiposUnidades = array_map(function($term) { return $term->term; }, $termsUnidade);
$termsGestao = $app->repo('Term')->findBy(['taxonomy' => 'instituicao_tipos_gestao']);
$tiposGestao = array_map(function($term) { return $term->term; }, $termsGestao);
$termsServico = $app->repo('Term')->findBy(['taxonomy' => 'instituicao_servicos']);
$tiposServico = array_map(function($term) { return $term->term; }, $termsServico);

$taxoSpaceType = $app->repo('Term')->findBy(['taxonomy' => 'instituicao_tipos_unidades']);
$typeSpaces = [];
$new = "";
$indice = 0;
foreach ($taxoSpaceType as $key => $value) {
    $indice = $value->id;
    $new = $value->term;
    unset($chave);

    $typeSpaces[$indice] = ['name' => $new];

}

return array(
    'metadata' => array(
        'emailPublico' => array(
            'label' => \MapasCulturais\i::__('Email Público'),
            'validations' => array(
                'v::email()' => \MapasCulturais\i::__('O email público não é um email válido.')
            ),
            'available_for_opportunities' => true
        ),

        'emailPrivado' => array(
            'label' => \MapasCulturais\i::__('Email Privado'),
            'validations' => array(
                'v::email()' => \MapasCulturais\i::__('O email privado não é um email válido.')
            ),
        	'private' => true,
            'available_for_opportunities' => true
        ),
        'cnpj' => array(
            'private' => true,
            'label' => \MapasCulturais\i::__('CNPJ'),
            'validations' => array(
               'v::cnpj()' => \MapasCulturais\i::__('O número de documento informado é inválido.')
            ),
            'available_for_opportunities' => true
        ),
        'razaoSocial' => array(
            'label' => \MapasCulturais\i::__('Razão Social'),
            'type' => 'text',
            'available_for_opportunities' => true
        ),
        'telefonePublico' => array(
            'label' => \MapasCulturais\i::__('Telefone Público'),
            'type' => 'string',
           /* 'validations' => array(
                'v::brPhone()' => \MapasCulturais\i::__('Por favor, informe o telefone público no formato (xx) xxxx-xxxx.')
            ),*/
            'available_for_opportunities' => true,
            //'field_type' => 'brPhone'
        ),

        'telefone1' => array(
            'label' => \MapasCulturais\i::__('Telefone 1'),
            'type' => 'string',
           /* 'validations' => array(
                'v::brPhone()' => \MapasCulturais\i::__('Por favor, informe o telefone 1 no formato (xx) xxxx xxxx.')
            ),*/
        	'private' => true,
            'available_for_opportunities' => true,
            //'field_type' => 'brPhone'
        ),


        'telefone2' => array(
            'label' => \MapasCulturais\i::__('Telefone 2'),
            'type' => 'string',
            /*'validations' => array(
                'v::brPhone()' => \MapasCulturais\i::__('Por favor, informe o telefone 2 no formato ')
            ),*/
        	'private' => true,
            'available_for_opportunities' => true,
            //'field_type' => 'brPhone',

        ),

        'acessibilidade' => array(
            'label' => \MapasCulturais\i::__('Acessibilidade'),
            'type' => 'select',
            'options' => array(
                '' => \MapasCulturais\i::__('Não Informado'),
                'Sim' => \MapasCulturais\i::__('Sim'),
                'Não' => \MapasCulturais\i::__('Não')
            )
        ),
        'acessibilidade_fisica' => array(
            'label' => \MapasCulturais\i::__('Acessibilidade física'),
            'type' => 'multiselect',
            'allowOther' => true,
            'allowOtherText' => \MapasCulturais\i::__('Outros'),
            'options' => array(
                \MapasCulturais\i::__('Banheiros adaptados'),
                \MapasCulturais\i::__('Rampa de acesso'),
                \MapasCulturais\i::__('Elevador'),
                \MapasCulturais\i::__('Sinalização tátil'),

                // vindos do sistema de museus.cultura.gov.br
                \MapasCulturais\i::__('Bebedouro adaptado'),
                \MapasCulturais\i::__('Cadeira de rodas para uso do visitante'),
                \MapasCulturais\i::__('Circuito de visitação adaptado'),
                \MapasCulturais\i::__('Corrimão nas escadas e rampas'),
                \MapasCulturais\i::__('Elevador adaptado'),
                \MapasCulturais\i::__('Rampa de acesso'),
                \MapasCulturais\i::__('Sanitário adaptado'),
                \MapasCulturais\i::__('Telefone público adaptado'),
                \MapasCulturais\i::__('Vaga de estacionamento exclusiva para deficientes'),
                \MapasCulturais\i::__('Vaga de estacionamento exclusiva para idosos')
            )
        ),
        'capacidade' => array(
            'label' => \MapasCulturais\i::__('Capacidade'),
            'validations' => array(
                "v::intVal()->positive()" => \MapasCulturais\i::__("A capacidade deve ser um número positivo.")
            ),
            'available_for_opportunities' => true
        ),

        'endereco' => array(
            'label' => \MapasCulturais\i::__('Endereço'),
            'type' => 'text'
        ),


        'En_CEP' => [
            'label' => \MapasCulturais\i::__('CEP'),
        ],
        'En_Nome_Logradouro' => [
            'label' => \MapasCulturais\i::__('Logradouro'),
        ],
        'En_Num' => [
            'label' => \MapasCulturais\i::__('Número'),
        ],
        'En_Complemento' => [
            'label' => \MapasCulturais\i::__('Complemento'),
        ],
        'En_Bairro' => [
            'label' => \MapasCulturais\i::__('Bairro'),
        ],
        'En_Municipio' => [ // select DISTINCT municipio from public.estabelecimentos order by municipio
            'label' => \MapasCulturais\i::__('Município'),
            'type' => 'select',
            'options' => array(
                "ABAIARA",
                "ACARAPE",
                "ACARAU",
                "ACOPIARA",
                "AIUABA",
                "ALCANTARAS",
                "ALTANEIRA",
                "ALTO SANTO",
                "AMONTADA",
                "ANTONINA DO NORTE",
                "APUIARES",
                "AQUIRAZ",
                "ARACATI",
                "ARACOIABA",
                "ARARENDA",
                "ARARIPE",
                "ARATUBA",
                "ARNEIROZ",
                "ASSARE",
                "AURORA",
                "BAIXIO",
                "BANABUIU",
                "BARBALHA",
                "BARREIRA",
                "BARRO",
                "BARROQUINHA",
                "BATURITE",
                "BEBERIBE",
                "BELA CRUZ",
                "BOA VIAGEM",
                "BREJO SANTO",
                "CAMOCIM",
                "CAMPOS SALES",
                "CANINDE",
                "CAPISTRANO",
                "CARIDADE",
                "CARIRE",
                "CARIRIACU",
                "CARIUS",
                "CARNAUBAL",
                "CASCAVEL",
                "CATARINA",
                "CATUNDA",
                "CAUCAIA",
                "CEDRO",
                "CHAVAL",
                "CHORO",
                "CHOROZINHO",
                "COREAU",
                "CRATEUS",
                "CRATO",
                "CROATA",
                "CRUZ",
                "DEPUTADO IRAPUAN PINHEIRO",
                "ERERE",
                "EUSEBIO",
                "FARIAS BRITO",
                "FORQUILHA",
                "FORTALEZA",
                "FORTIM",
                "FRECHEIRINHA",
                "GENERAL SAMPAIO",
                "GRACA",
                "GRANJA",
                "GRANJEIRO",
                "GROAIRAS",
                "GUAIUBA",
                "GUARACIABA DO NORTE",
                "GUARAMIRANGA",
                "HIDROLANDIA",
                "HORIZONTE",
                "IBARETAMA",
                "IBIAPINA",
                "IBICUITINGA",
                "ICAPUI",
                "ICO",
                "IGUATU",
                "INDEPENDENCIA",
                "IPAPORANGA",
                "IPAUMIRIM",
                "IPU",
                "IPUEIRAS",
                "IRACEMA",
                "IRAUCUBA",
                "ITAICABA",
                "ITAITINGA",
                "ITAPAGE",
                "ITAPIPOCA",
                "ITAPIUNA",
                "ITAREMA",
                "ITATIRA",
                "JAGUARETAMA",
                "JAGUARIBARA",
                "JAGUARIBE",
                "JAGUARUANA",
                "JARDIM",
                "JATI",
                "JIJOCA DE JERICOACOARA",
                "JUAZEIRO DO NORTE",
                "JUCAS",
                "LAVRAS DA MANGABEIRA",
                "LIMOEIRO DO NORTE",
                "MADALENA",
                "MARACANAU",
                "MARANGUAPE",
                "MARCO",
                "MARTINOPOLE",
                "MASSAPE",
                "MAURITI",
                "MERUOCA",
                "MILAGRES",
                "MILHA",
                "MIRAIMA",
                "MISSAO VELHA",
                "MOMBACA",
                "MONSENHOR TABOSA",
                "MORADA NOVA",
                "MORAUJO",
                "MORRINHOS",
                "MUCAMBO",
                "MULUNGU",
                "NOVA OLINDA",
                "NOVA RUSSAS",
                "NOVO ORIENTE",
                "OCARA",
                "OROS",
                "PACAJUS",
                "PACATUBA",
                "PACOTI",
                "PACUJA",
                "PALHANO",
                "PALMACIA",
                "PARACURU",
                "PARAIPABA",
                "PARAMBU",
                "PARAMOTI",
                "PEDRA BRANCA",
                "PENAFORTE",
                "PENTECOSTE",
                "PEREIRO",
                "PINDORETAMA",
                "PIQUET CARNEIRO",
                "PIRES FERREIRA",
                "PORANGA",
                "PORTEIRAS",
                "POTENGI",
                "POTIRETAMA",
                "QUITERIANOPOLIS",
                "QUIXADA",
                "QUIXELO",
                "QUIXERAMOBIM",
                "QUIXERE",
                "REDENCAO",
                "RERIUTABA",
                "RUSSAS",
                "SABOEIRO",
                "SALITRE",
                "SANTANA DO ACARAU",
                "SANTANA DO CARIRI",
                "SANTA QUITERIA",
                "SAO BENEDITO",
                "SAO GONCALO DO AMARANTE",
                "SAO JOAO DO JAGUARIBE",
                "SAO LUIS DO CURU",
                "SENADOR POMPEU",
                "SENADOR SA",
                "SOBRAL",
                "SOLONOPOLE",
                "TABULEIRO DO NORTE",
                "TAMBORIL",
                "TARRAFAS",
                "TAUA",
                "TEJUCUOCA",
                "TIANGUA",
                "TRAIRI",
                "TURURU",
                "UBAJARA",
                "UMARI",
                "UMIRIM",
                "URUBURETAMA",
                "URUOCA",
                "VARJOTA",
                "VARZEA ALEGRE",
                "VICOSA DO CEARA",

            )
        ],
        'En_Estado' => [
            'label' => \MapasCulturais\i::__('Estado'),
            'type' => 'select',
            'options' => array(
                'AC'=>'Acre',
                'AL'=>'Alagoas',
                'AP'=>'Amapá',
                'AM'=>'Amazonas',
                'BA'=>'Bahia',
                'CE'=>'Ceará',
                'DF'=>'Distrito Federal',
                'ES'=>'Espírito Santo',
                'GO'=>'Goiás',
                'MA'=>'Maranhão',
                'MT'=>'Mato Grosso',
                'MS'=>'Mato Grosso do Sul',
                'MG'=>'Minas Gerais',
                'PA'=>'Pará',
                'PB'=>'Paraíba',
                'PR'=>'Paraná',
                'PE'=>'Pernambuco',
                'PI'=>'Piauí',
                'RJ'=>'Rio de Janeiro',
                'RN'=>'Rio Grande do Norte',
                'RS'=>'Rio Grande do Sul',
                'RO'=>'Rondônia',
                'RR'=>'Roraima',
                'SC'=>'Santa Catarina',
                'SP'=>'São Paulo',
                'SE'=>'Sergipe',
                'TO'=>'Tocantins',
            )
        ],

        'horario' => array(
            'label' => \MapasCulturais\i::__('Horário de funcionamento'),
            'type' => 'text',
            'available_for_opportunities' => true
        ),

        'criterios' => array(
            'label' => \MapasCulturais\i::__('Critérios de uso do espaço'),
            'type' => 'text'
        ),

        'site' => array(
            'label' => \MapasCulturais\i::__('Site'),
            'validations' => array(
                "v::url()" => \MapasCulturais\i::__("A url informada é inválida.")
            ),
            'available_for_opportunities' => true
        ),
        'facebook' => array(
            'label' => \MapasCulturais\i::__('Facebook'),
            'validations' => array(
                "v::url('facebook.com')" => \MapasCulturais\i::__("A url informada é inválida.")
            ),
            'available_for_opportunities' => true
        ),
        'twitter' => array(
            'label' => \MapasCulturais\i::__('Twitter'),
            'validations' => array(
                "v::url('twitter.com')" => \MapasCulturais\i::__("A url informada é inválida.")
            ),
            'available_for_opportunities' => true
        ),
        'googleplus' => array(
            'label' => \MapasCulturais\i::__('Google+'),
            'validations' => array(
                "v::url('plus.google.com')" => \MapasCulturais\i::__("A url informada é inválida.")
            )
        ),
        'instagram' => array(
            'label' => \MapasCulturais\i::__('Instagram'),
            'validations' => array(
                "v::startsWith('@')" => \MapasCulturais\i::__("O usuário informado é inválido. Informe no formato @usuario e tente novamente")
            ),
            'available_for_opportunities' => true
        ),
        'instituicao_tipos_unidades' => [
            'label' => \MapasCulturais\i::__('Tipos de unidade'),
            'type' => 'select',
            'options' => $tiposUnidades
        ],
        'instituicao_tipos_gestao' => [
            'label' => \MapasCulturais\i::__('Tipo de gestão'),
            'type' => 'select',
            'options' => $tiposGestao
        ],
        'instituicao_servicos' => [
            'label' => \MapasCulturais\i::__('Serviços'),
            'type' => 'select',
            'options' => $tiposServico
        ],
        'instituicao_cnes' => [
            'label' => \MapasCulturais\i::__('Número CNES')
        ],
    ),

    'items' => array(
        \MapasCulturais\i::__('') => array(
            'range' => array(1,2000),
            'items' => $typeSpaces
        )
    )
);