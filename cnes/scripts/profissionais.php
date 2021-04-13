<?php

require_once "php-cnes-master/ws-security.php";
ini_set('display_errors', true);

$conMap = new PDO("pgsql:host=172.23.0.2;port=5432;dbname=mapas", "mapas", "mapas");
$conMap->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
if (!$conMap) {
    echo 'não conectou';
}

$row = 1;
if (($handle = fopen("../csv/profissionais.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($data);
        for ($c=0; $c < $num; $c++) {
            $cnss[] = $data[$c];
        }
    }
    fclose($handle);
}

$resultCNSS = array_unique($cnss);

foreach ($resultCNSS as $cns) {
    try {
    
        $options = array( 
            'location' => 'https://servicoshm.saude.gov.br/cnes/ProfissionalSaudeService/v1r0', 
            'encoding' => 'utf-8', 
            'soap_version' => SOAP_1_2,
            'connection_timeout' => 5,
            'trace'        => 1, 
            'exceptions'   => 1 
        );
    
        $client = new SoapClient('https://servicoshm.saude.gov.br/cnes/ProfissionalSaudeService/v1r0?wsdl', $options);   
        $client->__setSoapHeaders(soapClientWSSecurityHeader('CNES.PUBLICO', 'cnes#2015public'));
    
        $function = 'consultarProfissionalSaude';
    
        $arguments= array( 'prof' => array(
                                'FiltroPesquisaProfissionalSaude' => array(
                                    'CNS' => array(
                                        'numeroCNS'  => $cns
                                    )
                                )
                            )
                        );
    
        $result = $client->__soapCall($function, $arguments);

        $nomePessoa = $result->ProfissionalSaude->Nome->Nome;
        $cpf = $result->ProfissionalSaude->CPF->numeroCPF;
        $cnsMeta = $result->ProfissionalSaude->CNS->numeroCNS;
        $data = date('Y-m-d H:i:s');

        $idUsr = $argv[1]; 
        $sqlInsert = "INSERT INTO public.agent (user_id, type, name,  create_timestamp, status, is_verified, public_location, update_timestamp, short_description) 
            VALUES ({$idUsr}, 1, '{$nomePessoa}', '{$data}', '1', 'FALSE', 'TRUE', '{$data}', '{$nomePessoa}')";
        $conMap->exec($sqlInsert);
        $idAgent = $conMap->lastInsertId();
    
        salvarProfissionalMeta($conMap, $idAgent, 'documento', $cpf);
        salvarProfissionalMeta($conMap, $idAgent, 'cns', $cnsMeta);

        $cnessss = $result->ProfissionalSaude->CNES;

  
        if (is_array($cnessss)) {
            foreach ($cnessss as $cnesProfissional) {
                $vinculo = retornaVinculos($cns, $cnesProfissional->CodigoCNES->codigo);
 
                $sql3 = "SELECT object_id FROM public.space_meta WHERE key = 'instituicao_cnes' AND value = '{$cnesProfissional->CodigoCNES->codigo}'";
                $query3 = $conMap->query($sql3);
                $idSpace = $query3->fetchColumn();

                
                $sqlInsertAgentRelation = "INSERT INTO public.agent_relation (agent_id, object_type, object_id, type, has_control, create_timestamp, status) 
            VALUES ({$idAgent}, 'MapasCulturais\Entities\Space', '{$idSpace}', '{$vinculo->Vinculacaos->Vinculacao->CBOs->CBO->descricaoCBO}', 'FALSE', '{$data}', 1)";
                $conMap->query($sqlInsertAgentRelation);

            }
        } else {
            $sql3 = "SELECT object_id FROM public.space_meta WHERE key = 'instituicao_cnes' AND value = '{$cnessss->CodigoCNES->codigo}'";
            $query3 = $conMap->query($sql3);
            $idSpace = $query3->fetchColumn();

            $sqlInsertAgentRelation = "INSERT INTO public.agent_relation (agent_id, object_type, object_id, type, has_control, create_timestamp, status) 
            VALUES ({$idAgent}, 'MapasCulturais\Entities\Space', '{$idSpace}', '{$result->ProfissionalSaude->CBO->descricaoCBO}', 'FALSE', '{$data}', 1)";
            $conMap->query($sqlInsertAgentRelation);

            $location = retornaLatitudeLongitudeDoEstabelecimento($cnessss->CodigoCNES->codigo);
            if ($location != null) {
                $sqlUpdateLocation = "UPDATE public.agent SET location = '{$location}', _geo_location = '0101000020E610000000000008A63E43C090B78B3B9BCF0DC0' WHERE id = {$idAgent}";
                $conMap->query($sqlUpdateLocation);
            }
        }


        $row++;
        echo $row . PHP_EOL;
        // if ($row == 50) {
        //     die;
        // }
    } catch (Exception $e) {
        echo 'Problema CNS: ' . $cns . ' | erro: ' . $e->getMessage() . PHP_EOL;
        continue;
    }
}



function salvarProfissionalMeta($conMap, $agentId, $meta, $valor)
{

    $sql = "SELECT MAX(id)+1 FROM public.agent_meta";
    $maxAgentMeta = $conMap->query($sql);
    $id = $maxAgentMeta->fetchColumn();

    $id = !empty($id) ? $id : 1;


    $sqlInsertMeta = "INSERT INTO public.agent_meta (object_id, key, value, id) VALUES (
                                                                {$agentId}, 
                                                                '{$meta}', 
                                                                '{$valor}',  
                                                                $id
                                                    )";
    $conMap->exec($sqlInsertMeta);
}

