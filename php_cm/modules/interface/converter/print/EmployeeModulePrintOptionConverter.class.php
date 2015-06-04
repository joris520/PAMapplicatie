<?php

/**
 * Description of EmployeePrintOptionConverter
 *
 * @author hans.prins
 */

require_once('application/interface/converter/AbstractBaseConverter.class.php');
require_once('modules/print/option/EmployeeModulePrintOption.class.php');

class EmployeePrintOptionConverter extends AbstractBaseConverter
{
    static function display($value, $empty = '-')
    {
        $display = $empty;
        switch($value) {
            case EmployeeModulePrintOption::OPTION_ATTACHMENT:
                $display = TXT_UCF('PRINT_MODULE_ATTACHMENT');
                break;
            case EmployeeModulePrintOption::OPTION_PROFILE:
                $display = TXT_UCF('PRINT_MODULE_PROFILE');
                break;
            case EmployeeModulePrintOption::OPTION_COMPETENCE:
                //$display = TXT_UCF('PRINT_MODULE_COMPETENCE');
                $display = TXT_UCF(CUSTOMER_SCORE_TAB_LABEL);
                break;
            case EmployeeModulePrintOption::OPTION_PDP_ACTION:
                $display = TXT_UCF('PRINT_MODULE_PDP_ACTION');
                break;
            case EmployeeModulePrintOption::OPTION_PDP_COST:
                $display = TXT_UCF('PRINT_MODULE_PDP_COST');
                break;
            case EmployeeModulePrintOption::OPTION_TARGET:
                $display = TXT_UCF(CUSTOMER_TARGETS_TAB_LABEL);
                //$display = TXT_UCF('PRINT_MODULE_TARGET');
                break;
            case EmployeeModulePrintOption::OPTION_FINAL_RESULT:
                $display = TXT_UCF('FINAL_RESULT');
                break;
            case EmployeeModulePrintOption::OPTION_360:
                $display = TXT_UCF('PRINT_MODULE_360');
                break;
            case EmployeeModulePrintOption::OPTION_SIGNATURE:
                $display = TXT_UCF('PRINT_MODULE_SIGNATURE');
                break;
        }
        return $display;
    }

    // default de display
    static function input($value, $empty = '-')
    {
        return self::display($value, $empty);
    }

}

?>
