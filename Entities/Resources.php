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
        and r.resourceReply is null
        and r.replyPublish = false";
        $query = $app->em->createQuery($dql);
        $resource = $query->getResult();
        return $resource;
    }

    /**
     * Verifica a pontuação máxima configurada na avaliação para a banca poder alterar a nota
     *
     * @param [integer] $opportunity id da Oportunidade
     * @return integer
     */
    public static function maxPoint($opportunity) {
        $app = App::i();
        $pointMax = $app->repo("EvaluationMethodConfigurationMeta")->findBy([
            'owner' => $opportunity,
            'key' => 'criteria'
        ]);
        $spotsToarray = json_decode($pointMax[0]->value);
        $spots = 0;
        foreach ($spotsToarray as $value) {
            $spots = ($spots + $value->max);
        }
        return $spots;
    }

    public static function getEnabledResource($opportunity) {
        $app = App::i();
        //dump($opportunity);
        // $opp = $app->repo('OpportunityMeta')->findBy(['owner'=>$opportunity,'key'=>'claimDisabled']);
        // if(isset($opp[0])) {
        //     return $opp[0];
        // }
        $dql = "SELECT o
                FROM 
                MapasCulturais\Entities\OpportunityMeta o
                WHERE o.owner = {$opportunity}
                ";
        $query = $app->em->createQuery($dql);
        $check = $query->getResult();
        $date = '';
        $hour = '';
        $dateinit = '';
        foreach ($check as $key2 => $value2) {
            //dump($value2->key.' - '.$value2->value);
            
            if($value2->key == 'date-initial') {
                
                $dt = self::DataBRtoMySQL( $value2->value );
                $date = $dt;
                // dump($opportunity);
                // dump($value2->id.' - '.$value2->key.' - '.$value2->value);
                // $dtInit = $value2->value;
               
            }
            
            if($value2->key == 'hour-initial') {
                //dump($value2->id.' - '.$value2->key.' - '.$value2->value);
                //$dtInit .= ' '.$value2->value;
                //$date = $date.' '.$value2->value;
                dump($date);
            }
        }
        //dump($date);
        // $dateinit = \DateTime::createFromFormat('Y-m-d',$dt );
        // dump($dateinit);
        // // $dateinit = \DateTime::createFromFormat('Y-m-d',$dtInit);
        // dump($dateinit);
    }

    public static function DataBRtoMySQL( $DataBR ) 
    {
		$DataBR = str_replace(array(" – ","-"," "," "), " ", $DataBR);
		list($data) = explode(" ", $DataBR);
		return implode("-",array_reverse(explode("/",$data))) ;
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