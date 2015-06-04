<?php

/**
 * Description of StandardDatePageBuilder
 *
 * @author ben.dokter
 */

require_once('modules/interface/builder/settings/StandardDateInterfaceBuilder.class.php');

class StandardDatePageBuilder
{
    static function getPageHtml($displayWidth)
    {
        return StandardDateInterfaceBuilder::getViewHtml($displayWidth);
    }

    static function getEditPopupHtml($displayWidth, $contentHeight, $showWarning)
    {
        list($safeFormHandler, $contentHtml) = StandardDateInterfaceBuilder::getEditHtml($displayWidth);

        // popup
        $title = TXT_UCF('EDIT') . ' ' . TXT_LC('DEFAULT_END_DATE');
        $formId = 'edit_standard_date';
        return ApplicationInterfaceBuilder::getEditPopupHtml($formId, $safeFormHandler, $title, $contentHtml, $displayWidth, $contentHeight, $showWarning);
    }

}

?>
