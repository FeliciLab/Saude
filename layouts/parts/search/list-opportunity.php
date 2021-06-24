<header id="opportunity-list-header" class="entity-list-header clearfix" ng-show="data.global.filterEntity == 'opportunity'">
    <div class="clearfix">
        <div ng-if="data.global.type === 'edital' || data.global.type === 'concurso'">
        <h1><i class="fa fa-file-text" aria-hidden="true"></i></span> Editais e Concursos
        </div>
        <div ng-if="data.global.type !== 'edital' || data.global.type === 'concurso'">
        <h1><i class="fa fa-file-text" aria-hidden="true"></i></span> Oportunidades</h1>
        </div> 
    </div>
</header>

<div id="lista-dos-oportunidades" class="lista opportunity" infinite-scroll="data.global.filterEntity === 'opportunity' && addMore('opportunity')" ng-show="data.global.filterEntity === 'opportunity'">
    <div ng-if="data.global.type === 'edital' || data.global.type === 'concurso'">
        <?php $this->part('search/list-edital-item'); ?>
    </div>
    <div ng-if="data.global.type !== 'edital'|| data.global.type != 'concurso'">
        <?php $this->part('search/list-opportunity-item'); ?>
    </div>
</div>