<?php

/**
 * Description of FinalResultReportInterfaceBuilderComponents
 *
 * @author ben.dokter
 */

require_once('modules/interface/builder/reports/BaseReportEmployeeInterfaceBuilderComponents.class.php');

class FinalResultReportInterfaceBuilderComponents extends BaseReportEmployeeInterfaceBuilderComponents
{
    static function getEditAssessmentCycleLink()
    {
        $html = '';
        if (PermissionsService::isViewAllowed(PERMISSION_FINAL_RESULT_DASHBOARD)) {
            $html .= parent::getEditAssessmentCycleLink();
        }
        return $html;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // letop, $bossId kan ook een BossFilterValue zijn, dus '' eromheen
    static function getEmployeesTotalDetailLink($bossId,
                                                $detailCount)
    {
        $html = '';
        if (PermissionsService::isViewAllowed(PERMISSION_FINAL_RESULT_DASHBOARD)) {
            $html .= parent::getEmployeesTotalDetailLink(   $bossId,
                                                            $detailCount);
        }
        return $html;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // letop, $bossId kan ook een BossFilterValue zijn, dus '' eromheen; ditto $scoreId
    static function getFinalResultScoreDetailLink(  $bossId,
                                                    $scoreId,
                                                    $detailCount)
    {
        $html = '';
        if (PermissionsService::isViewAllowed(PERMISSION_FINAL_RESULT_DASHBOARD)) {
            if ($detailCount > 0 && !empty($bossId)) {
                $html .= InterfaceBuilder::iconLink('dashboard_final_result_' . $bossId . '_' . $scoreId,
                                                    TXT_UCF('ADDITIONAL_INFO'),
                                                    'xajax_public_report__dashboardFinalResultScoreDetail(\'' . $bossId . '\', \'' . $scoreId . '\');',
                                                    ICON_INFO);
            } else {
                $html .= ApplicationInterfaceBuilder::NO_ICON_LINK_SPACES; // hack ivm uitlijning
            }
        }
        return $html;
    }

}

?>
