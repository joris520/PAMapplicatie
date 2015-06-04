<?php

/**
 * Description of EmployeeCompetenceValueObject
 *
 * @author ben.dokter
 */
require_once('modules/model/valueobjects/employee/BaseEmployeeValueObject.class.php');

class EmployeeCompetenceValueObject extends BaseEmployeeValueObject
{

    // pas op, deze worden private. gebruik accessors
    public $employeeId;
    public $competenceId;
    public $competenceName;
    public $competenceIsKey;
    public $competenceScaleType;
    public $competenceIsOptional;
    public $competenceIsMain;

    public $categoryId;
    public $categoryName;

    public $clusterId;
    public $clusterName;

    // generieke functiewaarden bij een competentie
    public $competenceFunctionNorm;
    public $competenceFunctionWeight;

    // specifiek bij het (neven)functieprofiel van een medewerker
    public $competenceFunctionIsMain;


    // factory method
    static function createWithData($employeeId, $employeeCompetenceData)
    {
        return new EmployeeCompetenceValueObject($employeeId, $employeeCompetenceData['competence_id'], $employeeCompetenceData);
    }

    function __construct($employeeId, $competenceId, $employeeCompetenceData)
    {
        parent::__construct($employeeId, $competenceId, NULL, NULL, NULL);
        
        $this->employeeId               = $employeeId;
        $this->competenceId             = $competenceId;
        $this->competenceName           = $employeeCompetenceData['competence'];
        $this->competenceScaleType      = $employeeCompetenceData['scale'];
        $this->competenceIsKey          = $employeeCompetenceData['is_key'] == FUNCTION_IS_KEY_COMPETENCE;
        $this->competenceIsOptional     = $employeeCompetenceData['is_na_allowed'] == COMPETENCE_IS_OPTIONAL;
        $this->competenceIsMain         = $employeeCompetenceData['is_cluster_main'] == COMPETENCE_CLUSTER_IS_MAIN;

        $this->competenceFunctionIsMain = $employeeCompetenceData['main_function'] == 1; // todo: constante
        $this->competenceFunctionNorm   = $employeeCompetenceData['max_norm']; // de max(norm) van meerdere nevenfuncties
        $this->competenceFunctionWeight = $employeeCompetenceData['weight_factor'];

        $this->categoryId               = $employeeCompetenceData['category_id'];
        $this->categoryName             = $employeeCompetenceData['category'];

        $this->clusterId                = $employeeCompetenceData['cluster_id'];
        $this->clusterName              = $employeeCompetenceData['cluster'];
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $employeeId
    function getEmployeeId()
    {
        return $this->employeeId;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $competenceId
    function getCompetenceId()
    {
        return $this->competenceId;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $competenceName
    function getCompetenceName()
    {
        return $this->competenceName;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $competenceIsKey
    function getCompetenceIsKey()
    {
        return $this->competenceIsKey;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $competenceScaleType
    function getCompetenceScaleType()
    {
        return $this->competenceScaleType;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // competenceIsOptional
    function getCompetenceIsOptional()
    {
        return $this->competenceIsOptional;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $competenceIsMain
    function getCompetenceIsMain()
    {
        return $this->competenceIsMain;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $categoryId
    function getCategoryId()
    {
        return $this->categoryId;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $categoryName
    function getCategoryName()
    {
        return $this->categoryName;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $clusterId
    function getClusterId()
    {
        return $this->clusterId;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $clusterName
    function getClusterName()
    {
        return $this->clusterName;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $competenceFunctionNorm
    function getCompetenceFunctionNorm()
    {
        return $this->competenceFunctionNorm;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $competenceFunctionWeight
    function getCompetenceFunctionWeight()
    {
        return $this->competenceFunctionWeight;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $competenceFunctionIsMain
    function getCompetenceFunctionIsMain()
    {
        return $this->competenceFunctionIsMain;
    }


}

?>
