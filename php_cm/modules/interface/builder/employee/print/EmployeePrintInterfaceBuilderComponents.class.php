<?php

/**
 * Description of EmployeePrintInterfaceBuilderComponents
 *
 * @author hans.prins
 */

class EmployeePrintInterfaceBuilderComponents
{
    static function getPrintLink($employeeId)
    {
        $html = '';
        if (EmployeePrintService::isPrintAllowed()) {
            $html .= InterfaceBuilder::iconLink('print_employee_' . $employeeId,
                                                TXT_UCF('PRINT'),
                                                'xajax_public_employeePrint__displayPrintOptions(' . $employeeId . ');',
                                                ICON_PRINT);

        }
        return $html;
    }
}

?>
