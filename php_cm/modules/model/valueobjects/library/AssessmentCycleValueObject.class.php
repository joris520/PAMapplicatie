<?php

/**
 * Description of AssessmentCycleValueObject
 *
 * @author hans.prins
 */

require_once('gino/DateUtils.class.php');
require_once('application/model/valueobjects/BaseValueObject.class.php');

class AssessmentCycleValueObject extends BaseValueObject
{

    private $cycleName;
    private $startDate; // database format
    private $endDate; // database format

    static function createWithData( $assessmentCycleData,
                                    $endDate = NULL)
    {

        return new AssessmentCycleValueObject(  $assessmentCycleData[AssessmentCycleQueries::ID_FIELD],
                                                $assessmentCycleData,
                                                $endDate);
    }

    static function createWithValues(   $assessmentCycleId,
                                        $cycleName,
                                        $startDate,
                                        $endDate = NULL)
    {
        $assessmentCycleData = array();

        $assessmentCycleData[AssessmentCycleQueries::ID_FIELD] = $assessmentCycleId;
        $assessmentCycleData['cycle_name'] = $cycleName;
        $assessmentCycleData['start_date'] = $startDate;

        return new AssessmentCycleValueObject(  $assessmentCycleId,
                                                $assessmentCycleData,
                                                $endDate);
    }

    function __construct(   $assessmentCycleId,
                            $assessmentCycleData,
                            $endDate = NULL)
    {
        parent::__construct($assessmentCycleId,
                            $assessmentCycleData['saved_by_user_id'],
                            $assessmentCycleData['saved_by_user'],
                            $assessmentCycleData['saved_datetime']);

        $this->cycleName  = $assessmentCycleData['cycle_name'];
        $this->startDate  = $assessmentCycleData['start_date'];
        $this->endDate    = $endDate;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getAssessmentCycleName()
    {
        return $this->cycleName;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getStartDate()
    {
        return $this->startDate;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getEndDate()
    {
        return $this->endDate;
    }

    function hasEndDate()
    {
        return !empty($this->endDate) && $this->endDate != AssessmentCycleService::EMPTY_END_DATE;
    }
}

?>
