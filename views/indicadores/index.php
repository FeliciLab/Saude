<style>
   /*Estilo da página Indicadores*/
   .box-indicadores {
      background: #4054B2;
      padding: 0.9rem;
   }

   .box-indicadores h1 {
      color: white;
      font-size: 1.4rem;
      line-height: unset;
      margin-bottom: unset;
      font-family: Roboto;
      padding-top: 10px;
   }

   .abas-indicadores li {
      list-style-type: none;
      margin: 0;
      padding: 0;
      width: 50%;
      display: table;
      /* Transforma a div numa tabela */
      table-layout: fixed;
      /* Utiliza o algoritmo de uma table fixed */
      border-collapse: separate;
      /* Colapsa a tabela para poder adicionar o espaçamento */
      border-spacing: 5px 0px;
      text-align: center;
      border-bottom: white;

   }

   .abas-indicadores li.active {
      border-bottom: 1px solid #4054B2;
   }

   .abas-indicadores li a {
      width: 100%;
      margin: 5px;
      background-color: white;
   }

   .clearfix-indicadores:after {
      content: '.';
      display: block;
      height: 0;
      clear: both;
      visibility: hidden;

   }

   .linhaprincipal {
      display: table-cell;
      background: white;
   }

   .container-iframe {
      position: relative;
      width: 100%;
      overflow: hidden;
      padding-top: 80%;
      margin-top: -26px;
   }

   @media (max-width:600px) {
      .container-iframe {
         position: relative;
         width: 100%;
         overflow: hidden;
         padding-top: 100%;
         padding-bottom: 100%;
         margin-top: -26px;
      }
   }

   .responsive-iframe {
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      width: 100%;
      height: 100%;
      border: none;
   }

   /*Fim do sstilo da página Indicadores*/
</style>

<div class="box-indicadores">
   <h1>Indicadores</h1>
</div>

<div class="abas-indicadores">
   <ul class="abas clearfix-indicadores clear">
      <li class="linhaprincipal active-indicadores"><a href="#instituicoes" rel='noopener noreferrer'>
            <div class="fa fa-building"></div><?php \MapasCulturais\i::_e(" Espaços de Saúde"); ?>
         </a></li>
      <li class="linhaprincipal active-indicadores"><a href="#profissionais" rel='noopener noreferrer'>
            <div class="fa fa-users"></div><?php \MapasCulturais\i::_e(" Profissionais"); ?>
         </a></li>
   </ul>
</div>
<div class="container-iframe">
   <iframe class="responsive-iframe" id="instituicoes" src="https://metabase.esp.ce.gov.br/public/dashboard/d42b7987-c687-48ad-af5b-fd252585cea4">
   </iframe>
   <iframe class="responsive-iframe" id="profissionais" src="https://metabase.esp.ce.gov.br/public/dashboard/e9f6d26f-3495-4556-a9eb-2a59e387755b">
   </iframe>
</div>