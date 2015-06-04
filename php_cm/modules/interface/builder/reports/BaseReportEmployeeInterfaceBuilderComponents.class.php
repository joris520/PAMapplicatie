<?php

/**
 * Description of BaseReportEmployeeInterfaceBuilderComponents
 *
 * @author ben.dokter
 */
require_once('modules/interface/builder/reports/BaseReportInterfaceBuilderComponents.class.php');

class BaseReportEmployeeInterfaceBuilderComponents extends BaseReportInterfaceBuilderComponents
{

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // letop, $bossId kan ook een BossFilterValue zijn, dus '' eromheen
    protected static function getEmployeesTotalDetailLink(  $bossId,
                                                            $detailCount)
    {
        $html = '';
        if ($detailCount > 0 && !empty($bossId)) {
            $html .= InterfaceBuilder::iconLink('dashboard_total_employees_' . $bossId,
                                                TXT_UCF('ADDITIONAL_INFO'),
                                                'xajax_public_report__dashboardEmployeesTotalDetail(\'' . $bossId . '\');',
                                                ICON_INFO);
        } else {
            $html .= ApplicationInterfaceBuilder::NO_ICON_LINK_SPACES; // hack ivm uitlijning
        }
        return $html;
    }

}

?>
