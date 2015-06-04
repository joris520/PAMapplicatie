<?php

/**
 * Description of BaseReportEmployeePageBuilder
 *
 * @author ben.dokter
 */

require_once('modules/interface/builder/reports/BaseReportPageBuilder.class.php');
require_once('modules/interface/builder/reports/BaseReportEmployeeInterfaceBuilder.class.php');

class BaseReportEmployeePageBuilder extends BaseReportPageBuilder
{
    static function getEmployeesPopupHtml(  $displayWidth,
                                            $contentHeight,
                                            BaseReportEmployeeGroupCollection $groupCollection,
                                            $countTitle = NULL)
    {
        $contentHtml = '';

        foreach ($groupCollection->getKeys() as $key) {
            $collection = $groupCollection->getCollection($key);
            $contentHtml .= BaseReportEmployeeInterfaceBuilder::getEmployeesHtml(   $displayWidth,
                                                                                    $collection,
                                                                                    $countTitle);
        }

        // popup
        $title = TXT_UCF('ADDITIONAL_INFO') . ' ' . TXT_LC('EMPLOYEES');
        return ApplicationInterfaceBuilder::getInfoPopupHtml(   $title,
                                                                $contentHtml,
                                                                $displayWidth,
                                                                $contentHeight);
    }

}

?>
