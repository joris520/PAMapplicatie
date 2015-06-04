<?php

/**
 * Description of EmployeePdpActionInterfaceBuilderComponents
 *
 * @author ben.dokter
 */

require_once('modules/model/service/employee/pdpAction/EmployeePdpActionCompetenceService.class.php');
//require_once('modules/model/service/to_refactor/PdpActionSkillServiceDeprecated.class.php');

class EmployeePdpActionInterfaceBuilderComponents
{
    const TOGGLE_MODE_SHOW = 1;
    const TOGGLE_MODE_HIDE = 2;

    static function getAddLink($employeeId)
    {
        $html = '';
        if (PermissionsService::isAddAllowed(PERMISSION_EMPLOYEE_PDP_ACTIONS)) {
            $html .= InterfaceBuilder::iconLink('add_employee_pdp_action_' . $employeeId,
                                                TXT_UCF('ADD_NEW_PDP_ACTION'),
                                                'xajax_public_employeePdpAction__addPdpAction(' . $employeeId . ');',
                                                ICON_ADD);
        }
        return $html;
    }

    static function getEditLink($employeeId,
                                $employeePdpActionId)
    {
        $html = '';
        if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_PDP_ACTIONS)) {
            $html .= InterfaceBuilder::iconLink('edit_employee_pdp_action_' . $employeeId . '_' . $employeePdpActionId,
                                                TXT_UCF('EDIT_PDP_ACTION'),
                                                'xajax_public_employeePdpAction__editPdpAction(' . $employeeId . ', '. $employeePdpActionId . ');',
                                                ICON_EDIT);
        }
        return $html;
    }

    static function getRemoveLink(  $employeeId,
                                    $employeePdpActionId)
    {
        $html = '';
        if (PermissionsService::isDeleteAllowed(PERMISSION_EMPLOYEE_PDP_ACTIONS)) {
            $html .= InterfaceBuilder::iconLink('add_employee_pdp_action',
                                                TXT_UCF('DELETE_PDP_ACTION'),
                                                'xajax_public_employeePdpAction__removePdpAction(' . $employeeId . ',' . $employeePdpActionId . ');',
                                                ICON_DELETE);
        }
        return $html;
    }

    static function getTogglePdpActionLibraryLink($newToggleMode)
    {
        $html = '';
        if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_PDP_ACTIONS)) {
            $shouldHide = $newToggleMode == self::TOGGLE_MODE_HIDE;
            $label = ($shouldHide ? TXT_UCF('HIDE_PDP_ACTION_LIBRARY') : TXT_UCF('SHOW_PDP_ACTION_LIBRARY')) . '&nbsp;&nbsp;';
            $html .= InterfaceBuilder::iconLabelLink(   'toggle_library_visibility',
                                                        $shouldHide ? TXT_LC('HIDE_PDP_ACTION_LIBRARY') : TXT_LC('SHOW_PDP_ACTION_LIBRARY'),
                                                        'xajax_public_employeePdpAction__togglePdpActionLibraryVisibility(' . ($shouldHide ? self::TOGGLE_MODE_HIDE: self::TOGGLE_MODE_SHOW) . ');',
                                                        $shouldHide ? ICON_UP : ICON_DOWN,
                                                        $label);
        }
        return $html;
    }

    static function getToggleCompetencesLink($newToggleMode)
    {
        $html = '';
        if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_PDP_ACTIONS)) {
            $shouldHide = $newToggleMode == self::TOGGLE_MODE_HIDE;
            $label = ($shouldHide ? TXT_UCF('HIDE_RELATED_COMPETENCES') : TXT_UCF('SHOW_RELATED_COMPETENCES')) . '&nbsp;&nbsp;';
            $html .= InterfaceBuilder::iconLabelLink(   'toggle_library_visibility',
                                                        $shouldHide ? TXT_LC('HIDE_RELATED_COMPETENCES') : TXT_LC('SHOW_RELATED_COMPETENCES'),
                                                        'xajax_public_employeePdpAction__toggleCompetencesVisibility(' . ($shouldHide ? self::TOGGLE_MODE_HIDE: self::TOGGLE_MODE_SHOW) . ');',
                                                        $shouldHide ? ICON_UP : ICON_DOWN,
                                                        $label);
        }
        return $html;
    }

    //$employeePdpActionId is edit actie id of null bij nieuwe actie
    static function generateCheckCompetencesHtml(   $employeeId,
                                                    $employeePdpActionId,
                                                    &$safeFormHandler)
    {
        $html = '';
        $employee_action_skills_array = PdpActionSkillServiceDeprecated::getEmployeeScoredSkills($employeeId, $employeePdpActionId);
        if (!empty($employeePdpActionId)) {
            $action_skills_array = PdpActionSkillServiceDeprecated::getSkillsByAction($employeeId, $employeePdpActionId);
        } else {
            $action_skills_array = array();
        }
        $safeFormHandler->storeSafeValue('IDs_AVAIL_SKILLS', $employee_action_skills_array);

        global $smarty;
        $tpl = $smarty->createTemplate('to_refactor/mod_employees_pdpactions/pdpSkillsByActionEdit.tpl');
        $tpl->assign('competencesToggleId', EmployeePdpActionInterfaceBuilder::EDIT_HTML_COMPETENCES_TOGGLE_HTML_ID);
        $tpl->assign('competencesToggleContentId', EmployeePdpActionInterfaceBuilder::EDIT_HTML_COMPETENCES_CONTENT_HTML_ID);
        $tpl->assign('competencesToggleLink', EmployeePdpActionInterfaceBuilderComponents::getToggleCompetencesLink(self::TOGGLE_MODE_SHOW));
        $tpl->assign('newAction', empty($employeePdpActionId));
        $tpl->assign('scoredSkills', $employee_action_skills_array);
        $tpl->assign('actionSkills', $action_skills_array);
        $html = $smarty->fetch($tpl);
        return $html;
    }

    static function getPdpActionSelectLink( $pdpActionId)
    {
        return 'xajax_prefill_pdp_action_deprecated('.$pdpActionId.');';
    }
}

?>
