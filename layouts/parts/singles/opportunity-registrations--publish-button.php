<?php if ($entity->canUser('@control')): ?>
    <?php if ($entity->publishedRegistrations): ?>
        <div class="clearfix">
            <p class='alert success'><?php \MapasCulturais\i::_e("O resultado já foi publicado");?></p>
        </div>
    <?php else: ?>
        <div class="clearfix">
            <?php
            $sendEvaluation = $entity->evaluationMethodConfiguration->getAgentRelations();
            $totalEvaluator = count($sendEvaluation);// total de avaliadores
            $totalCheck = 0;// total de avaliadores que enviaram suas avaliações
            foreach ($sendEvaluation as $key => $evaluation) {
                if($evaluation->status == 10){
                    $totalCheck++;
                }
            }
            if($totalEvaluator == $totalCheck) :
                if ($entity->canUser('publishRegistrations')): ?>
                    <a id="btn-publish-results" class="btn btn-primary" href="<?php echo $app->createUrl('opportunity', 'publishRegistrations', [$entity->id]) ?>"><?php \MapasCulturais\i::_e("Publicar resultados");?></a>
                <?php else: ?>
                    <a id="btn-publish-results" class="btn btn-primary disabled hltip" title="<?php \MapasCulturais\i::esc_attr_e("Você só pode publicar a lista de aprovados após o término do período de inscrições.");?>"><?php \MapasCulturais\i::_e("Publicar resultados");?></a>
            <?php 
                endif;
            else:
            ?>
            <div class="alert info">
            <div class="close" style="cursor: pointer;"></div>
                <p>
                    <label for="">
                    O botão de publicar será habilitado após o envio das avaliações.
                    </label>
                </p>
            </div>
            <?php  
            endif;  
            ?>
        </div>
    <?php endif; ?>
<?php endif; ?>