<?php

/**
 * Description of EmployeeTargetBatchInterfaceProcessor
 *
 * @author hans.prins
 */

require_once('modules/interface/builder/batch/EmployeeTargetBatchPageBuilder.class.php');
require_once('modules/process/tab/OrganisationTabInterfaceProcessor.class.php');


class EmployeeTargetBatchInterfaceProcessor
{
    const DISPLAY_WIDTH = 1100;
    const RESULT_WIDTH = ApplicationInterfaceBuilder::MAIN_PANEL_SIMPLE_CONTENT;

    static function displayView($objResponse)
    {
        if (PermissionsService::isEditAllowed(PERMISSION_BATCH_ADD_EMPLOYEE_TARGET) &&
            PermissionsService::isAddAllowed(PERMISSION_EMPLOYEE_TARGETS)) {
            unset($_SESSION['ID_E']);

            $pageHtml = EmployeeTargetBatchPageBuilder::getPageHtml(self::DISPLAY_WIDTH);

            OrganisationTabInterfaceProcessor::displayContent(  $objResponse, self::DISPLAY_WIDTH, $pageHtml);
            ApplicationNavigationProcessor::activateModuleMenu( $objResponse, MODULE_ORGANISATION_MENU_TARGETS_BATCH);
        }
    }

    static function finishAddBatch($objResponse, $targetName, $employeeCount)
    {
        if (PermissionsService::isEditAllowed(PERMISSION_BATCH_ADD_EMPLOYEE_TARGET)) {
            $viewHtml = EmployeeTargetBatchPageBuilder::getConfirmationAddHtml(self::RESULT_WIDTH, $targetName, $employeeCount);
            OrganisationTabInterfaceProcessor::displayContent($objResponse, self::RESULT_WIDTH, $viewHtml);
        }
    }
}

?>
