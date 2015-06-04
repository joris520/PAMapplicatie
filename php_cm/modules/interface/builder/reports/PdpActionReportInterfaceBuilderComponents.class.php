<?php

/**
 * Description of PdpActionReportInterfaceBuilderComponents
 *
 * @author ben.dokter
 */

require_once('modules/interface/builder/reports/BaseReportEmployeeInterfaceBuilderComponents.class.php');

class PdpActionReportInterfaceBuilderComponents extends BaseReportEmployeeInterfaceBuilderComponents
{

    static function getEditAssessmentCycleLink()
    {
        $html = '';
        if (PermissionsService::isViewAllowed(PERMISSION_DASHBOARD_PDP_ACTION)) {
            $html .= parent::getEditAssessmentCycleLink();
        }
        return $html;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // letop, $bossId kan ook een BossFilterValue zijn, dus '' eromheen
    static function getEmployeesTotalDetailLink(  $bossId,
                                                            $detailCount)
    {
        $html = '';
        if (PermissionsService::isViewAllowed(PERMISSION_DASHBOARD_PDP_ACTION)) {
            $html = parent::getEmployeesTotalDetailLink($bossId,
                                                        $detailCount);
        }
        return $html;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // letop, $bossId kan ook een BossFilterValue zijn, dus '' eromheen; ditto $scoreId
    static function getCompletedStatusDetailLink(   $bossId,
                                                    $completedStatus,
                                                    $detailCount)
    {
        $html = '';
        if (PermissionsService::isViewAllowed(PERMISSION_DASHBOARD_PDP_ACTION)) {
            if ($detailCount > 0 && !empty($bossId)) {
                $html .= InterfaceBuilder::iconLink('dashboard_pdp_action_' . $bossId . '_' . $completedStatus,
                                                    TXT_UCF('ADDITIONAL_INFO'),
                                                    'xajax_public_dashboard__displayPdpActionCompletedStatusDetail(\'' . $bossId . '\', \'' . $completedStatus . '\');',
                                                    ICON_INFO);
            } else {
                $html .= ApplicationInterfaceBuilder::NO_ICON_LINK_SPACES; // hack ivm uitlijning
            }
        }
        return $html;
    }

}

?>
