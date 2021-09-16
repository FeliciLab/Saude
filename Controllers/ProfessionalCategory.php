<?php
namespace Saude\Controllers;

use DateTime;
use \MapasCulturais\App;
use \MapasCulturais\Entities\AgentMeta;
use \Saude\Entities\CategoryMeta;
use \Saude\Entities\ProfessionalCategory as CategoryPro;

class ProfessionalCategory extends \MapasCulturais\Controller {

	function GET_index() {
		$this->render('index');
	}

	function GET_allProfessional() {
		$all = CategoryPro::allProfessional();
		$this->json($all);
	}

	function POST_allCategory() {
		$cat = CategoryMeta::getAllCategory($this->postData['id'], $this->postData['key']);
		$this->json($cat);
	}

	function POST_store() {
		$app = App::i();
		$now = new \DateTime;

		$catPro = new CategoryPro;
		$catPro->name = $this->postData['name'];
		$app->em->persist($catPro);
		$app->em->flush();
		return $this->json(['title' => 'Sucesso', 'message' => 'Categoria profissional cadastrada com sucesso', 'type' => 'success', 'status' => 200], 200);
	}

	function POST_update() {
		$app = App::i();
		$cat = $app->em->find('Saude\Entities\ProfessionalCategory', $this->postData['id']);
		$cat->name = $this->postData['name'];
		$app->em->persist($cat);
		$app->em->flush();
		return $this->json(['title' => 'Sucesso', 'message' => 'Categoria profissional alterada com sucesso', 'type' => 'success', 'status' => 200], 200);
	}

	function DELETE_delete() {
		$app = App::i();
		$cat = $app->em->find('Saude\Entities\ProfessionalCategory', $this->data['id']);
		$cat->delete();
		$app->em->flush();
		return $this->json(['title' => 'Sucesso', 'message' => 'Categoria profissional excluida com sucesso', 'type' => 'success', 'status' => 200], 200);
	}

	function GET_especialidade() {
		$app = App::i();
		$user = $app->user;
		$cat = $app->em->find('Saude\Entities\ProfessionalCategory', $this->data['id']);
		$this->render('specialty', ['cat' => $cat]);
	}

	function POST_categoria_meta() {
		$app = App::i();
		$cat = new CategoryMeta;
		$cat->key = $this->postData['nameProfessional'];
		$cat->value = $this->postData['nameSpecialty'];
		$cat->owner = $this->postData['idProfessional'];
		$app->em->persist($cat);
		$app->em->flush();
		$this->json(['title' => 'Sucesso', 'message' => 'Especialidade profissional cadastrada com sucesso', 'type' => 'success', 'status' => 200], 200);
	}

