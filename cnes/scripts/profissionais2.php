<?php

require_once "php-cnes-master/ws-security.php";
ini_set('display_errors', true);

$conMap = new PDO("pgsql:host=192.168.32.2;port=5432;dbname=mapas", "mapas", "mapas");
$conMap->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
if (!$conMap) {
    echo 'não conectou';
}

$row = 1;
if (($handle = fopen("../csv/profissionais2.csv", "r")) !== FALSE) {
  while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
    $num = count($data);
    $row++;
    for ($c=0; $c < $num; $c++) {
        $profissionais[] = explode(';', $data[$c]);
    }
  }
  fclose($handle);
}
array_shift($profissionais);
foreach ($profissionais as $profissional) {
    $nome = $profissional[0];
    $cns = $profissional[1];
    $cbo = $profissional[6] . ' - '. $profissional[7];
    $cnes = $profissional[8];

    $data = date('Y-m-d H:i:s');

    $sqlExisteProfissional = "SELECT id FROM public.agent WHERE name = '{$nome}'";
    $queryExisteProfissional= $conMap->query($sqlExisteProfissional);
    $idExisteProfissional = $queryExisteProfissional->fetchColumn();

    if ($idExisteProfissional > 0) {

        $sql3 = "SELECT object_id FROM public.space_meta WHERE key = 'instituicao_cnes' AND value = '{$cnes}'";
        $query3 = $conMap->query($sql3);
        $idSpace = $query3->fetchColumn();

        if ($idSpace > 0 ) {
            $sqlInsertAgentRelation = "INSERT INTO public.agent_relation (agent_id, object_type, object_id, type, has_control, create_timestamp, status) 
            VALUES ({$idExisteProfissional}, 'MapasCulturais\Entities\Space', '{$idSpace}', '{$cbo}', 'FALSE', '{$data}', 1)";
                $conMap->query($sqlInsertAgentRelation);
        }

    } else {
        $idUsr = $argv[1]; 
        $sqlInsert = "INSERT INTO public.agent (user_id, type, name,  create_timestamp, status, is_verified, public_location, update_timestamp, short_description) 
            VALUES ({$idUsr}, 1, '{$nome}', '{$data}', '1', 'FALSE', 'TRUE', '{$data}', '{$nome}')";
        $conMap->exec($sqlInsert);
        $idAgent = $conMap->lastInsertId();
    
        salvarProfissionalMeta($conMap, $idAgent, 'cns', $cns);

        $sql3 = "SELECT object_id FROM public.space_meta WHERE key = 'instituicao_cnes' AND value = '{$cnes}'";
        $query3 = $conMap->query($sql3);
        $idSpace = $query3->fetchColumn();

        if ($idSpace > 0 ) {
            $sqlInsertAgentRelation = "INSERT INTO public.agent_relation (agent_id, object_type, object_id, type, has_control, create_timestamp, status) 
            VALUES ({$idAgent}, 'MapasCulturais\Entities\Space', '{$idSpace}', '{$cbo}', 'FALSE', '{$data}', 1)";
                $conMap->query($sqlInsertAgentRelation);
        }
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