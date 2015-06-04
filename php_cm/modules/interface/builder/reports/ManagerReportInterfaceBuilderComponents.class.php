<?php

/**
 * Description of ManagerReportInterfaceBuilderComponents
 *
 * @author ben.dokter
 */

require_once('modules/interface/builder/reports/BaseReportEmployeeInterfaceBuilderComponents.class.php');

class ManagerReportInterfaceBuilderComponents extends BaseReportEmployeeInterfaceBuilderComponents
{

//    static function getEditAssessmentCycleLink()
//    {
//        $html = '';
//        if (PermissionsService::isViewAllowed(PERMISSION_REPORT_MANAGER)) {
//            $html .= InterfaceBuilder::iconLink('edit_report_assessment_cycle_',
//                                                TXT_UCF('EDIT') . ' ' . TXT_LC('ASSESSMENT_CYCLE') . ' ' . TXT_LC('REPORT'),
//                                                'return false;',
//                                                ICON_EDIT);
//        }
//        return $html;
//    }

    static function getEmployeeInfoLink($bossId,
                                        $detailCount)
    {
        $html = '';
        //if (PermissionsService::isViewAllowed(PERMISSION_REPORT_MANAGER)) {
            $html .= parent::getEmployeesTotalDetailLink(   $bossId,
                                                            $detailCount);
        //}
        return $html;
    }

    static function getDepartmentInfoLink(  $managerUserId,
                                            $detailCount)
    {
        $html = '';
        if (PermissionsService::isViewAllowed(PERMISSION_DEPARTMENTS)) {
            if ($detailCount > 0 && !empty($managerUserId)) {
                $html .= InterfaceBuilder::iconLink('detail_manager_departments_' . $managerUserId,
                                                    TXT_UCF('ADDITIONAL_INFO'),
                                                    'xajax_public_report__detailManagerDepartments(' . $managerUserId . ');',
                                                    ICON_INFO);
            } else {
                $html .= '&nbsp;&nbsp;&nbsp;&nbsp;'; // hack ivm uitlijning
            }
        }
        return $html;
    }


}

?>
