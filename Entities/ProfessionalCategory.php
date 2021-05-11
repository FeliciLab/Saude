<?php
namespace Saude\Entities;

use Doctrine\ORM\Mapping as ORM;
use MapasCulturais\App;

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
        return $all;
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
            $dql = "SELECT p.id, p.name FROM \Saude\Entities\ProfessionalCategory p where p.id in ({$convertedResult})";
            $query = $app->em->createQuery($dql);
            $all = $query->getResult();
            
            foreach ($all as $key => $valueName) {
               array_push($namePro, $valueName['name']);
            }
        }

        return $namePro;
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
        
        return null;
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