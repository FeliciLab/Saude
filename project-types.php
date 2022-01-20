<?php
/**
 * See https://github.com/Respect/Validation to know how to write validations
 */
$app = MapasCulturais\App::i();
$termsProjeto = $app->repo('Term')->findBy(['taxonomy' => 'opportunity_taxonomia']);
$taxoProjetos = array_map(function($term) { return $term->term; }, $termsProjeto);

$taxoProjectType = $app->repo('Term')->findBy(['taxonomy' => 'project_type']);
$typeProject = [];
$new = "";
$indice = 0;
foreach ($taxoProjectType as $key => $value) {
    //$indice = ($indice + 1);
    $indice = $value->id;
    //PREENCHENDO O VALOR QUE É RETORNADO DO BANCO
    $new = $value->term;
    //EXCLUINDO O INDICE
    unset($chave);
    //INSERINDO UM NOVO ARRAY NO FINAL DO ARRAY
    $typeProject[$indice] = ['name' => $new];//array iniciando com indice 1
    //array iniciando com indice 0
    //array_push($typeProject, ['name' => $new]);
}
return array(
    'metadata' => array(
        'site' => array(
            'label' => \MapasCulturais\i::__('Site'),
            'validations' => array(
                "v::url()" => \MapasCulturais\i::__("A url informada é inválida.")
            )
        ),

        'facebook' => array(
            'label' => \MapasCulturais\i::__('Facebook'),
            'validations' => array(
                "v::url('facebook.com')" => \MapasCulturais\i::__("A url informada é inválida.")
            )
        ),
        'twitter' => array(
            'label' => \MapasCulturais\i::__('Twitter'),
            'validations' => array(
                "v::url('twitter.com')" => \MapasCulturais\i::__("A url informada é inválida.")
            )
        ),
        // 'googleplus' => array(
        //     'label' => \MapasCulturais\i::__('Google+'),
        //     'validations' => array(
        //         "v::url('plus.google.com')" => \MapasCulturais\i::__("A url informada é inválida.")
        //     )
        // ),

        'instagram' => array(
            'label' => \MapasCulturais\i::__('Instagram'),
            'validations' => array(
                "v::startsWith('@')" => \MapasCulturais\i::__("O usuário informado é inválido. Informe no formato @usuario e tente novamente")
            )
        ),

        'registrationSeals' => array(
                'label' => \MapasCulturais\i::__('Selos'),
                'serialize' => function($value) { return json_encode($value); },
                'unserialize' => function($value) { return json_decode($value); }
        ),
        'useSpaceRelation' => array(
            'label' => \MapasCulturais\i::__('Espaço Relacionado'),
            'type' => 'select',
            'options' => array(
                'dontUse' => \MapasCulturais\i::__('Não utilizar'),
                'required' => \MapasCulturais\i::__('Obrigatório'),
                'optional' => \MapasCulturais\i::__('Opcional')
            )
        ),
        #NO DB project_taxonomia
        'project_taxonomia' => [
            'label' => \MapasCulturais\i::__('Selecione'),
            'type' => 'select',
            'options' => $taxoProjetos
        ],


    ),
    'items' => $typeProject
    /* EXEMPLOS DE METADADOS:

    'cnpj' => array(
        'label' => 'CNPJ',
        'type' => 'text',
        'validations' => array(
            'unique' => 'Este CNPJ já está cadastrado em nosso sistema.',
            'v::cnpj()' => 'O CNPJ é inválido.'
        )
    ),
    'cpf' => array(
        'label' => 'CPF',
        'type' => 'text',
        'validations' => array(
            'required' => 'Por favor, informe o CPF.',
            'v::cpf()' => 'O CPF é inválido.'
        )
    ),
    'radio' => array(
        'label' => 'Um exemplo de input radio',
        'type' => 'radio',
        'options' => array(
            'valor1' => 'Label do valor 1',
            'valor2' => 'Label do valor 2',
        ),
        'default_value' => 'valor1'
    ),
    'checkboxes' => array(
        'label' => 'Um exemplo de grupo de checkboxes',
        'type' => 'checkboxes',
        'options' => array(
            'valor1' => 'Label do Primeiro checkbox',
            'valor2' => 'Label do Primeiro checkbox'
        ),
        'default_value' => array(),
        'validations' => array(
            'v::arrayType()->notEmpty()' => 'Você deve marcar ao menos uma opção.'
        )
    ),
    'checkbox' => array(
        'label' => 'Um exemplo de campo booleano com checkbox.',
        'type' => 'checkbox',
        'input_value' => 1,
        'default_value' => 0
    ),
    'email' => array(
        'label' => 'Email público para contato',
        'type' => 'text',
        'validations'=> array(
            'v::email()' => 'O email informado é inválido.'
        )
    ),
    'site' => array(
        'label' => 'Site',
        'type' => 'text',
        'validations'=> array(
            'v::url()' => 'A URL informada é inválida.'
        )
    ),
    'estado' => array(
        'label' => 'Estado de Residência',
        'type' => 'select',
        'options' => array(
            ''   => '',
            'AC' => 'Acre',
            'AL' => 'Alagoas',
            'AM' => 'Amazonas',
            'AP' => 'Amapá',
            'BA' => 'Bahia',
            'CE' => 'Ceará',
            'DF' => 'Distrito Federal',
            'ES' => 'Espírito Santo',
            'GO' => 'Goiás',
            'MA' => 'Maranhão',
            'MG' => 'Minas Gerais',
            'MS' => 'Mato Grosso do Sul',
            'MT' => 'Mato Grosso',
            'PA' => 'Pará',
            'PB' => 'Paraíba',
            'PE' => 'Pernambuco',
            'PI' => 'Piauí',
            'PR' => 'Paraná',
            'RJ' => 'Rio de Janeiro',
            'RN' => 'Rio Grande do Norte',
            'RO' => 'Rondônia',
            'RR' => 'Roraima',
            'RS' => 'Rio Grande do Sul',
            'SC' => 'Santa Catarina',
            'SE' => 'Sergipe',
            'SP' => 'São Paulo',
            'TO' => 'Tocantins',
            ''   => '',
            'OUT'   => 'Resido Fora do Brasil'
        ),

        'validations' => array(
            "v::stringType()->in('AC','AL','AM','AP','BA','CE','DF','ES','GO','MA','MG','MS','MT','PA','PB','PE','PI','PR','RJ','RN','RO','RR','RS','SC','SE','SP','TO','OUT')" => 'O estado informado não existe.'
        )
    )
     */
);
