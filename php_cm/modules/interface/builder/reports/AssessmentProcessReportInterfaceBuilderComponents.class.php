<?php

/**
 * Description of AssessmentProcessReportInterfaceBuilderComponents
 *
 * @author ben.dokter
 */

require_once('modules/interface/builder/reports/BaseReportInterfaceBuilderComponents.class.php');

class AssessmentProcessReportInterfaceBuilderComponents extends BaseReportInterfaceBuilderComponents
{
    static function getDashboardInvitationsDetailLink(  $bossId,
                                                        $detailCount)
    {
        $html = '';
        if (PermissionsService::isViewAllowed(PERMISSION_BATCH_SELF_ASSESSMENT_DASHBOARD_PROCESS)) {
            if ($detailCount > 0 && !empty($bossId)) {
                $html = InterfaceBuilder::iconLink('dashboard_process_invitations_' . $bossId,
                                                    TXT_UCF('SELF_ASSESSMENT_INVITED') . ' - ' . TXT_LC('ADDITIONAL_INFO'),
                                                    'xajax_public_report__dashboardInvitationsDetail(\'' . $bossId . '\');',
                                                    ICON_INFO);
            } else {
                $html = ApplicationInterfaceBuilder::NO_ICON_LINK_SPACES; // hack ivm uitlijning
            }
        }
        return $html;
    }

    static function getDashboardProcessPhase1DetailLink(    $bossId,
                                                            $detailCount)
    {
        $html = '';
        if (PermissionsService::isViewAllowed(PERMISSION_BATCH_SELF_ASSESSMENT_DASHBOARD_INVITATIONS)) {
            if ($detailCount > 0 && !empty($bossId)) {
                $html .= InterfaceBuilder::iconLink('dashboard_process_phase1_' . $bossId,
                                                    TXT_UCF('DASHBOARD_PHASE1_DESCRIPTION') . ' - ' . TXT_LC('ADDITIONAL_INFO'),
                                                    'xajax_public_report__dashboardProcessPhase1Detail(\'' . $bossId . '\');',
                                                    ICON_INFO);
            } else {
                $html .= ApplicationInterfaceBuilder::NO_ICON_LINK_SPACES; // hack ivm uitlijning
            }
        }
        return $html;
    }

    static function getDashboardProcessPhase2DetailLink(    $bossId,
                                                            $detailCount)
    {
        $html = '';
        if (PermissionsService::isViewAllowed(PERMISSION_BATCH_SELF_ASSESSMENT_DASHBOARD_INVITATIONS)) {
            if ($detailCount > 0 && !empty($bossId)) {
                $html .= InterfaceBuilder::iconLink('dashboard_process_phase2_' . $bossId,
                                                    TXT_UCF('DASHBOARD_PHASE2_DESCRIPTION') . ' - ' . TXT_LC('ADDITIONAL_INFO'),
                                                    'xajax_public_report__dashboardProcessPhase2Detail(\'' . $bossId . '\');',
                                                    ICON_INFO);
            } else {
                $html .= ApplicationInterfaceBuilder::NO_ICON_LINK_SPACES; // hack ivm uitlijning
            }
        }
        return $html;
    }

    static function getDashboardProcessPhase3DetailLink(    $bossId,
                                                            $detailCount)
    {
        $html = '';
        if (PermissionsService::isViewAllowed(PERMISSION_BATCH_SELF_ASSESSMENT_DASHBOARD_INVITATIONS)) {
            if ($detailCount > 0 && !empty($bossId)) {
                $html .= InterfaceBuilder::iconLink('dashboard_process_phase3_' . $bossId,
                                                    TXT_UCF('DASHBOARD_PHASE3_DESCRIPTION') . ' - ' . TXT_LC('ADDITIONAL_INFO'),
                                                    'xajax_public_report__dashboardProcessPhase3Detail(\'' . $bossId . '\');',
                                                    ICON_INFO);
            } else {
                $html .= ApplicationInterfaceBuilder::NO_ICON_LINK_SPACES; // hack ivm uitlijning
            }
        }
        return $html;
    }

    static function getDashboardProcessPhase3NoneDetailLink($bossId,
                                                            $detailCount)
    {
        $html = '';
        if (PermissionsService::isViewAllowed(PERMISSION_BATCH_SELF_ASSESSMENT_DASHBOARD_INVITATIONS)) {
            if ($detailCount > 0 && !empty($bossId)) {
                $html .= InterfaceBuilder::iconLink('dashboard_process_phase3_none_' . $bossId,
                                                    TXT_UCF('DASHBOARD_PHASE3_NO_DESCRIPTION') . ' - ' . TXT_LC('ADDITIONAL_INFO'),
                                                    'xajax_public_report__dashboardProcessEvaluationNoneDetail(\'' . $bossId . '\');',
                                                    ICON_INFO);
            } else {
                $html .= ApplicationInterfaceBuilder::NO_ICON_LINK_SPACES; // hack ivm uitlijning
            }
        }
        return $html;
    }

    static function getDashboardProcessPhase3PlannedDetailLink( $bossId,
                                                                $detailCount)
    {
        $html = '';
        if (PermissionsService::isViewAllowed(PERMISSION_BATCH_SELF_ASSESSMENT_DASHBOARD_INVITATIONS)) {
            if ($detailCount > 0 && !empty($bossId)) {
                $html .= InterfaceBuilder::iconLink('dashboard_process_phase3_planned_' . $bossId,
                                                    TXT_UCF('DASHBOARD_PHASE3_PLANNED_DESCRIPTION') . ' - ' . TXT_LC('ADDITIONAL_INFO'),
                                                    'xajax_public_report__dashboardProcessEvaluationPlannedDetail(\'' . $bossId . '\');',
                                                    ICON_INFO);
            } else {
                $html .= ApplicationInterfaceBuilder::NO_ICON_LINK_SPACES; // hack ivm uitlijning
            }
        }
        return $html;
    }

    static function getDashboardProcessPhase3ReadyDetailLink(   $bossId,
                                                                $detailCount)
    {
        $html = '';
        if (PermissionsService::isViewAllowed(PERMISSION_BATCH_SELF_ASSESSMENT_DASHBOARD_INVITATIONS)) {
            if ($detailCount > 0 && !empty($bossId)) {
                $html .= InterfaceBuilder::iconLink('dashboard_process_phase3_ready_' . $bossId,
                                                    TXT_UCF('DASHBOARD_PHASE3_READY_DESCRIPTION') . ' - ' . TXT_LC('ADDITIONAL_INFO'),
                                                    'xajax_public_report__dashboardProcessEvaluationReadyDetail(\'' . $bossId . '\');',
                                                    ICON_INFO);
            } else {
                $html .= ApplicationInterfaceBuilder::NO_ICON_LINK_SPACES; // hack ivm uitlijning
            }
        }
        return $html;
    }


}

?>
