<?php
namespace Saude\Controllers;

use DateTime;
use \MapasCulturais\App;
use \Saude\Entities\ProfessionalCategory as CategoryPro;
use \Saude\Entities\CategoryMeta;

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
        dump($this->postData);
        $app = App::i();
        $agentMeta = $app->repo('AgentMeta')->findBy([
            'owner' => $this->postData['id'],
            'key' => $this->postData['key']
        ]);
        // dump($agentMeta[0]->value);
        // die;
        $agentMeta[0]->value = $this->postData['value'];
        $app->em->persist($agentMeta[0]);
        $app->em->flush();
        
    }

    function GET_categoriaEspecialidade() {
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
        $app = App::i();
        $catEsp = $app->repo('Term')->findBy(['taxonomy' => 'profissionais_especialidades'], ['term' => 'ASC']);
        $arrayEsp = [];
        foreach ($catEsp as $key => $value) {
            $arrayEsp[$key] = ['id' => $value->id, 'text' => $value->term];
        }
        $this->json($arrayEsp);
    }
}