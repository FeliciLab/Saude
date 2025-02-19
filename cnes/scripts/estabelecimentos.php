<?php

require_once "php-cnes-master/ws-security.php";
ini_set('display_errors', true);

$conMap = new PDO("pgsql:host=192.168.32.2;port=5432;dbname=mapas", "mapas", "mapas");
$conMap->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
if (!$conMap) {
    echo 'não conectou';
}



$row = 1;
if (($handle = fopen("../csv/estabelecimentos.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($data);
        for ($c=0; $c < $num; $c++) {
            try {
                $cnes = sprintf("%07s", $data[$c]);
                
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
    
    
                $nomeFantasia = $result->DadosGeraisEstabelecimentoSaude->nomeFantasia->Nome;
    
                $location = '(' . $result->DadosGeraisEstabelecimentoSaude->Localizacao->longitude . ', ' . $result->DadosGeraisEstabelecimentoSaude->Localizacao->latitude . ')';
    
                if ($result->DadosGeraisEstabelecimentoSaude->Localizacao->longitude == null) {
                    $location = '(0, 0)';
                }

                $endereco = $result->DadosGeraisEstabelecimentoSaude->Endereco;
                $codigoCnes = $result->DadosGeraisEstabelecimentoSaude->CodigoCNES->codigo;
                $dataAtualizacao = $result->DadosGeraisEstabelecimentoSaude->dataAtualizacao;
                $tipoUnidade = $result->DadosGeraisEstabelecimentoSaude->tipoUnidade->descricao;

                $telefone = 'Não informado';
                if (@isset($result->DadosGeraisEstabelecimentoSaude->Telefone)) {
                    $telefone = $result->DadosGeraisEstabelecimentoSaude->Telefone->DDD . '-' . $result->DadosGeraisEstabelecimentoSaude->Telefone->numeroTelefone;
                }
                $percenteAoSus = $result->DadosGeraisEstabelecimentoSaude->perteceSistemaSUS == 1 ? 'SIM' : 'NÃO';

                $servicos = $result->DadosGeraisEstabelecimentoSaude->servicoespecializados->servicoespecializado;


                $idTipo = retornaIdTipoEstabelecimentoPorNome($conMap, $tipoUnidade);
                if ($idTipo == null || $idTipo == '') {
                    echo $tipoUnidade . PHP_EOL;
                }
    
                $data = date('Y-m-d H:i:s');
                $idAgenteResponsavel = $argv[1]; //mudar esse valor, pois ? baseado no agente
                $sqlInsert = "INSERT INTO public.space (location, _geo_location, name, short_description, long_description, create_timestamp, status, is_verified, public, agent_id, type) 
                            VALUES ('" . $location . "', '0101000020E610000000000008A63E43C090B78B3B9BCF0DC0', '" . $nomeFantasia . "', '" . $nomeFantasia . "', '" . $nomeFantasia . "', '" . $data . "', 1, 'FALSE', 'FALSE', '" . $idAgenteResponsavel ."', $idTipo)";
                $conMap->exec($sqlInsert);
                $idSpace = $conMap->lastInsertId();

                
                if (isset($servicos)) {
                    $servicosArray = array();

                    if (is_array($servicos)) {
                        foreach ($servicos as $serv) {
                            // NECESSÁRIO TRATAR AS ACENTUAÇÕES QUE DO CNES VEM SEM ACENTUAÇÃO, E POR PADRÃO PRECISAMOS USAR COM O PORTUGUÊS CORRETO
                            if (!empty($serv->descricao)) {
                                $servicosArray[] = adicionarAcentos($serv->descricao);
                            }

                            $servicosString = implode(';', $servicosArray);
                        }
                    } else {
                        $servicosString = adicionarAcentos($servicos->descricao);
                    }  
                    
                    salvarEstabelecimentoMeta($conMap, $idSpace, 'instituicao_servicos', $servicosString);
                }

                salvarEstabelecimentoMeta($conMap, $idSpace, 'En_CEP', $endereco->CEP->numeroCEP);
                salvarEstabelecimentoMeta($conMap, $idSpace, 'En_Nome_Logradouro', $endereco->nomeLogradouro);
                salvarEstabelecimentoMeta($conMap, $idSpace, 'En_Num', $endereco->numero);
                salvarEstabelecimentoMeta($conMap, $idSpace, 'En_Bairro', $endereco->Bairro->descricaoBairro);
                salvarEstabelecimentoMeta($conMap, $idSpace, 'En_Municipio', $endereco->Municipio->nomeMunicipio);
                salvarEstabelecimentoMeta($conMap, $idSpace, 'En_Estado', $endereco->Municipio->UF->siglaUF);
                salvarEstabelecimentoMeta($conMap, $idSpace, 'instituicao_cnes', $codigoCnes);
                salvarEstabelecimentoMeta($conMap, $idSpace, 'instituicao_cnes_data_atualizacao', $dataAtualizacao);
                salvarEstabelecimentoMeta($conMap, $idSpace, 'instituicao_cnes_competencia', date('m/Y'));
                salvarEstabelecimentoMeta($conMap, $idSpace, 'instituicao_tipos_unidades', adicionarAcentos($tipoUnidade));
                salvarEstabelecimentoMeta($conMap, $idSpace, 'telefonePublico', $telefone);
                salvarEstabelecimentoMeta($conMap, $idSpace, 'instituicao_pertence_sus', $percenteAoSus);

                salvarSelos($conMap, $idSpace, $idAgenteResponsavel);
                
    
                $row++;
                // if ($row == 1000) {
                //     die;
                // }
            } catch (Exception $e) {
                echo 'Problema CNES: ' . $cnes . ' | erro: ' . $e->getMessage() . PHP_EOL;
                continue;
            }            
        }
    }
    fclose($handle);
}



function salvarEstabelecimentoMeta($conMap, $idSpace, $meta, $valor)
{

    $sql = "SELECT MAX(id)+1 FROM public.space_meta";
    $maxSpaceMeta = $conMap->query($sql);
    $id = $maxSpaceMeta->fetchColumn();

    $id = !empty($id) ? $id : 1;


    $sqlInsertMeta = "INSERT INTO public.space_meta (object_id, key, value, id) VALUES (
                                                                {$idSpace}, 
                                                                '{$meta}', 
                                                                '{$valor}',  
                                                                $id
                                                    )";
    $conMap->exec($sqlInsertMeta);
}

