<?php

use MapasCulturais\i;
use MapasCulturais\Entities\Opportunity;

/**
 * Adicionado essas dependências para o funcionamento do componente do angular para buscar o(s) agente(s)
 */
$this->bodyProperties['ng-app'] = "entity.app";
$this->bodyProperties['ng-controller'] = "EntityController";

$this->jsObject['angularAppDependencies'][] = 'entity.module.opportunity';
$this->jsObject['angularAppDependencies'][] = 'ui.sortable';

// Se a rora for diferente de edição, então passa a entidade opportunity, mas se for edição então pode ser o lançamento de selos, devido ao conflito do objectjs
if ($this->controller->action != 'edit') {
    $this->addEntityToJs($opportunity);
}

$this->addOpportunityToJs($opportunity);

$this->addOpportunitySelectFieldsToJs($opportunity);

if ($this->isEditable()) {
    $this->addEntityTypesToJs($opportunity);
    $this->addTaxonoyTermsToJs('tag');
}

$this->includeAngularEntityAssets($opportunity);


$avatar = $opportunity->avatar ? $opportunity->avatar->transform('avatarSmall') : null;

$url = $this->isEditable() ? $opportunity->editUrl : $opportunity->singleUrl;
?>
<article class="objeto card-info-opportunity" ng-controller="OpportunityController">
    <?php if($opportunity->status == 0): ?>
        <p class="alert warning"><?php i::_e('Esta oportunidade é um rascunho')?></p>
    <?php endif; ?>
    <div class="card-info-header">
        <?php if ($avatar) : ?>
            <img src="<?php echo $avatar->url ?>" class="avatar-card-info-opportunity">
        <?php else : ?>
            <img src="<?php $this->asset('img/avatar--opportunity.png'); ?>" alt=""  class="avatar-card-info-opportunity" />
        <?php endif; ?>

        <span>
            <a href="<?php echo $url ?>"><?php echo $opportunity->name ?></a>
            <?php $this->part('singles/opportunity-about--registration-dates', ['entity' => $opportunity, 'disable_editable' => true]) ?>
        </span>
    </div>
    <div class="card-info-content">
        <?php
            $this->part('singles/opportunity-registrations--form', ['entity' => $opportunity, 'show_button_access_registration' => true]) 
        ?>
    </div>
</article>