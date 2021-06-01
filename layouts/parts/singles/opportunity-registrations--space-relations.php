<?php
use MapasCulturais\App;

$can_edit = $entity->canUser('modifyRegistrationFields');

$ditable_class = $can_edit ? 'js-editable editable editable-click' : '';

$editEntity = $this->controller->action === 'create' || $this->controller->action === 'edit';

$metadata_name = 'useSpaceRelation';

$option_label = $entity->$metadata_name ? $entity->$metadata_name : 'dontUse';

$projectMeta = \MapasCulturais\Entities\Project::getPropertiesMetadata();

$optionSelect = \MapasCulturais\Entities\RegistrationSpaceRelation::getOptionSelected($entity->id);
$message = $projectMeta['useSpaceRelation']['options'];
//PARA PŔEENCHIMENTO DO SELECT
if(isset($optionSelect[0]['value'])){
    $selectOption = \MapasCulturais\Entities\RegistrationSpaceRelation::getOptionLabel($optionSelect[0]['value']);
}else{
    $selectOption = \MapasCulturais\Entities\RegistrationSpaceRelation::getOptionLabel('dontUse');
}

?>

