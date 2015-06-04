<?php

/**
 * Description of FunctionKnowledgeSkillPointValueObject
 *
 * @author hans.prins
 */

require_once('modules/model/service/to_refactor/FunctionsServiceDeprecated.class.php');

class FunctionKnowledgeSkillPointValueObject {

    public $ID_KSP;
    public $customer_id;
    public $ID_KS;
    public $ID_C;
    public $knowledge_skill_point;
    public $description;
    public $is_key;
    public $one_none;
    public $two_basic;
    public $three_average;
    public $four_good;
    public $five_specialist;
    public $scale;
    public $is_na_allowed;
    public $is_cluster_main;
    public $modified_by_user;
    public $modified_time;
    public $modified_date;


    // factory methode
    static function createValueObject($id_ksp)
    {
        return new FunctionKnowledgeSkillPointValueObject($id_ksp, FunctionsServiceDeprecated::getKnowledgeSkillPointData($id_ksp));
    }

    function __construct($id_ksp, $knowledgeSkillPointData)
    {
        $this->ID_KSP                   = $id_ksp;
        $this->customer_id              = $knowledgeSkillPointData['customer_id'];
        $this->ID_KS                    = $knowledgeSkillPointData['ID_KS'];
        $this->ID_C                     = $knowledgeSkillPointData['ID_C'];
        $this->knowledge_skill_point    = $knowledgeSkillPointData['knowledge_skill_point'];
        $this->description              = $knowledgeSkillPointData['description'];
        $this->is_key                   = $knowledgeSkillPointData['is_key'];
        $this->one_none                 = $knowledgeSkillPointData['1none'];
        $this->two_basic                = $knowledgeSkillPointData['2basic'];
        $this->three_average            = $knowledgeSkillPointData['3average'];
        $this->four_good                = $knowledgeSkillPointData['4good'];
        $this->five_specialist          = $knowledgeSkillPointData['5specialist'];
        $this->scale                    = $knowledgeSkillPointData['scale'];
        $this->is_na_allowed            = $knowledgeSkillPointData['is_na_allowed'];
        $this->is_cluster_main          = $knowledgeSkillPointData['is_cluster_main'];
        $this->modified_by_user         = $knowledgeSkillPointData['modified_by_user'];
        $this->modified_time            = $knowledgeSkillPointData['modified_time'];
        $this->modified_date            = $knowledgeSkillPointData['modified_date'];
        
    }

}

?>
