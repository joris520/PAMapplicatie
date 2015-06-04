<?php

/**
 * Description of EmployeePrintOptionConverter
 *
 * @author hans.prins
 */

require_once('application/interface/converter/AbstractBaseConverter.class.php');
require_once('modules/print/option/EmployeeModuleDetailPrintOption.class.php');

class EmployeeModuleDetailPrintOptionConverter extends AbstractBaseConverter
{
    static function display($option, $empty = '-')
    {
        $display = $empty;
        switch($option) {
            case EmployeeModuleDetailPrintOption::SHOW_REMARKS:
                $display = TXT_UCF('PRINT_OPTION_REMARKS');
                break;
            case EmployeeModuleDetailPrintOption::SHOW_360:
                $display = TXT_UCF('PRINT_OPTION_EMPLOYEE_SCORES');
                break;
            case EmployeeModuleDetailPrintOption::SHOW_PDP_ACTION:
                $display = TXT_UCF('PRINT_OPTION_ACTION_FORM_MEETING');
                break;
            case EmployeeModuleDetailPrintOption::SELECT_CURRENT_CYCLE:
                $display = TXT_UCF('PRINT_OPTION_CURRENT_ASSESSMENT_CYCLE');
                break;
            case EmployeeModuleDetailPrintOption::SELECT_ALL_CYCLES:
                $display = TXT_UCF('PRINT_OPTION_ALL_ASSESSMENT_CYCLES');
                break;
        }
        return $display;
    }

    // default de display
    static function input($option, $empty = '-')
    {
        return self::display($option, $empty);
    }

}

?>
