<?php

use \Saude\Entities\ProfessionalCategory;

$allPro = ProfessionalCategory::allProfessional();

//RETORNA AS ESPECIALIDADES DO AGENTE
$getSpecialty = ProfessionalCategory::getSpecialtyEntity($entity, 'profissionais_especialidades');

$upCategoryAndSpecialty = ProfessionalCategory::alterCategoryProfessional($entity->id);

//RETORNA AS CATEGORIAS DO AGENTE
$getCat = ProfessionalCategory::getCategoryEntity($entity->id, 'profissionais_categorias_profissionais_id');
?>


<div class="ficha-spcultura">
    <h3><?php \MapasCulturais\i::_e("Dados profissionais"); ?></h3>
    <div class="servico">

        <p><span class="label"><?php \MapasCulturais\i::_e("Currículo Lattes"); ?>:</span>
            <span class="js-editable <?php echo ($entity->isPropertyRequired($entity, "curriculoLattes") && $this->isEditable() ? 'required' : ''); ?>" data-edit="curriculoLattes" data-original-title="<?php \MapasCulturais\i::esc_attr_e("Currículo Lattes"); ?>" data-emptytext="<?php \MapasCulturais\i::esc_attr_e("Adicione o link do currículo lattes"); ?>">
                <?php echo $entity->curriculoLattes; ?>
            </span>
        </p>

        <p>
            <span class="label"><?php \MapasCulturais\i::_e("Grau acadêmico"); ?>:</span>
            <span class="js-editable  <?php echo ($entity->isPropertyRequired($entity, "profissionais_graus_academicos") && $editEntity ? 'required' : ''); ?>" data-edit="profissionais_graus_academicos" data-original-title="<?php \MapasCulturais\i::esc_attr_e("Grau académico"); ?>" data-emptytext="<?php \MapasCulturais\i::esc_attr_e("Selecione o grau académico"); ?>">
                <?php echo $entity->profissionais_graus_academicos; ?>
            </span>
        </p>
        <?php
        if ($this->controller->action === 'edit') : ?>
            <p>
                <!-- Categoria profissional -->
                <span class="label"><?php \MapasCulturais\i::_e("Categoria profissional"); ?>:</span> <span id="labelCategoriaProfissional"></span><br>
                <small>Selecione uma categoria e suas especialidades</small><br>

            <div>
                <select name="professionalCategory" id="professionalCategory">
                    <option value="0">--Selecione--</option>
                    <?php
                    if (is_array($allPro) && !empty($allPro)) :
                        foreach ($allPro as $key => $value) : ?>
                            <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                    <?php endforeach;
                    endif;
                    ?>
                </select>
            </div>
            </p>
        <?php endif;
        if ($this->controller->action === 'single') : ?>
            <p>
                <!-- Categoria profissional -->
                <span class="label"><?php \MapasCulturais\i::_e("Categoria profissional"); ?>:</span>
                <?php
                if (!empty($allPro)) :
                    foreach ($getCat as $key => $nameCategory) : ?>
                        <span class="tag tag-agent">
                            <?php echo $nameCategory; ?>
                        </span>
                <?php endforeach;
                endif;
                ?>
            </p>
            <p>
                <!-- Especialidade(s) profissional(is) -->
                <span class="label"><?php \MapasCulturais\i::_e("Especialidade(s)"); ?>:</span>
                <?php if (!empty($getSpecialty)) : ?>
                    <?php echo $getSpecialty; ?>
                <?php endif; ?>
            </p>
        <?php endif;
        if ($this->controller->action === 'edit') : ?>
            <p>
                <span class="label"><?php \MapasCulturais\i::_e("Especialidade"); ?>: </span> <span id="labelEspecialidadeProfissional"></span><br>
                <small>Selecione sua(s) especialidade(s)</small><br>
                <input type="hidden" name="states[]" id="specialtyCategoryProfessional" />
                <br>
                <button class="btn btn-primary" id="btnSaveCatSpecialty" style="margin-top: 10px;">Ok</button>
            </p>
        <?php endif; ?>
    </div>
</div>