<?php
/**
 * See https://github.com/Respect/Validation to know how to write validations
 */
use \Saude\Entities\ProfessionalCategory;

$app = MapasCulturais\App::i();
$termsGraus = $app->repo('Term')->findBy(['taxonomy' => 'profissionais_graus_academicos']);
$graus = array_map(function($term) { return $term->term; }, $termsGraus);

$termsCategoria = $app->repo('Term')->findBy(['taxonomy' => 'profissionais_categorias_profissionais']);
$categoriasProfissionais = array_map(function($term) { return $term->term; }, $termsCategoria);

//CATEGORIAS PROFISSIONAIS
$allPro = ProfessionalCategory::allProfessional();

//FORMANDO O ARRAY COM INDICE
$proAll = [];
foreach ($allPro as $key => $value) {
    array_push($proAll, $value['name']);
}

$termsSpecialties = $app->repo('Term')->findBy(['taxonomy' => 'profissionais_especialidades'], ['term' => 'ASC']);
$specialties = array_map(function($term) { return $term->term; }, $termsSpecialties);

$termsSectorOperation = $app->repo('Term')->findBy(['taxonomy' => 'profissionais_setor_atuacao']);
$sectorOperation = array_map(function($term) { return $term->term; }, $termsSectorOperation);

return array(
    'metadata' => array(
        'nomeCompleto' => array(
            'private' => true,
            'label' => \MapasCulturais\i::__('Nome completo ou Razão Social'),
            'validations' => array(
                //'required' => \MapasCulturais\i::__('Seu nome completo ou jurídico deve ser informado.')
            ),
            'available_for_opportunities' => true
        ),

        'documento' => array(
            'private' => true,
            'label' => \MapasCulturais\i::__('CPF ou CNPJ'),
            'validations' => array(
               'v::oneOf(v::cpf(),v::cnpj())' => \MapasCulturais\i::__('O número de documento informado é inválido.')
            ),
            'available_for_opportunities' => true
        ),


        'raca' => array(
            'private' => true,
            'label' => \MapasCulturais\i::__('Raça/cor'),
            'type' => 'select',
            'options' => array(
                '' => \MapasCulturais\i::__('Não Informar'),
                'Branca' => \MapasCulturais\i::__('Branca'),
                'Preta' => \MapasCulturais\i::__('Preta'),
                'Amarela' => \MapasCulturais\i::__('Amarela'),
                'Parda' => \MapasCulturais\i::__('Parda'),
                'Indígena' => \MapasCulturais\i::__('Indígena')
            ),
            'available_for_opportunities' => true
        ),

        'dataDeNascimento' => array(
            'private' => true,
            'label' => \MapasCulturais\i::__('Data de Nascimento/Fundação'),
            'type' => 'date',
            'validations' => array(
                'v::date("Y-m-d")' => \MapasCulturais\i::__('Data inválida').'{{format}}',
            ),
            'available_for_opportunities' => true
        ),

        'localizacao' => array(
            'label' => \MapasCulturais\i::__('Localização'),
            'type' => 'select',
            'options' => array(
                '' => \MapasCulturais\i::__('Não Informar'),
                'Pública' => \MapasCulturais\i::__('Pública'),
                'Privada' => \MapasCulturais\i::__('Privada')
            )
        ),

        'genero' => array(
            'private' => true,
            'label' => \MapasCulturais\i::__('Gênero'),
            'type' => 'select',
            'options' => array(
                '' => \MapasCulturais\i::__('Não Informar'),
                'Mulher Cis' => \MapasCulturais\i::__('Mulher Cis'),
                'Homem Cis' => \MapasCulturais\i::__('Homem Cis'),
                'Mulher Trans/travesti' => \MapasCulturais\i::__('Mulher Trans/travesti'),
                'Homem Trans' => \MapasCulturais\i::__('Homem Trans'),
                'Não Binárie/outra variabilidade' => \MapasCulturais\i::__('Não Binárie/outra variabilidade'),
                'Não declarada' => \MapasCulturais\i::__('Não declarada'),
            ),
            'available_for_opportunities' => true,
            'field_type' => 'select'
        ),

        'orientacaoSexual' => array(
            'private' => true,
            'label' => \MapasCulturais\i::__('Orientação Sexual'),
            'type' => 'select',
            'options' => array(
                '' => \MapasCulturais\i::__('Não Informar'),
                'Heterossexual' => \MapasCulturais\i::__('Heterossexual'),
                'Lésbica' => \MapasCulturais\i::__('Lésbica'),
                'Gay' => \MapasCulturais\i::__('Gay'),
                'Bissexual' => \MapasCulturais\i::__('Bissexual'),
                'Assexual' => \MapasCulturais\i::__('Assexual'),
                'Outras' => \MapasCulturais\i::__('Outras')
            ),
            'available_for_opportunities' => true
        ),
        
        'emailPublico' => array(
            'label' => \MapasCulturais\i::__('Email Público'),
            'validations' => array(
                'v::email()' => \MapasCulturais\i::__('O endereço informado não é email válido.')
            ),
            'available_for_opportunities' => true,
            'field_type' => 'email'
        ),

        'emailPrivado' => array(
            'private' => true,
            'label' => \MapasCulturais\i::__('Email Privado'),
            'validations' => array(
                //'required' => \MapasCulturais\i::__('O email privado é obrigatório.'),
                'v::email()' => \MapasCulturais\i::__('O endereço informado não é um email válido.')
            ),
            'available_for_opportunities' => true,
            'field_type' => 'email'
        ),

        'telefonePublico' => array(
            'label' => \MapasCulturais\i::__('Telefone Público'),
            'type' => 'string',
            /*'validations' => array(
                'v::brPhone()' => \MapasCulturais\i::__('O número de telefone informado é inválido.')
            ),*/
            'available_for_opportunities' => true,
           // 'field_type' => 'brPhone'
        ),

        'curriculoLattes' => array(
            'label' => \MapasCulturais\i::__('Cole o link aqui'),
            'type' => 'string',
            'validations' => array(
                "v::url()" => \MapasCulturais\i::__("A url informada é inválida.")
            )
        ),

        'telefone1' => array(
            'private' => true,
            'label' => \MapasCulturais\i::__('Telefone 1'),
            'type' => 'string',
            /*'validations' => array(
                'v::brPhone()' => \MapasCulturais\i::__('O número de telefone informado é inválido.')
            ),*/
            'available_for_opportunities' => true,
            //'field_type' => 'brPhone'
        ),


        'telefone2' => array(
            'private' => true,
            'label' => \MapasCulturais\i::__('Telefone 2'),
            'type' => 'string',
           /* 'validations' => array(
                'v::brPhone()' => \MapasCulturais\i::__('O número de telefone informado é inválido.')
            ),*/
            'available_for_opportunities' => true,
            //'field_type' => 'brPhone'
        ),

        'endereco' => array(
            'private' => function(){
                return !$this->publicLocation;
            },
            'label' => \MapasCulturais\i::__('Endereço'),
            'type' => 'text'
        ),
                    
        'En_CEP' => [
            'label' => \MapasCulturais\i::__('CEP'),
            'private' => function(){
                return !$this->publicLocation;
            },
        ],
        'En_Nome_Logradouro' => [
            'label' => \MapasCulturais\i::__('Logradouro'),
            'private' => function(){
                return !$this->publicLocation;
            },
        ],
        'En_Num' => [
            'label' => \MapasCulturais\i::__('Número'),
            'private' => function(){
                return !$this->publicLocation;
            },
        ],
        'En_Complemento' => [
            'label' => \MapasCulturais\i::__('Complemento'),
            'private' => function(){
                return !$this->publicLocation;
            },
        ],
        'En_Bairro' => [
            'label' => \MapasCulturais\i::__('Bairro'),
            'private' => function(){
                return !$this->publicLocation;
            },
        ],
        'En_Municipio' => [ // select DISTINCT municipio from public.estabelecimentos order by municipio
            'label' => \MapasCulturais\i::__('Município'),
            'type' => 'select',
            'private' => function(){
                return !$this->publicLocation;
            },
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
            'private' => function(){
                return !$this->publicLocation;
            },
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
        'En_Pais' => [
            'label' => \MapasCulturais\i::__('País'),
            'type' => 'select',
            'options' => [
                'AD' => 'Andorra',
                'AR' => 'Argentina',
                'BO' => 'Bolivia',
                'BR' => 'Brasil',
                'CL' => 'Chile',
                'CO' => 'Colombia',
                'CR' => 'Costa Rica',
                'CU' => 'Cuba',
                'EC' => 'Ecuador',
                'SV' => 'El Salvador',
                'ES' => 'España',
                'GT' => 'Guatemala',
                'HN' => 'Honduras',
                'MX' => 'México',
                'NI' => 'Nicarágua',
                'PA' => 'Panamá',
                'PY' => 'Paraguay',
                'PE' => 'Perú',
                'PT' => 'Portugal',
                'DO' => 'República Dominicana',
                'UY' => 'Uruguay',
                'VE' => 'Venezuela',
            ]
        ],

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
        // 'googleplus' => array(
        //     'label' => \MapasCulturais\i::__('Google+'),
        //     'validations' => array(
        //         "v::url('plus.google.com')" => \MapasCulturais\i::__("A url informada é inválida.")
        //     ),
        //     'available_for_opportunities' => true
        // ),
        'instagram' => array(
            'label' => \MapasCulturais\i::__('Instagram'),
            'validations' => array(
                "v::startsWith('@')" => \MapasCulturais\i::__("O usuário informado é inválido. Informe no formato @usuario e tente novamente")
            ),
            'available_for_opportunities' => true
        ),
        #NO DB profissionais_graus_academicos
        'profissionais_graus_academicos' => [
            'label' => \MapasCulturais\i::__('Grau académico'),
            'type' => 'select',
            'options' => $graus
        ],
        #NO DB profissionais_categorias_profissionais
        'profissionais_categorias_profissionais' => [
            'label' => \MapasCulturais\i::__('Categoria profissional'),
            'type' => 'select',
            'options' => $proAll
        ],
        #NO DB profissionais_especialidades
        'profissionais_especialidades' => [
            'label' => \MapasCulturais\i::__('Especialidades'),
            'type' => 'select',
            'options' => $specialties 
        ],
        #NO DB profissionais_especialidades
        'profissionais_setor_atuacao' => [
            'label' => \MapasCulturais\i::__('Selecione'),
            'type' => 'multiselect',
            'allowOther' => true,
            'allowOtherText' => \MapasCulturais\i::__('Outros'),
            'options' => $sectorOperation
        ],
    ),
    'items' => array(
        1 => array( 'name' => \MapasCulturais\i::__('Individual' )),
        2 => array( 'name' => \MapasCulturais\i::__('Coletivo') ),
    )
);
