<?php
/**
 * Description of EmployeePrintService
 *
 * @author hans.prins
 */

require_once('modules/print/valueobjects/employee/EmployeePrintOptionValueObject.class.php');
require_once('modules/print/valueobjects/employee/EmployeeCompetenceDetailPrintOptionValueObject.class.php');
require_once('modules/print/valueobjects/employee/EmployeeAssessmentCycleDetailPrintOptionValueObject.class.php');

class EmployeePrintService
{
    /* private */ const SESSION_STORE__PRINT_EMPLOYEE__IDS  = 'a_employee_print_ids';
    /* private */ const SESSION_STORE__PRINT_OPTIONS        = 'o_employee_print_option_valueobject';


    static function isPrintAllowed()
    {
        return  PermissionsService::isPrintAllowed(PERMISSION_EMPLOYEE_PROFILE)         ||
                PermissionsService::isPrintAllowed(PERMISSION_EMPLOYEE_ATTACHMENTS)     ||
                PermissionsService::isPrintAllowed(PERMISSION_EMPLOYEE_SCORES)          ||
                PermissionsService::isPrintAllowed(PERMISSION_EMPLOYEE_TARGETS)         ||
                PermissionsService::isPrintAllowed(PERMISSION_EMPLOYEE_FINAL_RESULT)    ||
                PermissionsService::isPrintAllowed(PERMISSION_EMPLOYEE_PDP_ACTIONS)     ||
                PermissionsService::isPrintAllowed(PERMISSION_EMPLOYEE_360);
    }

    static function isPrintAllowedRemarks()
    {
        return CUSTOMER_OPTION_USE_SKILL_NOTES;
    }

    static function isPrintAllowed360()
    {
        return CUSTOMER_OPTION_SHOW_360;
    }

    static function isPrintAllowedPdpAction()
    {
        return CUSTOMER_OPTION_SHOW_ACTIONS && PermissionsService::isPrintAllowed(PERMISSION_EMPLOYEE_PDP_ACTIONS);
    }

    ////////////////////////////////////////////////////////////////////////////
    static function storeEmployeeIds($employeeIds)
    {
        $_SESSION[self::SESSION_STORE__PRINT_EMPLOYEE__IDS] = $employeeIds;
    }

    static function retrieveEmployeeIds()
    {
        return @$_SESSION[self::SESSION_STORE__PRINT_EMPLOYEE__IDS];
    }

    ////////////////////////////////////////////////////////////////////////////
    static function storePrintOptionValueObject(EmployeePrintOptionValueObject $printOptionValueObject)
    {
        $_SESSION[self::SESSION_STORE__PRINT_OPTIONS] = serialize($printOptionValueObject);
    }

    static function retrievePrintOptionValueObject()
    {
        return unserialize(@$_SESSION[self::SESSION_STORE__PRINT_OPTIONS]);
    }


    ////////////////////////////////////////////////////////////////////////////
    // clear the session

    static function clearPrintStore()
    {
        unset($_SESSION[self::SESSION_STORE__PRINT_EMPLOYEE__IDS]);
        unset($_SESSION[self::SESSION_STORE__PRINT_OPTIONS]);
    }

    static function validatePrintOptions(EmployeePrintOptionValueObject $optionValueObject)
    {
        $hasError = false;
        $messages = array();

        $printOptions = $optionValueObject->getPrintOptions();
        foreach ($printOptions as $printOption) {
            switch ($printOption) {
                case EmployeeModulePrintOption::OPTION_ATTACHMENT:
                case EmployeeModulePrintOption::OPTION_PROFILE:
                case EmployeeModulePrintOption::OPTION_PDP_COST:
                case EmployeeModulePrintOption::OPTION_360:
                case EmployeeModulePrintOption::OPTION_SIGNATURE:
                    if (!BooleanValue::isValidValue($optionValueObject->getSelectedModuleOption($printOption))) {
                        $hasError = true;
                    }
                    break;
                case EmployeeModulePrintOption::OPTION_COMPETENCE:
                    if (!BooleanValue::isValidValue($optionValueObject->getSelectedModuleOption($printOption))) {
                        $hasError = true;
                    }
                    // specifieke detail info ophalen
                    list($hasErrorOption) = self::validatePrintCompetenceOptions($optionValueObject->getDetailPrintOptionValueObject($printOption));
                    $hasError = $hasError || $hasErrorOption;
                    break;
                case EmployeeModulePrintOption::OPTION_TARGET:
                case EmployeeModulePrintOption::OPTION_PDP_ACTION:
                case EmployeeModulePrintOption::OPTION_FINAL_RESULT:
                    if (!BooleanValue::isValidValue($optionValueObject->getSelectedModuleOption($printOption))) {
                        $hasError = true;
                    }
                    // specifieke detail info ophalen
                    list($hasErrorOption) = self::validatePrintAssessmentCycleOptions(  $printOption,
                                                                                        $optionValueObject->getDetailPrintOptionValueObject($printOption));
                    $hasError = $hasError || $hasErrorOption;
                    break;
            }
        }
        if ($hasError) {
            $messages[] = TXT_UCF('INVALID_PRINT_OPTION_VALUE');
        } else {
            $hasSelections = false;
            foreach ($printOptions as $printOption) {
                if ($optionValueObject->selectedModuleOption($printOption)) {
                    $hasSelections = true;
                }
            }
            if (!$hasSelections) {
                $hasError = true;
                $messages[] = TXT_UCF('NO_PRINT_OPTION_SELECTED');
            }

        }

        return array($hasError, $messages);
    }

   static function validatePrintCompetenceOptions(EmployeeCompetenceDetailPrintOptionValueObject $competenceOptionsValueObject)
    {
        $hasError = false;
        $messages = array();

        if (!BooleanValue::isValidValue($competenceOptionsValueObject->getShowRemarks())) {
            $hasError = true;
        }

        if (!BooleanValue::isValidValue($competenceOptionsValueObject->getShow360())) {
            $hasError = true;
        }

        if (!BooleanValue::isValidValue($competenceOptionsValueObject->getShowPdpAction())) {
            $hasError = true;
        }

        if ($hasError) {
            $messages[] = TXT_UCF('INVALID_PRINT_OPTION_VALUE');
        }

        return array($hasError, $messages);
    }

    static function validatePrintAssessmentCycleOptions($printOption,
                                                        EmployeeAssessmentCycleDetailPrintOptionValueObject $optionsValueObject)
    {
        $hasError = false;
        $messages = array();

        if (!EmployeeModuleDetailPrintOption::isValidOption($optionsValueObject->getAssessmentCycleOption(),
                                                            $printOption)) {
            $hasError = true;
            $messages[] = TXT_UCF('INVALID_PRINT_OPTION_VALUE');
        }

        return array($hasError, $messages);
    }
}

?>
