<?php

/**
 * Description of EmployeePrintInterfaceBuilder
 *
 * @author hans.prins
 */

// components
require_once('modules/interface/builder/employee/print/EmployeePrintInterfaceBuilderComponents.class.php');

// services
require_once('modules/print/service/employee/EmployeePrintService.class.php');

// interfaceobjects
require_once('modules/interface/interfaceobjects/employee/print/EmployeePrintOptionsDialog.class.php');
require_once('modules/interface/interfaceobjects/employee/print/EmployeeCompetencePrintOptionDetail.class.php');
require_once('modules/interface/interfaceobjects/employee/print/EmployeeAssessmentCyclePrintOptionDetail.class.php');

// converters
require_once('modules/interface/converter/print/EmployeeModulePrintOptionConverter.class.php');
require_once('modules/interface/converter/print/EmployeeModuleDetailPrintOptionConverter.class.php');

class EmployeePrintInterfaceBuilder
{
    const DETAIL_OPTIONS_INDENTATIONS = 23;

    static function getPrintOptionsHtml(    $displayWidth,
                                            Array $employeeIds,
                                            AssessmentCycleValueObject $assessmentCycleValueObject,
                                            Array /* EmployeeModulePrintOption */ $modulePrintOptions,
                                            Array /* EmployeeModulePrintOption */ $checkedPrintOptions)
    {

        // safeForm
        $safeFormHandler = SafeFormHandler::create(SAFEFORM_EMPLOYEE__PRINT);
        $safeFormHandler->storeSafeValue('employeeIds', $employeeIds);
        $safeFormHandler->storeSafeValue('printOptions', $modulePrintOptions);
        $safeFormHandler->storeSafeValue('assessmentCycleValueObject', $assessmentCycleValueObject);

        $safeFormHandler->addPrefixIntegerInputFormatType('print_option_');

        // valueObject
        $printOptionsValueObject = EmployeePrintOptionValueObject::create(  $employeeIds,
                                                                            $modulePrintOptions,
                                                                            $assessmentCycleValueObject);

        // interface object
        $interfaceObject = EmployeePrintOptionsDialog::create(  $printOptionsValueObject,
                                                                $displayWidth,
                                                                self::DETAIL_OPTIONS_INDENTATIONS);
        //$interfaceObject->setDialogTemplate('employee/print/employeePrintOptionDetail.tpl');
        $interfaceObject->setCheckedPrintOptions($checkedPrintOptions);

        foreach ($modulePrintOptions as $printOption) {
            $printOptionsValueObject->setSelectedModuleOption($printOption, BooleanValue::TRUE);

            // sommige hebben detail options
            switch($printOption) {

                case EmployeeModulePrintOption::OPTION_COMPETENCE:
                    $EmployeeCompetencePrintOptionDetail = EmployeeCompetencePrintOptionDetail::create( $displayWidth,
                                                                                                        $printOption,
                                                                                                        self::DETAIL_OPTIONS_INDENTATIONS,
                                                                                                        in_array($printOption, $checkedPrintOptions),
                                                                                                        EmployeeCompetencePrintOptionDetail::ALL_CHECKED);

                    $detailOptions = EmployeeModuleDetailPrintOption::options($printOption);
                    foreach($detailOptions as $detailOption) {
                        switch ($detailOption) {
                            case EmployeeModuleDetailPrintOption::SHOW_REMARKS:
                                $isAllowedRemarks = EmployeePrintService::isPrintAllowedRemarks();
                                if ($isAllowedRemarks) {
                                    $safeFormHandler->addIntegerInputFormatType('show_remarks_' . $printOption);
                                    $EmployeeCompetencePrintOptionDetail->setIsAllowedShowRemarks($isAllowedRemarks);
                                }
                                break;

                            case EmployeeModuleDetailPrintOption::SHOW_360:
                                $isAllowed360 = EmployeePrintService::isPrintAllowed360();
                                if ($isAllowed360) {
                                    $safeFormHandler->addIntegerInputFormatType('show_threesixty_' . $printOption);
                                    $EmployeeCompetencePrintOptionDetail->setIsAllowedShow360($isAllowed360);
                                }
                                break;

                            case EmployeeModuleDetailPrintOption::SHOW_PDP_ACTION:
                                $isAllowedPdpAction = EmployeePrintService::isPrintAllowedPdpAction();
                                if ($isAllowedPdpAction) {
                                    $safeFormHandler->addIntegerInputFormatType('show_action_' . $printOption);
                                    $EmployeeCompetencePrintOptionDetail->setIsAllowedShowPdpAction($isAllowedPdpAction);
                                }
                                break;
                        }
                    }
                    $interfaceObject->setPrintOptionDetail($printOption, $EmployeeCompetencePrintOptionDetail);
                    break;

                case EmployeeModulePrintOption::OPTION_TARGET:
                case EmployeeModulePrintOption::OPTION_FINAL_RESULT:
                case EmployeeModulePrintOption::OPTION_PDP_ACTION:
                    $safeFormHandler->addIntegerInputFormatType('show_cycle_' . $printOption);

                    $detailOptions = EmployeeModuleDetailPrintOption::options($printOption);

                    $detailPrintOptionsDialog = EmployeeAssessmentCyclePrintOptionDetail::create(   $displayWidth,
                                                                                                    $printOption,
                                                                                                    self::DETAIL_OPTIONS_INDENTATIONS,
                                                                                                    in_array($printOption, $checkedPrintOptions),
                                                                                                    EmployeeModuleDetailPrintOption::SELECT_CURRENT_CYCLE);
                    $detailPrintOptionsDialog->setSelectableValues($detailOptions);

                    $interfaceObject->setPrintOptionDetail($printOption, $detailPrintOptionsDialog);
                    break;
            }
        }

        // safeForm
        $safeFormHandler->finalizeDataDefinition();

        $contentHtml = $interfaceObject->fetchHtml();

        return array($safeFormHandler, $contentHtml);
    }
}
?>
