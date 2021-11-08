<?php
namespace Saude;

use Exception;
use MapasCulturais\Themes\BaseV1;
use MapasCulturais\App;
use MapasCulturais\Entities;
use MapasCulturais\Definitions;
use MapasCulturais\i;
USE MapasCulturais\Entities\Registration;
USE MapasCulturais\Entities\Opportunity;

class Theme extends BaseV1\Theme{

    protected static function _getTexts(){
        $self = App::i()->view;

        return array(
                        
            'site: of the region' => 'do estado de Ceará',
            'site: by the site owner' => 'pela Escola de saúde pública do Ceará',

            'home: title' => "Bem Vindes!",

            'home: welcome' => "<div class='font-style'>O <b class='b-home'>Mapa da Saúde</b> é uma solução aberta para governança colaborativa, desenvolvida pela <a href='https://www.esp.ce.gov.br/' target='blank'>Escola de Saúde Pública do  Ceará</a>, através do <a href='https://sus.ce.gov.br/felicilab/' target='blank'>Felicilab</a>.</br></br>
            <p>A plataforma estrutura uma política digital de relacionamento e gestão de informações, integrando dados de diferentes sistemas e serviços, oferecendo à cidadania e aos governos um importante instrumento de apoio, avaliação e qualificação da <b class='b-home'>Força de Trabalho do SUS</b>.</br>
            <p>No Mapa, é possível encontrar e inserir informações sobre profissionais (pessoas gestoras e trabalhadoras), eventos (oficiais e comunitários), espaços (públicos e privados), além de indicadores e inscrições em diferentes oportunidades na área da saúde no Ceará.</br> 
            <p>Crie seu perfil e colabore com a transformação digital do SUS!
            </div>
            
            ",
            /*'home: events' => "Você pode pesquisar eventos culturais da cidade nos campos de busca combinada. Como usuário cadastrado, você pode incluir seus eventos na plataforma e divulgá-los gratuitamente.",*/
            'home: agents' => "<div class='font-style'>Se você é uma pessoa trabalhadora ou gestora da saúde em seu município, pode criar seu perfil e fazer a gestão da informação que você conhece e produz.</br></br>
            <p>Tornando-se um agente, você fortalece a transparência e o diálogo com sua comunidade e colabora com a transformação da saúde de sua cidade ou região.</br>
            <p>Aqui é possível cadastrar sua instituição, vincular seu perfil aos espaços nos quais você trabalha, divulgar e participar de oportunidades, tais como eventos e editais de projetos vinculados à Escola de Saúde Pública do Ceará.</div>
            ",
            'home: spaces' => "<div class='font-style'>No Mapa da Saúde já estão disponíveis todas as unidades do Ceará, presentes no <a href='https://mapa.sus.ce.gov.br/selo/id:1/#/tab=sobre' target='blank'>Cadastro Nacional de Estabelecimentos de Saúde (CNES)</a>.</br></br>
            <p>Para encontrá-las, diga onde e o que busca, através dos campos de busca combinada, que ajudam na precisão de sua pesquisa.</br>
            <p>Cadastre também os espaços nos quais desenvolve suas atividades em saúde, na capital ou no interior.</br>
            <p>E lembrando: como agente, você que é profissional de saúde poderá também vincular o seu perfil às unidades já cadastradas. </div>
            ",
            /*'home: opportunities' => "Faça a sua inscrição ou acesse o resultado de diversas convocatórias como editais, oficinas, prêmios e concursos. Você também pode criar o seu próprio formulário e divulgar uma oportunidade para outros atores de mudança.",*/
            'home: colabore' => "Colabore com o Mapa da Saúde",

            'home: abbreviation' => "ESP-CE",
            'home: home_devs' => "<div class='font-style'>
            <p>O Mapa da Saúde é uma das ações da Rede de Inovação Aberta no SUS, que estão sendo realizadas para promover o controle social, garantir a transparência e viabilizar a colaboração em rede.</br>
            <p>Se você é uma pessoa desenvolvedora e deseja interagir com o Mapa, basta acessar nosso repositório no <a href='https://github.com/EscolaDeSaudePublica/mapadasaude' target='blank'>GitHub</a> e fazer parte do grupo no <a href='https://t.me/joinchat/WCYOkjUEcYZ0mu1i' target='blank'>Telegram</a>.</div>",

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
        //CHAMADA DO TEMPLATE DE RECURSOS 
        $app->hook('view.partial(claim-configuration).params', function($__data, &$__template){
            $__template = 'singles/opportunity-resources--form';
        });

        $app->hook("template(registration.view.registration-save-button):begin", function() use($app){
            $app->view->enqueueStyle('app', 'novo', 'css/registration-button-save-style.css');
            $this->part('singles/button/registration-save--button');
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

        $app->hook('controller(registration).saveEvaluationValidate', function($registration) use($app) {
            $evaluation_type = $registration->getEvaluationMethodDefinition()->slug;
            if ($evaluation_type == 'technical') {
                $cfg = $registration->getEvaluationMethodConfiguration();
                foreach($cfg->criteria as $cri){
                    $key = $cri->id;
                    if(isset($this->postData['data']["{$key}"]) && $this->postData['data']["{$key}"] > $cri->max) {
                        return $this->json(['message' => "O valor do campo ".$cri->title." é maior que a pontuação máxima permitida", 'status' => 'error'], 403);
                    }
                }
            }           
        });

        /**
         * Adiciona campos de configurações para envio de e-mail
         */
        $app->hook('view.partial(singles/opportunity-registrations--fields):after', function () {
            $entity = $this->controller->requestedEntity;
            $this->part('singles/opportunity-field-mail-confirm.php', ['entity' => $entity]);
        });  

        /**
         * Ao finalizar o envio das inscrições é enviado um email
         */
        $app->hook('entity(Registration).send:after', function () use ($app) {
            $registration = $this;

            if ($registration->opportunity->mailTitleSendConfirm && $registration->opportunity->mailDescriptionSendConfirm) {
                $template = 'registration_confirm_custom';

                $dataValue = [
                    'mailDescriptionSendConfirm' => $registration->opportunity->mailDescriptionSendConfirm,
                    'number' => $registration->number,
                    'opportunity' => $registration->opportunity->name
                ];

                $subject = $registration->opportunity->mailTitleSendConfirm;

            } else {
                $template = 'registration_confirm_default';

                $dataValue = [
                    'name' => $registration->owner->name,
                    'number' => $registration->number,
                    'opportunity' => $registration->opportunity->name
                ];
                $subject = 'Confirmação de inscrição - ' . "#{$dataValue['number']}";
            }

            $message = $app->renderMailerTemplate($template, $dataValue);

            $app->createAndSendMailMessage([
                'from' => $app->config['mailer.from'],
                'to' => $registration->owner->user->email,
                'bcc' => $registration->opportunity->owner->user->email,
                'subject' => $subject,
                'body' => $message['body']
            ]);          
        });      
    }

    public static function setStatusOwnerOpportunity($opportunity, $note) {
        $app = App::i();
        $notaMedia = intval($note);

        $opportunityRepo = $app->repo('Opportunity')->find($opportunity);

        if ($opportunityRepo->publishedRegistrations) {
            return json_encode(['message' => 'Não foi possível alterar a situação de inscrição, pois a oportunidade já foi publicada.', 'status' => 200, 'type' => 'success']);
        }

        if (empty($note)) {
            return json_encode(['message' => 'Avaliação para a oportunidade não contém nota mínima', 'status' => 200, 'type' => 'success']);
        }

        try {
            $dql = "SELECT r FROM MapasCulturais\Entities\Registration r 
            WHERE r.opportunity = {$opportunity}";
            $query      = $app->em->createQuery($dql);
            $upStatus   = $query->getResult();
            foreach ($upStatus as $key => $value) {
                $dql = "";
                $newState = Registration::STATUS_ENABLED;
                if ($value->consolidatedResult >= $notaMedia) {
                    $newState = Registration::STATUS_APPROVED;
                } else {
                    $newState = Registration::STATUS_NOTAPPROVED;
                }      
                                    
                $dql = "UPDATE MapasCulturais\Entities\Registration r SET r.status = {$newState} WHERE r.id = {$value->id}";
                $query      = $app->em->createQuery($dql);
                $upStatus   = $query->getResult();
            
            }
            return json_encode(['message' => 'Atualização de status dos candidatos realizada com sucesso.', 'status' => 200, 'type' => 'success']);
        } catch (\Throwable $th) {
            return json_encode(['message' => 'error', 'status' => $th->getMessage()]);
        }
    
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
        
        $this->registerOpportunityMetadata('mailTitleSendConfirm', [
            'label' => 'Título do e-mail',
            'type' => 'text'
        ]);

        $this->registerOpportunityMetadata('mailDescriptionSendConfirm', [
            'label' => 'Descrição do e-mail',
            'type' => 'text'
        ]);       

        $app = App::i();
        $app->registerAuthProvider('keycloak');
        $app->registerController('taxonomias', 'Saude\Controllers\Taxonomias');
        $app->registerController('recursos', 'Saude\Controllers\Resources');
        // $app->registerController('panel',   'Saude\Controllers\Panel');
        $app->registerController('categoria-profissional', 'Saude\Controllers\ProfessionalCategory');
        $app->registerController('indicadores', 'Saude\Controllers\Indicadores');
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
                        'value' => 'like({val}%)'
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
                    'placeholder' => i::__('São exibidas apenas as seleções da ESP'),
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

    public function getLoginLinkAttributes() {
        $link_attributes = parent::getLoginLinkAttributes();
        if($this->controller->id=='indicadores'){
            $app = \MapasCulturais\App::i();
            $loginURL = $app->createUrl('panel');
            $link_attributes = 'href="'. $loginURL .'"';  
        }
        return $link_attributes;
    }

}


