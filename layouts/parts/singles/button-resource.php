<?php

use MapasCulturais\i;

$app = \MapasCulturais\App::i();
$user = $app->user;
$baseUrl = $app->_config['base.url'];

?>
<div class="opportunity-claim-button">
    <a class="btn btn-primary" href="<?php echo $baseUrl . 'painel/inscricoes/?id=' . $registration->id . '#' . $registration->id; ?>">
        Ir para página de recurso.
    </a>
</div>

<script>
    // remove o botão de abrir recurso padrão do mapas culturais
    $(document).ready(function () {
        $('.opportunity-claim-box').remove();
    });
</script>