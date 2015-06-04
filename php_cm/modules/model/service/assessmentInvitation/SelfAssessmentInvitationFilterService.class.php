<?php

/**
 * Description of SelfAssessmentInvitationFilterService
 *
 * @author ben.dokter
 */

require_once('modules/model/queries/assessmentInvitation/SelfAssessmentInvitationFilterQueries.class.php');

class SelfAssessmentInvitationFilterService
{
    static function getEmployeesWithInvitation( $allowedEmployeeIds,
                                                AssessmentCycleValueObject $currentCycle,
                                                $returnAsString = true)
    {
        $employeeIds = array();

        $query = SelfAssessmentInvitationFilterQueries::getEmployeesWithInvitationInPeriod( $allowedEmployeeIds,
                                                                                            $currentCycle->getStartDate(),
                                                                                            $currentCycle->getEndDate());
        while ($employeeIdData = @mysql_fetch_assoc($query)) {
            $employeeIds[] = $employeeIdData[SelfAssessmentInvitationFilterQueries::ID_FIELD];
        }
        mysql_free_result($query);

        return $returnAsString ? implode(',', $employeeIds) : $employeeIds;
    }

    static function getEmployeesWithoutInvitation(  $allowedEmployeeIds,
                                                    AssessmentCycleValueObject $currentCycle,
                                                    $returnAsString = true)
    {
        $employeeIds = array();

        $query = SelfAssessmentInvitationFilterQueries::getEmployeesWithoutInvitationInPeriod(  $allowedEmployeeIds,
                                                                                                $currentCycle->getStartDate(),
                                                                                                $currentCycle->getEndDate());
        while ($employeeIdData = @mysql_fetch_assoc($query)) {
            $employeeIds[] = $employeeIdData[SelfAssessmentInvitationFilterQueries::ID_FIELD];
        }
        mysql_free_result($query);

        return $returnAsString ? implode(',', $employeeIds) : $employeeIds;
    }

}

?>
