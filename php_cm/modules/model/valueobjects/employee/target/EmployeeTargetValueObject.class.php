<?php

/**
 * Description of EmployeeTargetValueObject
 *
 * @author hans.prins
 */

require_once('modules/model/valueobjects/employee/BaseEmployeeValueObject.class.php');

class EmployeeTargetValueObject extends BaseEmployeeValueObject
{
    private $targetName;
    private $performanceIndicator;
    private $endDate;
    private $status;
    private $evaluation;
    private $evaluationDate;

    static function createWithData( $employeeId,
                                    $targetData)
    {

        return new EmployeeTargetValueObject(   $employeeId,
                                                $targetData[EmployeeTargetQueries::ID_FIELD],
                                                $targetData);
    }

    static function createWithValues($employeeId,
                                     $targetId,
                                     $targetName,
                                     $performanceIndicator,
                                     $endDate,
                                     $status,
                                     $evaluation,
                                     $evaluationDate)
    {
        $targetData = array();
        $targetData[EmployeeTargetQueries::ID_FIELD] = $targetId;
        $targetData['target_name']                   = $targetName;
        $targetData['performance_indicator']         = $performanceIndicator;
        $targetData['end_date']                      = $endDate;
        $targetData['status']                        = $status;
        $targetData['evaluation']                    = $evaluation;
        $targetData['evaluation_date']               = $evaluationDate;

        return new EmployeeTargetValueObject(   $employeeId,
                                                $targetId,
                                                $targetData);
    }

    function __construct(   $employeeId,
                            $targetId,
                            $targetData)
    {
        parent::__construct($employeeId,
                            $targetId,
                            $targetData['saved_by_user_id'],
                            $targetData['saved_by_user'],
                            $targetData['saved_datetime']);

        $this->targetName           = $targetData['target_name'];
        $this->performanceIndicator = $targetData['performance_indicator'];
        $this->endDate              = $targetData['end_date'];
        $this->status               = $targetData['status'];
        $this->evaluation           = $targetData['evaluation'];
        $this->evaluationDate       = $targetData['evaluation_date'];
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $targetName
    function getTargetName()
    {
        return $this->targetName;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $performanceIndicator
    function getPerformanceIndicator()
    {
        return $this->performanceIndicator;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $endDate
    function getEndDate()
    {
        return $this->endDate;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $status
    function getStatus()
    {
        return $this->status;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $evaluation
    function getEvaluation()
    {
        return $this->evaluation;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $evaluationDate
    function getEvaluationDate()
    {
        return $this->evaluationDate;
    }
}

?>
