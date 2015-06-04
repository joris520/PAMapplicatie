<?php

/**
 * Description of CompetenceValueObject
 *
 * @author ben.dokter
 */
require_once('application/model/valueobjects/BaseValueObject.class.php');

class CompetenceValueObject extends BaseValueObject
{
    public $competenceName;
    public $competenceDescription;
    public $scale;
    public $score1Description;
    public $score2Description;
    public $score3Description;
    public $score4Description;
    public $score5Description;

    public $competenceIsKey;
    public $competenceScaleType;
    public $competenceIsOptional;
    public $competenceIsMain;

    // extra info
    public $categoryId;
    public $categoryName;
    public $clusterId;
    public $clusterName;

    public $competenceFunctionNorm;
    public $competenceFunctionWeight;


    static function createWithData($competenceData)
    {
        return new CompetenceValueObject($competenceData[CompetenceQueries::ID_FIELD], $competenceData);
    }

    // todo: uitbreiden voor competence edit
    static function createWithValues(   $competenceId,
                                        $competenceName,
                                        $competenceDescription,
                                        $scale,
                                        $score1Description,
                                        $score2Description,
                                        $score3Description,
                                        $score4Description,
                                        $score5Description,
                                        $categoryId,
                                        $categoryName,
                                        $clusterId,
                                        $clusterName,
                                        $competenceIsKey,
                                        $competenceScaleType,
                                        $competenceIsOptional,
                                        $competenceIsMain,
                                        $competenceFunctionNorm,
                                        $competenceFunctionWeight)
    {
        $competenceData = array();

        $competenceData[CompetenceQueries::ID_FIELD]    = $competenceId;
        $competenceData['knowledge_skill_point']        = $competenceName;
        $competenceData['description']                  = $competenceDescription;
        $competenceData['scale']                        = $scale;
        $competenceData['1none']                        = $score1Description;
        $competenceData['2basic']                       = $score2Description;
        $competenceData['3average']                     = $score3Description;
        $competenceData['4good']                        = $score4Description;
        $competenceData['5specialist']                  = $score5Description;
        $competenceData['is_key']                       = $competenceIsKey;
        $competenceData['scale']                        = $competenceScaleType;
        $competenceData['is_na_allowed']                = $competenceIsOptional;
        $competenceData['is_cluster_main']              = $competenceIsMain;

        // extra info
        $competenceData['category_id']                  = $categoryId;
        $competenceData['knowledge_skill']              = $categoryName ;
        $competenceData['cluster_id']                   = $clusterId;
        $competenceData['cluster']                      = $clusterName ;
        $competenceData['norm']                         = $competenceFunctionNorm;
        $competenceData['weight_factor']                = $competenceFunctionWeight;

        return new CompetenceValueObject($competenceId, $competenceData);
    }

    function __construct($competenceId, $competenceData)
    {
        parent::__construct($competenceId,
                            $competenceData['saved_by_user_id'], // BESTAAN NOG NIET
                            $competenceData['modified_by_user'], // opbouwen uit "oude" velden
                            $competenceData['modified_date'] . ' ' . $competenceData['modified_time']);

        $this->competenceName           = $competenceData['knowledge_skill_point'];
        $this->competenceDescription    = $competenceData['description'];
        $this->scale                    = $competenceData['scale'];
        $this->score1Description        = $competenceData['1none'];
        $this->score2Description        = $competenceData['2basic'];
        $this->score3Description        = $competenceData['3average'];
        $this->score4Description        = $competenceData['4good'];
        $this->score5Description        = $competenceData['5specialist'];

        // extra info
        $this->categoryId               = $competenceData['category_id'];
        $this->categoryName             = $competenceData['knowledge_skill'];
        $this->clusterId                = $competenceData['cluster_id'];
        $this->clusterName              = $competenceData['cluster'];
        $this->competenceIsKey          = $competenceData['is_key'] == FUNCTION_IS_KEY_COMPETENCE;
        $this->competenceScaleType      = $competenceData['scale'];
        $this->competenceIsOptional     = $competenceData['is_na_allowed'] == COMPETENCE_IS_OPTIONAL;
        $this->competenceIsMain         = $competenceData['is_cluster_main'] == COMPETENCE_CLUSTER_IS_MAIN;
        $this->competenceFunctionNorm   = $competenceData['norm'];
        $this->competenceFunctionWeight = $competenceData['weight_factor'];

    }

}

?>
