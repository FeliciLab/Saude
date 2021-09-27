<style>

    .div-box {
        display: flex;
        align-items: center;
        justify-content: center;
        background: #2e6837;
    }

    .div-box a {
        margin: 15px;
        width: 200px;
        height: 300px;
        border-style: solid;
        border-width: 1px 1px 1px 1px;

        align-items: center;
        justify-content: center;
        background: #fff;
        position: relative;
        padding: 50px 30px 50px;
        -moz-box-shadow: 0 0 10px rgba(0,0,0,.1);
        -webkit-box-shadow: 0 0 10px rgba(0,0,0,.1);
        -o-box-shadow: 0 0 10px rgba(0,0,0,.1);
        box-shadow: 0 0 10px rgba(0,0,0,.1);
        border-top: 8px solid #f36821;
        z-index: 1;
        overflow: hidden;
        margin-bottom: 1em;
        font-weight: bold;
        text-align: center;
        color: #2e6837;
    }

    .div-box a:hover {
        border-top: 8px solid #FFF;
        background: #2e6837;
        color: #FFF;
        text-decoration: none;
    }
    
    h1 {
        color: #2e6837;
    }

    .icon-indicadores {
        font-size: 5em;
        margin-top: 120px;
    }

    .span-indicadores {
        margin-top: 100px;
    }


</style>
<div class="box">
    <h1>Mapa da Saúde - Indicadores</h1>
</div>

<div class="div-box">
    <a href="<?php echo $app->createUrl('indicadores', 'profissionaisDeSaude'); ?>">
        <span class="icon icon-panel icon-indicadores"></span><br><br>
        <span class="menu-item-label span-indicadores">FORÇA DE TRABALHO SAÚDE - PROFISSIONAIS DE SAÚDE</span>
    </a>

    <a href="<?php echo $app->createUrl('indicadores', 'profissionaisDeSaudeMedicos'); ?>">
        <span class="icon icon-panel icon-indicadores"></span><br><br>
        <span class="menu-item-label span-indicadores">FORÇA DE TRABALHO SAÚDE - MÉDICOS</span>

    </a>

    <a href="<?php echo $app->createUrl('indicadores', 'instituicoes'); ?>">
        <span class="icon icon-panel icon-indicadores"></span><br><br>
        <span class="menu-item-label span-indicadores">ESTABELECIMENTOS DE SAÚDE</span>

    </a>
</div>