function adicionarAcentos($frase) 
{
    $arrayComAcento = ['ORGÃOS', 'CAPTAÇÃO','NOTIFICAÇÃO', 'PÚBLICA', 'LABORATÓRIO', 'GESTÃO', 'ATENÇÃO' , 'BÁSICA' , 'DOENÇA' , 'CRÔNICA', 'FAMÍLIA' ,  'ESTRATÉGIA' ,'COMUNITÁRIOS' , 'LOGÍSTICA' ,  'IMUNOBIOLÓGICOS', 'REGULAÇÃO', 'AÇÕES', 'SERVIÇOS', 'SERVIÇO', 'HANSENÍASE', 'MÓVEL', 'URGÊNCIAS', 'DIAGNÓSTICO', 'LABORATÓRIO', 'CLÍNICO', 'DISPENSAÇÃO', 'ÓRTESES' ,'PRÓTESES', 'REABILITAÇÃO', 'PRÁTICAS', 'URGÊNCIA', 'EMERGÊNCIA', 'VIGILÂNCIA', 'BIOLÓGICOS', 'FARMÁCIA', 'GRÁFICOS', 'DINÂMICOS', 'MÉTODOS', 'PATOLÓGICA', 'INTERMEDIÁRIOS', 'TORÁCICA', 'PRÉ-NATAL', 'IMUNIZAÇÃO', 'CONSULTÓRIO', 'VIOLÊNCIA','SITUAÇÃO', 'POPULAÇÕES' ,'INDÍGENAS', 'ASSISTÊNCIA', 'COMISSÕES', 'COMITÊS', 'SAÚDE', 'BÁSICA'];

    $arraySemAcento = ['ORGAOS', 'CAPTACAO','NOTIFICACAO', 'PUBLICA', 'LABORATORIO', 'GESTAO', 'ATENCAO' , 'BASICA' , 'DOENCA' , 'CRONICA', 'FAMILIA' ,'ESTRATEGIA' ,'COMUNITARIOS' , 'LOGISTICA' ,  'IMUNOBIOLOGICOS', 'REGULACAO' , 'ACOES', 'SERVICOS', 'SERVICO', 'HANSENIASE', 'MOVEL' , 'URGENCIAS', 'DIAGNOSTICO', 'LABORATORIO' , 'CLINICO', 'DISPENSACAO' ,'ORTESES' ,'PROTESES', 'REABILITACAO', 'PRATICAS', 'URGENCIA' , 'EMERGENCIA' , 'VIGILANCIA', 'BIOLOGICOS', 'FARMACIA', 'GRAFICOS' , 'DINAMICOS' , 'METODOS', 'PATOLOGICA', 'INTERMEDIARIOS', 'TORACICA', 'PRE-NATAL', 'IMUNIZACAO', 'CONSULTORIO', 'VIOLENCIA', 'SITUACAO', 'POPULACOES' ,'INDIGENAS', 'ASSISTENCIA', 'COMISSOES', 'COMITES', 'SAUDE', 'BASICA'];

    return str_replace($arraySemAcento , $arrayComAcento, $frase);
}

function salvarSelos($conMap, $idSpace, $idAgent)
{

    $sql = "SELECT MAX(id)+1 FROM public.seal_relation";
    $maxSealRelation = $conMap->query($sql);
    $id = $maxSealRelation->fetchColumn();

    $id = !empty($id) ? $id : 1;

    $dataHora = date('Y-m-d H:i:s');
    $sqlInsertSeal = "INSERT INTO public.seal_relation 
                    (id, seal_id, object_id, create_timestamp, status, object_type, agent_id, validate_date, renovation_request) 
                    VALUES ({$id} ,'2', '" . $idSpace . "', '{$dataHora}' , '1' , 'MapasCulturais\Entities\Space' , {$idAgent},
                    '2029-12-08 00:00:00' , true)";
            $conMap->exec($sqlInsertSeal);
}

function retornaIdTipoEstabelecimentoPorNome($conMap, $tipoNome)
{
    $tipoNome = adicionarAcentos($tipoNome);

    $sql = "SELECT id FROM public.term WHERE taxonomy='instituicao_tipos_unidades' AND term='{$tipoNome}'";
    $result = $conMap->query($sql);
    $id = $result->fetchColumn();
    return $id;
}
