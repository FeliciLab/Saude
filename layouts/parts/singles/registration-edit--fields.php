<div ng-if="data.fields.length > 0" id="registration-attachments" class="registration-fieldset registration-edit-mode">
    <!--
    <h4><?php \MapasCulturais\i::_e("Campos adicionais");?></h4>
    <p class="registration-help"><?php \MapasCulturais\i::_e("Para efetuar sua inscrição, informe os campos abaixo.");?></p>
    -->
    <ul class="attachment-list" ng-controller="RegistrationFieldsController">
        <li id="wrapper-{{field.fieldName}}" ng-repeat="field in ::data.fields" ng-if="showField(field)" on-repeat-done="registration-fields" data-field-name="{{field.fieldName}}" class="attachment-list-item registration-edit-mode attachment-list-item-type-{{field.fieldType}}">
            {{ (fieldName = field.fieldName) && false ? '' : ''}}
            
            <?php 
            $definitions = \MapasCulturais\App::i()->getRegisteredRegistrationFieldTypes();

            foreach($definitions as $def) {
                $this->part($def->viewTemplate);
            }
            ?>
            
            <div ng-if="::field.fieldType !== 'file'" ng-repeat="error in field.error" class="alert danger">{{error}}</div>
            
            <div ng-class="field.error ? 'invalidField': '' " ng-if="::field.fieldType === 'file'" id="file_{{::field.id}}" >
                <span class="label"> 
                    {{::field.title}}
                    <span ng-if="::field.required "><?php \MapasCulturais\i::_e('obrigatório'); ?></span>
                </span>

                <div class="attachment-description">
                    <span ng-if="::field.description">{{::field.description}}</span>
                    <span ng-if="::field.template">
                        (<a class="attachment-template" target="_blank" href="{{::field.template.url}}" rel='noopener noreferrer'><?php \MapasCulturais\i::_e("baixar modelo");?></a>)
                    </span>
                </div>
                <a ng-if="!field.multiple && field.file" class="delete delete-attachment" ng-if="field.file" ng-click="removeFile(file)" title="<?php \MapasCulturais\i::esc_attr_e("excluir anexo");?>"></a>
                <a ng-if="!field.multiple && field.file" class="attachment-title" href="{{field.file.url}}" target="_blank" rel='noopener noreferrer'>{{field.file.name}}</a>
                
                <p ng-if="field.multiple" ng-repeat="file in field.file" id="{{file.id}}">
                    <a class="delete delete-attachment" ng-if="field.file" ng-click="removeFile(file)" title="<?php \MapasCulturais\i::esc_attr_e("excluir anexo");?>"></a>
                    {{file.description}} - <a class="attachment-title" href="{{file.url}}" target="_blank" rel='noopener noreferrer'>{{file.name}}</a>

                </p>
                <div class="btn-group" ng-if="::!field.multiple">
                    <!-- se já subiu o arquivo-->
                    <!-- se não subiu ainda -->
                    <a class="btn btn-default" ng-class="{'send':!field.file,'edit':field.file}" ng-click="openFileEditBox(field.id, $index, $event)" title="{{!field.file ? 'enviar' : 'editar'}} <?php \MapasCulturais\i::_e("anexo");?>">{{!field.file ? 'Enviar' : 'Editar'}}</a>
                </div>
                <div class="btn-group" ng-if="::field.multiple">
                    <!-- se já subiu o arquivo-->
                    <!-- se não subiu ainda -->
                    <a class="btn btn-default send" ng-click="openFileEditBox(field.id, $index, $event)" title="Enviar anexo">Enviar</a>
                </div>
                <div ng-repeat="error in field.error" class="alert danger">{{error}}</div>
                <edit-box id="editbox-file-{{::field.id}}" position="bottom" title="{{::field.title}} {{::field.required ? '*' : ''}}"
                          cancel-label ="<?php \MapasCulturais\i::esc_attr_e("Cancelar");?>"
                          submit-label ="<?php \MapasCulturais\i::esc_attr_e("Enviar anexo");?>"
                          loading-label="<?php \MapasCulturais\i::esc_attr_e("Carregando ...");?>"
                          on-submit="sendFile" close-on-cancel='true' index="{{$index}}" spinner-condition="data.uploadSpinner">

                    <form class="js-ajax-upload" method="post" action="{{uploadUrl}}" data-group="{{::field.groupName}}"  enctype="multipart/form-data">
                        <div class="alert danger hidden"></div>
                        <label ng-if="::field.multiple">
                            Descrição:
                            <input type="input" name="description[{{::field.groupName}}]" />
                        </label>
                        
                        <p>Selecione seu anexo:</p>
                        <input type="file" name="{{::field.groupName}}" />
                        <p class="form-help">Consulte o edital desta oportunidade para entender as limitações de tamanho e formato dos arquivos solicitados.</p>
                        <div class="js-ajax-upload-progress">
                            <div class="progress">
                                <div class="bar"></div>
                                <div class="percent">0%</div>
                            </div>
                        </div>
                    </form>
                </edit-box>
            </div>
        </li>
    </ul>
</div>
