<?php

/**
 * Description of AssessmentInvitationInterfaceBuilderComponents
 *
 * @author ben.dokter
 */

require_once('modules/model/value/assessmentInvitation/AssessmentInvitationCompletedValue.class.php');
require_once('modules/interface/converter/employee/competence/ScoreStatusConverter.class.php');
require_once('modules/interface/converter/assessmentInvitation/AssessmentInvitationCompletedConverter.class.php');

class AssessmentInvitationInterfaceBuilderComponents
{
    static function getScoreStatusDetails($isInvited, $scoreStatus)
    {
        if (CUSTOMER_OPTION_SHOW_SCORE_STATUS_ICONS) {
            if ($isInvited) { // uitgenodigd

                $title = TXT_UCF('MANAGER_HAS_NOT_FILLED_IN_ASSESSMENT');
                $icon = ScoreStatusConverter::imageSrc($scoreStatus);

                switch ($scoreStatus) {
                    case ScoreStatusValue::PRELIMINARY:
                        $title = TXT_UCF('MANAGER_HAS_NOT_FILLED_IN_ASSESSMENT');
                        break;
                    case ScoreStatusValue::FINALIZED:
                        $title = TXT_UCF('MANAGER_HAS_FILLED_IN_ASSESSMENT');
                        break;
                }
            } else { // niet uitgenodigd...
                $icon  = ICON_EMPLOYEE_ASSESSMENT_NOT_INVITED_THIS_PERIOD;
                $title = TXT_UCF('EMPLOYEE_IS_NOT_INVITED_FOR_ASSESSMENT_THIS_PERIOD');
            }
        } else {
            $icon = '';
            $title = '';
        }
        return array($title, $icon);
    }

    static function getSelfAssessmentDetails($isInvited, $completedStatus)
    {
        if (CUSTOMER_OPTION_SHOW_SCORE_STATUS_ICONS) {
            $title = '';
            $icon  = ICON_EMPLOYEE_ASSESSMENT_NOT_INVITED;
            if (empty($completedStatus)) {
                $completedStatus = AssessmentInvitationCompletedValue::NOT_COMPLETED;
            }

            // employee
            if ($isInvited) { // uitgenodigd
                $icon = AssessmentInvitationCompletedConverter::imageSrc($completedStatus);
                if ($completedStatus != AssessmentInvitationCompletedValue::NOT_COMPLETED) { // todo: converter
                    $title = TXT_UCF('EMPLOYEE_HAS_FILLED_IN_ASSESSMENT');
                } else {
                    $title = TXT_UCF('EMPLOYEE_HAS_NOT_FILLED_IN_ASSESSMENT');
                }
            } else { // niet uitgenodigd...
                $icon  = ICON_EMPLOYEE_ASSESSMENT_NOT_INVITED_THIS_PERIOD;
                $title = TXT_UCF('EMPLOYEE_IS_NOT_INVITED_FOR_ASSESSMENT_THIS_PERIOD');
            }
        } else {
            $icon = '';
            $title = '';
        }

        return array($title, $icon);

    }

}

?>
