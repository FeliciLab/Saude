<?php
namespace Saude\Entities;

use Doctrine\ORM\Mapping as ORM;
use MapasCulturais\App;
use \MapasCulturais\Entities\AgentMeta;

/**
 * ProfessionalCategory
 * 
 * @ORM\Entity
 * @ORM\Table(name="professional_category")
*/
class ProfessionalCategory extends \MapasCulturais\Entity{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="professional_category_id_seq", allocationSize=1, initialValue=1)
     */
    protected $id;

     /**
     * @var string
     *
     * @ORM\Column(name="name", type="text", nullable=false)
     */
    protected $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="create_timestamp", type="datetime", nullable=false)
     */
    protected $createTimestamp;

     /**
     * @var \DateTime
     *
     * @ORM\Column(name="update_timestamp", type="datetime", nullable=true)
     */
    protected $updateTimestamp;

    public static function allProfessional() {
        $app = App::i();
        $dql = "SELECT p.id, p.name FROM \Saude\Entities\ProfessionalCategory p ORDER BY p.id";
        $query = $app->em->createQuery($dql);
        $all = $query->getResult();
        if(empty($all)){
            return ['id' =>0, 'name' => 'Saude' ];
        }else{
            return $all;
        } 
    }

    public static function getCategoryEntity($entity, $key) {
        $app = App::i();
        $namePro = [];
        $agent = $app->repo('Agent')->find($entity);
        $categoryPro = $app->repo('AgentMeta')->findBy(
            [
            'key' => $key,
            'owner' => $agent
            ]
        );
        
        if(!empty($categoryPro)) {
            
            $resCatPro = [];
            foreach ($categoryPro as $catPro) {
                array_push($resCatPro, $catPro->value);
            }
            
            $result = array_unique($resCatPro);
            $convertedResult = implode(",", $result);

            //PARA OS PRIMEIROS CASOS QUE SOMENTE EXISTE UMA CATEGORIA QUE NÃO TEM A VIRGULA OU PONTO E VIRGULA
            $namePro = self::returnCategoryProfessional($convertedResult);
            return $namePro;
        }
        
        return [0 => 'Não Informado'];
    }

    public static function getSpecialtyEntity($entity, $key) {
        $app = App::i();
        $agent = $app->repo('Agent')->find($entity);
        $categoryPro = $app->repo('AgentMeta')->findBy(
            [
            'key' => $key,
            'owner' => $agent
            ]
        );
        if(!empty($categoryPro)) {
            $resCatPro = [];
            foreach ($categoryPro as $catPro) {
                array_push($resCatPro, $catPro->value);
            }
            $result = array_unique($resCatPro);
            $convertedResult = implode(", ", $result);
            return $convertedResult;
        }
        return 'Não Informado';
    }

    public static function alterCategoryProfessional($entity) {
        // PARA ESPECIALIDADES
        ProfessionalCategory::alterCategorySpecialty($entity, 'profissionais_especialidades');
        ProfessionalCategory::alterCategorySpecialty($entity, 'profissionais_categorias_profissionais');
    }

    public static function returnCategoryProfessional($convertedResult) {

        $app        = App::i();
        $namePro    = [];
        $dql = "";
       
        if(getType($convertedResult) == "integer")
        {
            $dql = "SELECT p.id, p.name FROM \Saude\Entities\ProfessionalCategory p where p.id in ({$convertedResult})";

        }else if(getType($convertedResult) == "string")
        {
            $dql = "SELECT p.id, p.name FROM \Saude\Entities\ProfessionalCategory p where p.name = '{$convertedResult}'";
        }
        $query      = $app->em->createQuery($dql);
        $all        = $query->getResult();
        
        foreach ($all as $key => $valueName) {
            array_push($namePro, $valueName['name']);
        }
        return $namePro;
    }

    /**
     *  profissionais_especialidades
     *  profissionais_categorias_profissionais
     *  SEPARANDO OS ITENS DA STRING EM VARIAS OUTRAS OPÇÕES, FAZ O REGISTRO DESSAS OPÇÕES E APAGA O REGISTRO ANTIGO
     *
     * @param [type] $entity
     * @param [type] $key o tipo do campos para categoria ou especialidade
     * @return void
     */
    public static function alterCategorySpecialty($entity, $key) {
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
        $app = App::i();
        $app->disableAccessControl();
        
        $agent = $app->repo('Agent')->find($entity);
        $meta  = $app->repo('AgentMeta')->findBy([
            'key' => $key,
            'owner' => $agent 
        ]);
        if(!empty($meta)){

            $metaExplode = explode(";",$meta[0]->value);
            //FAZENDO UMA VERIFICAÇÃO SE NA STRING TEM ALGUM ( ; )
            $verify = strpos($meta[0]->value, ";");
            //SE CONSTAR ALGUM INTEIRO,ENTRA NO IF
            if($verify !== false)
            {
                if($key == 'profissionais_especialidades') {
                    foreach ($metaExplode as $specialty) {
                        //REGISTRO PARA ESPECIALIDADES
                        $newMeta = new AgentMeta;
                        $newMeta->owner = $agent;
                        $newMeta->key = $key;
                        $newMeta->value = $specialty;
                        $app->em->persist($newMeta);
                        $app->em->flush();
                    }
                    //EXCLUINDO O REGISTRO ATUAL
                    foreach ($meta as $req)
                        $req->delete();
                        $app->em->flush();
                }else{
                    $catEsp = [];
                    //REGISTRO PARA ESPECIALIDADE PROFISSIONAL
                    foreach ($metaExplode as $category) {
                        $dql = "SELECT c.id, c.name FROM Saude\Entities\ProfessionalCategory c WHERE c.name = '{$category}'";
                        $query          = $app->em->createQuery($dql);
                        $catEsp         = $query->getResult();
                    
                        $newMeta        = new AgentMeta;
                        $newMeta->owner = $agent;
                        $newMeta->key   = $key;
                        $newMeta->value = $catEsp[0]['id'];
                        $app->em->persist($newMeta);
                        $app->em->flush();
                    }
                
                      foreach ($meta as $req)
                        $req->delete();
                        $app->em->flush();
                }
            }

        }
        //dump('alterCategoryProfessional');
    }

    /** @ORM\PrePersist */
    public function _prePersist($args = null){
        App::i()->applyHookBoundTo($this, 'entity(ProfessionalCategory).meta(' . $this->key . ').insert:before', $args);
    }
    /** @ORM\PostPersist */
    public function _postPersist($args = null){
        App::i()->applyHookBoundTo($this, 'entity(ProfessionalCategory).meta(' . $this->key . ').insert:after', $args);
    }

    /** @ORM\PreRemove */
    public function _preRemove($args = null){
        App::i()->applyHookBoundTo($this, 'entity(ProfessionalCategory).meta(' . $this->key . ').remove:before', $args);
    }
    /** @ORM\PostRemove */
    public function _postRemove($args = null){
        App::i()->applyHookBoundTo($this, 'entity(ProfessionalCategory).meta(' . $this->key . ').remove:after', $args);
    }

    /** @ORM\PreUpdate */
    public function _preUpdate($args = null){
        App::i()->applyHookBoundTo($this, 'entity(ProfessionalCategory).meta(' . $this->key . ').update:before', $args);
    }
    /** @ORM\PostUpdate */
    public function _postUpdate($args = null){
        App::i()->applyHookBoundTo($this, 'entity(ProfessionalCategory).meta(' . $this->key . ').update:after', $args);
    }
}