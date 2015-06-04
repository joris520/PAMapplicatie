<?php

/**
 * Description of BaseReportInterfaceBuilderComponents
 *
 * @author ben.dokter
 */
class BaseReportInterfaceBuilderComponents
{
    protected static function getEditAssessmentCycleLink()
    {
        $currentModule = ApplicationNavigationService::getCurrentModule();
        return InterfaceBuilder::iconLink(  'edit_report_assessment_cycle',
                                            TXT_UCF('EDIT') . ' ' . TXT_LC('ASSESSMENT_CYCLE') . ' ' . TXT_LC('REPORT'),
                                            'xajax_public_report__selectAssessmentCycle(\'' . $currentModule . '\');return false;',
                                            ICON_EDIT);
    }
    
    static function getCancelInlineSelectorLink()
    {
        $html .= InterfaceBuilder::iconLink('cancel_inline_report_assessment_cycle',
                                            TXT_UCF('CANCEL'),
                                            'xajax_public_report__cancelSelectAssessmentCycle();return false;',
                                            ICON_CANCEL);

        return $html;

    }

}

?>
