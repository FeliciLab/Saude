<?php

namespace MapasCulturais;

$app = App::i();
$agent_fields = $app->modules['RegistrationFieldTypes']->getAgentFields();
$definitions = [];
foreach (Entities\Agent::getPropertiesMetadata() as $key => $def) {
    if (in_array($key, $agent_fields)) {
        $def = (object) $def;
        if (empty($def->field_type)) {
            if (in_array($key, ['shortDescription', 'longDescription'])) {
                $def->field_type = 'textarea';
            } else {
                $def->field_type = 'text';
            }
        }
        $definitions[$key] = $def;
    }
}
?>
<div ng-class="field.error ? 'invalidField': '' " ng-if="::field.fieldType === 'agent-owner-field'" id="field_{{::field.id}}">
    <span class="label">
        <span ng-if="field.config.entityField == 'genero'">
            <div ng-click="editbox.open('editbox-select-registration-owner_', $event)">
                <i class="icon icon-agent"></i>
                {{::field.title}} <i class="fa fa-question-circle-o"></i>
                <span ng-if="requiredField(field)"><?php i::_e('obrigatório') ?></span>
            </div> 
        </span>

        <span ng-if="field.config.entityField !== 'genero'">
            <i class="icon icon-agent"></i>
            {{::field.title}}
            <span ng-if="requiredField(field)"><?php i::_e('obrigatório') ?></span>
            <em class="relation-field-info">(<?php i::_e('Este campo será salvo no agente responsável pela inscrição') ?>)</em>
        </span>
        <div ng-if="::field.description" class="attachment-description">{{::field.description}}</div>

        <div ng-if="::field.config.entityField == '@location'">
            <?php $this->part('registration-field-types/fields/_location') ?>
        </div>
        <div ng-if="::field.config.entityField == '@links'">
            <?php $this->part('registration-field-types/fields/links') ?>
        </div>
        <div ng-if="::field.config.entityField == '@terms:area'">
            <?php $this->part('registration-field-types/fields/checkboxes') ?>
        </div>
        <?php
        foreach ($definitions as $key => $def) :
            $type = $key == 'documento' ? 'cpf' : $def->field_type;
        ?>
            <div ng-if="::field.config.entityField == '<?= $key ?>'">
                <?php $this->part('registration-field-types/fields/' . $type) ?>
            </div>
        <?php endforeach; ?>

</div>

<!-- Conteúdo do edit-box -->
<edit-box id="editbox-select-registration-owner_" position="up" cancel-label="<?php \MapasCulturais\i::esc_attr_e("Fechar"); ?>" close-on-cancel='true' spinner-condition="data.registrationSpinner">

    <div>
        <h5 style="text-align: center;"><b>Identidade de gênero<b></h5>

        <b class="title-gender"> Mulher Cis</b>
        <p>Pessoa do sexo feminino com identidade de gênero consonante, também feminina.</p>

        <b class="title-gender">Homem Cis</b>
        <p>Pessoa do sexo masculino com identidade de gênero consonante, também masculina.</p>

        <b class="title-gender">Mulher Trans/travesti</b>
        <p>Pessoa que possui identidade de gênero feminina, embora tenha nascido com o sexo masculino, optando por se definir como mulher.</p>

        <b class="title-gender">Homem Trans</b>
        <p>Pessoa que possui identidade de gênero masculina, embora tenha nascido com o sexo feminino, optando por se definir como homem.</p>

        <b class="title-gender">Não binário/ outra variabilidade</b>
        <p>Pessoa cuja identidade de gênero não se ancora nem em definições de masculina nem de feminina.</p>
    </div>
</edit-box>