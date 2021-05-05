<?php
namespace Saude\Controllers;

use DateTime;
use \MapasCulturais\App;
use \Saude\Entities\ProfessionalCategory as CategoryPro;
use \Saude\Entities\CategoryMeta;

class ProfessionalCategory extends \MapasCulturais\Controller{

    function GET_index() {
        $this->render('index');
    }

    function GET_allProfessional() {
        $all = CategoryPro::allProfessional();
        $this->json($all);
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
        $cat = $app->em->find('Saude\Entities\ProfessionalCategory',$this->data['id']);
        $this->render('specialty',['cat' => $cat]);
    }
}