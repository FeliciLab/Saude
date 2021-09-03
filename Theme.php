<?php
namespace Saude;

use MapasCulturais\Themes\BaseV1;
use MapasCulturais\App;
use MapasCulturais\Entities;
use MapasCulturais\Definitions;
use MapasCulturais\i;

class Theme extends BaseV1\Theme{

    protected static function _getTexts(){
        $self = App::i()->view;

        return array(
            'site: of the region' => 'do estado de Ceará',
            'site: by the site owner' => 'pela Escola de saúde pública do Ceará',

            'home: welcome' => "O Mapa da Saúde é um software livre, gratuito e construído de modo colaborativo, implementado pela Escola de Saúde Pública do Ceará (ESP-CE). Integra dados de diferentes sistemas, serviços e recursos para melhor subsidiar a sociedade e os governos sobre o setor de saúde do Estado do Ceará, trazendo informações sobre os profissionais, os serviços e os sistemas relacionados à Escola. Para saber mais e colaborar na gestão estadual, basta criar seu perfil.
            ",
            /*'home: events' => "Você pode pesquisar eventos culturais da cidade nos campos de busca combinada. Como usuário cadastrado, você pode incluir seus eventos na plataforma e divulgá-los gratuitamente.",*/
            'home: agents' => "Você pode colaborar na gestão da saúde da cidade com suas próprias informações, preenchendo seu perfil de ator de mudança. Neste espaço, estão registrados profissionais, gestores e instituições; uma rede de atores envolvidos no cenário de saúde. Você pode cadastrar um ou mais informes, além de associar ao seu perfil eventos e espaços de com divulgação gratuita.",
            'home: spaces' => "Procure por espaços culturais incluídos na plataforma, acessando os campos de busca combinada que ajudam na precisão de sua pesquisa. Cadastre também os espaços onde desenvolve suas atividades artísticas e culturais na cidade.",
            'home: projects' => "Reúne os projetos ou agrupa os eventos de todos os tipos executados pela escola. Neste espaço, você encontra leis de fomento, mostras, convocatórias e editais criado pela Escola de Saúde Pública-CE, além de diversas iniciativas cadastradas pelos usuários da plataforma. Cadastre-se e divulgue seus projetos.",
            'home: opportunities' => "Faça a sua inscrição ou acesse o resultado de diversas convocatórias como editais, oficinas, prêmios e concursos. Você também pode criar o seu próprio formulário e divulgar uma oportunidade para outros atores de mudança.",
            'home: colabore' => "Colabore com o Mapa da Saúde",

            'home: abbreviation' => "ESP-CE",
            'home: home_devs' => 'Existem algumas maneiras de desenvolvedores interagirem com o Mapa de Saúde. A primeira é através da nossa  <a href="https://github.com/hacklabr/mapasculturais/blob/master/documentation/docs/mc_config_api.md" target="_blank">API</a>. 
            Com ela você pode acessar os dados públicos no nosso banco de dados e utilizá-los para desenvolver aplicações externas. Além disso, o Mapa da Saúde é construído a partir do software livre, recebendo contribuição para o seu desenvolvimento através do <a href="https://github.com/hacklabr/mapasculturais/" target="_blank">GitHub</a>.',

            'search: verified results' => 'Resultados da ESP-CE',
            'search: verified' => "ESP-CE"
        );
    }

    static function getThemeFolder() {
        return __DIR__;
    }

    function _init() {
        parent::_init();
        $app = App::i();
        //$this->jsObject['angularAppDependencies'][] = 'taxonomies';
        $app->hook('view.render(<<*>>):before', function() use($app) {
            $this->_publishAssets();
        });
        //ADICIONANDO SOMENTE QUANDO FOR UMA ROTA DO TIPO DE EDIÇÃO
        $app->hook("template(<<*>>.edit.tabs):end", function() use($app){
            $app->view->enqueueScript('app', 'resources-meta', 'js/resources-meta.js');
        });
       
        $app->hook('GET(opportunity.evaluationCandidate)', function() use($app){
            $app = App::i();
            
            $regis = $app->repo('Registration')->findBy(
                [
                'owner' => $this->getData['idAgent'] , 
                'opportunity' => $this->getData['opportunity']
                ]);
            empty($regis) ? $this->json(['message' => true]) : $this->json(['message' => false]);
        });
        
        $app->hook('POST(opportunity.setStatus)', function() use($app) { 
            //$plugin = $app->plugins['EvaluationMethodTechnical'];
            try {
                $dql = "UPDATE MapasCulturais\Entities\Registration r 
                SET r.status = 10 WHERE r.opportunity = {$this->postData['opportunity']} AND r.status = 1";
                $query      = $app->em->createQuery($dql);
                $upStatus   = $query->getResult();
                $this->json(['message' => 'Total de registro alterado: '.$upStatus], 200);
 
            } catch (Exception $th) {
                $this->json(['message' => $th->getMessage()], 500);
            }
        });

         /**
         * Verifica a nota minima da oportunidade e altera as inscrições com a mudança do status
         */
        $app->hook('POST(opportunity.minimumNote)', function() use($app) {
            $opportunity = $app->repo('Opportunity')->find($this->postData['id']);
            //MUDARÁ O STATUS EM CASO DA AVALIAÇAO SER TÉCNICA
            if($opportunity->evaluationMethodConfiguration->getDefinition()->slug == 'technical') {
                $setStatus = self::setStatusOwnerOpportunity($this->postData['id'], $opportunity->metadata['registrationMinimumNote']);
                echo $setStatus;
            }
        });
    }

