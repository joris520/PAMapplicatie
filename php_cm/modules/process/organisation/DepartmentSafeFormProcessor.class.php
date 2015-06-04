<?php

/**
 * Description of DepartmentSafeFormProcessor
 *
 * @author ben.dokter
 */

require_once('modules/model/service/organisation/DepartmentController.class.php');

class DepartmentSafeFormProcessor
{
    static function processAdd($objResponse, $safeFormHandler)
    {
        $hasError = true;
        $messages = array();

        if (PermissionsService::isAddAllowed(PERMISSION_DEPARTMENTS) ||
            PermissionsService::isAddAllowed(PERMISSION_MENU_ORGANISATION_DEPARTMENTS) ||
            PermissionsService::isAddAllowed(PERMISSION_MENU_DASHBOARD_DEPARTMENTS)) {

            $newDepartmentId = null;
            $departmentName  = $safeFormHandler->retrieveInputValue('department_name');

            $valueObject = DepartmentValueObject::createWithValues( $newDepartmentId,
                                                                    $departmentName);

            list($hasError, $messages, $newDepartmentId) = DepartmentController::processAdd($valueObject);
            if (!$hasError) {
                // klaar met add
                $safeFormHandler->finalizeSafeFormProcess();
                DepartmentInterfaceProcessor::finishAdd($objResponse, $newDepartmentId);
            }
        }
        return array($hasError, $messages);
    }

    static function processEdit($objResponse, $safeFormHandler)
    {
        $hasError = true;
        $messages = array();

        if (PermissionsService::isEditAllowed(PERMISSION_DEPARTMENTS) ||
            PermissionsService::isEditAllowed(PERMISSION_MENU_ORGANISATION_DEPARTMENTS) ||
            PermissionsService::isEditAllowed(PERMISSION_MENU_DASHBOARD_DEPARTMENTS)) {

            $departmentId = $safeFormHandler->retrieveSafeValue('departmentId');

            $departmentName = $safeFormHandler->retrieveInputValue('department_name');

            $valueObject = DepartmentValueObject::createWithValues( $departmentId,
                                                                    $departmentName);

            list($hasError, $messages) = DepartmentController::processEdit($departmentId, $valueObject);
            if (!$hasError) {
                // klaar met edit
                $safeFormHandler->finalizeSafeFormProcess();
                DepartmentInterfaceProcessor::finishEdit($objResponse, $departmentId);
            }
        }
        return array($hasError, $messages);
    }

    static function processRemove($objResponse, $safeFormHandler)
    {
        $hasError = true;
        $messages = array();

        if (PermissionsService::isDeleteAllowed(PERMISSION_DEPARTMENTS) ||
            PermissionsService::isDeleteAllowed(PERMISSION_MENU_ORGANISATION_DEPARTMENTS) ||
            PermissionsService::isDeleteAllowed(PERMISSION_MENU_DASHBOARD_DEPARTMENTS)) {

            $departmentId = $safeFormHandler->retrieveSafeValue('departmentId');

            list($hasError, $messages) = DepartmentController::processRemove($departmentId);
            if (!$hasError) {
                // klaar met delete
                $safeFormHandler->finalizeSafeFormProcess();
                DepartmentInterfaceProcessor::finishRemove($objResponse, $departmentId);
            }
        }
        return array($hasError, $messages);
    }}

?>
