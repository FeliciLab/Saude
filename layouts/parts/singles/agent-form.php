<style>
#editable-multiselect-profissionais_especialidades .edit-box {
    top: 0px !important
}
</style>
<?php 
use \Saude\Entities\ProfessionalCategory;
$allPro = ProfessionalCategory::allProfessional();

?>
<div class="ficha-spcultura">
    <?php if($this->isEditable() && $entity->shortDescription && strlen($entity->shortDescription) > 2000): ?>
        <div class="alert warning">
            <?php \MapasCulturais\i::_e("O limite de caracteres da descrição curta foi diminuido para 400, mas seu texto atual possui");?>
            <?php echo strlen($entity->shortDescription) ?>
            <?php \MapasCulturais\i::_e("caracteres. Você deve alterar seu texto ou este será cortado ao salvar.");?>
        </div>
    <?php endif; ?>
    <span class="js-editable <?php echo ($entity->isPropertyRequired($entity,"shortDescription") && $editEntity? 'required': '');?>" data-edit="shortDescription" data-original-title="<?php \MapasCulturais\i::esc_attr_e("Descrição Curta");?>" data-emptytext="<?php \MapasCulturais\i::esc_attr_e("Insira uma descrição curta");?>" data-showButtons="bottom" data-tpl='<textarea maxlength="400"></textarea>'><?php echo $this->isEditable() ? $entity->shortDescription : nl2br($entity->shortDescription); ?></span>

    <?php $this->applyTemplateHook('tab-about-service','before'); ?><!--. hook tab-about-service:before -->

    <div class="servico">
        <?php $this->applyTemplateHook('tab-about-service','begin'); ?><!--. hook tab-about-service:begin -->

        <?php if($this->isEditable() || $entity->site): ?>
            <p><span class="label"><?php \MapasCulturais\i::_e("Site");?>:</span>
            <?php if($this->isEditable()): ?>
                <span class="js-editable <?php echo ($entity->isPropertyRequired($entity,"site") && $editEntity? 'required': '');?>" data-edit="site" data-original-title="<?php \MapasCulturais\i::esc_attr_e("Site");?>" data-emptytext="<?php \MapasCulturais\i::esc_attr_e("Insira a url de seu site");?>"><?php echo $entity->site; ?></span></p>
            <?php else: ?>
                <a class="url" href="<?php echo $entity->site; ?>"><?php echo $entity->site; ?></a>
            <?php endif; ?>
        <?php endif; ?>

        <?php if($this->isEditable()): ?>
            <!-- Campo Nome Completo -->
            <p class="privado">
                <span class="icon icon-private-info"></span>
                <span class="label"><?php \MapasCulturais\i::_e("Nome Completo");?>:</span>
                <span class="js-editable <?php echo ($entity->isPropertyRequired($entity,"nomeCompleto") && $editEntity? 'required': '');?>" data-edit="nomeCompleto" data-original-title="<?php \MapasCulturais\i::esc_attr_e("Nome Completo ou Razão Social");?>" data-emptytext="<?php \MapasCulturais\i::esc_attr_e("Informe seu nome completo ou razão social");?>">
                    <?php echo $entity->nomeCompleto; ?>
                </span>
            </p>
            <!-- Campo CPF/CNPJ -->
            <p class="privado">
                <span class="icon icon-private-info"></span>
                <span class="label"><?php \MapasCulturais\i::_e("CPF/CNPJ");?>:</span>
                <span class="js-editable <?php echo ($entity->isPropertyRequired($entity,"documento") && $editEntity? 'required': '');?>" data-edit="documento" data-original-title="<?php \MapasCulturais\i::esc_attr_e("CPF/CNPJ");?>" data-emptytext="<?php \MapasCulturais\i::esc_attr_e("Informe seu CPF ou CNPJ com pontos, hífens e barras");?>">
                    <?php echo $entity->documento; ?>
                </span>
            </p>
            <!-- Campo Data de Nascimento / Fundação -->
            <p class="privado">
                <span class="icon icon-private-info"></span>
                <span class="label"><?php \MapasCulturais\i::_e("Data de Nascimento/Fundação");?>:</span>
                <span class="js-editable <?php echo ($entity->isPropertyRequired($entity,"dataDeNascimento") && $this->isEditable()? 'required': '');?>" <?php echo $entity->dataDeNascimento ? "data-value='".$entity->dataDeNascimento . "'" : ''?>  data-type="date" data-edit="dataDeNascimento" data-viewformat="dd/mm/yyyy" data-showbuttons="false" data-original-title="<?php \MapasCulturais\i::esc_attr_e("Data de Nascimento/Fundação");?>" data-emptytext="<?php \MapasCulturais\i::esc_attr_e("Insira a data de nascimento ou fundação do agente");?>">
                    <?php $dtN = (new DateTime)->createFromFormat('Y-m-d', $entity->dataDeNascimento); echo $dtN ? $dtN->format('d/m/Y') : ''; ?>
                </span>
            </p>
            <!-- Gênero -->
            <p class="privado">
                <span class="icon icon-private-info"></span>
                <span class="label"><?php \MapasCulturais\i::_e("Gênero");?>:</span>
                <span class="js-editable <?php echo ($entity->isPropertyRequired($entity,"genero") && $editEntity? 'required': '');?>" data-edit="genero" data-original-title="<?php \MapasCulturais\i::esc_attr_e("Gênero");?>" data-emptytext="<?php \MapasCulturais\i::esc_attr_e("Selecione o gênero se for pessoa física");?>">
                    <?php echo $entity->genero; ?>
                </span>
            </p>
            <!-- Orientação Sexual -->
            <p class="privado"><span class="icon icon-private-info"></span>
                <span class="label"><?php \MapasCulturais\i::_e("Orientação Sexual");?>:</span>
                <span class="js-editable <?php echo ($entity->isPropertyRequired($entity,"orientacaoSexual") && $editEntity? 'required': '');?>" data-edit="orientacaoSexual" data-original-title="<?php \MapasCulturais\i::esc_attr_e("Orientação Sexual");?>" data-emptytext="<?php \MapasCulturais\i::esc_attr_e("Selecione uma orientação sexual se for pessoa física");?>">
                    <?php echo $entity->orientacaoSexual; ?>
                </span>
            </p>
            <!-- Raça/Cor -->
            <p class="privado"><span class="icon icon-private-info"></span>
                <span class="label"><?php \MapasCulturais\i::_e("Raça/Cor");?>:</span>
                <span class="js-editable  <?php echo ($entity->isPropertyRequired($entity,"raca") && $editEntity? 'required': '');?>" data-edit="raca" data-original-title="<?php \MapasCulturais\i::esc_attr_e("Raça/cor");?>" data-emptytext="<?php \MapasCulturais\i::esc_attr_e("Selecione a raça/cor se for pessoa física");?>">
                    <?php echo $entity->raca; ?>
                </span>
            </p>
            <!-- E-mail privado-->
            <p class="privado"><span class="icon icon-private-info"></span>
                <span class="label"><?php \MapasCulturais\i::_e("Email Privado");?>:</span>
                <span class="js-editable <?php echo ($entity->isPropertyRequired($entity,"emailPrivado") && $editEntity? 'required': '');?>" data-edit="emailPrivado" data-original-title="<?php \MapasCulturais\i::esc_attr_e("Email Privado");?>" data-emptytext="<?php \MapasCulturais\i::esc_attr_e("Insira um email que não será exibido publicamente");?>">
                    <?php echo $entity->emailPrivado; ?>
                </span>
            </p>
        <?php endif; ?>

        <!-- Email Público -->
        <?php if($this->isEditable() || $entity->emailPublico): ?>
            <p><span class="label"><?php \MapasCulturais\i::_e("E-mail");?>:</span>
                <span class="js-editable <?php echo ($entity->isPropertyRequired($entity,"emailPublico") && $this->isEditable()? 'required': '');?>" data-edit="emailPublico" data-original-title="<?php \MapasCulturais\i::esc_attr_e("Email Público");?>" data-emptytext="<?php \MapasCulturais\i::esc_attr_e("Insira um email que será exibido publicamente");?>">
                    <?php echo $entity->emailPublico; ?>
                </span>
            </p>
        <?php endif; ?>

        <!-- Email Público -->
        <?php if($this->isEditable() || $entity->telefonePublico): ?>
            <p><span class="label"><?php \MapasCulturais\i::_e("Telefone Público");?>:</span>
                <span class="js-editable js-mask-phone <?php echo ($entity->isPropertyRequired($entity,"telefonePublico") && $this->isEditable()? 'required': '');?>" data-edit="telefonePublico" data-original-title="<?php \MapasCulturais\i::esc_attr_e("Telefone Público");?>" data-emptytext="<?php \MapasCulturais\i::esc_attr_e("Insira um telefone que será exibido publicamente");?>">
                    <?php echo $entity->telefonePublico; ?>
                </span>
            </p>
        <?php endif; ?>

        <?php if($this->isEditable()): ?>
            <!-- Telefone Privado 1 -->
            <p class="privado"><span class="icon icon-private-info"></span>
                <span class="label"><?php \MapasCulturais\i::_e("Telefone 1");?>:</span>
                <span class="js-editable js-mask-phone <?php echo ($entity->isPropertyRequired($entity,"telefone1") && $this->isEditable()? 'required': '');?>" data-edit="telefone1" data-original-title="<?php \MapasCulturais\i::esc_attr_e("Telefone Privado");?>" data-emptytext="<?php \MapasCulturais\i::esc_attr_e("Insira um telefone que não será exibido publicamente");?>">
                    <?php echo $entity->telefone1; ?>
                </span>
            </p>
            <!-- Telefone Privado 2 -->
            <p class="privado"><span class="icon icon-private-info"></span>
                <span class="label"><?php \MapasCulturais\i::_e("Telefone 2");?>:</span>
                <span class="js-editable js-mask-phone <?php echo ($entity->isPropertyRequired($entity,"telefone2") && $this->isEditable()? 'required': '');?>" data-edit="telefone2" data-original-title="<?php \MapasCulturais\i::esc_attr_e("Telefone Privado");?>" data-emptytext="<?php \MapasCulturais\i::esc_attr_e("Insira um telefone que não será exibido publicamente");?>">
                    <?php echo $entity->telefone2; ?>
                </span>
            </p>
        <?php endif; ?>

        <!-- Grau acadêmico -->
        <p>
            <span class="label"><?php \MapasCulturais\i::_e("Grau acadêmico");?>:</span>
            <span class="js-editable  <?php echo ($entity->isPropertyRequired($entity,"profissionais_graus_academicos") && $editEntity? 'required': '');?>" data-edit="profissionais_graus_academicos" data-original-title="<?php \MapasCulturais\i::esc_attr_e("Grau académico");?>" data-emptytext="<?php \MapasCulturais\i::esc_attr_e("Selecione o grau académico");?>">
                <?php echo $entity->profissionais_graus_academicos; ?>
            </span>
        </p>   

        <!-- Categoria profissional -->
        <p>
            <span class="label"><?php \MapasCulturais\i::_e("Categoria profissional");?>:</span>
            <editable-multiselect entity-property="profissionais_categorias_profissionais" empty-label="<?php \MapasCulturais\i::esc_attr_e('Selecione');?>" allow-other="true" box-title="<?php \MapasCulturais\i::esc_attr_e('Categoria profissional:');?>"></editable-multiselect>
        </p>
        <p>
            <div>
            
            </div>
        </p>
        <?php 
        //  dump($entity->metadata['profissionais_categorias_profissionais']);
        //  die;
        if($this->isEditable()): ?>
            <input type="hidden" id="nameSelectAgentMeta" value="<?php echo $entity->metadata['profissionais_categorias_profissionais']; ?>">
            <!-- <span class="label"><?php \MapasCulturais\i::_e("Categoria profissional");?>:</span> -->
            <!-- <select name="professionalCategory" id="professionalCategory">
                <option value="0">--Selecione--</option>
                <?php foreach ($allPro as $key => $value) : ?>
                    <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                <?php endforeach; ?>
            </select> -->
        <?php endif; ?>
        <!-- Especialidades -->
        <p>
            <span class="label"><?php \MapasCulturais\i::_e("Especialidade");?>: </span>
            <editable-multiselect entity-property="profissionais_especialidades" empty-label="<?php \MapasCulturais\i::esc_attr_e('Selecione');?>" allow-other="true" box-title="<?php \MapasCulturais\i::esc_attr_e('Especialidade física:');?>"></editable-multiselect>
        </p>
        <?php $this->applyTemplateHook('tab-about-service','end'); ?><!--. hook tab-about-service:end -->
    </div><!--.servico -->

    <?php $this->applyTemplateHook('tab-about-service','after'); ?><!--. hook tab-about-service:after -->

</div>