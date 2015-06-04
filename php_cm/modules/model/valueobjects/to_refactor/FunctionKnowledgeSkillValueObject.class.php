<?php

/**
 * Description of FunctionKnowledgeSkillValueObject
 *
 * @author hans.prins
 */

require_once('modules/model/service/to_refactor/FunctionsServiceDeprecated.class.php');

class FunctionKnowledgeSkillValueObject {

    public $ID_KS;
    public $knowledge_skill;
    public $axes;
    public $modified_by_user;
    public $modified_time;
    public $modified_date;


    // factory methode
    static function createValueObject($id_ks)
    {
        return new FunctionKnowledgeSkillValueObject($id_ks, FunctionsServiceDeprecated::getKnowledgeSkillData($id_ks));
    }

    function __construct($id_ks, $knowledgeSkillData)
    {
        $this->ID_KS            = $id_ks;
        $this->knowledge_skill  = $knowledgeSkillData['knowledge_skill'];
        $this->axes             = $knowledgeSkillData['axes'];
        $this->modified_by_user = $knowledgeSkillData['modified_by_user'];
        $this->modified_time    = $knowledgeSkillData['modified_time'];
        $this->modified_date    = $knowledgeSkillData['modified_date'];
        
    }

}

?>
