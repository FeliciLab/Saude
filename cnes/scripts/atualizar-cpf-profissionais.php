<?php

namespace Saude\cnes\scripts;

require_once "php-cnes-master/ws-security.php";

require '/var/www/html/protected/application/bootstrap.php';

use MapasCulturais\App;
use PDO;
use SoapClient;

$app = App::i();


$driver = env('CNES_DW_DB_DRIVE');
$host = env('CNES_DW_DB_HOST');
$port = env('CNES_DW_DB_PORT');
$name = env('CNES_DW_DB_NAME');
$username = env('CNES_DW_DB_USERNAME');
$password = env('CNES_DW_DB_PASSWORD');

$conMap = new PDO($driver . ":host=" . $host . ";port=" . $port . ";dbname=" . $name, $username, $password);
$conMap->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
if (!$conMap) {
    echo 'não conectou';
}

$sql = "SELECT DISTINCT cns FROM cns_prof_cpf WHERE cpf = ''";

$sth = $conMap->prepare($sql);
$sth->execute();
$cnss = $sth->fetchAll();

$cont = 0;

echo ("====== Dados Profissional ======" . PHP_EOL);

foreach ($cnss as $cns) {
    echo ($cns[0] . PHP_EOL);
    $options = array(
        'location' => 'https://servicoshm.saude.gov.br/cnes/ProfissionalSaudeService/v1r0',
        'encoding' => 'utf-8',
        'soap_version' => SOAP_1_2,
        'connection_timeout' => 180,
        'trace'        => 1,
        'exceptions'   => 1
    );

    $client = new \SoapClient('https://servicoshm.saude.gov.br/cnes/ProfissionalSaudeService/v1r0?wsdl', $options);
    $client->__setSoapHeaders(soapClientWSSecurityHeader('CNES.PUBLICO', 'cnes#2015public'));

    $function = 'consultarProfissionalSaude';

    $arguments = array(
        'prof' => array(
            'FiltroPesquisaProfissionalSaude' => array(
                'CNS' => array(
                    'numeroCNS'  => $cns[0]
                )
            )
        )
    );

    try {
        $result = $client->__soapCall($function, $arguments);
    } catch (\Exception $e) {
        echo ($e->getMessage() . PHP_EOL);

        continue;
    }

    print("<pre> CPF:" . print_r($result->ProfissionalSaude->CPF->numeroCPF, true) . "</pre>" . PHP_EOL);
    print("<pre> CNS:" . print_r($cns[0], true) . "</pre>" . PHP_EOL);
    $cpf = $result->ProfissionalSaude->CPF->numeroCPF;
    $num_cns = $cns[0];

    $sql = "UPDATE cns_prof_cpf SET cpf = '$cpf' where cns = '$num_cns'";
    $sth = $conMap->prepare($sql);
    $sth->execute();

    print("<pre> Contador:" . print_r($cont, true) . "</pre>" . PHP_EOL);

    $cont++;
}

?>