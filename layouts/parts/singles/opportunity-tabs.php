<?php
$app = MapasCulturais\App::i();
$sent = $app->repo('Registration')->findByUser($app->user, 'sent');

$this->applyTemplateHook('tabs', 'before'); ?>
<ul class="abas clearfix">
    <?php $this->applyTemplateHook('tabs', 'begin'); ?>
    <li class="active"><a href="#main-content" rel='noopener noreferrer'><?php \MapasCulturais\i::_e("Principal"); ?></a></li>

    <?php if ($this->isEditable()) : ?>
        <?php if (!$entity->isNew()) : ?>
            <li><a href="#evaluations-config" rel='noopener noreferrer'><?php \MapasCulturais\i::_e("Configuração da Avaliação"); ?></a></li>
        <?php endif; ?>
    <?php else : ?>
        <li><a href="#necessary-documents" rel='noopener noreferrer'>Documentos necessários</a></li>

        <?php if ($entity->canUser('@control')) : ?>
            <li><a href="#inscritos" rel='noopener noreferrer'><?php \MapasCulturais\i::_e("Inscritos"); ?></a></li>
        <?php endif; ?>

        <?php if ($entity->canUser('viewEvaluations') || $entity->canUser('@control')) : ?>
            <!-- Aba resultado era para ser mostrado para os candidatos
                <li><a href="#inscritos" rel='noopener noreferrer'><?php \MapasCulturais\i::_e("Resultado"); ?></a></li> -->
            <li><a href="#evaluations" rel='noopener noreferrer'><?php \MapasCulturais\i::_e("Avaliações"); ?></a></li>
            <?php
            // Somente mostrará a aba de recurso se o agente logado for avaliador da oportunidade e se a oportunidade está com o recurso habilitado
            if (isset($entity->metadata['claimDisabled']) && $entity->metadata['claimDisabled'] == 0) :  ?>
                <li><a href="#resource" rel='noopener noreferrer'><?php \MapasCulturais\i::_e("Recursos"); ?></a></li>
            <?php endif; ?>
        <?php endif; ?>

    <?php endif; ?>

    <?php $this->applyTemplateHook('tabs', 'end'); ?>
</ul>
<?php $this->applyTemplateHook('tabs', 'after'); ?>