	function POST_alterAgentMeta() {

		$app = App::i();
		$pieces = [];

		$strstr1 = strstr($this->postData['idSpe'], ',');
		if ($strstr1 == false) {
			$pieces = explode("; ", $this->postData['idSpe']);
		} else {
			$pieces = explode(",", $this->postData['idSpe']);
		}
		$agent = $app->repo('Agent')->find($this->postData['id']);
		// $this->json(['id' => $this->postData['idCat']]);

		if ($this->postData['idCat'] > 0) {
			//dump($this->postData['idCat']);

			$cat = CategoryPro::getCategoryProfessional($this->postData['idCat']);
			// dump($cat[0]['name']);
			// die;
			$agentMeta = new AgentMeta;
			$agentMeta->key = 'profissionais_categorias_profissionais';
			$agentMeta->value = $cat[0]['name'];
			$agentMeta->owner = $agent;
			$app->em->persist($agentMeta);
			$app->em->flush();

			$agentMetaIdCategory = new AgentMeta;
			$agentMetaIdCategory->key = 'profissionais_categorias_profissionais_id';
			$agentMetaIdCategory->value = $this->postData['idCat'];
			$agentMetaIdCategory->owner = $agent;
			$app->em->persist($agentMetaIdCategory);
			$app->em->flush();
		}
		if (count($pieces) > 0) {
			foreach ($pieces as $key => $value) {
				$cat = $app->em->find('\Saude\Entities\CategoryMeta', $value);
				$agentMeta = new AgentMeta;
				$agentMeta->key = 'profissionais_especialidades';
				$agentMeta->value = $cat->value;
				$agentMeta->owner = $agent;
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
		$query = $app->em->createQuery($dql);
		$catEsp = $query->getResult();
		$this->json($catEsp);
	}

	function GET_getCategoryProfessional() {
		$app = App::i();
		$agent = $app->repo('Agent')->find($this->data['id']);
		$cat = $app->repo('AgentMeta')->findBy(
			[
				'key' => 'profissionais_categorias_profissionais_id',
				'owner' => $agent,
			]
		);

		$idCatPro = '';
		foreach ($cat as $key => $agentMeta) {
			$idCatPro .= $agentMeta->value . ',';
		}

		$idsCatPro = substr($idCatPro, 0, -1);
		$dql = "SELECT p.id, p.name as text FROM Saude\Entities\ProfessionalCategory p
        WHERE p.id IN ($idsCatPro)";
		$query = $app->em->createQuery($dql);
		$catPro = $query->getResult();

		$this->json($catPro);
	}

	function GET_getSpecialtyProfessional() {
		$app = App::i();
		$agent = $app->repo('Agent')->find($this->data['id']);
		$cat = $app->repo('AgentMeta')->findBy(
			[
				'key' => 'profissionais_especialidades',
				'owner' => $agent,
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
				'value' => $this->data['value'],
			]
		);
		$app->disableAccessControl();
		foreach ($del as $req) {
			$req->delete();
		}

		$app->em->flush();
		$this->json(['message' => 'Categoria e Especialidade excluida', 'type' => 'success'], 200);
	}

	function DELETE_deleteCategory() {
		$app = App::i();
		$idCat = $this->data['idCat'];
		$agent = $app->repo('Agent')->find($this->data['idEntity']);
		//dump($idCat);
		$dql = "SELECT c.id, c.value FROM Saude\Entities\CategoryMeta c
        WHERE c.owner = {$idCat} AND c.key = 'especialidade'";
		$query = $app->em->createQuery($dql);
		$catEsp = $query->getResult();
		//dump($catEsp);
		//die;
		if (!empty($catEsp)) {
			$app->disableAccessControl();

			foreach ($catEsp as $resultValue) {
				$del = $app->repo('AgentMeta')->findBy(
					[
						'owner' => $agent,
						'key' => 'profissionais_especialidades',
						'value' => $resultValue['value'],
					]
				);

				foreach ($del as $req) {
					$req->delete();
					$app->em->flush();
				}
				//EXCLUINDO profissionais_categorias_id PELA STRING
				$delCategory = $app->repo('AgentMeta')->findBy(
					[
						'owner' => $agent,
						'key' => 'profissionais_categorias_profissionais_id',
						'value' => $this->data['idCat'],
					]
				);
				foreach ($delCategory as $req) {
					$req->delete();
					$app->em->flush();
				}
				//BUSCANDO A CATEGORIA PELO ID
				$dql = "SELECT p.id, p.name as text FROM Saude\Entities\ProfessionalCategory p 	WHERE p.id = " . $idCat;
				$query = $app->em->createQuery($dql);
				$categoriaPro = $query->getResult();

				$delCategoryProfessional = $app->repo('AgentMeta')->findBy(
					[
						'owner' => $agent,
						'key' => 'profissionais_categorias_profissionais',
						'value' => $categoriaPro[0]['text'],
					]
				);
				//EXCLUINDO profissionais_categorias_profissionais PELA STRING
				foreach ($delCategoryProfessional as $req) {
					$req->delete();
					$app->em->flush();
				}
			}
			$this->json(['message' => 'Categoria excluida', 'type' => 'success'], 200);
		}
	}

	function POST_updateSpecialty() {
		$app = App::i();
		$specialty = $app->em->find('Saude\Entities\CategoryMeta', $this->postData['id']);
		$specialty->value = $this->postData['name'];
		$app->em->persist($specialty);
		$app->em->flush();
		$this->json(['message' => 'Especialidade alterada com sucesso', 'type' => 'success', 'title' => 'Sucesso'], 200);
	}

	function GET_alterIdCategory() {
		ini_set('display_errors', 1);
		error_reporting(E_ALL);
		$app = App::i();
		//BUSCANDO TODOS OS AGENTES QUE ESTÃO COM KEY profissionais_categorias_profissionais
		$allAgentCategory = $app->repo('AgentMeta')->findBy(
			[
				'key' => 'profissionais_categorias_profissionais',
			]
		);
		//LOOP PARA ADD UM REGISTRO COM O NOVO VALOR (profissionais_categorias_profissionais_id) ONDE IRÁ GUARDAR O ID DA CATEGORIA
		foreach ($allAgentCategory as $key => $catAgent) {
			//INSTANCIANDO UM OBJETO AGENT_META
			$agentMeta = new AgentMeta;
			$agentMeta->key = 'profissionais_categorias_profissionais_id';
			$agentMeta->value = $catAgent->value;
			$agentMeta->owner = $catAgent->owner;
			//SALVANDO
			$app->em->persist($agentMeta);
			// INFORMATIVO NA TELA
			if (!empty($agentMeta) && $catAgent->value > 0) {
				echo "Criado o ID = " . $catAgent->value . " da categoria profissional.<br />";
			}

			//BUNCANDO A CATETEGORIA PELO ID
			$cat = CategoryPro::getCategoryProfessional($catAgent->value);
			if (!empty($cat)) {
				//INSTANCIANDO UM OBJETO AGENT_META E TROCANDO O ID POR O NOME DA CATEGORIA PROFISSIONAL
				$agentPro = $app->repo('AgentMeta')->find($catAgent->id);
				$agentPro->key = 'profissionais_categorias_profissionais';
				$agentPro->value = $cat[0]['name'];
				$agentPro->owner = $catAgent->owner;
				$app->em->persist($agentPro);
				// INFORMATIVO NA TELA
				if (!empty($agentPro)) {
					echo "Criado Nome " . $cat[0]['name'] . " da categoria profissional.<br />";
				}
			}
			$app->em->flush();
		}
	}

}