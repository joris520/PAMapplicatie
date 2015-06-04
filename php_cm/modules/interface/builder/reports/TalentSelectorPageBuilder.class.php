<?php

/**
 * Description of TalentSelectorPageBuilder
 *
 * @author hans.prins
 */

require_once('modules/interface/builder/reports/TalentSelectorInterfaceBuilder.class.php');

class TalentSelectorPageBuilder
{
    static function getPageHtml($displayWidth)
    {
        list($safeFormHandler, $contentHtml) = TalentSelectorInterfaceBuilder::getViewHtml($displayWidth);

        $formId                     = 'execute_talent_selector_form';
        $title                      = TXT_UCF('TALENT_SELECTOR');
        $contentPixelHeight         = NULL;
        $showReferenceDateWarning   = ApplicationInterfaceBuilder::HIDE_WARNING;
        $buttonName                 = TXT_BTN('SEARCH');
        $buttonId                   = NULL;
        $cancelName                 = TXT_BTN('CLEAR');
        $cancelFunction             = 'xajax_public_report__displayTalentSelector()';
        $showCancel                 = TRUE;
        $buttonTop                  = TRUE;
        $buttonBottom               = FALSE;
        $buttonAlign                = 'right';

        return ApplicationInterfaceBuilder::getReportActionHtml($formId,
                                                                $safeFormHandler,
                                                                $title,
                                                                $contentHtml,
                                                                $displayWidth,
                                                                $contentPixelHeight,
                                                                $showReferenceDateWarning,
                                                                $buttonName,
                                                                $buttonId,
                                                                $cancelName,
                                                                $cancelFunction,
                                                                $showCancel,
                                                                $buttonTop,
                                                                $buttonBottom,
                                                                $buttonAlign);
    }

    static function getResultPageHtml($displayWidth, TalentSelectorResultCollection $resultCollection)
    {

        list($safeFormHandler, $contentHtml) =  TalentSelectorInterfaceBuilder::getResultViewHtml($displayWidth, $resultCollection);

        $formId                     = 'print_talent_selector_form';
        $title                      = '';
        $contentPixelHeight         = NULL;
        $showReferenceDateWarning   = ApplicationInterfaceBuilder::HIDE_WARNING;
        $buttonTop                  = FALSE;
        $buttonBottom               = TRUE;
        $buttonAlign                = 'right';

        return ApplicationInterfaceBuilder::getReportResultHtml($formId,
                                                                $safeFormHandler,
                                                                $title,
                                                                $contentHtml,
                                                                $displayWidth,
                                                                $contentPixelHeight,
                                                                $showReferenceDateWarning,
                                                                $buttonTop,
                                                                $buttonBottom,
                                                                $buttonAlign);

    }
}

?>
