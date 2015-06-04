<?php

/**
 * Description of EmployeePrintController
 *
 * @author hans.prins
 */
require_once('modules/print/service/employee/EmployeePrintService.class.php');

class EmployeePrintController
{
    static function processPrintOptions(EmployeePrintOptionValueObject $optionValueObject)
    {
        list($hasError, $messages) = EmployeePrintService::validatePrintOptions($optionValueObject);

        if (!$hasError) {
            EmployeePrintService::storePrintOptionValueObject($optionValueObject);
        }

        return array($hasError, $messages);
    }
}

?>
