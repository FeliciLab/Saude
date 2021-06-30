<?php
namespace Saude\Controllers;

use DateTime;
use \MapasCulturais\App;
use Aw\Nusoap\NusoapClient;
//use nusoap_client;

 /**
 * Para uso do nusoap dentro do tema
 * require_once(__DIR__."/nusoap/lib/nusoap.php");
 * $client = new nusoap_client("http://www2.sefaz.ce.gov.br/InfoDaeService/InfoDae?wsdl", true);
 */

/**
 * Pacote de uso: https://github.com/AsistenteWeb/NuSOAP
 * Comentar NusoapClient.php - Linha 304
 */

class Dae extends \MapasCulturais\Controller{

    function GET_gerarBoleto() {
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
       
        $client = new NusoapClient("http://www2.sefaz.ce.gov.br/InfoDaeService/InfoDae?wsdl", true);

        $path = THEMES_PATH ."Saude/Controllers";
       
        $cert = $path . "arquivo.cer";
        $keyFile = $path . "chave.key";
        
        $client->use_curl                       = TRUE;
        $client->authtype                       = "certificate";
        $client->soap_defencoding               = "UTF-8";
        $client->certRequest["sslcertfile"]     = $cert;
        $client->certRequest["sslkeyfile"]      = $keyFile;
        $client->certRequest['passphrase']      = env('PASSPHRASE', '');
        $client->certRequest['certpassword']    = env('CERTPASSWORD', '');
        $client->certRequest["verifypeer"]      = false;
        $client->certRequest["verifyhost"]      = false;
        $client->certRequest["trace"]           = true;

        $data = new DateTime();
        $data_venc = $data->format('Y-m-d');
        
        //dump($data_venc);
        $dados =  array('numIdentificador' => NULL,
                        'codEmissor' => env('CODEMISSOR', ''),
                        'codProduto' => env('CODPRODUTO', ''),
                        'codReceita' => env('CODRECEITA', ''),
                        'numParcela' => '1',
                        'periodo' => date('Y'),
                        'datVenciento' => str_replace('-', '', $data_venc),//buscar no banco ou inserir manualmente
                        'docOrigem' => env('CODORIGEM', ''), 
                        'codCgf' => NULL, 
                        'tipCgcCpf' => 2, 
                        'codCgcCpf' => env('CODCGCCPF', ''),
                        'codMuninicipio' => 4400, 
                        'vlrPrincipal' => 0, //buscar no banco ou inserir manualmente
                        'vlrMulta' => 0,
                        'vlrJuros' => 0,
                        'vlrDescontos' => 0,
                        'vlrAtualPrincipal' => 0, 
                        'vlrAtualMulta' => 0,
                        'datValidade' => str_replace('-', '',  $data_venc),//buscar no banco ou inserir manualmente
                        'tipOrigem' => 1, 
                        'vetIdContribuinte1' => "<strong>Fulano de tal</strong>",//buscar no banco
                        'vetIdContribuinte2' => "CPF: 444.257.561-42",//buscar no banco
                        'vetIdContribuinte3' => "Augue platea phasellus cursus bibendum quis",//buscar no banco
                        'vetIdContribuinte4' => "",//buscar no banco
                        'vetIdContribuinte5' => "",//buscar no banco
                        'vetIdContribuinte6' => "",//buscar no banco
                        'vetInfComplementar1' => "Escola de Saude Publica do Ceara :: ESP-CE",
                        'vetInfComplementar2' => "CNPJ No. 73.695.868/0001-27",
                        'vetInfComplementar3' => "Av. Antonio Justa, 3161, Meireles",
                        'vetInfComplementar4' => "Fortaleza / Ceara",
                        'vetInfComplementar5' => "",
                        'codRetorno' => 0);
        # criando um vetor para passar por parametro pelo web service
        $parametros = array('arg0' => $dados, 'arg1' => 'RECEITA');
        # gera o resultado do DAE
       
        $resultDae = $client->call("gerarDae", $parametros);
        
        if ($client->fault) {
            echo '<h2>Falhou (Experado um requisição SOAP válida)</h2><pre>'; print_r($resultDae); echo '</pre>';
        } else {
            $err = $client->getError();
            if ($err) {
                echo '<h2>Erro: </h2><pre>' . $err . '</pre>';
            } else {
                echo '<h2>Resultado: </h2><pre>'; print_r($resultDae); echo '</pre>';
            }
        }
        dump($resultDae);
        dump($client);
        dump($dados);
        dump($keyFile);
        die;
    }
}