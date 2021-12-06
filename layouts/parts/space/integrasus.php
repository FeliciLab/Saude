<?php 
$this->enqueueScript('app', 'space', 'js/space.js');
?>
<link rel="stylesheet" type="text/css" href="https://daneden.github.io/animate.css/animate.min.css">
<div class="widget" id="infoIntegrasus">
    <h3>Informações <a href="#" style="color:#79d279"> <strong> Integrasus</strong> </a> </h3>
    <ul class="list-group">
        <li class="list-group-item"  title="Representa o tempo médio, em dias, que os pacientes permanecem internados.">
            <small><strong>Tempo médio de internamento: </strong>
            <label id="info_permanence_actual" class="badge_success"></label> dias 
            </small>
        </li>
        <li class="list-group-item">
            <small><strong>Taxa de ocupação dos leitos: </strong>
            <label id="info_ocupation" class="badge_success"></label> 
            </small>
        </li>
        <li class="list-group-item">
            <small><strong>Taxa de mortalidade hospitalar: </strong>
            <label id="info_hospital_mortality" class="badge_success"></label> 
            </small>
        </li>
        <li class="list-group-item">
            <small><strong>Atendimento Ambulatorial (anual): </strong>
            <label id="quantity_attendance_hospital_amb" 
                class="badge_success"></label>
            </small>
        </li>
        <li class="list-group-item">
            <small><strong>Atendimento Emergência (anual):  </strong>
            <label id="quantity_attendance_hospital_eme" 
                class="badge_success"></label>
            </small>
        </li>
    </ul>
    <div class="space"><br></div>
    <h3>Comparativo com outro mês e ano,</h3>
    <small class="text-danger" id="requiredMonthPermanence"><strong>Esses dois campos são obrigatórios</strong></small>      
    <select class="form-control" name="monthPermanence" id="monthPermanence">
        <option selected value='0'>-- Selecione o Mês --</option>
        <option value='1'>Janeiro</option>
        <option value='2'>Fevereiro</option>
        <option value='3'>Março</option>
        <option value='4'>Abril</option>
        <option value='5'>Maio</option>
        <option value='6'>Junho</option>
        <option value='7'>Julho</option>
        <option value='8'>Agosto</option>
        <option value='9'>Setembro</option>
        <option value='10'>Outubro</option>
        <option value='11'>Novembro</option>
        <option value='12'>Dezembro</option>
    </select>
    <small class="text-danger" id="requiredYearPermanence"><strong>Esse campo é obrigatório</strong></small>
    <select class="form-control" name="yearPermanence" id="yearPermanence">
        <option selected value='0'>-- Selecione o Ano --</option>
        <option value='2018'>2018</option>
        <option value='2019'>2019</option>
    </select>
    <button class="btn btn-success" id="btnComparativeIntegraSus">Consultar indicador</button>
    <div class="box-indicador animated bounceInUp" id="boxComparativeIntegrasus">
        <div class="box-body" id="bodyComparativeIntegrasus">
            <ul class="list-group">
                <li class="list-group-item">
                    <small><strong>Permanencia Atualmente: </strong>
                    <label id="info_permanence_actual_select" class="badge_success"></label> dias 
                    </small>
                </li>
                <li class="list-group-item">
                    <small><strong>Taxa de ocupação dos leitos: </strong>
                    <label id="info_ocupation_select" class="badge_success"></label> 
                    </small>
                </li>
                <li class="list-group-item">
                    <small><strong>Taxa de mortalidade hospitalar: </strong>
                    <label id="info_hospital_mortality_select" class="badge_success"></label> 
                    </small>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="box-indicador" id="iframeBoxIntegrasus">
</div>