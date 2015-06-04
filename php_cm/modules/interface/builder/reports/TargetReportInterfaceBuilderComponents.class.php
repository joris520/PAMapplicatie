<?php

/**
 * Description of TargetReportInterfaceBuilderComponents
 *
 * @author ben.dokter
 */

require_once('modules/interface/builder/reports/BaseReportEmployeeInterfaceBuilderComponents.class.php');

class TargetReportInterfaceBuilderComponents extends BaseReportEmployeeInterfaceBuilderComponents
{
    static function getEditAssessmentCycleLink()
    {
        $html = '';
        if (PermissionsService::isViewAllowed(PERMISSION_DASHBOARD_TARGET)) {
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
        if (PermissionsService::isViewAllowed(PERMISSION_DASHBOARD_TARGET)) {
            $html = parent::getEmployeesTotalDetailLink($bossId,
                                                        $detailCount);
        }
        return $html;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // letop, $bossId kan ook een BossFilterValue zijn, dus '' eromheen; ditto $scoreId
    static function getStatusDetailLink($bossId,
                                        $targetStatus,
                                        $detailCount)
    {
        $html = '';
        if (PermissionsService::isViewAllowed(PERMISSION_DASHBOARD_TARGET)) {
            if ($detailCount > 0 && !empty($bossId)) {
                $html .= InterfaceBuilder::iconLink('dashboard_target_' . $bossId . '_' . $targetStatus,
                                                    TXT_UCF('ADDITIONAL_INFO'),
                                                    'xajax_public_dashboard__displayTargetStatusDetail(\'' . $bossId . '\', \'' . $targetStatus . '\');',
                                                    ICON_INFO);
            } else {
                $html .= ApplicationInterfaceBuilder::NO_ICON_LINK_SPACES; // hack ivm uitlijning
            }
        }
        return $html;
    }

}

?>
