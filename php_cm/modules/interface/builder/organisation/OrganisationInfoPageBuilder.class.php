<?php


/**
 * Description of OrganisationInfoPageBuilder
 *
 * @author ben.dokter
 */

require_once('modules/interface/builder/organisation/OrganisationInfoInterfaceBuilder.class.php');

class OrganisationInfoPageBuilder
{
    static function getPageHtml($displayWidth)
    {
        return OrganisationInfoInterfaceBuilder::getViewHtml($displayWidth);
    }

    static function getEditPopupHtml($displayWidth, $contentHeight, $showWarning)
    {
        list($safeFormHandler, $contentHtml) = OrganisationInfoInterfaceBuilder::getEditHtml($displayWidth);

        // popup
        $title = TXT_UCF('EDIT') . ' ' . TXT_LC('COMPANY_INFORMATION');
        $formId = 'edit_organisation_info';
        return ApplicationInterfaceBuilder::getEditPopupHtml(   $formId,
                                                                $safeFormHandler,
                                                                $title,
                                                                $contentHtml,
                                                                $displayWidth,
                                                                $contentHeight,
                                                                $showWarning);
    }

}

?>
