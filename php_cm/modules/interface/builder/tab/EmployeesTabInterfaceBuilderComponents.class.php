<?php

/**
 * Description of EmployeesTabInterfaceBuilderComponents
 *
 * @author ben.dokter
 */
class EmployeesTabInterfaceBuilderComponents
{

    static function getWelcomeMessage()
    {
        // zie ook ModuleHelpers::getWelcomeMessage($module_name)
        $welcomeText = ApplicationNavigationService::hasSelectedEmployeeId() ? TXT_UCF('LOADING_PLEASE_WAIT') : '';//TXT_UCF('SELECT_EMPLOYEES');
        return '<p class="info-text">' . $welcomeText . '</p>';
    }
}

?>
