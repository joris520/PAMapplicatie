<?php

/**
 * Description of AssessmentInvitationCompletedConverter
 *
 * @author ben.dokter
 */

require_once('application/interface/converter/AbstractBaseConverter.class.php');
require_once('modules/interface/interfaceobjects/assessmentInvitation/AssessmentIconView.class.php');

require_once('modules/model/value/assessmentInvitation/AssessmentInvitationCompletedValue.class.php');

class AssessmentInvitationCompletedConverter extends AbstractBaseConverter
{

    static function display($value, $empty = '-')
    {
        $display = $empty;
        switch($value) {
            case AssessmentInvitationCompletedValue::NOT_COMPLETED:
                $display = TXT_UCF('INVITATION_NOT_COMPLETED');
                break;
            case AssessmentInvitationCompletedValue::COMPLETED:
                $display = TXT_UCF('INVITATION_COMPLETED');
                break;
            case AssessmentInvitationCompletedValue::RESULT_DELETED:
                $display = TXT_UCF('INVITATION_RESULT_DELETED');
                break;
        }
        return $display;
    }

    static function displayReport($value, $empty = '-')
    {
        $display = $empty;
        switch($value) {
            case AssessmentInvitationCompletedValue::NOT_COMPLETED:
                $display = TXT_UCF('REPORT_INVITATION_NOT_COMPLETED');
                break;
            case AssessmentInvitationCompletedValue::COMPLETED:
                $display = TXT_UCF('REPORT_INVITATION_COMPLETED');
                break;
            case AssessmentInvitationCompletedValue::RESULT_DELETED:
                $display = TXT_UCF('REPORT_INVITATION_RESULT_DELETED');
                break;
        }
        return $display;
    }


    // default de display
    static function input($value, $empty = '-')
    {
        return self::display($value, $empty);
    }

    static function imageSrc($value)
    {
        $imageSrc   = ICON_EMPLOYEE_ASSESSMENT_NOT_INVITED_THIS_PERIOD;

        switch($value) {
            case AssessmentInvitationCompletedValue::NOT_COMPLETED:
                $imageSrc = ICON_EMPLOYEE_ASSESSMENT_NOT_COMPLETED;
                break;
            case AssessmentInvitationCompletedValue::COMPLETED:
                $imageSrc = ICON_EMPLOYEE_ASSESSMENT_COMPLETED;
                break;
            case AssessmentInvitationCompletedValue::RESULT_DELETED:
                $imageSrc = ICON_EMPLOYEE_ASSESSMENT_COMPLETED_DELETED;
                break;
        }

        return $imageSrc;
    }

    static function image($value)
    {
        $imageTitle = self::display($value);
        $imageSrc   = self::imageSrc($value);

        $iconView = AssessmentIconView::create($imageSrc, $imageTitle);
        return $iconView->fetchHtml();
    }


}

?>
