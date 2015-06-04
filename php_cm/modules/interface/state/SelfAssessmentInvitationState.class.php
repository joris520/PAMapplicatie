<?php

/**
 * Description of SelfAssessmentInvitationState
 *
 * @author ben.dokter
 */
class SelfAssessmentInvitationState
{
    const NOT_INVITED       = 0;
    const INVITED_NOT_SEND  = 1;
    const INVITED_SENT      = 2;
    const INVITED_COMPLETED = 3;

    static function determineState(EmployeeAssessmentCollection $assessmentCollection) //, $invitationCount)
    {
        $state = self::NOT_INVITED;

        $isInvited          = $assessmentCollection->isInvited();
        $isSent             = $assessmentCollection->isSent();
        $completedStatus    = $assessmentCollection->getCompleted();

        // gedefinieerde waarde geven
        $completedStatus    = empty($completedStatus)   ? AssessmentInvitationCompletedValue::NOT_COMPLETED  : $completedStatus;

        if ($isInvited) {
            if ($isSent) {
                $state = $completedStatus == AssessmentInvitationCompletedValue::NOT_COMPLETED ? self::INVITED_SENT : self::INVITED_COMPLETED;
            } else {
                $state = self::INVITED_NOT_SEND;
            }
        }

        return $state;
    }

}

?>
