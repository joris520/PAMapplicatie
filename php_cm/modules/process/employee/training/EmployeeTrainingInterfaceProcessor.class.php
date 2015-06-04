<?php

/**
 * Description of EmployeeTrainingInterfaceProcessor
 *
 */

class EmployeeTrainingInterfaceProcessor
{
    const DISPLAY_WIDTH = ApplicationInterfaceBuilder::VIEW_WIDTH;

    static function displayView(xajaxResponse $objResponse,
                                $employeeId)
    {
        if (PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_TRAINING)) {

            if (empty($employeeId)) {
                $viewHtml = TXT_UCF('NO_EMPLOYEE_SELECTED');
            } else {
                $viewHtml = 'Hier willen we graag de opleidingen';
            }

            // deze functie zorgt voor het tonen van de inhoud van de Employee tab
            EmployeesTabInterfaceProcessor::displayContent( $objResponse,
                                                            $viewHtml);
            // deze functie zorgt voor het selecteren (hiliten) van het juiste menu
            EmployeesTabInterfaceProcessor::displayMenu(    $objResponse,
                                                            $employeeId,
                                                            MODULE_EMPLOYEE_TRAINING);
        }
    }
}

?>
