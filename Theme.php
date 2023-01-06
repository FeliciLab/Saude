<?php

namespace Saude;

use MapasCulturais\Themes\BaseV1;
use MapasCulturais\App;
use MapasCulturais\Entities\Project;
use MapasCulturais\i;

class Theme extends BaseV1\Theme{

    protected static function _getTexts(){
        return array(
                        
            'site: of the region' => 'do estado de Ceará',
            'site: by the site owner' => 'pela Escola de saúde pública do Ceará',

            'home: title' => "",

            'home: welcome' => "<div class='font-style'><p style='margin-bottom: 1rem'>O <b class='b-home'>Mapa da Saúde</b> é uma solução aberta para governança colaborativa, desenvolvida pela <a href='https://www.esp.ce.gov.br/' target='blank'>Escola de Saúde Pública do  Ceará</a>, por meio do <a href='https://sus.ce.gov.br/felicilab/' target='blank'>Felicilab</a>.</p>
            <p style='margin-bottom: 1rem'>A plataforma estrutura uma política digital de relacionamento e gestão de informações, integrando dados de diferentes sistemas e serviços, oferecendo à cidadania e aos governos um importante instrumento de apoio, avaliação e qualificação da <b class='b-home'>Força de Trabalho do SUS.</b></p>
            <p style='margin-bottom: 2rem'>Crie seu perfil e colabore com a transformação digital do SUS!</p>
            </div>
            
            ",
            /*'home: events' => "Você pode pesquisar eventos culturais da cidade nos campos de busca combinada. Como usuário cadastrado, você pode incluir seus eventos na plataforma e divulgá-los gratuitamente.",*/
            'home: agents' => "<div class='font-style'><p>Se você é uma pessoa trabalhadora ou gestora da saúde em seu município, pode criar seu perfil e fazer a gestão da informação que você conhece e produz.</p>
            <p>Tornando-se um agente, você fortalece a transparência e o diálogo com sua comunidade e colabora com a transformação da saúde de sua cidade ou região.</p>
            <p>Aqui é possível cadastrar sua instituição, vincular seu perfil aos espaços nos quais você trabalha, divulgar e participar de oportunidades, tais como eventos e editais de projetos vinculados à Escola de Saúde Pública do Ceará.</p></div>
            ",
            'home: spaces' => "<div class='font-style'><p>No Mapa da Saúde já estão disponíveis todas as unidades do Ceará, presentes no <a href='https://mapa.sus.ce.gov.br/selo/id:1/#/tab=sobre' target='blank'>Cadastro Nacional de Estabelecimentos de Saúde (CNES)</a>.</p>
            <p>Para encontrá-las, diga onde e o que busca, através dos campos de busca combinada, que ajudam na precisão de sua pesquisa.</p>
            <p>Cadastre também os espaços nos quais desenvolve suas atividades em saúde, na capital ou no interior.</p>
            <p>E lembrando: como agente, você que é profissional de saúde poderá também vincular o seu perfil às unidades já cadastradas. </p></div>
            ",
            /*'home: opportunities' => "Faça a sua inscrição ou acesse o resultado de diversas convocatórias como editais, oficinas, prêmios e concursos. Você também pode criar o seu próprio formulário e divulgar uma oportunidade para outros atores de mudança.",*/
            'home: colabore' => "Colabore com o Mapa da Saúde",

            'home: abbreviation' => "ESP-CE",
            'home: home_devs' => "<div class='font-style'>
            <p>O Mapa da Saúde é uma das ações da Rede de Inovação Aberta no SUS, que estão sendo realizadas para promover o controle social, garantir a transparência e viabilizar a colaboração em rede.</p>
            <p>Se você é uma pessoa desenvolvedora e deseja interagir com o Mapa, basta acessar nosso repositório no <a href='https://github.com/EscolaDeSaudePublica/mapadasaude' target='blank'>GitHub</a> e fazer parte do grupo no <a href='https://t.me/joinchat/WCYOkjUEcYZ0mu1i' target='blank'>Telegram</a>.</p></div>",

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

        // modifica valor padrão do metadado Opportunity::claimDisabled
        $app->getRegisteredMetadata('MapasCulturais\Entities\Opportunity')['claimDisabled']->default_value = '1';

        /* OPORTUNIDADES */
        // adiciona aba de documentos necessários em oportunidades
        $app->hook('template(opportunity.single.tabs):end', function () {
            $this->part('tab', ['id' => 'necessary-documents', 'label' => i::__('Documentos necessários')]);
        });
        $app->hook('template(opportunity.single.tabs-content):end', function () {
            $opportunity = $this->controller->requestedEntity;
            $this->part('singles/opportunity-necessary-documents', ['entity' => $opportunity]);
        });

        // adiciona aba de recursos em oportunidades
        $app->hook('template(opportunity.single.tabs):end', function () {
            $opportunity = $this->controller->requestedEntity;
            if (($opportunity->canUser('viewEvaluations') || $opportunity->canUser('@control')) && !$opportunity->claimDisabled) {
                $this->part('tab', ['id' => 'resource', 'label' => i::__('Recursos')]);
            }
        });
        $app->hook('template(opportunity.single.tabs-content):end', function () {
            $opportunity = $this->controller->requestedEntity;
            
            if (($opportunity->canUser('viewEvaluations') || $opportunity->canUser('@control')) && !$opportunity->claimDisabled) {
                $this->part('singles/opportunity-resources', ['entity' => $opportunity]);
            }
        });

        // adiciona configuração da nota mínima nas avaliações técnicas
        $app->hook('template(opportunity.edit.evaluation-config-form--technical):after', function () {
            $this->part('opportunity/nota-minima', ['entity' => $this->controller->requestedEntity]);
        });

        // remove a seção de configuração da vinculação de espaço à ficha de inscrição
        $app->hook('view.partial(singles/opportunity-registrations--space-relations).params', function (&$__data, &$__template) {
            $__template = '_empty';
        });

        $app->hook('view.partial(home-opportunities).params', function (&$__data, &$__template) {
            $__template = '_empty';
        });

        // adiciona botões para modificação dos status das inscrições das avaliações técnica
        // <!-- TEMPLATE HOOK: template(opportunity.single.header-inscritos):end -->
        $app->hook('template(opportunity.single.header-inscritos):end', function() {
            $entity = $this->controller->requestedEntity;
            if($entity->publishedRegistrations) {
                 return;
            }
            $_evaluation_type = $entity->evaluationMethodConfiguration->getType();
            $this->part('opportunity/registration-status-buttons', ['_evaluation_type' => $_evaluation_type]);
        });

        /* INSCRIÇÕES */
        // modifica mensagem de ajuda no form de upload
        $app->hook('view.partial(singles/registration-edit--upload-form).params', function (&$__data) {
            $__data['form_help'] = i::__('Consulte o edital desta oportunidade para entender as limitações de tamanho e formato dos arquivos solicitados.');
        });
            
        /* PROJETOS */
        // muda o nome da aba Principal para Detalhes
        $app->hook('view.partial(tab).params', function(&$__data, &$__template) {
            if ($this->controller->id === 'project' && $__data['id'] === 'sobre') {
                $__data['label'] = i::__('Detalhes');
                unset($__data['active']);
            }
        });

        // adiciona a aba inscrições na primeira posição
        $app->hook('template(project.<<*>>.tabs):begin', function () {
            $this->part('tab', ['id' => 'inscricoes', 'label' => i::__('Inscrições'), 'active' => true]);
        });
        $app->hook('template(project.single.tabs-content):begin', function () {
            $this->part('singles/project-registrations', ['entity' => $this->controller->requestedEntity]); 
        });
        
        // remove aba oportunidades
        $app->hook('view.partial(entity-opportunities--<<tabs-single|item>>).params', function (&$__data, &$__template) {
            if ($this->controller->id === 'project' && $this->controller->action === 'single') {
                $__template = '_empty';
            }
        });

        /* ABAS DOS AGENTES */
        // adiciona aba de espaços relacionados
        $app->hook('template(agent.single.tabs):end', function () {
            $this->part('tab', ['id' => 'related-spaces', 'label' => i::__('Espaços')]);
        });
        $app->hook('template(agent.single.tabs-content):end', function () {
            $this->part('agent/related-spaces'); 
        });
        

        /* ESPAÇOS */
        // adiciona aba profissionais de saúde
        $app->hook('template(space.single.tabs):end', function () {
            $this->part('tab', ['id' => 'profsaude', 'label' => i::__('Profissionais de Saúde')]);
        });
        $app->hook('template(space.single.tabs-content):end', function () {
            $this->part('space/profsaude', ['entity' => $this->controller->requestedEntity]); 
        });

        // remove os agentes relacionados da sidebar
        $app->hook('view.partial(related-agents).params', function (&$__data, &$__template) {
            if ($this->controller->id === 'space' && $this->controller->action === 'single' && !isset($__data['profsaude'])) {
                $__template = '_empty';
            }
        });

        // adiciona o integrasus ao sidebar right
        if(false) {
            // @todo tirar do if quando corrigir a integração.
            $app->hook('template(space.single.sidebar-right):begin', function () {
                $this->part('space/integrasus');
            });
        }

        /* PAINEL */
        // adiciona h2 na seção principal
        $app->hook('template(panel.index.content.entities):begin', function () use($app){
            echo '<h2>Seus itens</h2>';
        });
        
        // adiciona as seções para gerencimanto de taxonomias e conta
        $app->hook('template(panel.index.content.entities):after', function () use($app){
            if ($app->user->is('admin')) {
                $this->part('panel/taxonomies');
            }

            $this->part('panel/account');
        });

        // remove link padrão de apagar conta
        $app->hook('view.partial(delete-account--button).params', function (&$__data, &$__template) {
            if ($this->controller->id === 'panel') {
                $__template = '_empty';
            }
        });
        /* ----- */

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

        $app->hook("template(registration.view.registration-opportunity-buttons):after", function() use($app){
            $app->view->enqueueStyle('app', 'novo', 'css/registration-button-save-style.css');
            $this->part('singles/button/registration-save--button');
        });

        $app->hook("template(registration.view.registration-opportunity-buttons):before", function() use($app){
            $app->view->enqueueStyle('app', 'novo', 'css/registration-button-save-style.css');
            $this->part('singles/button/registration-send--button');
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
        
        $app->hook('POST(opportunity.setAllStatusToApproved)', function() use($app) { 
            $app = App::i();
            $opportunity_id = intval($this->postData['opportunity']);

            $opportunity = $app->repo('Opportunity')->find($opportunity_id);

            if(!$opportunity) {
                $this->errorJson(i::__('Oportunidade não encontrada'), 400);
            }

            $opportunity->checkPermission('@controll');


            $dql = "SELECT 
                r.id 
            FROM 
                MapasCulturais\\Entities\\Registration r 
            WHERE 
                r.status = 1 AND
                r.opportunity = :opp";  

            $query = $app->em->createQuery($dql);

            $query->setParameter('opp', $opportunity);
            
            $result = $query->getArrayResult();
            $ids = array_map(function ($item) {
                return $item['id'];
            }, $result);

            $num = count($ids);
            foreach($ids as $i => $id) {
                $i++;
                $registration = $app->repo('Registration')->find($id);

                $registration->setStatusToApproved();

                $app->log->info("setAllStatusToApproved: {$i}/{$num} - {$id}");

                $app->em->clear();
            }

            $this->json($ids);
        });

         /**
         * Verifica a nota minima da oportunidade e altera as inscrições com a mudança do status
         */
        $app->hook('POST(opportunity.updateStatusNote)', function() use($app) {
            $app = App::i();
            $opportunity_id = intval($this->postData['id']);
            $opportunity = $app->repo('Opportunity')->find($opportunity_id);
            $minimum_grade = (int) $opportunity->registrationMinimumNote;

            if (!$opportunity) $this->errorJson(i::__('Oportunidade não encontrada'), 400);

            $opportunity->checkPermission('@controll');

            if ($opportunity->publishedRegistrations) {
                $this->errorJson(i::__('Não foi possível alterar a situação de inscrição, pois a oportunidade já foi publicada.'), 400);
            }

            if (empty($minimum_grade)) $this->errorJson(i::__('Avaliação para a oportunidade não contém nota mínima.'), 400);

            $dql = "SELECT 
                r.id 
            FROM 
                MapasCulturais\\Entities\\Registration r 
            WHERE 
                r.status = 1 AND
                r.opportunity = :opp";  

            $query = $app->em->createQuery($dql);

            $query->setParameter('opp', $opportunity);

            $result = $query->getArrayResult();
            $ids = array_map(function ($item) {
                return $item['id'];
            }, $result);

            $num = count($ids);
            foreach($ids as $i => $id) {
                $i++;
                $registration = $app->repo('Registration')->find($id);

                if($registration->consolidatedResult >= intval($opportunity->registrationMinimumNote)) {
                    $registration->setStatusToApproved();
                    $app->log->info("updateStatusNote (APPROVED): {$i}/{$num} - {$id}");
                } else {
                    $registration->setStatusToNotApproved();
                    $app->log->info("updateStatusNote (NOT APPROVED): {$i}/{$num} - {$id}");
                }

                $app->em->clear();
            }

            $this->json($ids);

        });

        /**
         * Remove a validação da descrição curta dos agentes
         */
        $app->hook("entity(Agent).validations", function(&$validations) {
            unset($validations['shortDescription']);
        });

        /**
         * Define valor do resultado preliminar na consolidação da nota da inscrição
         */
        $app->hook('entity(Registration).consolidateResult', function($result) {
            $this->preliminaryResult = $result;
        }, 10000);


        /**
         * Remove aba de oportunidades das páginas de projeto
         */
        $app->hook('view.partial(entity-opportunities--<<tabs|content>>-edit).params', function (&$__data, &$__template) {
            if($this->controller->id == 'project') {
                $__template = '_empty';
            }
        });

        /**
         * Substitui template da listagem de oportunidades
         */
        $app->hook('view.partial(entity-opportunities--item).params', function (&$__data, &$__template) {
            $__template = 'module-EntityOpportunities/entity-opportunities--item';
        });

        /**
         * Substitui template das datas das oportunidades dentro da página da oportunida
         */
        $app->hook('view.partial(singles/opportunity-about--registration-dates).params', function (&$__data, &$__template) {
            if ($this->controller->id === 'opportunity') {
                $__template = 'singles/opportunity-about--registration-dates-link';
            }
        });

        /**
         * Renomeia widget de downloads para Publicações da Oportunidade
         */
        $app->hook('view.partial(downloads).params', function(&$__data){
            if($this->controller->id == 'opportunity') {
                $__data['label'] = i::__('Publicações da Oportunidade');
            }
        });

        /**
         * Adiciona campos de configurações para envio de e-mail
         */
        $app->hook('view.partial(singles/opportunity-registrations--fields):after', function () {
            $entity = $this->controller->requestedEntity;
            $mailTitleSendConfirmDefault = 'Confirmação de inscrição';
            $mailDescriptionSendConfirmDefault = "Olá! Confirmamos sua inscrição no Mapa da Saúde.";
            $this->part('singles/opportunity-field-mail-confirm.php', ['entity' => $entity, 'mailTitleSendConfirmDefault'=>$mailTitleSendConfirmDefault, 'mailDescriptionSendConfirmDefault'=>$mailDescriptionSendConfirmDefault]);
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
                    'name' => $registration->owner->name,
                    'number' => $registration->number,
                    'opportunity' => $registration->opportunity->name,
                    'url_project' => $app->createUrl('panel', 'registrations')
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

        /**
         * Add visão para gerenciar o label do regulamento
         */
        $app->hook('view.partial(singles/opportunity-registrations--rules):before', function () {
            $entity = $this->controller->requestedEntity;
            $this->part('singles/opportunity-field-label-rules.php', ['entity' => $entity]);
        }); 


        // add validação opportunity categorias
        $app->hook('entity(Opportunity).validations', function(&$validations) use($app) { 
            $validations['registrationCategories'] = [
                'required' => \MapasCulturais\i::__('Categorias é obrigatório'),
            ];
        });

        $app->hook("modal(Opportunity).field(registrationCategories)", function ($entity_classname, &$definition, &$show_field) {
            $definition['placeholder'] = 'Insira uma opção por linha';
            $definition['label'] = 'Categorias';
            $definition['type'] = 'text';
        });
        /** 
         * Substitui template da listagem de oportunidades 
         */ 
        $app->hook('view.partial(entity-opportunities--item).params', function (&$__data, &$__template) { 
            $__template = 'module-EntityOpportunities/entity-opportunities--item'; 
        }); 


        /**
         * Oculta as situaões na página de inscrito
         */
        $app->hook('view.partial(singles/registration-single--header):after', function () use ($app) {
            $app->view->enqueueScript('app', 'hideinfo', 'js/hideinfo.js');
        });

        /**
         * Adicionar alteracao do alert
         */
        $app->hook('view.partial(singles/registration-single--header):after', function () use ($app) {
            $app->view->enqueueScript('app', 'alert_change', 'js/alert_change.js');
            $app->view->enqueueStyle('app', 'alert_changes', 'css/alert_changes.css');
        });
        
        /**
         * Adicionar botão para acessar fase
         */
        $app->hook('view.partial(widget-opportunity-phases):before', function () use ($app) {
            $app->view->enqueueScript('app', 'opportunity-phase-button', 'js/opportunity-phase-button.js');
            $app->view->enqueueStyle('app', 'oportunity_next_phase', 'css/oportunity_next_phase.css');
        });
        
        /**
         * Removendo info sobre agente da pagina inicial
         */
        $app->hook('template(site.index.home-agents):begin', function () use ($app) {
            $app->view->enqueueScript('app', 'hide_agent_home', 'js/details/hide_agent_home.js');
        });

        /**
         * Oculta a aba agenda
         */
        $app->hook('view.partial(agenda-singles--tab):after', function($template, &$html){
            $html = '';
        });

        /**
         * Oculta aba de denuncia e contato
         */
        $app->hook('view.partial(compliant_suggestion).params', function($template, &$html){
           $html = "_empty";
        });
        
        /**
         * Adicionando parte de criação de oportunidades na tela de agente
         */
        $app->hook('template(agent.edit.entity-opportunities):after', function(){
            $this->renderModalFor('opportunity', true, "Criar Oportunidade", "btn btn-default add js-open-dialog");
        });

         /**
         * Adicionando o campo rascunho para a tipagem quando o usuário não preenche as informações
         */
        $app->hook('view.partial(panel-opportunity).params', function($data) use ($app){
            $entity = $data['entity'];
            if($entity->type == null){
                $term = $app->repo('Term')->findBy(['taxonomy' => 'opportunity_taxonomia' , 'term' => 'Rascunho']);
                $entity->type = reset($term)->id;
            }
        });

        /**
         * Removendo parte de prestação de contas
         */
        $app->hook('view.partial(accountability/accountability-nav-panel).params', function($template, &$html){
            $html = "_empty";
         });

        /**
         * Hook para alterar nomes nas opções do menu e icones;
         */
        $app->hook('template(panel.index.content):before', function() use ($app){
            $app->view->enqueueScript('app', 'menu_names', 'js/menu_names.js');
        });

        /**
         * Hook para corrigir redirect para form de importação
         */
        $app->hook('entity(Opportunity.importFields:after', function () use ($app) {
            $opportunity = $app->repo("Opportunity")->find($this->id);

            $app->redirect($opportunity->editUrl . '#tab=form-config');
        });

        /**
         * Adicionando modal para continuar o registro do usuário na oportunidade
         */
        $app->hook('view.partial(singles/opportunity-tabs):after', function($template, &$html){
            $this->part('modals/continue-registration');
        });

        $this->validateRegistrationLimitPerOwnerProject();

        $app->hook("template(opportunity.<<*>>.user-registration-table--registration--status):end", function ($registration, $opportunity){
            if($registration->canUser('sendClaimMessage')){
                $this->part('singles/button-resource.php', ['registration' => $registration]);
            }
        });

        /**
        * Adiciona máscara de CPF/CNPJ na criação e edição de um agente
        */
        $app->hook('entity(Agent).get(site)', function() use ($app) {
            $app->view->enqueueScript('app', 'agent', 'js/agent.js');
        });


         /**
         * Adiciona novos menus no painel
         */
        $app->hook('template(panel.index.nav.panel.registrations):after', function () use($app) {
            if ($app->user->is('admin')) {
                $this->part('panel/nav-indicadores');
                $this->part('panel/nav-assinador');
            }
            
            if ($app->user->is('saasAdmin')) {
                $this->part('panel/nav-categoria-profissional');
            }

            $this->part('panel/nav-recursos');
        });

        $app->hook('template(space.<<*>>.tab-about-extra-info):before', function(){
            $entity = $this->controller->requestedEntity;
            $this->part('singles/space-services', ['entity' => $entity]);
        }); 

        /**
         * Não permite que CPF seja salvo no agente responsável pela inscrição se este já estiver vinculado a outro agente
         */
        $app->hook('PATCH(registration.single):data', function(&$data) use ($app) {
            $registration = $app->repo('Registration')->find(intval($data['id']));
            $query = $app->em->createQuery("SELECT rfc.id FROM MapasCulturais\Entities\RegistrationFieldConfiguration rfc WHERE rfc.owner = :opportunityId AND rfc.config LIKE '%documento%'");

            $query->setParameter('opportunityId', $registration->opportunity->id);

            if (count($query->getResult())) {
                $result = $query->getSingleResult();
                $field_id = $result['id'];
                $cpf = $data["field_{$field_id}"];
                $query = $app->em->createQuery("SELECT IDENTITY(am.owner) FROM MapasCulturais\Entities\AgentMeta am WHERE am.value = :cpf AND am.owner != :agentId");
                $query->setParameter('cpf', $cpf);
                $query->setParameter('agentId', $registration->owner->id);

                $result = $query->getResult();

                $msgEmailVinculado = '';
                if (!empty($result) && $result[0][1]) {
                    $agent = $app->repo('Agent')->find($result[0][1]);

                    $emailVinculado = $agent->getMetadata('emailPrivado');

                    $emailVinculadoPart = explode('@', $emailVinculado);
                    $user = substr($emailVinculadoPart[0], 0, -3);
                    $dominio = $emailVinculadoPart[1];

                    $email = $user . '***@' . $dominio;

                    $msgEmailVinculado = 'CPF vinculado ao e-mail: ' . $email;
                }


                if (checkValidDocument($cpf) && $cpf && count($result)) {
                    $this->errorJson(json_decode('{"field_'.$field_id.'": ["Já existe um cadastro vinculado a este CPF. ' . $msgEmailVinculado . '.  Verifique se você possui outra conta no Mapa da Saúde."]}'), 400);
                } elseif (!checkValidDocument($cpf) && $cpf) {
                    $this->errorJson(json_decode('{"field_'.$field_id.'": ["O número de documento informado é inválido."]}'), 400);
                }
            }
        });

        $app->hook('template(registration.view.form):begin', function() use($app) {
            $entity = $this->controller->requestedEntity;

            $current_registration = $entity;
            $this->jsObject['entity']['object']->category = $current_registration->category;
        });
    }

    private function validateRegistrationLimitPerOwnerProject()
    {
        $app = App::i();

        $app->hook('template(project.<<edit||create>>.tab-about--highlighted-message):after', function () {
            $entity = $this->controller->requestedEntity;
            $this->part('singles/project-newfields', ['entity' => $entity]);
        });

        $app->hook("entity(Registration).validations", function(&$validations) {  
            $validations['owner']['$app->view->validateRegistrationLimitPerOwnerProjectRegistration($this)'] = \MapasCulturais\i::__('Foi excedido o limite de inscrições para este agente responsável no projeto.');   
        });
    }

    function validateRegistrationLimitPerOwnerProjectRegistration($registration)
    { 
        $app = App::i();

        $opportunity = $registration->opportunity;
        
        if (is_null($opportunity->parent) && $opportunity->ownerEntity instanceof Project) {
            $project = $opportunity->ownerEntity;
            $limit = $project->registrationLimitPerOwnerProject;
            while (!$limit && $project->parent) {
                $project = $project->parent;
                $limit = $project->registrationLimitPerOwnerProject;
            }

            if (!$limit) {
                return true;
            }
            
            $projectIds = $project->getChildrenIds();
            $projectIds[] = $project->id;

            $dql = "SELECT 
                r.id
            FROM 
                MapasCulturais\\Entities\\Registration r 
            WHERE
                r.owner = :owner AND r.status <> 0 AND
                r.opportunity in (
                    SELECT o FROM MapasCulturais\\Entities\\ProjectOpportunity o WHERE o.ownerEntity in (:projectIds) 
                 ) 
            ";  

            $query = $app->em->createQuery($dql);

            $query->setParameter('owner', $registration->owner);
            $query->setParameter('projectIds', $projectIds);
            
            $result = $query->getScalarResult();

            return (int)$limit > count($result);
        }

        return true;
    }
    
    
    protected function _publishAssets() {
        $app = App::i();
        
        $app->view->enqueueScript('app', 'entity.module.opportunity', 'js/ng.entity.module.opportunity.js', array('ng-mapasculturais'));
        $app->view->enqueueScript('app', 'taxonomies', 'js/ng.taxonomies.js');
        $app->view->enqueueScript('app', 'evaluations-send', 'js/evaluations-send.js');
        $app->view->enqueueScript('app', 'professional.category', 'js/ng.professional.category.js');
        $app->view->enqueueScript('app', 'category.meta', 'js/ng.category.meta.js');
        //RECURSOS
        $app->view->enqueueScript('app', 'resource', 'js/ng.resource.js');
        
        // Notifications
        $app->view->enqueueStyle('app', 'pnotify', 'css/pnotify.css');
        $app->view->enqueueStyle('app', 'pnotify.brighttheme', 'css/pnotify.brighttheme.css');
        $app->view->enqueueStyle('app', 'pnotify.buttons', 'css/pnotify.buttons.css');
        $app->view->enqueueScript('app', 'pnotify', 'js/pnotify.js');
        $app->view->enqueueScript('app', 'pnotify.buttons', 'js/pnotify.buttons.js');
        $app->view->enqueueScript('app', 'pnotify.confirm', 'js/pnotify.confirm.js');

        // Modals
        $app->view->enqueueStyle('app', 'jqueryModal', 'css/remodal.css');
        $app->view->enqueueStyle('app', 'jqueryModal-theme', 'css/remodal-default-theme.css');
        $app->view->enqueueScript('app', 'jqueryModal', 'js/remodal.min.js');

        // Alerts
        $app->view->enqueueScript('app', 'sweetalert2', 'js/sweetalert2.all.min.js');
        
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

        $this->registerOpportunityMetadata('labelCustomRules', [
            'label' => 'Label do regulamento',
            'type' => 'text'
        ]); 

        // @todo necessário implementar validação do quantitativo de inscrições por projetos pai, o valor não deve ser maior que os valores definidos nos projetos pai e avó
        $this->registerProjectMetadata('registrationLimitPerOwnerProject', [
            'label' => \MapasCulturais\i::__('Número máximo de inscrições por agente responsável no projeto'),
            'validations' => array(
                "v::intVal()" => \MapasCulturais\i::__("O número máximo de inscrições por agente responsável no projeto deve ser um número inteiro")
            )
        ]); 

        $app = App::i();

        $app->registerAuthProvider('keycloak');
        $app->registerController('taxonomias', 'Saude\Controllers\Taxonomias');
        $app->registerController('recursos', 'Saude\Controllers\Resources');
        // $app->registerController('panel',   'Saude\Controllers\Panel');
        $app->registerController('categoria-profissional', 'Saude\Controllers\ProfessionalCategory');
        $app->registerController('indicadores', 'Saude\Controllers\Indicadores');

        $this->registerRegistrationMetadata('preliminaryResult', [
            'label' => i::__('Resultado Preliminar'),
            'type' => 'string',
            'private' => true
        ]);
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
                        'value' => 'IN({val})'
                    ]
                ],
                'instituicao_servicos' => [
                    'label' => i::__('Serviços'),
                    'placeholder' => i::__('Serviços'),
                    'type' => 'metadata',
                    'filter' => [
                        'param' => 'instituicao_servicos',
                        'value' => 'IN({val})'
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

function checkValidDocument($document)
{
    // Extrai somente os números
    $document = preg_replace('/[^0-9]/is', '', $document);

    // Verifica se o documento está completo
    if (strlen($document) !== 11) return false;

    // Verifica se o documento é uma sequência de números iguais
    if (preg_match('/(\d)\1{10}/', $document)) return false;

    // Faz o calculo para validar o CPF
    for ($digits = 9; $digits < 11; $digits++) {
        for ($sum_digits = 0, $digit_index = 0; $digit_index < $digits; $digit_index++) {
            $sum_digits += $document[$digit_index] * (($digits + 1) - $digit_index);
        }

        $sum_digits = ((10 * $sum_digits) % 11) % 10;

        if ($document[$digit_index] != $sum_digits) return false;
    }

    return true;
}
