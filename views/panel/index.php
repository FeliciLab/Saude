<?php
$this->layout = 'panel';

$subsite = $app->getCurrentSubsite();

$posini = 0;
$posfin = 0;
$msg = "";
$button = "";

$agent = $app->repo('AgentMeta')->findBy([
    'owner' => $app->user->profile->id
]);

$all = $app->em->getConnection()->fetchAll("SELECT * FROM examination_room");

$cpf    = '';
$newcpf = '';

foreach ($agent as $campo => $valor) {
    if ($agent[$campo]->key == 'documento') {
        $cpf = $valor->value;
    }
}

function limpaCPF_CNPJ($valor)
{
    $valor = trim($valor);
    $valor = str_replace(".", "", $valor);
    $valor = str_replace(",", "", $valor);
    $valor = str_replace("-", "", $valor);
    $valor = str_replace("/", "", $valor);
    return $valor;
}

$newcpf = limpaCPF_CNPJ($cpf);

$not_admin_error_message = '';

if (isset($_SESSION['not_admin_error'])) {
    $not_admin_error_message = $_SESSION['not_admin_error'];
}

?>

<?php $this->applyTemplateHook('content', 'before'); ?>
<div class="panel-main-content">
    <?php $this->applyTemplateHook('content', 'begin'); ?>

    <?php $this->part('panel/highlighted-message') ?>

    <?php if ($subsite && $subsite->canUser('modify')) : ?>
        <p class="highlighted-message" style="margin-top:-2em;">
            <?php printf(\MapasCulturais\i::__('Você é administrador deste subsite. Clique %saqui%s para configurar.'), '<a rel="noopener noreferrer" href="' . $subsite->singleUrl . '">', '</a>'); ?>
        </p>
        <?php endif;
    foreach ($all as $key => $value) {
        $agent_cpf = limpaCPF_CNPJ($value['agent_cpf']);
        if ($newcpf == $agent_cpf) {
        ?>
            <!-- <div class="panel panel-primary">
        <div class="panel-heading">Edital 02/2021</div>
        <div class="panel-body">
            <ul class="list-group">
                <li class="list-group-item">
                    Sala: <?php echo $value['room_number']; ?>
                </li>
                <li class="list-group-item">
                Para acessar plataforma Meet: <a href="<?php echo $value['meet_link']; ?>" class="btn btn-primary" target="_blank">clique aqui</a>
                </li>
            </ul>
        </div>
    </div> -->
    <?php
        }
    } ?>
    <div class="panel panel-primary">
        <div class="panel-heading">Seus itens</div>
        <div class="panel-body">
            <?php $this->applyTemplateHook('content.entities', 'before'); ?>
            <section id="user-stats" class="clearfix">
                <?php $this->applyTemplateHook('content.entities', 'begin'); ?>
                <?php if ($app->isEnabled('events')) : ?>
                    <div>
                        <div>
                            <div class="clearfix">
                                <span class="alignleft"><?php $this->dict('entities: Events') ?></span>
                                <div class="icon icon-event alignright"></div>
                            </div>
                            <div class="clearfix">
                                <a class="user-stats-value hltip" href="<?php echo $app->createUrl('panel', 'events') ?>" title="<?php \MapasCulturais\i::esc_attr_e("Ver Meus eventos"); ?>"><?php echo $count->events; ?></a>
                                <span class="user-stats-value hltip">|</span>
                                <a class="user-stats-value hltip" href="<?php echo $app->createUrl('panel', 'events') ?>#tab=permitido" title="<?php \MapasCulturais\i::esc_attr_e("Ver Eventos Cedidos"); ?>"><?php echo count($app->user->hasControlEvents); ?></a>
                                <?php $this->renderModalFor('event', false, false, "icon icon-add alignright"); ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($app->isEnabled('agents')) : ?>
                    <div>
                        <div>
                            <div class="clearfix">
                                <span class="alignleft"><?php $this->dict('entities: Agents') ?></span>
                                <div class="icon icon-agent alignright"></div>
                            </div>
                            <div class="clearfix">
                                <a class="user-stats-value hltip" href="<?php echo $app->createUrl('panel', 'agents') ?>" title="<?php \MapasCulturais\i::esc_attr_e("Ver meus agentes"); ?>"><?php echo $count->agents; ?></a>
                                <span class="user-stats-value hltip">|</span>
                                <a class="user-stats-value hltip" href="<?php echo $app->createUrl('panel', 'agents') ?>#tab=permitido" title="<?php \MapasCulturais\i::esc_attr_e("Ver Agentes Cedidos"); ?>"><?php echo count($app->user->hasControlAgents); ?></a>
                                <?php $this->renderModalFor('agent', false, false, "icon icon-add alignright"); ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($app->isEnabled('spaces')) : ?>
                    <div>
                        <div>
                            <div class="clearfix">
                                <span class="alignleft"><?php $this->dict('entities: Spaces') ?></span>
                                <div class="icon icon-space alignright"></div>
                            </div>
                            <div class="clearfix">
                                <a class="user-stats-value hltip" href="<?php echo $app->createUrl('panel', 'spaces') ?>" title="<?php \MapasCulturais\i::esc_attr_e("Ver"); ?> <?php $this->dict('entities: My spaces') ?>"><?php echo $count->spaces; ?></a>
                                <span class="user-stats-value hltip">|</span>
                                <a class="user-stats-value hltip" href="<?php echo $app->createUrl('panel', 'spaces') ?>#tab=permitido" title="<?php \MapasCulturais\i::esc_attr_e("Ver Espaços Cedidos"); ?>"><?php echo count($app->user->hasControlSpaces); ?></a>
                                <?php $this->renderModalFor('space', false, false, "icon icon-add alignright"); ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($app->isEnabled('projects')) : ?>
                    <div>
                        <div>
                            <div class="clearfix">
                                <span class="alignleft"><?php $this->dict('entities: Projects') ?></span>
                                <div class="icon icon-project alignright"></div>
                            </div>
                            <div class="clearfix">
                                <a class="user-stats-value hltip" href="<?php echo $app->createUrl('panel', 'projects') ?>" title="<?php \MapasCulturais\i::esc_attr_e("Ver meus projetos"); ?>"><?php echo $count->projects; ?></a>
                                <span class="user-stats-value hltip">|</span>
                                <a class="user-stats-value hltip" href="<?php echo $app->createUrl('panel', 'projects') ?>#tab=permitido" title="<?php \MapasCulturais\i::esc_attr_e("Ver Projetos Cedidos"); ?>"><?php echo count($app->user->hasControlProjects); ?></a>
                                <?php $this->renderModalFor('project', false, false, "icon icon-add alignright"); ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($app->isEnabled('opportunities')) : ?>
                    <div>
                        <div>
                            <div class="clearfix">
                                <span class="alignleft"><?php \MapasCulturais\i::_e('Oportunidade'); ?></span>
                                <div class="icon icon-opportunity alignright"></div>
                            </div>
                            <div class="clearfix">
                                <a class="user-stats-value hltip" href="<?php echo $app->createUrl('panel', 'opportunities') ?>" title="<?php \MapasCulturais\i::esc_attr_e("Ver minhas oportunidades"); ?>"><?php echo $count->opportunities; ?></a>
                                <span class="user-stats-value hltip">|</span>
                                <a class="user-stats-value hltip" href="<?php echo $app->createUrl('panel', 'opportunities') ?>#tab=permitido" title="<?php \MapasCulturais\i::esc_attr_e("Ver Oportunidades Cedidas"); ?>"><?php echo count($app->user->hasControlOpportunities); ?></a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($app->isEnabled('subsite') && $app->user->is('saasAdmin')) : ?>
                    <div>
                        <div>
                            <div class="clearfix">
                                <span class="alignleft"><?php \MapasCulturais\i::_e('Subsite'); ?></span>
                                <div class="icon icon-subsite alignright"></div>
                            </div>
                            <div class="clearfix">
                                <a class="user-stats-value hltip" href="<?php echo $app->createUrl('panel', 'subsite') ?>" title="<?php \MapasCulturais\i::esc_attr_e('Ver meus subsites'); ?>"><?php echo $count->subsite; ?></a>
                                <a class="icon icon-add alignright hltip" href="<?php echo $app->createUrl('subsite', 'create'); ?>" title="<?php \MapasCulturais\i::esc_attr_e('Adicionar subsite'); ?>"></a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if ($app->isEnabled('seals') && $app->user->is('admin')) : ?>
                    <div>
                        <div>
                            <div class="clearfix">
                                <span class="alignleft"><?php \MapasCulturais\i::_e('Selos'); ?></span>
                                <div class="icon icon-seal alignright"></div>
                            </div>
                            <div class="clearfix">
                                <a class="user-stats-value hltip" href="<?php echo $app->createUrl('panel', 'seals') ?>" title="<?php \MapasCulturais\i::esc_attr_e("Ver meus selos"); ?>"><?php echo $count->seals; ?></a>
                                <span class="user-stats-value hltip">|</span>
                                <a class="user-stats-value hltip" href="<?php echo $app->createUrl('panel', 'seals') ?>#tab=permitido" title="<?php \MapasCulturais\i::esc_attr_e("Ver Selos Cedidos"); ?>"><?php echo count($app->user->hasControlSeals); ?></a>
                                <a class="icon icon-add alignright hltip" href="<?php echo $app->createUrl('seal', 'create'); ?>" title="<?php \MapasCulturais\i::esc_attr_e("Adicionar selos"); ?>"></a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <?php $this->applyTemplateHook('content.entities', 'end'); ?>
            </section>
            <?php $this->applyTemplateHook('content.entities', 'after'); ?>
        </div>
    </div>
    <?php if ($app->user->notifications) : ?>
        <?php $this->applyTemplateHook('content.notification', 'before'); ?>
        <section id="activities">
            <?php $this->applyTemplateHook('content.notification', 'begin'); ?>
            <header>
                <h2><?php \MapasCulturais\i::_e("Atividades"); ?></h2>
            </header>
            <?php foreach ($app->user->notifications as $notification) : ?>
                <?php $posini = strpos($notification->message, "<a  rel='noopener noreferrer' "); ?>

                <?php $msg = $notification->message; ?>

                <div class="activity clearfix">
                    <p>
                        <span class="small"><?php \MapasCulturais\i::_e("Em"); ?> <?php echo $notification->createTimestamp->format('d/m/Y - H:i') ?></span><br />
                        <?php echo $msg; ?>
                    </p>
                    <?php if ($notification->request) : ?>
                        <div>
                            <?php if ($notification->request->canUser('approve')) : ?><a class="btn btn-small btn-success" href="<?php echo $notification->approveUrl ?>"><?php \MapasCulturais\i::_e("aceitar"); ?></a><?php endif; ?>
                            <?php if ($notification->request->canUser('reject')) : ?>
                                <?php if ($notification->request->requesterUser->equals($app->user)) : ?>
                                    <a class="btn btn-small btn-default" href="<?php echo $notification->rejectUrl ?>"><?php \MapasCulturais\i::_e("cancelar"); ?></a>
                                    <a class="btn btn-small btn-success" href="<?php echo $notification->deleteUrl ?>"><?php \MapasCulturais\i::_e("ok"); ?></a>
                                <?php else : ?>
                                    <a class="btn btn-small btn-danger" href="<?php echo $notification->rejectUrl ?>"><?php \MapasCulturais\i::_e("rejeitar"); ?></a>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    <?php else : ?>
                        <div>
                            <?php if ($button) : ?>
                                <?php echo $button; ?>
                            <?php endif; ?>
                            <a class="btn btn-small btn-success" href="<?php echo $notification->deleteUrl ?>"><?php \MapasCulturais\i::_e("ok"); ?></a>
                        </div>
                    <?php endif ?>
                </div>
            <?php endforeach; ?>

            <?php $this->applyTemplateHook('content.notification', 'end'); ?>
        </section>
        <?php $this->applyTemplateHook('content.notification', 'after'); ?>
    <?php endif; ?>
    <section>
        <?php
        if ($app->user->is('admin')) {
        ?>
            <div class="panel panel-primary">
                <div class="panel-heading">Menu Taxonomia</div>
                <div class="panel-body">
                    <section id="" class="clearfix menu-stats">
                        <div>
                            <div class="clearfix">
                                <a href="<?php echo $app->createUrl('taxonomias', 'info') ?>" class="btn btn-secound" title="<?php \MapasCulturais\i::_e('Taxonomia de agente'); ?>">
                                    <i class="fa fa-user alignleft icon-fa" aria-hidden="true"></i>
                                    <?php \MapasCulturais\i::_e('Agente'); ?></a>
                            </div>
                        </div>
                        <!-- spaces -->
                        <div>
                            <div class="clearfix">
                                <a href="<?php echo $app->createUrl('taxonomias', 'spaces') ?>" class="btn btn-secound" title="<?php \MapasCulturais\i::_e('Taxonomia de espaço'); ?>">
                                    <i class="fa fa-map-marker alignleft icon-fa" aria-hidden="true"></i>
                                    <?php \MapasCulturais\i::_e('Espaco'); ?></a>
                            </div>
                        </div>
                        <!-- Project -->
                        <div>
                            <div class="clearfix">
                                <a href="<?php echo $app->createUrl('taxonomias', 'projects') ?>" class="btn btn-secound" title="<?php \MapasCulturais\i::_e('Taxonomia de projeto'); ?>">
                                    <i class="fa fa-th-list alignleft icon-fa" aria-hidden="true"></i>
                                    <?php \MapasCulturais\i::_e('Projeto'); ?></a>
                            </div>
                        </div>
                        <!-- Oportunidades -->
                        <div>
                            <div class="clearfix">
                                <a href="<?php echo $app->createUrl('taxonomias', 'opportunity') ?>" class="btn btn-secound" title="<?php \MapasCulturais\i::_e('Taxonomia da oportunidade'); ?>">
                                    <i class="fa fa-pencil-square alignleft icon-fa" aria-hidden="true"></i>
                                    <?php \MapasCulturais\i::_e('Oportunidade'); ?></a>
                            </div>
                        </div>
                        <!-- Àrea101 -->
                        <div>
                            <div class="clearfix">
                                <a href="<?php echo $app->createUrl('taxonomias', 'area') ?>" class="btn btn-secound" title="<?php \MapasCulturais\i::_e('Taxonomia da área'); ?>">
                                    <i class="fa fa-area-chart alignleft icon-fa" aria-hidden="true"></i>
                                    <?php \MapasCulturais\i::_e('Área'); ?></a>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        <?php
        } // FIM IF ADMIN
        ?>
        <div class="panel panel-primary">
            <div class="panel-heading">Conta</div>
            <div class="panel-body">
                <section class="clearfix menu-stats">
                    <div>
                        <div class="clearfix">
                            <a href="https://dev.id.org.br/auth/realms/saude/account/password" target="_blank" class="btn btn-secound" title="<?php \MapasCulturais\i::_e('Trocar Senha'); ?>">
                                <i class="fa fa-lock alignleft icon-fa" aria-hidden="true"></i>
                                <?php \MapasCulturais\i::_e('Trocar Senha'); ?></a>
                        </div>
                    </div>
                    <div>
                        <div class="clearfix">
                            <a href="https://dev.id.org.br/auth/realms/saude/login-actions/reset-credentials?client_id=DigitalSaude" class="btn btn-secound" title="<?php \MapasCulturais\i::_e('Em casos que você não venha lembrar da senha atual para trocar a sua senha.'); ?>" target="_blank">
                                <i class="fa fa-unlock-alt alignleft icon-fa" aria-hidden="true"></i>
                                <?php \MapasCulturais\i::_e('Esqueci a senha'); ?></a>
                        </div>
                    </div>
                    <div>
                        <div class="clearfix">
                            <a href="<?php echo $app->createUrl('panel', 'deleteAccount') ?>" class="btn btn-danger" title="<?php \MapasCulturais\i::_e('Apagar Conta'); ?>">
                                <i class="fa fa-trash alignleft icon-fa" aria-hidden="true"></i>
                                <?php \MapasCulturais\i::_e('Apagar Conta'); ?></a>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
    <?php $this->applyTemplateHook('settings', 'before'); ?>
    <ul class="panel-settings">
        <?php $this->applyTemplateHook('settings', 'begin'); ?>

        <?php $this->applyTemplateHook('settings', 'end'); ?>
        <div class="clear"></div>
    </ul>
    <?php $this->applyTemplateHook('settings', 'after'); ?>

    <?php $this->applyTemplateHook('content', 'end'); ?>
</div>
<?php $this->applyTemplateHook('content', 'after'); ?>
<script>
    jQuery('.delete').css('display', 'none');
</script>