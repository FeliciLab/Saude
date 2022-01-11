<?php
namespace Saude\Controllers;
use \MapasCulturais\App;
use \MapasCulturais\i;

class Taxonomias extends \MapasCulturais\Controller{

    function GET_info() {
        $this->render('info');
        //echo "index";
    }


    function POST_create() {
        $app = App::i();
        if(empty($this->postData['taxonomy']) || empty($this->postData['term'])) {
            return $this->json([
                'title' => 'Ops!',
                'message' => 'Escolha um taxonomia ou digite um nome.', 
                'params' => $this->postData['taxonomy'],
                'type' => 'error'
            ], 500);
        }
        $taxo = new \MapasCulturais\Entities\Term;
        $taxo->taxonomy = $this->postData['taxonomy'];
        $taxo->term = $this->postData['term'];
        $taxo->description = $this->postData['description'];
        $app->em->persist($taxo);
        $app->em->flush();
        $this->json([
            'title' => 'Sucesso!',
            'message' => 'Cadastro realizado com sucesso.', 
            'params' => $this->postData['taxonomy'],
            'type' => 'success'
        ], 200);
    }

    function GET_allData() {
        $app = App::i();
        $termsGraus = $app->repo('Term')->findBy(
            ['taxonomy' => $this->getData['params']],
            ['term' => 'ASC']);
        $graus = [];
        foreach ($termsGraus as $key => $value) {
            //echo $key." - ".$value."<br />";
            //echo $termsGraus[$key]->id."<br />"; 
            array_push($graus, [
                'id' => $termsGraus[$key]->id, 
                'nome' => $termsGraus[$key]->term]
            );
        }
        $this->json($graus);
    }

    function POST_alterTaxo() {
        $app = App::i();
        $taxoUp = $app->repo('Term')->findBy(['id' => $this->postData['id'] ], ['id' => "ASC"]);
        $taxoUp[0]->term = $this->postData['nome'];
        $app->em->flush();
        return $this->json(['message' => 'Cadastro com sucesso', 'status' => 'success'], 200);
    }

    function DELETE_delete()
    {
        try {
            $app = App::i();
            $taxoUp = $app->repo('Term')->find($this->urlData['id']);
            $taxoUp->delete();
            $app->em->flush();
            return $this->json(true);
       } catch (\Throwable $th) {
           echo $th->getMessage();
       }
        
    }

    function GET_spaces() {
        $this->render('spaces');
    }

    function GET_projects() {
        $this->render('projects');
    }

    function GET_opportunity() {
        $this->render('opportunity');
    }

    function GET_area() {
        $this->render('area');
    }

    function POST_searchTaxo() {
        $type = "";
        switch ($this->postData['type']) {
            case 'agent':
                $type = "AgentMeta";
                break;
            case 'space':
                $type = "SpaceMeta";
                break;
            case 'project':
                $type = "ProjectMeta";
                break;
            case 'opportunity':
                $type = "OpportunityMeta";
                break;
            case 'area':
                $type = "TermRelation";
                break;
        }
        
        $app = App::i();
        if($this->postData['type'] == 'area') {
            $search = $app->repo($type)->findBy(['term' => $this->postData['id'] ]);
        }else{
            $search = $app->repo($type)->findBy(
                ['key' => $this->postData['taxo'],
                'value' => $this->postData['value']
                ], ['value' => "ASC"] ,1,0);
        }
        (count($search) > 0) ? $this->json(['message' => 'Já existem dados vinculados ao registro', 'status' => 'warning'], 200) : $this->json(['message' => 'Não tem registro', 'status' => 'success'], 200);
    }


    function GET_alterTypeTaxo() {
        dump($this->data);
        $app = App::i();
        $term = $app->repo('Term')->findBy([
            'taxonomy' => 'project_type'
        ]);
        foreach ($term as $key => $value) {
           dump(($key+1) .' - '. $value);
        }
        $project = $app->repo('Project')->findBy([
            'status' => 1
        ]);
        dump(count($project));
        foreach ($project as $key => $value) {
           dump($project[$key]->type);
        }
    }

    function POST_syncTaxo() {
        $app = App::i();
        $nameEntity = $this->data['entity'];
        //TEM QUE ESTÁ AUTENTICADO
        $this->requireAuthentication();
        $allTaxo = $app->repo('Term')->findBy([
            'taxonomy' => $this->data['taxo']
        ]);
        //PASSANDO O NOME DA ENTIDADE PARA O METODO REPO()
        $entity = $app->repo($nameEntity)->findBy([
            'status' => 1
        ]);
        //DESABILITA O CONTOLER
        $app->disableAccessControl();
        
        // FAZENDO LOOP EM TODAS AS TAXONOMIAS DE PROJETOS
        //foreach ($allTaxo as $key => $value) {
        for ($i=0; $i < count($entity) ; $i++) { 
            $idTaxo = null;
            //SE EXISTE O PROJETO ENTRA NA CONDIÇÃO
            if(isset($entity[$i])) {
                if($entity[$i]->type->id !== null){
                    $idTaxo = $entity[$i]->type->id;
                    //DIMINUINDO UM VALOR DO INDICE ATUAL QUE SERÁ A POSIÇÃO DO ARRAY DAS TAXO
                    $id = ($idTaxo - 1);
                    //PASSANDO O VALOR PARA CONSULTAR O ID DO DETERMINADO INDICE
                    $entity[$i]->type = $allTaxo[$id]->id;
                    $entity[$i]->save(true);
                }else{
                    $this->errorJson(['message' => 'Error'] , 403); 
                }
            }
        }
            
        //}
        $app->enableAccessControl();
        $this->json(['message' => 'Sincronização realizada com sucesso'], 200);
       
    }
}