    public static function setStatusOwnerOpportunity($opportunity, $note) {
        $app = App::i();
        $notaMedia = intval($note);

        if(!empty($note) && $notaMedia >= 0 ) {
            try {
                // ALTERANDO CANDIDATOS COM NOTA IGUAL OU SUPERIOR A NOTA MINIMA DA OPORTUNIDADE
                $dql = "SELECT r FROM MapasCulturais\Entities\Registration r 
                WHERE r.opportunity = {$opportunity} AND r.consolidatedResult >= '{$notaMedia}'";
                $query      = $app->em->createQuery($dql);
                $upStatus   = $query->getResult();
                //dump($upStatus);
                foreach ($upStatus as $key => $value) {
                    $dql = "";
                    if(!$value->opportunity->publishedRegistrations) {
                    $dql = "UPDATE MapasCulturais\Entities\Registration r 
                        SET r.status = 10 WHERE r.id = {$value->id}";
                    }
                    $query      = $app->em->createQuery($dql);
                    $upStatus   = $query->getResult();
                }
                return json_encode(['message' => 'Alterado status de candidatos nota igual ou maior que a média', 'status' => 200, 'type' => 'success']);
            } catch (\Throwable $th) {
                return json_encode(['message' => 'error', 'status' => 500]);
            }

            //NOTA ABAIXO DA NOTA MINIMA
            try {
                $dql = "SELECT r FROM MapasCulturais\Entities\Registration r 
                WHERE r.opportunity = {$opportunity} AND r.consolidatedResult < '{$notaMedia}'";
                $query      = $app->em->createQuery($dql);
                $minimum   = $query->getResult();
                //dump($minimum);
                foreach ($minimum as $key => $value) {
                    $dql = "";
                    if(!$value->opportunity->publishedRegistrations) {
                        $dql = "UPDATE MapasCulturais\Entities\Registration r 
                        SET r.status = 1 WHERE r.id = {$value->id}";
                    }else {
                        $dql = "UPDATE MapasCulturais\Entities\Registration r 
                        SET r.status = 1 WHERE r.id = {$value->id}";
                    }
                    $query      = $app->em->createQuery($dql);
                    $upStatus   = $query->getResult();
                }
                return json_encode(['message' => 'Status de candidato alterado, mas com nota a baixo da média', 'status' => 200, 'type' => 'success']);
            } catch (\Throwable $th) {
                return json_encode(['message' => 'error', 'status' => 500]);
            }
        }
        return json_encode(['message' => 'Não foi alterado status com base em nota por que não tem nota média.', 'status' => 200, 'type' => 'success']);
    }
    
    protected function _publishAssets() {
        $app = App::i();
        $app->view->enqueueStyle('app', 'fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css');

        $app->view->enqueueScript('app', 'entity.module.opportunity', 'js/ng.entity.module.opportunity.js', array('ng-mapasculturais'));
        $app->view->enqueueScript('app', 'taxonomies', 'js/ng.taxonomies.js');
        $app->view->enqueueScript('app', 'evaluations-send', 'js/evaluations-send.js');
        $app->view->enqueueScript('app', 'professional.category', 'js/ng.professional.category.js');
        $app->view->enqueueScript('app', 'category.meta', 'js/ng.category.meta.js');
        //RECURSOS
        $app->view->enqueueScript('app', 'resource', 'js/ng.resource.js');
        
        //alertas
        $app->view->enqueueStyle('app', 'pnotify', 'css/pnotify.css');
        $app->view->enqueueStyle('app', 'pnotify.brighttheme', 'css/pnotify.brighttheme.css');
        $app->view->enqueueStyle('app', 'pnotify.buttons', 'css/pnotify.buttons.css');
        $app->view->enqueueScript('app', 'pnotify', 'js/pnotify.js');
        $app->view->enqueueScript('app', 'pnotify.buttons', 'js/pnotify.buttons.js');
        $app->view->enqueueScript('app', 'pnotify.confirm', 'js/pnotify.confirm.js');
        //Query Modal
        $app->view->enqueueStyle('app', 'jqueryModal', 'css/remodal.css');
        $app->view->enqueueStyle('app', 'jqueryModal-theme', 'css/remodal-default-theme.css');
        $app->view->enqueueScript('app', 'jqueryModal', 'js/remodal.min.js');
        
    }

