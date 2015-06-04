<?php

/**
 * Description of FinalResultDashboardCountValueObject
 *
 * @author ben.dokter
 */

require_once('modules/model/valueobjects/report/BaseDashboardCountValueObject.class.php');

class FinalResultDashboardCountValueObject extends BaseDashboardCountValueObject
{


    // de create kan zonder id, aangeroepen vanuit de collection
    static function create()
    {
        return new FinalResultDashboardCountValueObject(NULL);
    }

    static function isNotAssessedScoreId($scoreId)
    {
        return $scoreId == ScoreValue::INPUT_SCORE_NA;
    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function addEmployeeCountForScore($score, $finalResult)
    {
        $this->addEmployeeCountForKey($score, $finalResult);
    }

    function getFinalResultForScore($score)
    {
        return $this->getEmployeeCountForKey($score);
    }

    function getScoreKeys()
    {
        return $this->getEmployeeCountKeys();
    }

}

?>
