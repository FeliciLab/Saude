<?php
namespace Saude\Controllers;

use DateTime;
use \MapasCulturais\App;
use \Saude\Entities\Resources as EntitiesResources;
use \Saude\Entities\ResourceMeta;
use MapasCulturais\Entities\OpportunityMeta;
// use Dompdf\Dompdf;
// require_once PROTECTED_PATH. 'vendor/dompdf/autoload.inc.php';

class Resources extends \MapasCulturais\Controller{

    function GET_index() {
        //$this->render('resources');
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
        $app = App::i();
        dump($app);
    }

    function POST_store() {
        $app = App::i();
        if(empty($this->postData['resource_text'])){

            $this->json(['title' => 'Erro','message' => 'O campo não pode ser vazio', 'type' => 'error'], 500);
        }
        // RECUPERANDO OS OBJETOS PARA RELACIONAMENTO
        $regId = $app->repo('Registration')->find($this->postData['registration_id']);
        $oppId = $app->repo('Opportunity')->find($this->postData['opportunity_id']);
        $ageId = $app->repo('Agent')->find($this->postData['agent_id']);
        $verifyPeriod = EntitiesResources::getEnabledResource($oppId);
        dump($verifyPeriod);
        die();
        // INICIANDO A INSTANCIA
        $app->disableAccessControl();
        $rec = new EntitiesResources;
        $rec->resourceText = $this->postData['resource_text'];
        $rec->registrationId = $regId;
        $rec->opportunityId = $oppId;
        $rec->agentId = $ageId;
        $date = new DateTime('now');
        $rec->resourceSend = $date;
        try {
            $app->em->persist($rec);
            $app->em->flush();
            $app->enableAccessControl();
            $this->json(['title' => 'Sucesso','message' => 'Seu recurso foi enviado com sucesso','id' => $rec->id, 'type' => 'success'], 200);
        } catch (Exception $e) {
            dump( $e->getMessage());
            // $this->json(['title' => 'Erro','message' => 'Ocorreu um erro inesperado, tente novamente!','type' => 'eror'], 500);
        } 
    }

    function GET_allResource() {
        try {
            $all = EntitiesResources::allResource();
            $this->json($all);
        } catch (Exception $e) {
            dump($e->getMessage());
        }
    }

    function GET_inforesource() {
        $text = EntitiesResources::inforesource($this->getData['reg'], $this->getData['opp']);        
        $textSimple = ['id' => $text[0]['id'], 'text' => $text[0]['resource_text']];
        $this->json($textSimple);
    }

    function GET_inforesourceReply() {
        $text = EntitiesResources::find($this->getData['id']);
        $this->json($text);
    }

    function PUT_replyResource() {
       
        if(
            empty($this->postData['resource_reply']) || 
            empty($this->postData['resource_status'])){
            $this->json(['title' => 'Erro','message' => 'Todos os campos deve ser preenchidos', 'type' => 'error'], 500);
        }
        if($this->postData['resource_status'] === 'Deferido' && $this->postData['status'] === '0' || $this->postData['resource_status'] === 'ParcialmenteDeferido' && $this->postData['status'] === '0'){
            $this->json(['title' => 'Erro','message' => 'Confira o Status do candidato. = ' .$this->postData['status'], 'type' => 'error'], 500);
        }
        $app = App::i();
        $date = new DateTime('now');
        $reply = $app->em->find('Saude\Entities\Resources', $this->putData['resource_id']);
        $reply->resourceReply = $this->putData['resource_reply'];
        $reply->resourceStatus = $this->putData['resource_status'];
        $reply->resourceDateReply = $date;

        //ALTERAR A NOTA FINAL
        if(!empty($this->putData['new_consolidated_result'])) {
            $max = EntitiesResources::maxPoint($reply->opportunityId->id);

            $reg = $app->repo('Registration')->find($reply->registrationId->id);
            if($this->putData['new_consolidated_result'] > $max) {
                $this->json(['title' => 'Ops!','message' => 'A nova nota não pode ser maior que a nota máxima', 'type' => 'error'], 401);
            }else{
                
                if(isset($this->putData['status']) && $this->putData['status'] == '1') {
                    $dql = "UPDATE MapasCulturais\Entities\Registration r 
                    SET r.status = 10 WHERE r.id = {$reg->id}";
                    $query      = $app->em->createQuery($dql);
                    $query->getResult();
                }
                $reg->consolidatedResult = $this->putData['new_consolidated_result'];
                $app->em->persist($reg);
            }
        }

        try {
            $app->em->persist($reply);
            $app->em->flush();
            $this->json(['title' => 'Sucesso','message' => 'Sua resposta foi enviado com sucesso', 'type' => 'success'], 200);
        } catch (Exception $th) {
            //throw new \Exception('Controller Id already in use');
            $this->json(['title' => 'Ops!','message' => 'Ocorreu um erro inesperado, tente mais tarde.', 'type' => 'error'], 500);
        }
        
    }

