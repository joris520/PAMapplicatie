<?php

/**
 * Description of ScoreSelfAssessmentState
 *
 * @author ben.dokter
 */

class ScoreSelfAssessmentState
{
    const NONE                                      =  0;

    const MANAGER_NONE_EMPLOYEE_NOT_INVITED         =  1;
    const MANAGER_PRELIMINARY_EMPLOYEE_NOT_INVITED  =  2;
    const MANAGER_FINALIZED_EMPLOYEE_NOT_INVITED    =  3;

    const MANAGER_NONE_EMPLOYEE_INVITED             =  4;
    const MANAGER_PRELIMINARY_EMPLOYEE_INVITED      =  5;
    const MANAGER_FINALIZED_EMPLOYEE_INVITED        =  6;

    const MANAGER_NONE_EMPLOYEE_COMPLETED           =  7;
    const MANAGER_PRELIMINARY_EMPLOYEE_COMPLETED    =  8;
    const MANAGER_FINALIZED_EMPLOYEE_COMPLETED      =  9;


    static function determineState(EmployeeAssessmentCollection $assessmentCollection) //, $invitationCount)
    {
        $state = self::NONE;

        $scoreStatus     = $assessmentCollection->getScoreStatus();
        $isInvited       = $assessmentCollection->isInvited();
        $completedStatus = $assessmentCollection->getCompleted();

        // gedefinieerde waarde geven
        $isInvited          = empty($isInvited)         ? false                     : $isInvited;
        $scoreStatus        = empty($scoreStatus)       ? ScoreStatusValue::NONE    : $scoreStatus;
        $completedStatus    = empty($completedStatus)   ? AssessmentInvitationCompletedValue::NOT_COMPLETED  : $completedStatus;

        if ($isInvited) {
            // uitgenodigd voor zelfevaluatie
            switch($scoreStatus) {
                case ScoreStatusValue::FINALIZED:
                    $state = $completedStatus == AssessmentInvitationCompletedValue::COMPLETED ? self::MANAGER_FINALIZED_EMPLOYEE_COMPLETED      : self::MANAGER_FINALIZED_EMPLOYEE_INVITED;
                    break;
                case ScoreStatusValue::PRELIMINARY:
                    $state = $completedStatus == AssessmentInvitationCompletedValue::COMPLETED ? self::MANAGER_PRELIMINARY_EMPLOYEE_COMPLETED    : self::MANAGER_PRELIMINARY_EMPLOYEE_INVITED;
                    break;
                default: // NONE
                    $state = $completedStatus == AssessmentInvitationCompletedValue::COMPLETED ? self::MANAGER_NONE_EMPLOYEE_COMPLETED           : self::MANAGER_NONE_EMPLOYEE_INVITED;
                    break;
            }
        } else { // niet uitgenodigd...
            switch($scoreStatus) {
                case ScoreStatusValue::FINALIZED:
                    $state = self::MANAGER_FINALIZED_EMPLOYEE_NOT_INVITED;
                    break;
                case ScoreStatusValue::PRELIMINARY:
                    $state = self::MANAGER_PRELIMINARY_EMPLOYEE_NOT_INVITED;
                    break;
                default: // NONE
                    $state = self:: MANAGER_NONE_EMPLOYEE_NOT_INVITED;
                    break;
            }
        }
        return $state;
    }

    static function isInvited($state)
    {
        return $state >= self::MANAGER_NONE_EMPLOYEE_INVITED;
    }

    static function debugInfo($state)
    {
        $debugInfo = '';
        switch($state) {
            case self::NONE:
                $debugInfo .= 'NONE';
                break;
            case self::MANAGER_NONE_EMPLOYEE_NOT_INVITED:
                $debugInfo .= 'manager_none_employee_not_invited';
                break;
            case self::MANAGER_PRELIMINARY_EMPLOYEE_NOT_INVITED:
                $debugInfo .= 'manager_preliminary_employee_not_invited';
                break;
            case self::MANAGER_FINALIZED_EMPLOYEE_NOT_INVITED:
                $debugInfo .= 'manager_finalized_employee_not_invited';
                break;
            case self::MANAGER_NONE_EMPLOYEE_INVITED:
                $debugInfo .= 'manager_none_employee_invited';
                break;
            case self::MANAGER_PRELIMINARY_EMPLOYEE_INVITED:
                $debugInfo .= 'manager_preliminary_employee_invited';
                break;
            case self::MANAGER_FINALIZED_EMPLOYEE_INVITED:
                $debugInfo .= 'manager_finalized_employee_invited';
                break;
            case self::MANAGER_NONE_EMPLOYEE_COMPLETED:
                $debugInfo .= 'manager_none_employee_completed';
                break;
            case self::MANAGER_PRELIMINARY_EMPLOYEE_COMPLETED:
                $debugInfo .= 'manager_preliminary_employee_completed';
                break;
            case self::MANAGER_FINALIZED_EMPLOYEE_COMPLETED:
                $debugInfo .= 'manager_finalized_employee_completed';
                break;
            default:
                $debugInfo .= 'empty';
        }
        return $debugInfo;
    }
}

?>