function retornaVinculos($cns, $cnes)
{

    $tipoVinculo = retornaTipoDeVinculo($cns, $cnes);

    $options = array( 'location' => 'https://servicoshm.saude.gov.br/cnes/VinculacaoProfissionalService/v1r0',
	'encoding' => 'utf-8', 
	'soap_version' => SOAP_1_2,
	'connection_timeout' => 5,
	'trace'        => 1, 
	'exceptions'   => 1 );

	$client = new SoapClient('https://servicoshm.saude.gov.br/cnes/VinculacaoProfissionalService/v1r0?wsdl', $options);
	$client->__setSoapHeaders(soapClientWSSecurityHeader('CNES.PUBLICO', 'cnes#2015public'));

	$function = 'detalharVinculacaoProfissionalSaude';

	$arguments= array( 'vin' => array(
							'FiltroPesquisaVinculacao' => array(
                                'IdentificacaoProfissional' => array(
                                    'cns' => array(
                                        'numeroCNS'  => $cns
                                    )
                                ),
                                'IdentificacaoEstabelecimento' => array(
                                    'cnes' => array(
                                        'codigo'  => $cnes
                                    )
                                ),
                                'IdentificacaoVinculacao' => array(
                                        'tipoVinculacao'  => (int)$tipoVinculo
                                )
							)
	                    )
	                );

    $result = $client->__soapCall($function, $arguments);
    return $result;
}

function retornaTipoDeVinculo($cns, $cnes)
{
    $options = array( 'location' => 'https://servicoshm.saude.gov.br/cnes/VinculacaoProfissionalService/v1r0',
        'encoding' => 'utf-8',
        'soap_version' => SOAP_1_2,
        'connection_timeout' => 5,
        'trace'        => 1,
        'exceptions'   => 1 );

    $client = new SoapClient('https://servicoshm.saude.gov.br/cnes/VinculacaoProfissionalService/v1r0?wsdl', $options);
    $client->__setSoapHeaders(soapClientWSSecurityHeader('CNES.PUBLICO', 'cnes#2015public'));

    $function = 'pesquisarVinculacaoProfissionalSaude';

    $arguments= array( 'vin' => array(
        'FiltroPesquisaVinculacaos' => array(
            'IdentificacaoProfissional' => array(
                'cns' => array(
                    'numeroCNS'  => $cns
                )
            ),
            'IdentificacaoEstabelecimento' => array(
                'cnes' => array(
                    'codigo'  => $cnes
                )
            )

        ),
        'Paginacao' => array(
            'registroInicial'  => 1,
            'quantidadeRegistros' => 100,
            'totalRegistros' => 1000
        )
    )
    );

    $result = $client->__soapCall($function, $arguments);

    return $result->Vinculacaos->Vinculacao->codigoModVinculo;
}

function retornaLatitudeLongitudeDoEstabelecimento($cnes) 
{
    $options = array('location' => 'https://servicoshm.saude.gov.br/cnes/EstabelecimentoSaudeService/v1r0',
            'encoding' => 'utf-8',
            'soap_version' => SOAP_1_2,
            'connection_timeout' => 1800000,
            'trace' => 1,
            'exceptions' => 1);

    $client = new SoapClient('https://servicoshm.saude.gov.br/cnes/EstabelecimentoSaudeService/v1r0?wsdl', $options);
    $client->__setSoapHeaders(soapClientWSSecurityHeader('CNES.PUBLICO', 'cnes#2015public'));

    $function = 'consultarEstabelecimentoSaude';

    $arguments = array('est' =>
        array(
            'FiltroPesquisaEstabelecimentoSaude' => array(
                'CodigoCNES' => array(
                    'codigo' => $cnes
                )
            )
        )
    );

    $result = $client->__soapCall($function, $arguments);

    $location = '(' . $result->DadosGeraisEstabelecimentoSaude->Localizacao->longitude . ', ' . $result->DadosGeraisEstabelecimentoSaude->Localizacao->latitude . ')';

    if ($result->DadosGeraisEstabelecimentoSaude->Localizacao->longitude == null) {
        $location = '(0, 0)';
    }

    return $location;
} 