    function POST_publishResource() {
        //dump($this->postData);
        $res = EntitiesResources::publishResource($this->postData['opportunity_id']);
        if($res > 0) {
            $this->json([ 'title' => 'Sucesso', 'message' => 'Publicação realizada com sucesso', 'type' => 'success'], 200);
        }
        $this->json([ 'title' => 'Error', 'message' => 'Ocorreu um erro inesperado.', 'type' => 'error'], 500);
    }

    function GET_getNameOpportunity() {
        $app = App::i();
        $opp = $app->repo('Opportunity')->find($this->getData['id']);
        $this->json($opp->name);
    }

    function POST_candidateData() {
        $app = App::i();
        //dump($this->getData);
        $id = base64_decode($this->postData['id']);
        $report = EntitiesResources::find($id);

        $this->render('printResource', ['report' => $report]);
    }

    function POST_verifyResource() {
        $app = App::i();
        $reply = EntitiesResources::verifyResourceNotReply($this->postData['opportunityId']);
        if(count($reply) > 0){
            $this->json([ 'title' => 'Error', 'message' => 'Ainda existe recurso sem resposta', 'type' => 'error'], 401);
        }else{
            $this->json([ 'title' => 'Sucesso!', 'message' => 'Autorizado publicar', 'type' => 'success'], 200);
        }
    }

    function GET_pointMax() {
        $max = EntitiesResources::maxPoint($this->getData['opportunityId']);
        if(!empty($max)) {
            $this->json(['message' => $max], 200);
        }else{
            $this->json([ 'title' => 'Error', 'message' => 'Ainda existe recurso sem resposta', 'type' => 'error'], 401);   
        }
    }

    function POST_checksResourceEvaluator() {
        $app = App::i();
        //BUSCA E INSTANCIA UM OBJETO
        $check = EntitiesResources::find($this->postData['id']);
        //VERIFICANDO SE TEM UM ID DO AGENTE RESPONSÁVEL
        if($check->replyAgentId == null){
            //SALVANDO O ID DO USUARIO PARA CONSULTA NA TABELA AGENT NO CAMPO user_id
            $check->replyAgentId = $app->user->profile->id;
            $app->em->persist($check);
            $app->em->flush();
            $this->json(['message' => 'Esse recurso está com você'],200);
        }else{
            $evaluator = $app->repo('Agent')->find($check->replyAgentId);
            if($evaluator->id !== $app->user->profile->id){
                $this->json(['message' => 'Esse recurso está com '.$evaluator->name],401);
            }
            $this->json(['message' => 'Continue'],200);
        }
        
        
    }

    function POST_opportunityEnabled(){
        $app = App::i();
        //id oportunidade
        $id = $this->postData['opportunity'];
        //instancia da oportunidade
        $opportunity = $app->repo('Opportunity')->find($this->postData['opportunity']);
        $dql = "SELECT o
                FROM 
                MapasCulturais\Entities\OpportunityMeta o
                WHERE o.owner = {$id}
                ";
        $query = $app->em->createQuery($dql);
        $check = $query->getResult();
        $verify = false;
        foreach ($this->postData as $key => $value) {
            foreach ($check as $key2 => $value2) {
                if($key == $value2->key){
                    $upOpMeta = $app->repo('OpportunityMeta')->find($value2->id);
                    $upOpMeta->value = $value;
                    $upOpMeta->save(true);
                    $verify = true;
                }
            }  
        }

        $countLoop = 0;
        /*
        Verifica se já existe dados do recurso pela data de inicio
        percorrendo todo o objeto e adicionando valor ao countLoop 
        se não existir date-initial. 
        Se existir date-initial, o countLoop volta para zero.
        */
        for ($i=0; $i < count($check); $i++) { 
            if($check[$i]->key !== 'date-initial'){
                $countLoop++;
            }else{
                $countLoop = 0;
            }
        }
        $countVerify = false;
        //Verifica se o total de countLoop é igual ao tamnho do objeto. 
        if($countLoop == count($check)) {
            foreach ($this->postData as $key => $value) {
                $newOpMeta = new OpportunityMeta;
                $newOpMeta->owner = $opportunity;
                $newOpMeta->key = $key;
                $newOpMeta->value = $value;
                $app->em->persist($newOpMeta);
                $newOpMeta->save(true);
                $countVerify = true;
            }
        }

        //Retorna quando a data for altera. 
        if($verify){
            $this->json(['title' => 'Sucesso','message' => 'A data de recurso foi alterada com sucesso', 'type' => 'success'], 200);
        }

        //Retorna quando o período for inserido.
        if($countVerify){
            $this->json(['title' => 'Sucesso','message' => 'Período de recurso habilitado com sucesso', 'type' => 'success'], 200);
        }
    }

    function POST_disabledResource(){
        $app = App::i();
        $opp = $app->repo('OpportunityMeta')->findBy(['owner'=>$this->postData['id'],'key'=>'claimDisabled']);
        $opp[0]->value = 1;
        $opp[0]->save(true);
    }

    function DataBRtoMySQL( $DataBR ) 
    {
		$DataBR = str_replace(array(" – ","-"," "," "), " ", $DataBR);
		list($data) = explode(" ", $DataBR);
		return implode("-",array_reverse(explode("/",$data))) ;
	}
}