<?php 
use MapasCulturais\i;

$configuration = $entity->evaluationMethodConfiguration;
$definition = $configuration->definition;
?>

<div id="evaluations-config" class="aba-content" ng-controller="EvaluationMethodConfigurationController">

    <?php
    if(is_object($definition) && property_exists($definition, 'evaluationMethod') ) :
        $evaluationMethod = $definition->evaluationMethod;
        $config_form_part_name = $evaluationMethod->getConfigurationFormPartName();
    ?>
        <p class="js-editable"><?php echo $definition->name ?> - <em><?php echo $definition->description ?></em></p>

        <?php $this->part('singles/opportunity-evaluations--committee', ['entity' => $entity]) ?>

        <?php if($config_form_part_name): ?>
            <div> <?php $this->part($config_form_part_name, ['entity' => $entity]) ?> </div> <hr>
        <?php endif; ?>
        <p>
        <?php
        if($entity->evaluationMethodConfiguration->getDefinition()->slug == 'technical') :  ?>
            <span class="label <?php echo ($entity->isPropertyRequired($entity,"registrationMinimumNote") && $editEntity? 'required': '');?>"><?php \MapasCulturais\i::_e("Informe o valor mínimo de aprovação da oportunidade");?></span><br>
            <span class="registration-help"><?php \MapasCulturais\i::_e("Informe a nota mínima (a partir de 0) para classificação nesta oportunidade.");?></span><br>
            <span class="js-editable" data-edit="registrationMinimumNote" data-original-title="<?php \MapasCulturais\i::esc_attr_e("Informe o valor mínimo de aprovação da oportunidade");?>" data-emptytext="<?php \MapasCulturais\i::esc_attr_e("Insira a nota média");?>"><?php
            if($entity->registrationMinimumNote == ''){
                echo 'Sem nota';
            }else{
                echo $entity->registrationMinimumNote;
            }
            ?></span>
        <?php endif; ?>
        </p>
        <div>
            <h4> <?php i::_e('Textos informativos para a fichas de inscrição') ?> </h4>
            <div class="evaluations-config--intro">
                <label> <?php i::_e('Para todas as inscrições') ?> <br>
                    <textarea ng-model="config['infos']['general']" ng-model-options="{ debounce: 1000, updateOn: 'blur' }"></textarea>
                </label>
            </div>

            <h4> <?php i::_e('Por categoria') ?> </h4>
            <div ng-repeat="category in data.categories" class="evaluations-config--intro">
                <label> {{category}} <br>
                    <textarea ng-model="config['infos'][category]" ng-model-options="{ debounce: 1000, updateOn: 'blur' }"></textarea>
                </label>
            </div>
        </div>

    <?php
    else:
        i::_e('As inscrições para esta oportunidade já foram encerradas. Não é mais possível configurar a avaliação.');
    endif; ?>

</div>