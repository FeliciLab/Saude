<?php
namespace Saude\Controllers;

use DateTime;
use \MapasCulturais\App;
use \Saude\Entities\ProfessionalCategory as CategoryPro;
use \Saude\Entities\CategoryMeta;
use \MapasCulturais\Entities\AgentMeta;

class ProfessionalCategory extends \MapasCulturais\Controller{

    // public function __construct(){
    //     $app = App::i();
    //     $user = $app->user;
    //     if(!$user->is('saasAdmin') || !$user->is('superAdmin')) {
    //         return $app->redirect($app->createUrl('painel', 401));
    //     }
    // }

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
        //dump($cat);
        $cat->name = $this->postData['name'];
        //dump($cat->name);
        $app->em->persist($cat);
        $app->em->flush();
        return $this->json(['title' => 'Sucesso','message' => 'Categoria profissional alterada com sucesso','type' => 'success', 'status' => 200], 200);
    }

    function DELETE_delete() {
        // dump($this->data);
        // dump($this->data['id']);
        // die;
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
        //dump($this->postData);
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
        dump($this->postData['idSpe']);
        $pieces = explode("; ", $this->postData['idSpe']);
        dump($pieces);
        $agent = $app->repo('Agent')->find($this->postData['id']);
        // $this->json(['id' => $this->postData['idCat']]);
        if($this->postData['idCat'] > 0) {
            $agent = $app->repo('Agent')->find($this->postData['id']);
            $agentMeta = new AgentMeta;
            $agentMeta->key   = 'profissionais_categorias_profissionais';
            $agentMeta->value = $this->postData['idCat'];
            $agentMeta->owner = $agent;
            $app->em->persist($agentMeta);
            $app->em->flush();
        }
        if(count($pieces) > 0) {
            foreach ($pieces as $key => $value) {
                echo $value;
                $cat = $app->em->find('\Saude\Entities\CategoryMeta',$value);
                dump($cat->value);
                $agent = $app->repo('Agent')->find($this->postData['id']);
                $agentMeta = new AgentMeta;
                $agentMeta->key   = 'profissionais_especialidades';
                $agentMeta->value = $cat->value;
                $agentMeta->owner = $agent;
                $app->em->persist($agentMeta);
                $app->em->flush();
            }
            
        }
        
    }

    function POST_categoriaEspecialidade() {
        //dump($this->postData);
        $id = $this->postData['id'];
        $type = $this->postData['type'];
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
        $app = App::i();
        $dql = "SELECT c.id, c.value as text FROM Saude\Entities\CategoryMeta c 
        WHERE c.owner = {$id} AND c.key = '{$type}'";
        $query  = $app->em->createQuery($dql);
        $catEsp = $query->getResult();
        $this->json($catEsp);
        // $arrayEsp = [];
        // foreach ($catEsp as $key => $value) {
        //     $arrayEsp[$key] = ['id' => $value->id, 'text' => $value->term];
        // }
        // $this->json($arrayEsp);
    }

    function GET_getCategoryProfessional() {
        $app = App::i();

        $agent = $app->repo('Agent')->find($app->user->profile->id);
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
}