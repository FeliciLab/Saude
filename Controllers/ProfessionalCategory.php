<?php
namespace Saude\Controllers;

use DateTime;
use \MapasCulturais\App;
use \Saude\Entities\ProfessionalCategory as CategoryPro;

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
        return $this->json(['title' => 'Sucesso','type' => 'success', 'status' => 200], 200);
    }
}