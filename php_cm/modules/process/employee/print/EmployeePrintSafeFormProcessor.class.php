<?php

/**
 * Description of EmployeePrintSafeFormProcessor
 *
 * @author hans.prins
 */

require_once('modules/print/service/employee/EmployeePrintController.class.php');

require_once('modules/print/valueobjects/employee/EmployeePrintOptionValueObject.class.php');
require_once('modules/print/valueobjects/employee/EmployeeCompetenceDetailPrintOptionValueObject.class.php');
require_once('modules/print/valueobjects/employee/EmployeeAssessmentCycleDetailPrintOptionValueObject.class.php');

class EmployeePrintSafeFormProcessor
{
    function processPrintOptions(   xajaxResponse $objResponse,
                                    SafeFormHandler $safeFormHandler)
    {
        $hasError          = true;
        $messages          = array();

        if (EmployeePrintService::isPrintAllowed()) {

            $employeeId                 = $safeFormHandler->retrieveSafeValue('employeeIds');
            $printOptions               = $safeFormHandler->retrieveSafeValue('printOptions');
            $assessmentCycleValueObject = $safeFormHandler->retrieveSafeValue('assessmentCycleValueObject');

            $optionValueObject = EmployeePrintOptionValueObject::create($employeeId, $printOptions, $assessmentCycleValueObject);

            foreach ($printOptions as $printOption) {

                $optionValue = $safeFormHandler->retrieveInputValue('print_option_' . $printOption) ? BooleanValue::TRUE : BooleanValue::FALSE;
                $detailPrintOptionValueObject = NULL;
                switch ($printOption) {
                    case EmployeeModulePrintOption::OPTION_ATTACHMENT:
                    case EmployeeModulePrintOption::OPTION_PROFILE:
                    case EmployeeModulePrintOption::OPTION_PDP_COST:
                    case EmployeeModulePrintOption::OPTION_360:
                    case EmployeeModulePrintOption::OPTION_SIGNATURE:
                        $optionValueObject->setSelectedModuleOption($printOption, $optionValue);
                        break;

                    case EmployeeModulePrintOption::OPTION_COMPETENCE:
                        $optionValueObject->setSelectedModuleOption($printOption, $optionValue);
                        // specifieke detail info ophalen
                        $detailPrintOptionValueObject = self::processCompetenceDetailOptions($printOption, $safeFormHandler);
                        break;

                    case EmployeeModulePrintOption::OPTION_TARGET:
                    case EmployeeModulePrintOption::OPTION_FINAL_RESULT:
                    case EmployeeModulePrintOption::OPTION_PDP_ACTION:
                        $optionValueObject->setSelectedModuleOption($printOption, $optionValue);
                        // specifieke detail info ophalen
                        $detailPrintOptionValueObject = self::processAssessmentCycleDetailOptions($printOption, $safeFormHandler);
                        break;
                }
                // Als er detailopties zijn, deze opslaan
                if (!is_null($detailPrintOptionValueObject)) {
                    $optionValueObject->setDetailPrintOptionValueObject($printOption, $detailPrintOptionValueObject);
                }
            }

            list($hasError, $messages) = EmployeePrintController::processPrintOptions($optionValueObject);

            if (!$hasError) {
                $safeFormHandler->finalizeSafeFormProcess();
                EmployeePrintInterfaceProcessor::finishPrintOptions($objResponse);
            }
        }
        return array($hasError, $messages);
    }

    private function processCompetenceDetailOptions($printOption,
                                                    SafeFormHandler $safeFormHandler)
    {
        $isAllowedRemarks   = EmployeePrintService::isPrintAllowedRemarks();
        $isAllowed360       = EmployeePrintService::isPrintAllowed360();
        $isAllowedPdpAction = EmployeePrintService::isPrintAllowedPdpAction();

        $competenceOptionValueObject = EmployeeCompetenceDetailPrintOptionValueObject::create();
        if ($isAllowedRemarks) {
            $showRemarks = $safeFormHandler->retrieveInputValue('show_remarks_' . $printOption) ? BooleanValue::TRUE : BooleanValue::FALSE;
            $competenceOptionValueObject->setShowRemarks($showRemarks);
        }
        if ($isAllowed360) {
            $show360 = $safeFormHandler->retrieveInputValue('show_threesixty_' . $printOption) ? BooleanValue::TRUE : BooleanValue::FALSE;
            $competenceOptionValueObject->setShow360($show360);
        }
        if ($isAllowedPdpAction) {
            $showPdpAction = $safeFormHandler->retrieveInputValue('show_action_' . $printOption) ? BooleanValue::TRUE : BooleanValue::FALSE;
            $competenceOptionValueObject->setShowPdpAction($showPdpAction);
        }
        return $competenceOptionValueObject;
    }

    private function processAssessmentCycleDetailOptions(   $printOption,
                                                            SafeFormHandler $safeFormHandler)
    {
        $targetOptionValueObject = EmployeeAssessmentCycleDetailPrintOptionValueObject::create();

        $detailValue = $safeFormHandler->retrieveInputValue('show_cycle_' . $printOption);
        $targetOptionValueObject->setAssessmentCycleOption($detailValue);

        return $targetOptionValueObject;
    }

}

?>
