<?php
namespace Saude\Controllers;

use DateTime;
use \MapasCulturais\App;
use \Saude\Entities\ProfessionalCategory as CategoryPro;
use \Saude\Entities\CategoryMeta;
use \MapasCulturais\Entities\AgentMeta;

class ProfessionalCategory extends \MapasCulturais\Controller{

    public function __construct() {
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
        $app = App::i();
        $user = $app->user;
        if(!$user->is('saasAdmin') || !$user->is('superAdmin')) {
            $_SESSION['not_admin_error'] = 'Usuário não tem permissão para gerenciar esta página';
            return $app->redirect($app->createUrl('painel'));
        }
    }

    function GET_index() {
        $this->render('index');
    }

    function GET_allProfessional() {
        $all = CategoryPro::allProfessional();
        $this->json($all);
    }

    function POST_allCategory() {
        $cat = CategoryMeta::getAllCategory($this->postData['id'],  $this->postData['key']);
        $this->json($cat);
    }

    function POST_store() {
        $app = App::i();
        $now = new \DateTime;

        $catPro = new CategoryPro;
        $catPro->name = $this->postData['name'];
        $app->em->persist($catPro);
        $app->em->flush();
        return $this->json(['title' => 'Sucesso','message' => 'Categoria profissional cadastrada com sucesso','type' => 'success', 'status' => 200], 200);
    }

    function POST_update() {
        $app = App::i();
        $cat = $app->em->find('Saude\Entities\ProfessionalCategory', $this->postData['id']);
        $cat->name = $this->postData['name'];
        $app->em->persist($cat);
        $app->em->flush();
        return $this->json(['title' => 'Sucesso','message' => 'Categoria profissional alterada com sucesso','type' => 'success', 'status' => 200], 200);
    }

    function DELETE_delete() {
        $app = App::i();
        $cat = $app->em->find('Saude\Entities\ProfessionalCategory',$this->data['id']);
        $cat->delete();
        $app->em->flush();
        return $this->json(['title' => 'Sucesso','message' => 'Categoria profissional excluida com sucesso','type' => 'success', 'status' => 200], 200);
    }

    function GET_especialidade() {
        $app = App::i();
        $user = $app->user;
        $cat = $app->em->find('Saude\Entities\ProfessionalCategory',$this->data['id']);
        $this->render('specialty',['cat' => $cat]);
    }

    function POST_categoria_meta() {
        $app = App::i();
        $cat = new CategoryMeta;
        $cat->key   = $this->postData['nameProfessional'];
        $cat->value = $this->postData['nameSpecialty'];
        $cat->owner = $this->postData['idProfessional'];
        $app->em->persist($cat);
        $app->em->flush();
        $this->json(['title' => 'Sucesso','message' => 'Especialidade profissional cadastrada com sucesso','type' => 'success', 'status' => 200], 200);
    }

    function POST_alterAgentMeta() {
        
        $app = App::i();
        $pieces = [];
       
        $strstr1 = strstr($this->postData['idSpe'], ',');
        if($strstr1 == false) {
            $pieces = explode("; ", $this->postData['idSpe']);
        }else{
            $pieces = explode(",", $this->postData['idSpe']);
        }
        $agent = $app->repo('Agent')->find($this->postData['id']);
        // $this->json(['id' => $this->postData['idCat']]);
        
        if($this->postData['idCat'] > 0) {
            $agentMeta = new AgentMeta;
            $agentMeta->key   = 'profissionais_categorias_profissionais';
            $agentMeta->value = $this->postData['idCat'];
            $agentMeta->owner = $agent;
            $app->em->persist($agentMeta);
            $app->em->flush();
        }
        if(count($pieces) > 0) {
            foreach ($pieces as $key => $value) {
                $cat = $app->em->find('\Saude\Entities\CategoryMeta',$value);
                $agentMeta          = new AgentMeta;
                $agentMeta->key     = 'profissionais_especialidades';
                $agentMeta->value   = $cat->value;
                $agentMeta->owner   = $agent;
                $app->em->persist($agentMeta);
                $app->em->flush();
            }
           $this->json(['message' => 'Categoria e Especialidade registrada', 'type' => 'success'], 200);
        }
    }

