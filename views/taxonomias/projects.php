<?php
use MapasCulturais\App;

$this->layout = 'panel';

$app = \MapasCulturais\App::i();
$subsite = $app->getCurrentSubsite();
$this->includeMapAssets();  
$this->includeSearchAssets(); 
$this->bodyProperties['ng-app'] = "taxonomies";
$this->jsObject['deleteType'] = "project";
?>
<?php $this->applyTemplateHook('content','before'); ?>
<div class="panel-main-content">
   
<?php $this->applyTemplateHook('content','begin'); ?>
    <?php if($subsite && $subsite->canUser('modify')):?>
    <p class="highlighted-message" style="margin-top:-2em;">
        <?php printf(\MapasCulturais\i::__('Você é administrador deste subsite. Clique %saqui%s para configurar.'), '<a rel="noopener noreferrer" href="' . $subsite->singleUrl . '">', '</a>'); ?>
    </p>
    <?php endif; ?>
    <div class="panel panel-default">
        <div class="panel-heading"><?php \MapasCulturais\i::_e('Taxonomias dos Projetos'); ?></div>
        <div class="panel-body">
       
            <div ng-controller="TaxonomiaController">
                <?php 
                    $taxo = [
                        'project_type' => 'Tipos de projeto', 
                        'project_taxonomia' => 'Taxonomia do Projeto'
                    ];
                $this->part('taxonomy/form', ['taxo' => $taxo]); ?>
                <div>
                    <?php $this->part('taxonomy/table-taxonomy');
                        // ARRAY DE CONFIGURAÇÃO PARA USO DO COMPONENTE
                        $data = [
                            'nameHook'          => 'sync-taxo',
                            'titleTaxo'         => 'Type de projeto',
                            'descriptionTaxo'   => "Alterar os types atuais pelos os id's da taxonomia.",
                            'taxonomy'          => 'project_type',
                            'entity'            => 'Project'
                        ];
                        $this->part('taxonomy/sync-taxo', ['data' => $data]);
                    ?>
                </div>
            </div>
        </div>
    </div>
    
</div>
