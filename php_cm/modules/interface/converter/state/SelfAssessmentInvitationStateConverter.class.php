<?php

/**
 * Description of SelfAssessmentInvitationStateConverter
 *
 * @author ben.dokter
 */
require_once('application/interface/converter/AbstractBaseConverter.class.php');
require_once('modules/interface/state/SelfAssessmentInvitationState.class.php');

class SelfAssessmentInvitationStateConverter extends AbstractBaseConverter
{
    static function display($value, $empty = '-')
    {
        $display = $empty;
        switch($value) {
            case SelfAssessmentInvitationState::NOT_INVITED:
                $display = TXT_UCF('NOT_INVITED_FOR_SELF_ASSESSMENT');
                break;
            case SelfAssessmentInvitationState::INVITED_NOT_SEND:
                $display = TXT_UCF('SELF_ASSESSMENT_PREPARED');
                break;
            case SelfAssessmentInvitationState::INVITED_SENT:
                $display = TXT_UCF('SELF_ASSESSMENT_INVITATION_SENT');
                break;
            case SelfAssessmentInvitationState::INVITED_COMPLETED:
                $display = TXT_UCF('SELF_ASSESSMENT_COMPLETED');
                break;
        }
        return $display;
    }

    // default de display
    static function input($value, $empty = '-')
    {
        return self::display($value, $empty);
    }

}

?>
