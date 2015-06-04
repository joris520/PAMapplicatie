<?php

/**
 * Description of PdpActionInterfaceBuilderComponents
 *
 * @author ben.dokter
 */

class PdpActionInterfaceBuilderComponents
{

    static function getAddLink()
    {
        $html = '';
        if (PermissionsService::isAddAllowed(PERMISSION_PDP_ACTION_LIBRARY)) {
            $html .= InterfaceBuilder::iconLink('add_pdp_action',
                                                TXT_UCF('ADD_PDP_ACTION'),
                                                'xajax_public_library__addPdpAction();',
                                                ICON_ADD);
        }
        return $html;
    }

    static function getEditLink($pdpActionId)
    {
        $html = '';
        if (PermissionsService::isEditAllowed(PERMISSION_PDP_ACTION_LIBRARY)) {
            $html .= InterfaceBuilder::iconLink('edit_pdp_action_' . $pdpActionId,
                                                TXT_UCF('EDIT_PDP_ACTION'),
                                                'xajax_public_library__editPdpAction(' . $pdpActionId . ');',
                                                ICON_EDIT);
        }
        return $html;
    }

    static function getRemoveLink($pdpActionId)
    {
        $html = '';
        if (PermissionsService::isDeleteAllowed(PERMISSION_PDP_ACTION_LIBRARY)) {
            $html .= InterfaceBuilder::iconLink('delete_pdp_action_' . $pdpActionId,
                                                TXT_UCF('DELETE_PDP_ACTION'),
                                                'xajax_public_library__removePdpAction(' . $pdpActionId . ');',
                                                ICON_DELETE);
        }
        return $html;
    }

    static function getEditUserDefinedLink( $employeeId,
                                            $employeePdpActionId)
    {
        $html = '';
        if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_PDP_ACTIONS)) {
            $html .= InterfaceBuilder::iconLink('edit_employee_pdp_action_' . $employeePdpActionId,
                                                TXT_UCF('EDIT_PDP_ACTION') . ' ' . TXT_UCF('EMPLOYEE'),
                                                'xajax_public_library__editUserDefinedEmployeePdpAction(' . $employeeId . ',' . $employeePdpActionId . ');',
                                                ICON_EDIT);
        }
        return $html;
    }


    static function getEmployeeInfoLink($pdpActionId,
                                        $employeeCount)
    {
        $html = '';
        if (PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_PROFILE)) {
            if ($employeeCount > 0) {
                $html .= InterfaceBuilder::iconLink('detail_pdp_actions_employees_' . $pdpActionId,
                                                    TXT_UCF('ADDITIONAL_INFO'),
                                                    'xajax_public_library__detailPdpActionEmployees(' . $pdpActionId . ');',
                                                    ICON_INFO);
            } else {
                $html .= ApplicationInterfaceBuilder::NO_ICON_LINK_SPACES; // hack ivm uitlijning
            }
        }
        return $html;
    }

    static function getEditClusterLink($pdpActionClusterId)
    {
        $html = '';
        if (PermissionsService::isEditAllowed(PERMISSION_PDP_ACTION_LIBRARY)) {
            $html .= InterfaceBuilder::iconLink('edit_pdp_action_cluster_' . $pdpActionClusterId,
                                                TXT_UCF('UPDATE_CLUSTER'),
                                                'xajax_public_library__editPdpActionCluster(' . $pdpActionClusterId . ');',
                                                ICON_EDIT);
        }
        return $html;
    }

    static function getRemoveClusterLink($pdpActionClusterId)
    {
        $html = '';
        if (PermissionsService::isDeleteAllowed(PERMISSION_PDP_ACTION_LIBRARY)) {
            $html .= InterfaceBuilder::iconLink('delete_pdp_action_cluster_' . $pdpActionClusterId,
                                                TXT_UCF('DELETE_CLUSTER'),
                                                'xajax_public_library__removePdpActionCluster(' . $pdpActionClusterId . ');',
                                                ICON_DELETE);
        }
        return $html;
    }

    static function getPrintLink()
    {
        $html = '';
        if (PermissionsService::isPrintAllowed(PERMISSION_PDP_ACTION_LIBRARY)) {
            $html .= InterfaceBuilder::iconLink('print_pdp_actions',
                                                TXT_UCF('PRINT'),
                                                'xajax_public_library__printPdpActions();',
                                                ICON_PRINT);
        }
        return $html;
    }


}

?>
