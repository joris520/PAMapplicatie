<?php

/**
 * Description of FunctionKnowledgeSkillClusterValueObject
 *
 * @author hans.prins
 */

require_once('modules/model/service/to_refactor/FunctionsServiceDeprecated.class.php');

class FunctionKnowledgeSkillClusterValueObject {

    public $ID_C;
    public $customer_id;
    public $ID_KS;
    public $cluster;
    public $modified_by_user;
    public $modified_time;
    public $modified_date;


    // factory methode
    static function createValueObject($id_c)
    {
        return new FunctionKnowledgeSkillClusterValueObject($id_c, FunctionsServiceDeprecated::getKnowledgeSkillClusterData($id_c));
    }

    function __construct($id_c, $knowledgeSkillClusterData)
    {
        $this->ID_C             = $id_c;
        $this->customer_id      = $knowledgeSkillClusterData['customer_id'];
        $this->ID_KS            = $knowledgeSkillClusterData['ID_KS'];
        $this->cluster          = $knowledgeSkillClusterData['cluster'];
        $this->modified_by_user = $knowledgeSkillClusterData['modified_by_user'];
        $this->modified_time    = $knowledgeSkillClusterData['modified_time'];
        $this->modified_date    = $knowledgeSkillClusterData['modified_date'];
        
    }

}

?>
