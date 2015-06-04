<?php

/**
 * Description of SelfAssessmentReportInterfaceBuilderComponents
 *
 * @author ben.dokter
 */

require_once('modules/interface/builder/reports/BaseReportInterfaceBuilderComponents.class.php');

class SelfAssessmentReportInterfaceBuilderComponents extends BaseReportInterfaceBuilderComponents
{
    static function getEditAssessmentCycleLink()
    {
        $html = '';
        if (PermissionsService::isViewAllowed(PERMISSION_BATCH_SELF_ASSESSMENT_OVERVIEW) ||
            PermissionsService::isViewAllowed(PERMISSION_DASHBOARD_SELF_ASSESSMENT_OVERVIEW)) {
            $html .= parent::getEditAssessmentCycleLink();
        }
        return $html;
    }

    static function getInvitationDetailLink($employeeId, $invitationHash)
    {
        $html = '';
        if (PermissionsService::isViewAllowed(PERMISSION_BATCH_SELF_ASSESSMENT_OVERVIEW) ||
            PermissionsService::isViewAllowed(PERMISSION_DASHBOARD_SELF_ASSESSMENT_OVERVIEW)) {
            $html .= InterfaceBuilder::iconLink('detail_invitation_' . $employeeId,
                                                TXT_UCF('ADDITIONAL_INFO'),
                                                'xajax_public_report__detailInvitation(' . $employeeId . ', \'' . $invitationHash . '\');',
                                                ICON_INFO);
        }
        return $html;
    }

    // de link om direct de invitation te openen
    static function getInvitationHashLink($invitationHash)
    {
        $href = ' href="' . SITE_URL . '/360evaluation.php?h=' . $invitationHash . '"';
        $title = ' title="' . TXT_UCF('COMPLETE_THREESIXTY_INVITATION') . '"';

        $html = '<a' . $href  . $title . '>' . $invitationHash . '</a>';

        return $html;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // letop, $bossId kan ook een BossFilterValue zijn, dus '' eromheen
    static function getDashboardInvitationsDetailLink($bossId, $detailCount)
    {
        $html = '';
        if (PermissionsService::isViewAllowed(PERMISSION_BATCH_SELF_ASSESSMENT_DASHBOARD_INVITATIONS) ||
            PermissionsService::isViewAllowed(PERMISSION_DASHBOARD_SELF_ASSESSMENT_DASHBOARD_INVITATIONS)) {
            if ($detailCount > 0 && !empty($bossId)) {
                $html .= InterfaceBuilder::iconLink('dashboard_invitations_' . $bossId,
                                                    TXT_UCF('SELF_ASSESSMENT_INVITED') . ' - ' . TXT_LC('ADDITIONAL_INFO'),
                                                    'xajax_public_report__dashboardInvitationsDetail(\'' . $bossId . '\');',
                                                    ICON_INFO);
            } else {
                $html .= ApplicationInterfaceBuilder::NO_ICON_LINK_SPACES; // hack ivm uitlijning
            }
        }
        return $html;
    }

    static function getDashboardEmployeeNotCompletedDetailLink($bossId, $detailCount)
    {
        $html = '';
        if (PermissionsService::isViewAllowed(PERMISSION_BATCH_SELF_ASSESSMENT_DASHBOARD_INVITATIONS)) {
            if ($detailCount > 0 && !empty($bossId)) {
                $html .= InterfaceBuilder::iconLink('dashboard_employee_not_completed_' . $bossId,
                                                    TXT_UCF('DASHBOARD_NOT_COMPLETED_BY_EMPLOYEE') . ' - ' . TXT_LC('ADDITIONAL_INFO'),
                                                    'xajax_public_report__dashboardEmployeeNotCompletedDetail(\'' . $bossId . '\');',
                                                    ICON_INFO);
            } else {
                $html .= ApplicationInterfaceBuilder::NO_ICON_LINK_SPACES; // hack ivm uitlijning
            }
        }
        return $html;
    }

    static function getDashboardEmployeeCompletedDetailLink($bossId, $detailCount)
    {
        $html = '';
        if (PermissionsService::isViewAllowed(PERMISSION_BATCH_SELF_ASSESSMENT_DASHBOARD_INVITATIONS)) {
            if ($detailCount > 0 && !empty($bossId)) {
                $html .= InterfaceBuilder::iconLink('dashboard_employee_completed_' . $bossId,
                                                    TXT_UCF('DASHBOARD_COMPLETED_BY_EMPLOYEE') . ' - ' . TXT_LC('ADDITIONAL_INFO'),
                                                    'xajax_public_report__dashboardEmployeeCompletedDetail(\'' . $bossId . '\');',
                                                    ICON_INFO);
            } else {
                $html .= ApplicationInterfaceBuilder::NO_ICON_LINK_SPACES; // hack ivm uitlijning
            }
        }
        return $html;
    }

    static function getDashboardBossNotCompletedDetailLink($bossId, $detailCount)
    {
        $html = '';
        if (PermissionsService::isViewAllowed(PERMISSION_BATCH_SELF_ASSESSMENT_DASHBOARD_INVITATIONS)) {
            if ($detailCount > 0 && !empty($bossId)) {
                $html .= InterfaceBuilder::iconLink('dashboard_boss_not_completed_' . $bossId ,
                                                    TXT_UCF('DASHBOARD_NOT_COMPLETED_BY_MANAGER') . ' - ' . TXT_LC('ADDITIONAL_INFO'),
                                                    'xajax_public_report__dashboardBossNotCompletedDetail(\'' . $bossId . '\');',
                                                    ICON_INFO);
            } else {
                $html .= ApplicationInterfaceBuilder::NO_ICON_LINK_SPACES; // hack ivm uitlijning
            }
        }
        return $html;
    }

    static function getDashboardBossCompletedDetailLink($bossId, $detailCount)
    {
        $html = '';
        if (PermissionsService::isViewAllowed(PERMISSION_BATCH_SELF_ASSESSMENT_DASHBOARD_INVITATIONS)) {
            if ($detailCount > 0 && !empty($bossId)) {
                $html .= InterfaceBuilder::iconLink('dashboard_boss_completed_' . $bossId,
                                                    TXT_UCF('DASHBOARD_COMPLETED_BY_MANAGER') . ' - ' . TXT_LC('ADDITIONAL_INFO'),
                                                    'xajax_public_report__dashboardBossCompletedDetail(\'' . $bossId . '\');',
                                                    ICON_INFO);
            } else {
                $html .= ApplicationInterfaceBuilder::NO_ICON_LINK_SPACES; // hack ivm uitlijning
            }
        }
        return $html;
    }

    static function getDashboardFullCompletedDetailLink($bossId, $detailCount)
    {
        $html = '';
        if (PermissionsService::isViewAllowed(PERMISSION_BATCH_SELF_ASSESSMENT_DASHBOARD_INVITATIONS)) {
            if ($detailCount > 0 && !empty($bossId)) {
                $html .= InterfaceBuilder::iconLink('dashboard_both_completed_' . $bossId,
                                                    TXT_UCF('DASHBOARD_COMPLETED_BY_BOTH') . ' - ' . TXT_LC('ADDITIONAL_INFO'),
                                                    'xajax_public_report__dashboardFullCompletedDetail(\'' . $bossId . '\');',
                                                    ICON_INFO);
            } else {
                $html .= ApplicationInterfaceBuilder::NO_ICON_LINK_SPACES; // hack ivm uitlijning
            }
        }
        return $html;
    }
}

?>
