<?php

$registrationFieldConfigurationRepo = $app->repo('RegistrationFieldConfiguration');

$registrationFileConfigurationRepo = $app->repo('RegistrationFileConfiguration');

$registrationFieldConfigurations = $registrationFieldConfigurationRepo->findBy(['owner' => $entity->id]);

$registrationFileConfigurations = $registrationFileConfigurationRepo->findBy(['owner' => $entity->id]);

?>

<style>
    #registration {
        display: flex;
        flex-direction: column;
    }

    #registration span {
        display: flex;
    }

    #is-required {
        margin-left: 1rem;
    }

    #registration-description {
        font-size: 16px;
        line-height: 16px;
        letter-spacing: 0.4px;
        color: rgba(0, 0, 0, 0.6);
    }
</style>

<div id="necessary-documents" class="aba-content">
    <?php $this->applyTemplateHook('tab-space', 'begin'); ?>
    <h4>Lista de documentos necessários para está inscrição:</h4>
    <?php foreach ($registrationFieldConfigurations as $registration) : ?>
        <div id="registration">
            <span>
                <strong><?php echo $registration->title ?></strong>
                <?php if ($registration->required) : ?>
                    <h6 id="is-required" class="registration-help">Obrigatório</h6>
                <?php else : ?>
                    <h6 id="is-required" class="registration-help">Não Obrigatório</h6>
                <?php endif; ?>
            </span>
            <h6 id="registration-description"><?php echo $registration->description ?></h6>
        </div>
        <hr />
    <?php endforeach; ?>
    <?php foreach ($registrationFileConfigurations as $registration) : ?>
        <div id="registration">
            <span>
                <strong><?php echo $registration->title ?></strong>
                <?php if ($registration->required) : ?>
                    <h6 id="is-required" class="registration-help">Obrigatório</h6>
                <?php else : ?>
                    <h6 id="is-required" class="registration-help">Não Obrigatório</h6>
                <?php endif; ?>
            </span>
            <h6 id="registration-description"><?php echo $registration->description ?></h6>
        </div>
        <hr />
    <?php endforeach; ?>
    <?php $this->applyTemplateHook('tab-space', 'end'); ?>
</div>