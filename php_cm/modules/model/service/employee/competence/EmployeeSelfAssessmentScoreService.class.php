<?php

/**
 * Description of EmployeeSelfAssessementScoreService
 *
 * @author ben.dokter
 */

require_once('modules/model/queries/employee/competence/EmployeeSelfAssessmentScoreQueries.class.php');
require_once('modules/model/valueobjects/employee/competence/EmployeeSelfAssessmentScoreValueObject.class.php');

class EmployeeSelfAssessmentScoreService
{

    static function getValueObject( $employeeId,
                                    $competenceId,
                                    AssessmentCycleValueObject $assessmentCycle)
    {
        $query = EmployeeSelfAssessmentScoreQueries::getScoreInPeriod(  $employeeId,
                                                                        $competenceId,
                                                                        $assessmentCycle->getStartDate(),
                                                                        $assessmentCycle->getEndDate());
        $threesixtyEvaluationData = @mysql_fetch_assoc($query);
        mysql_free_result($query);

        return EmployeeSelfAssessmentScoreValueObject::createWithData(  $employeeId,
                                                                        $competenceId,
                                                                        $threesixtyEvaluationData);
    }

}

?>
