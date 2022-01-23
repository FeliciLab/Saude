<div ng-click="editbox.open('editbox-select-registration-owner_', $event)">
    <i class="fa fa-question-circle-o"></i>
</div>
<edit-box id="editbox-select-registration-owner_" position="bottom" cancel-label="<?php \MapasCulturais\i::esc_attr_e("Fechar"); ?>" close-on-cancel='true' spinner-condition="data.registrationSpinner">
                
                <!-- Conteúdo do edit-box -->
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
           