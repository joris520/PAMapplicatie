<?php

/**
 * Description of EmployeeModuleDetailPrintOption
 *
 * @author hans.prins
 */
require_once('application/print/option/AbstractBasePrintOption.class.php');
require_once('modules/print/option/EmployeeModulePrintOption.class.php');

class EmployeeModuleDetailPrintOption extends AbstractBasePrintOption
{
    // OPTION_COMPETENCE
    const SHOW_REMARKS      = 1;
    const SHOW_360          = 2;
    const SHOW_PDP_ACTION   = 3;

    // OPTION_TARGET
    const SELECT_CURRENT_CYCLE = 11;
    const SELECT_ALL_CYCLES    = 12;

    static function options($printOption = NULL)
    {
        $options = array();
        switch($printOption) {
            case EmployeeModulePrintOption::OPTION_COMPETENCE:
                if (CUSTOMER_OPTION_USE_SKILL_NOTES) {
                    $options[] = self::SHOW_REMARKS;
                }
                if (CUSTOMER_OPTION_SHOW_360) {
                    $options[] = self::SHOW_360;
                }
                if (CUSTOMER_OPTION_SHOW_ACTIONS && PermissionsService::isPrintAllowed(PERMISSION_EMPLOYEE_PDP_ACTIONS)) {
                    $options[] = self::SHOW_PDP_ACTION;
                }
                break;
            case EmployeeModulePrintOption::OPTION_TARGET:
            case EmployeeModulePrintOption::OPTION_FINAL_RESULT:
            case EmployeeModulePrintOption::OPTION_PDP_ACTION:
                $options = array(
                    self::SELECT_CURRENT_CYCLE,
                    self::SELECT_ALL_CYCLES
                );
                break;
        }
        return $options;
    }

    static function isValidOption($option, $printOption = NULL)
    {
        return self::isAllowedOption($option, self::options($printOption));
    }

}

?>
