<?php
namespace Saude\Entities;

use Doctrine\ORM\Mapping as ORM;
use MapasCulturais\App;

/**
 * CategoryMeta
 * 
 * @ORM\Entity
 * @ORM\Table(name="category_meta")
*/
class CategoryMeta extends \MapasCulturais\Entity{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="category_meta_id_seq", allocationSize=1, initialValue=1)
     */
    protected $id;

     /**
     * @var string
     *
     * @ORM\Column(name="key", type="string", nullable=false)
     */
    protected $key;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="text", nullable=true)
     */
    protected $value;

    /**
     * @var integer
     *
     * @ORM\Column(name="object_id", type="integer", nullable=true)
     */
    protected $owner;

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

    static public function getOwner($id, $class) {
        $app = App::i();
        $path = "'Saude'Entities'";
        $new = addslashes($path);
        $classEntities = str_replace("'", '', $new);
        $owner = $app->em->find($classEntities.$class, $id);
        return $owner;
    }

    static public function getAllCategory($id, $key) {
        $app = App::i();
        $dql = "SELECT c.id, c.value FROM \Saude\Entities\CategoryMeta c WHERE c.owner = {$id} AND c.key = '{$key}' ORDER BY c.id asc";
        $query = $app->em->createQuery($dql);
        return $query->getResult();
       
    }

    /** @ORM\PrePersist */
    public function _prePersist($args = null){
        App::i()->applyHookBoundTo($this, 'entity(CategoryMeta).meta(' . $this->key . ').insert:before', $args);
    }
    /** @ORM\PostPersist */
    public function _postPersist($args = null){
        App::i()->applyHookBoundTo($this, 'entity(CategoryMeta).meta(' . $this->key . ').insert:after', $args);
    }

    /** @ORM\PreRemove */
    public function _preRemove($args = null){
        App::i()->applyHookBoundTo($this, 'entity(CategoryMeta).meta(' . $this->key . ').remove:before', $args);
    }
    /** @ORM\PostRemove */
    public function _postRemove($args = null){
        App::i()->applyHookBoundTo($this, 'entity(CategoryMeta).meta(' . $this->key . ').remove:after', $args);
    }

    /** @ORM\PreUpdate */
    public function _preUpdate($args = null){
        App::i()->applyHookBoundTo($this, 'entity(CategoryMeta).meta(' . $this->key . ').update:before', $args);
    }
    /** @ORM\PostUpdate */
    public function _postUpdate($args = null){
        App::i()->applyHookBoundTo($this, 'entity(CategoryMeta).meta(' . $this->key . ').update:after', $args);
    }
}