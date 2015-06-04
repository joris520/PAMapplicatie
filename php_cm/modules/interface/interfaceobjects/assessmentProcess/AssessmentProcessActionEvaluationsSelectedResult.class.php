<?php

/**
 * Description of AssessmentProcessActionEvaluationsSelectedResult
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseInterfaceObject.class.php');

class AssessmentProcessActionEvaluationsSelectedResult extends BaseInterfaceObject
{
    const TEMPLATE_FILE = 'assessmentProcess/assessmentProcessActionEvaluationsSelectedResult.tpl';

    private $bossLabel;
    private $evaluationCount;

    static function create($displayWidth)
    {
        return new AssessmentProcessActionEvaluationsSelectedResult(    $displayWidth,
                                                                        self::TEMPLATE_FILE);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setBossLabel($bossLabel)
    {
        $this->bossLabel = $bossLabel;
    }

    function getBossLabel()
    {
        return $this->bossLabel;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setEvaluationCount($evaluationCount)
    {
        $this->evaluationCount = $evaluationCount;
    }

    function getEvaluationCount()
    {
        return $this->evaluationCount;
    }

}

?>
