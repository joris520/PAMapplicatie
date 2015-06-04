<?php

/**
 * Description of TalentSelectorCompetenceValueObject
 *
 * @author hans.prins
 */
require_once('modules/model/valueobjects/report/BaseReportValueObject.class.php');

class TalentSelectorCompetenceValueObject extends BaseReportValueObject
{
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

    public $operator;
    public $requestedScore;

    static function createWithData($competenceData)
    {
        return new TalentSelectorCompetenceValueObject($competenceData);
    }

    static function createWithValues($competenceId,
                                     $competenceName,
                                     $operator,
                                     $requestedScore)
    {
        $competenceData = array();
        $competenceData['competenceId']   = $competenceId;
        $competenceData['competenceName'] = $competenceName;
        $competenceData['operator']       = $operator;
        $competenceData['requestedScore'] = $requestedScore;
        return new TalentSelectorCompetenceValueObject($competenceData);
    }

    function __construct($competenceData)
    {
        $competenceId = $competenceData['competenceId'];

        parent::__construct($competenceId);

        $this->competenceId             = $competenceId;
        $this->competenceName           = $competenceData['competenceName'];

        $this->competenceScaleType      = $competenceData['scale'];
        $this->competenceIsKey          = $competenceData['is_key'] == FUNCTION_IS_KEY_COMPETENCE;
        $this->competenceIsOptional     = $competenceData['is_na_allowed'] == COMPETENCE_IS_OPTIONAL;
        $this->competenceIsMain         = $competenceData['is_cluster_main'] == COMPETENCE_CLUSTER_IS_MAIN;

        $this->competenceFunctionIsMain = $competenceData['main_function'] == 1; // todo: constante
        $this->competenceFunctionNorm   = $competenceData['max_norm']; // de max(norm) van meerdere nevenfuncties
        $this->competenceFunctionWeight = $competenceData['weight_factor'];

        $this->categoryId               = $competenceData['categoryId'];
        $this->categoryName             = $competenceData['category'];

        $this->clusterId                = $competenceData['clusterId'];
        $this->clusterName              = $competenceData['cluster'];

        $this->operator                 = $competenceData['operator'];
        $this->requestedScore           = $competenceData['requestedScore'];
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

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $operator
    function getOperator()
    {
        return $this->operator;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $requestedScore
    function getRequestedScore()
    {
        return $this->requestedScore;
    }
}

?>
