<?php
namespace Saude\Entities;

use Doctrine\ORM\Mapping as ORM;
use MapasCulturais\App;
use MapasCulturais\Entities\Opportunity;

/**
 * Resources
 * 
 * @ORM\Entity
 * @ORM\Table(name="resources")
*/
class Resources extends \MapasCulturais\Entity{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="resources_id_seq", allocationSize=1, initialValue=4)
     */
    protected $id;

     /**
     * @var string
     *
     * @ORM\Column(name="resource_text", type="text", nullable=false)
     */
    protected $resourceText;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="resource_send", type="datetime", nullable=false)
    */
    protected $resourceSend;

    /**
     * @var string
     *
     * @ORM\Column(name="resource_status", type="string", nullable=false)
    */
    protected $resourceStatus = 'Aguardando';

    /**
     * @var string
     *
     * @ORM\Column(name="resource_reply", type="text", nullable=true)
    */
    protected $resourceReply;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="resource_date_reply", type="datetime", nullable=true)
    */
    protected $resourceDateReply;

    /**
     * @var \MapasCulturais\Entities\Registration
     *
     * @ORM\OneToOne(targetEntity="MapasCulturais\Entities\Registration", fetch="LAZY", mappedBy="\MapasCulturais\Entities\Registration")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="registration_id", referencedColumnName="id")
     * })
     */
    protected $registrationId;

    /**
     * @var \MapasCulturais\Entities\Opportunity
     *
     * @ORM\ManyToOne(targetEntity="MapasCulturais\Entities\Opportunity", fetch="LAZY")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="opportunity_id", referencedColumnName="id")
     * })
     */
    protected $opportunityId;

    /**
     * @var \MapasCulturais\Entities\Agent
     *
     * @ORM\OneToOne(targetEntity="MapasCulturais\Entities\Agent", fetch="LAZY")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="agent_id", referencedColumnName="id")
     * })
     */
    protected $agentId;

    /**
     * @var integer
     *
     * @ORM\Column(name="reply_agent_id", type="integer", nullable=true)
     */
    protected $replyAgentId;

    /**
     * @var bool
     *
     * @ORM\Column(name="resources_reply_publish", type="boolean", nullable=true)
     */
    protected $replyPublish = false;

    public static function allResource() {
        $app = App::i();
        $userId = $app->user->profile->id;
        $all = $app->em->getConnection()->fetchAll("SELECT * FROM resources r WHERE r.agent_id = {$userId} ");
        return $all;
    }

    
    public static function resourceIdOpportunity($opportunity) {
        $app = App::i();
        $all = $app->em->getConnection()->fetchAll("SELECT * FROM resources r WHERE r.opportunity_id = {$opportunity} ");
        return $all;
    }

    public static function inforesource($reg, $opp) {
        $app = App::i();
        $text = $app->em->getConnection()->fetchAll("SELECT r.id, r.resource_text FROM resources r WHERE r.registration_id = {$reg} AND r.opportunity_id = {$opp}");

        return $text;
    }

    public static function updateReply($id) {
        $app = App::i();
        $userId = $app->user->id;
        $all = $app->em->getConnection()->fetchAll("SELECT * FROM resources r WHERE r.agent_id = {$userId} ");
    }

    public static function validateOnlyResource($registrationId, $opportunityId, $agentId){
        $app = App::i();
        $validate = false;
        $resources = $app->em->getConnection()->fetchAll("SELECT resource_text from resources r WHERE r.registration_id = {$registrationId} AND r.opportunity_id = {$opportunityId} AND r.agent_id = {$agentId}
        ");
        
        if(count($resources) > 0){
            $validate = true;
        }

        return $validate; 
    }

    public static function find($id){
        $app = App::i();
        $resource = $app->em->find('Saude\Entities\Resources', $id);
        return $resource;
    }

    public static function publishResource($opportunityId) {
        $app = App::i();
        $dql = "UPDATE Saude\Entities\Resources r SET r.replyPublish = true WHERE r.opportunityId = {$opportunityId}";
        $query = $app->em->createQuery($dql);
        $resource = $query->getResult();
        return $resource;
    }

    public static function checkPublishOpportunity($oppotunity, $registration) {
        $app = App::i();
        $dql = "SELECT r, o
        FROM 
        Saude\Entities\Resources r
        JOIN r.opportunityId o
        JOIN r.registrationId re
        WHERE r.opportunityId = {$oppotunity}
        and r.registrationId  = {$registration}";
        $query = $app->em->createQuery($dql);
        $resource = $query->getResult();
        //dump($resource);
        if(!empty($resource)) {
            return ['text' => $resource[0]->resourceText, 'publish' => $resource[0]->replyPublish];

        }
        return ['text' => 'Não existe texto', 'publish' => 'sem publicacao'];
    }

    /**
     * Undocumented function
     *
     * @param [opportunity] $opportunity opportunidade para verificar se existe recurso sem resposta
     * @return void
    */
    public static function verifyResourceNotReply($opportunity) {
        $app = App::i();
        $dql = "SELECT r
        FROM 
        Saude\Entities\Resources r
        WHERE r.opportunityId = {$opportunity}
        and r.resourceReply  = '' 
        and r.replyPublish = false";
        $query = $app->em->createQuery($dql);
        $resource = $query->getResult();
        return $resource;
    }
    /** @ORM\PrePersist */
    public function _prePersist($args = null){
        App::i()->applyHookBoundTo($this, 'entity(Resources).meta(' . $this->key . ').insert:before', $args);
    }
    /** @ORM\PostPersist */
    public function _postPersist($args = null){
        App::i()->applyHookBoundTo($this, 'entity(Resources).meta(' . $this->key . ').insert:after', $args);
    }

    /** @ORM\PreRemove */
    public function _preRemove($args = null){
        App::i()->applyHookBoundTo($this, 'entity(Resources).meta(' . $this->key . ').remove:before', $args);
    }
    /** @ORM\PostRemove */
    public function _postRemove($args = null){
        App::i()->applyHookBoundTo($this, 'entity(Resources).meta(' . $this->key . ').remove:after', $args);
    }

    /** @ORM\PreUpdate */
    public function _preUpdate($args = null){
        App::i()->applyHookBoundTo($this, 'entity(Resources).meta(' . $this->key . ').update:before', $args);
    }
    /** @ORM\PostUpdate */
    public function _postUpdate($args = null){
        App::i()->applyHookBoundTo($this, 'entity(Resources).meta(' . $this->key . ').update:after', $args);
    }

    //============================================================= //
    // The following lines ara used by MapasCulturais hook system.
    // Please do not change them.
    // ============================================================ //

    /** @ORM\PrePersist */
    public function prePersist($args = null){ parent::prePersist($args); }
    /** @ORM\PostPersist */
    public function postPersist($args = null){ parent::postPersist($args); }

    /** @ORM\PreRemove */
    public function preRemove($args = null){ parent::preRemove($args); }
    /** @ORM\PostRemove */
    public function postRemove($args = null){ parent::postRemove($args); }

    /** @ORM\PreUpdate */
    public function preUpdate($args = null){ parent::preUpdate($args); }
    /** @ORM\PostUpdate */
    public function postUpdate($args = null){ parent::postUpdate($args); }

}