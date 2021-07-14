<?php
use Saude\Entities\Resources;

$resources = Resources::resourceIdOpportunity($entity->id);
?>

<div id="resource" class="aba-content">
<table id="registrations-table" class="js-registration-list registrations-table" ng-class="{'no-options': data.entity.registrationCategories.length === 0, 'no-attachments': data.entity.registrationFileConfigurations.length === 0, 'registrations-results': data.entity.published, 'fullscreen': data.fullscreenTable}">
        <thead>
            <tr class="active">
                <!-- <th>Publicar</th> -->
                <th>Inscrição</th>
                <th ng-show="data.registrationTableColumns.category" ng-if="data.entity.registrationCategories" title="{{data.registrationCategory}}">
                <mc-select class="left transparent-placeholder" placeholder="status" model="registrationsFilters['category']" data="data.registrationCategoriesToFilter" title="{{data.registrationCategory}}"></mc-select>
            </th>
                <th>Agente</th>
                <th>Status</th>
                <th>Responder</th>
                <th>Responsável</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $agentReply = "";
        foreach ($resources as $key => $resource) {
            //pegando a instancia do objecto com o relacionamento
            $rec = Resources::find($resources[$key]['id']);

            $registration = $app->repo('Registration')->find($rec->registrationId->id);
            //  Se tiver avaliador responsável no banco
            if($resources[$key]['reply_agent_id'] !== NULL && $resources[$key]['reply_agent_id'] > 0) {
                $agentReply = $app->repo('Agent')->find($resources[$key]['reply_agent_id']);
            }
        ?>
            <tr>
                <td><?php echo $rec->registrationId->number; ?></td>
                <td ng-show="data.registrationTableColumns.category" ng-if="data.entity.registrationCategories" class="registration-option-col"><?php echo $rec->registrationId->category?></td>
                <td><?php echo $rec->agentId->name; ?></td>
                <td><?php echo $rec->resourceStatus; ?></td>
                <td>
                    <?php  
                       if(isset($resources[0]['resources_reply_publish']) && $resources[0]['resources_reply_publish'] == false) {
                        echo substr($rec->resourceReply, 0 , 30) ;
                    ?>...
                    <p>
                    <a href="#modal-resposta-recurso" onclick="showModalReply('<?php echo $rec->id; ?>', '<?php echo $entity->id; ?>', '<?php echo $rec->opportunityId->name; ?>','<?php echo $registration->consolidatedResult; ?>')" class="btn btn-info" title="Responder o recurso do <?php echo $rec->agentId->name; ?>">
                        <i class="fa fa-share-square" aria-hidden="true"></i> Responder Recurso
                    </a>
                    </p>
                    <?php }else{
                        echo 'Recurso já foi publicado';
                    } ?>
                </td>
                <td>
                    <?php 
                        ($resources[$key]['reply_agent_id'] !== NULL && $resources[$key]['reply_agent_id'] > 0) ? printf($agentReply->name) : $agentReply;
                    ?>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <div class="form-group">
    <?php if(isset($resources[0]['resources_reply_publish']) && $resources[0]['resources_reply_publish'] == false) { ?>
        <div id="div-publish">
            <button class="btn btn-primary" onclick="clickPublish(<?php echo $entity->id; ?>)"> 
                <i class="fa fa-bullhorn" aria-hidden="true"></i>
                Publicar Recurso
            </button>
        </div>
    <?php }elseif(isset($resources[0]['resources_reply_publish']) && $resources[0]['resources_reply_publish'] == true){ ?>
        <div id="div-alert-publish" class="text-success show-publish">
            <i class="fa fa-check"></i>
            <label for="" class="text-success">Recurso já enviado.</label>
        </div>
    </div>
    <?php } ?>
</div>
<!-- modal de resposta de recurso -->
<?php $this->part('modals/form-reply-resource') ?>