    function POST_categoriaEspecialidade() {
        $id = $this->postData['id'];
        $type = $this->postData['type'];
        $app = App::i();
        $dql = "SELECT c.id, c.value as text FROM Saude\Entities\CategoryMeta c 
        WHERE c.owner = {$id} AND c.key = '{$type}'";
        $query  = $app->em->createQuery($dql);
        $catEsp = $query->getResult();
        $this->json($catEsp);
    }

    function GET_getCategoryProfessional() {
        $app = App::i();
        $agent = $app->repo('Agent')->find($this->data['id']);
        $cat = $app->repo('AgentMeta')->findBy(
            [
            'key' => 'profissionais_categorias_profissionais',
            'owner' => $agent
            ]
        );
        $idCatPro = '';
        foreach ($cat as $key => $agentMeta) {
           $idCatPro .= $agentMeta->value.',';
        }
        $idsCatPro = substr($idCatPro, 0,-1);
        $dql = "SELECT p.id, p.name as text FROM Saude\Entities\ProfessionalCategory p 
        WHERE p.id IN ($idsCatPro)";
        $query  = $app->em->createQuery($dql);
        $catPro = $query->getResult();
        $this->json($catPro);
    }

    function GET_getSpecialtyProfessional() {
        $app = App::i();
        $agent = $app->repo('Agent')->find($this->data['id']);
        $cat = $app->repo('AgentMeta')->findBy(
            [
            'key' => 'profissionais_especialidades',
            'owner' => $agent
            ]
        );
        $arrayEsp = [];
        foreach ($cat as $key => $value) {
            $arrayEsp[$key] = ['id' => $value->id, 'text' => $value->value];
        }
        $this->json($arrayEsp);
    }

    function DELETE_deleteSpecialty() {
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
        $app = App::i();
        $agent = $app->repo('Agent')->find($this->data['id']);
        $del = $app->repo('AgentMeta')->findBy(
            [
            'key' => 'profissionais_especialidades',
            'owner' => $agent,
            'value' => $this->data['value']
            ]
        );
        $app->disableAccessControl();
        foreach ($del as $req)
            $req->delete();
        $app->em->flush();
        $this->json(['message' => 'Categoria e Especialidade excluida', 'type' => 'success'], 200);
    }

    function DELETE_deleteCategory() {
        $app = App::i();
        $idCat = $this->data['idCat'];
        $agent = $app->repo('Agent')->find($this->data['idEntity']);

        $dql = "SELECT c.id, c.value FROM Saude\Entities\CategoryMeta c 
        WHERE c.owner = {$idCat} AND c.key = 'especialidade'";
        $query  = $app->em->createQuery($dql);
        $catEsp = $query->getResult();
        if(!empty($catEsp)) {
            $app->disableAccessControl();
            foreach ($catEsp as $resultValue) {
                $del = $app->repo('AgentMeta')->findBy(
                    [
                    'owner' => $agent,
                    'key' => 'profissionais_especialidades',
                    'value' => $resultValue['value']
                    ]
                );
                
                foreach ($del as $req){
                    $req->delete();
                    $app->em->flush();
                }
                    

                $delCategory = $app->repo('AgentMeta')->findBy(
                    [
                    'owner' => $agent,
                    'key' => 'profissionais_categorias_profissionais',
                    'value' => $this->data['idCat']
                    ]
                ); 
                foreach ($delCategory as $req){
                    //dump($req);
                    $req->delete();
                    $app->em->flush();
                }
            }
            $this->json(['message' => 'Categoria excluida', 'type' => 'success'], 200);
        }
    }

    function POST_updateSpecialty() {
        $app = App::i();
        $specialty = $app->em->find('Saude\Entities\CategoryMeta',$this->postData['id']);
        $specialty->value = $this->postData['name'];
        $app->em->persist($specialty);
        $app->em->flush();
        $this->json(['message' => 'Especialidade alterada com sucesso', 'type' => 'success', 'title' => 'Sucesso'], 200);
    }

    
}