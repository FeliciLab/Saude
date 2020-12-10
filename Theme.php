<?php
namespace Saude;

use MapasCulturais\Themes\BaseV1;
use MapasCulturais\App;

use MapasCulturais\i;

class Theme extends BaseV1\Theme{

    protected static function _getTexts(){
        $self = App::i()->view;

        return array(
            'site: of the region' => 'do estado de Ceará',
            'site: by the site owner' => 'pela Escola de saúde pública do Ceará',

            'home: welcome' => "O Mapa da Saúde é um software livre, gratuito e colaborativo implementado pela Escola de Saúde Pública (ESP-CE). No qual, abrange informações   de diferentes sistemas, serviços e recursos para melhor informar e integrar a sociedade e os governos sobre o quadro de saúde do Estado do Ceará, trazendo dados sobre os profissionais, os serviços e os sistema relacionados a escola. Para conferir mais e colaborar na gestão estadual, basta criar seu perfil.",
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
            'search: verified' => "ESP-CE",
        );
    }

    static function getThemeFolder() {
        return __DIR__;
    }

    function _init() {
        parent::_init();
        $app = App::i();
    }

    function register() {
        parent::register();

        $app = App::i();
        $app->registerAuthProvider('keycloak');
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
                
                'instituicao_tipos_gestao' => [
                    'label' => i::__('Tipo de gestão'),
                    'placeholder' => i::__('Tipo de gestão'),
                    'type' => 'metadata',
                    'filter' => [
                        'param' => 'instituicao_tipos_gestao',
                        'value' => 'IN({val})'
                    ]
                ],
                'instituicao_servicos_especializados' => [
                    'label' => i::__('Serviços'),
                    'placeholder' => i::__('Serviços'),
                    'type' => 'metadata',
                    'filter' => [
                        'param' => 'instituicao_servicos_especializados',
                        'value' => 'IN({val})'
                    ]
                ],
            ],
            'agent' => [
                'profissionais_graus_academicos' => [
                    'label' => i::__('Grau académico'),
                    'placeholder' => i::__('Grau académico'),
                    'type' => 'metadata',
                    'filter' => [
                        'param' => 'profissionais_graus_academicos',
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


