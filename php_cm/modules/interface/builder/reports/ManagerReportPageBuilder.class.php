<?php

/**
 * Description of ManagerReportPageBuilder
 *
 * @author ben.dokter
 */
require_once('modules/interface/builder/reports/ManagerReportInterfaceBuilder.class.php');

class ManagerReportPageBuilder
{

    static function getPageHtml($viewWidth,
                                ManagerReportCollection $collection)
    {
        return ManagerReportInterfaceBuilder::getViewHtml(  $viewWidth,
                                                            $collection);
    }

    static function geDepartmentsPopupHtml( $displayWidth,
                                            $contentHeight,
                                            DepartmentCollection $collection)
    {
        $contentHtml = ManagerReportInterfaceBuilder::getDepartmentsHtml(   $displayWidth,
                                                                            $collection);

        // popup
        $title = TXT_UCF('ADDITIONAL_INFO') . ' ' . TXT_LC('DEPARTMENTS');
        return ApplicationInterfaceBuilder::getInfoPopupHtml($title, $contentHtml, $displayWidth, $contentHeight);
    }

}

?>