    function getAddressByPostalCode($postalCode) {
        $app = App::i();
        if ($app->config['cep.token']) {
            $cep = str_replace('-', '', $postalCode);
            // $url = 'http://www.cepaberto.com/api/v2/ceps.json?cep=' . $cep;
            $url = sprintf($app->config['cep.endpoint'], $cep);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            if ($app->config['cep.token_header']) {
                // curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Token token="' . $app->config['cep.token'] . '"'));
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(sprintf($app->config['cep.token_header'], $app->config['cep.token'])));
            }
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $output = curl_exec($ch);
            $json = json_decode($output);
            
            if (isset($json->cep)) {
                $response = [
                    'success' => true,
                    'lat' => @$json->latitude,
                    'lon' => @$json->longitude,
                    'streetName' => @$json->logradouro,
                    'neighborhood' => @$json->bairro,
                    'city' => @$json->cidade,
                    'state' => @$json->estado
                ];

            } else {
                $response = [
                    'success' => false,
                    'error_msg' => 'Falha ao buscar o endereço'
                ];
            }
        } else {
            $response = [
                'success' => false,
                'error_msg' => 'No token for CEP'
            ];
        }

        return $response;
    }

    function register() {
        parent::register();
        
        $app = App::i();
        $app->registerAuthProvider('keycloak');
        $app->registerController('taxonomias', 'Saude\Controllers\Taxonomias');
        $app->registerController('recursos', 'Saude\Controllers\Resources');
        // $app->registerController('panel',   'Saude\Controllers\Panel');
        $app->registerController('categoria-profissional', 'Saude\Controllers\ProfessionalCategory');
    }
    


    protected function _getFilters(){
        $filters = [
            'space' => [
                'En_Municipio' => [
                    'label' => i::__('Municípios'),
                    'placeholder' => i::__('Municípios'),
                    'type' => 'metadata',
                    'filter' => [
                        'param' => 'En_Municipio',
                        'value' => 'IN({val})'
                    ]
                ],
                'instituicao_tipos_unidades' => [
                    'label' => i::__('Tipos de unidade'),
                    'placeholder' => i::__('Tipo de unidade'),
                    'type' => 'metadata',
                    'filter' => [
                        'param' => 'instituicao_tipos_unidades',
                        'value' => 'like(%{val}%)'
                    ]
                ],
                'instituicao_servicos' => [
                    'label' => i::__('Serviços'),
                    'placeholder' => i::__('Serviços'),
                    'type' => 'metadata',
                    'filter' => [
                        'param' => 'instituicao_servicos',
                        'value' => 'like(*{val}*)'
                    ]
                ],
            ],
            'agent' => [
                'profissionais_graus_academicos' => [
                    'label' => i::__('Grau acadêmico'),
                    'placeholder' => i::__('Grau acadêmico'),
                    'type' => 'metadata',
                    'filter' => [
                        'param' => 'profissionais_graus_academicos',
                        'value' => 'IN({val})'
                    ]
                ],
                'profissionais_categorias_profissionais' => [
                    'label' => i::__('Categorias profissionais'),
                    'placeholder' => i::__('Categorias profissionais'),
                    'type' => 'metadata',
                    'filter' => [
                        'param' => 'profissionais_categorias_profissionais',
                        'value' => 'IN({val})'
                    ]
                ],
                'profissionais_especialidades' => [
                    'label' => i::__('Especialidades'),
                    'placeholder' => i::__('Especialidades'),
                    'type' => 'metadata',
                    'filter' => [
                        'param' => 'profissionais_especialidades',
                        'value' => 'IN({val})'
                    ]
                ],
            ],
            'event' => [
            ],
            'project' => [
                'inscricoes' => [
                    'label' => i::__('Inscrições Abertas'),
                    'fieldType' => 'custom.project.ropen'
                ],
                'verificados' => [
                    'label' => $this->dict('search: verified results', false),
                    'tag' => $this->dict('search: verified', false),
                    'placeholder' => $this->dict('search: display only verified results', false),
                    'fieldType' => 'checkbox-verified',
                    'addClass' => 'verified-filter',
                    'isArray' => false,
                    'filter' => [
                        'param' => '@verified',
                        'value' => 'IN(1)'
                    ]
                ]
            ],
            'opportunity' => [
                'inscricoes' => [
                    'label' => i::__('Inscrições Abertas'),
                    'fieldType' => 'custom.opportunity.ropen'
                ],
                'verificados' => [
                    'label' => $this->dict('search: verified results', false),
                    'tag' => $this->dict('search: verified', false),
                    'placeholder' => $this->dict('search: display only verified results', false),
                    'fieldType' => 'checkbox-verified',
                    'addClass' => 'verified-filter',
                    'isArray' => false,
                    'filter' => [
                        'param' => '@verified',
                        'value' => 'IN(1)'
                    ]
                ]
            ]
        ];

        
        App::i()->applyHookBoundTo($this, 'search.filters', [&$filters]);

        return $filters;
    }

}


