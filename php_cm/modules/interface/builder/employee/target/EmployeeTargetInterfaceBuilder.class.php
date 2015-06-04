<?php

/**
 * Description of EmployeeTargetInterfaceBuilder
 *
 * @author hans.prins
 */

require_once('modules/interface/builder/employee/AbstractEmployeeInterfaceBuilder.class.php');

// components
require_once('modules/interface/builder/employee/target/EmployeeTargetInterfaceBuilderComponents.class.php');
require_once('modules/interface/builder/employee/print/EmployeePrintInterfaceBuilderComponents.class.php');

// services
require_once('modules/model/service/employee/target/EmployeeTargetService.class.php');

// values
require_once('modules/model/value/employee/target/EmployeeTargetStatusValue.class.php');

// interfaceobjects
require_once('modules/interface/interfaceobjects/employee/target/EmployeeTargetActionView.class.php');
require_once('modules/interface/interfaceobjects/employee/target/EmployeeTargetGroup.class.php');
require_once('modules/interface/interfaceobjects/employee/target/EmployeeTargetView.class.php');
require_once('modules/interface/interfaceobjects/employee/target/EmployeeTargetAdd.class.php');
require_once('modules/interface/interfaceobjects/employee/target/EmployeeTargetEdit.class.php');
require_once('modules/interface/interfaceobjects/employee/target/EmployeeTargetDelete.class.php');
require_once('modules/interface/interfaceobjects/employee/target/EmployeeTargetHistory.class.php');
//require_once('modules/interface/interfaceobjects/employee/target/EmployeeAssessmentCyclePrintOptionDetail.class.php');

require_once('modules/interface/interfaceobjects/base/BaseTitleInterfaceObject.class.php');
require_once('modules/interface/interfaceobjects/base/BaseBlockInterfaceObject.class.php');

// converters
require_once('modules/interface/converter/employee/target/EmployeeTargetStatusConverter.class.php');

class EmployeeTargetInterfaceBuilder extends AbstractEmployeeInterfaceBuilder
{
    const DETAIL_OPTIONS_INDENTATIONS = 0;

    static function getViewHtml( $displayWidth,
                                 $employeeId,
                                 Array $employeeTargetCollections,
                                 $hiliteId = NULL )
    {
        $html = '';
        $isViewAllowedEvaluation = PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_TARGET_EVALUATION);

        foreach($employeeTargetCollections as $employeeTargetCollection) {
            $groupInterfaceObject = EmployeeTargetGroup::create($displayWidth);
            $groupInterfaceObject->setIsViewAllowedEvaluation($isViewAllowedEvaluation);

            // data verzamelen
            $employeeTargetValueObjects = $employeeTargetCollection->getEmployeeTargetValueObjects();
            $assessmentCycleValueObject = $employeeTargetCollection->getAssessmentCycleValueObject();

            // interface opbouwen
            foreach($employeeTargetValueObjects as $valueObject) {

                $employeeTargetId = $valueObject->getId();
                if (!empty($employeeTargetId)) {
                    $interfaceObject = EmployeeTargetView::createWithValueObject(   $valueObject,
                                                                                    $displayWidth);
                    $interfaceObject->setIsViewAllowedEvaluation($isViewAllowedEvaluation);

                    $interfaceObject->setDateWarning           (!EmployeeTargetService::hasStatus($valueObject) &&
                                                                DateUtils::isBefore(REFERENCE_DATE, $valueObject->getEndDate()));
                    $interfaceObject->setHiliteRow             ($employeeTargetId == $hiliteId);
                    $interfaceObject->setEditLink              (EmployeeTargetInterfaceBuilderComponents::getEditLink($employeeId, $employeeTargetId));
                    $interfaceObject->setRemoveLink            (EmployeeTargetInterfaceBuilderComponents::getDeleteLink($employeeId, $employeeTargetId));
                    $interfaceObject->setHistoryLink           (EmployeeTargetInterfaceBuilderComponents::getHistoryLink($employeeId, $employeeTargetId));

                    $groupInterfaceObject->addInterfaceObject($interfaceObject);
                }
            }


            // de regel voor de assessment cycle
            $assessmentCycleInfo = AssessmentCycleInterfaceBuilder::getDetailInfo(   $displayWidth,
                                                                                     $assessmentCycleValueObject);
            // en dat alles in een blok laten zien
            $blockInterfaceObject = BaseBlockInterfaceObject::create(   $groupInterfaceObject,
                                                                        $assessmentCycleInfo->fetchHtml(),
                                                                        $displayWidth);

            $html .= $blockInterfaceObject->fetchHtml();
        }

        return $html;
    }


    static function getActionsHtml($displayWidth, $employeeId)
    {
        $blockInterfaceObject = BaseTitleInterfaceObject::create(   TXT_UCF('TARGETS'),
                                                                    $displayWidth);
        $blockInterfaceObject->setIsSubHeader();
        $blockInterfaceObject->addActionLink(   EmployeeTargetInterfaceBuilderComponents::getAddLink($employeeId));

        return $blockInterfaceObject->fetchHtml();
    }

    static function getAddHtml($displayWidth, $employeeId)
    {
        // data
        $valueObject = EmployeeTargetValueObject::createWithData($employeeId, NULL);

        // safeForm
        $safeFormHandler = SafeFormHandler::create(SAFEFORM_EMPLOYEE__ADD_EMPLOYEE_TARGET);
        $safeFormHandler->storeSafeValue          ('employeeId', $employeeId);
        $safeFormHandler->addStringInputFormatType('target_name');
        $safeFormHandler->addStringInputFormatType('performance_indicator');
        $safeFormHandler->addDateInputFormatType  ('end_date');

        // TODO: ook aan de process kant verwerken
        if (PermissionsService::isAddAllowed(PERMISSION_EMPLOYEE_TARGET_EVALUATION)) {
            $safeFormHandler->addStringInputFormatType('status');
        }
        $safeFormHandler->finalizeDataDefinition();

        $interfaceObject = EmployeeTargetAdd::createWithValueObject(    $valueObject,
                                                                        $displayWidth);
        $interfaceObject->setIsAddAllowedEvaluation(PermissionsService::isAddAllowed(PERMISSION_EMPLOYEE_TARGET_EVALUATION));
        $interfaceObject->setEndDatePicker(         InterfaceBuilderComponents::getCalendarInputPopupHtml(  'end_date',
                                                                                                            $valueObject->getEndDate()));
        $interfaceObject->setEvaluationDatePicker(  InterfaceBuilderComponents::getCalendarInputPopupHtml(  'evaluation_date',
                                                                                                            $valueObject->getEvaluationDate()));

        $contentHtml = $interfaceObject->fetchHtml();

        return array($safeFormHandler, $contentHtml);
    }

    static function getEditHtml($displayWidth,
                                $employeeId,
                                $employeeTargetId)
    {
        // data
        $valueObject = EmployeeTargetService::getValueObject($employeeId, $employeeTargetId);

        // safeForm
        $safeFormHandler = SafeFormHandler::create(SAFEFORM_EMPLOYEE__EDIT_EMPLOYEE_TARGET);
        $safeFormHandler->storeSafeValue(   'employeeId',        $employeeId);
        $safeFormHandler->storeSafeValue(   'employeeTargetId', $employeeTargetId);

        // TODO: ook aan de process kant verwerken
        if(PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_TARGETS)) {
            $safeFormHandler->addStringInputFormatType( 'target_name');
            $safeFormHandler->addStringInputFormatType( 'performance_indicator');
            $safeFormHandler->addDateInputFormatType(   'end_date');
        }

        if(PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_TARGET_EVALUATION)) {
            $safeFormHandler->addStringInputFormatType( 'status');
            $safeFormHandler->addStringInputFormatType( 'evaluation');
            $safeFormHandler->addDateInputFormatType(   'evaluation_date');
        }
        $safeFormHandler->finalizeDataDefinition();

        $interfaceObject = EmployeeTargetEdit::createWithValueObject($valueObject, $displayWidth);
        $interfaceObject->setShowLabel(                 PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_TARGET_EVALUATION));
        $interfaceObject->setIsEditAllowedTarget(       PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_TARGETS));
        $interfaceObject->setIsViewAllowedEvaluation(   PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_TARGET_EVALUATION));
        $interfaceObject->setIsEditAllowedEvaluation(   PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_TARGET_EVALUATION));

        $interfaceObject->setEndDatePicker(         InterfaceBuilderComponents::getCalendarInputPopupHtml(  'end_date',
                                                                                                            $valueObject->getEndDate()));
        $interfaceObject->setEvaluationDatePicker(  InterfaceBuilderComponents::getCalendarInputPopupHtml(  'evaluation_date',
                                                                                                            $valueObject->getEvaluationDate()));

        $contentHtml = $interfaceObject->fetchHtml();

        return array($safeFormHandler, $contentHtml);
    }

    static function getRemoveHtml(  $displayWidth,
                                    $employeeId,
                                    $employeeTargetId)
    {
        // data
        $valueObject = EmployeeTargetService::getValueObject($employeeId, $employeeTargetId);

        // safeForm
        $safeFormHandler = SafeFormHandler::create(SAFEFORM_EMPLOYEE__DELETE_EMPLOYEE_TARGET);

        $safeFormHandler->storeSafeValue('employeeId',       $employeeId);
        $safeFormHandler->storeSafeValue('employeeTargetId', $employeeTargetId);
        $safeFormHandler->finalizeDataDefinition();

        // vullen interface objects
        $interfaceObject = EmployeeTargetDelete::createWithValueObject( $valueObject,
                                                                        $displayWidth);
        $interfaceObject->setConfirmQuestion(   TXT_UCF('ARE_YOU_SURE_YOU_WANT_TO_DELETE_THIS_TARGET'));

        $contentHtml = $interfaceObject->fetchHtml();

        return array($safeFormHandler, $contentHtml);
    }

    static function getHistoryHtml( $displayWidth,
                                    $employeeId,
                                    $employeeTargetId)
    {
        $targetValueObjects = EmployeeTargetService::getHistoryValueObjects($employeeId, $employeeTargetId);

        $interfaceObject    = EmployeeTargetHistory::create($displayWidth);

        $historyPeriod = NULL;
        foreach ($targetValueObjects as $valueObject) {
            // haal de assessment cycle er bij op
            if (is_null($historyPeriod)) {
                $historyPeriod = AssessmentCycleService::getCurrentValueObject($valueObject->getSavedDateTime());
            }
            $valueObject->setAssessmentCycleValueObject($historyPeriod);
            $interfaceObject->addValueObject($valueObject);
        }

        $interfaceObject->setIsViewAllowedEvaluation(   PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_TARGET_EVALUATION));

        return $interfaceObject->fetchHtml();
    }

//    static function getPrintOptionsHtml($displayWidth, $employeeId)
//    {
//        // safeForm
//        $safeFormHandler = SafeFormHandler::create(SAFEFORM_EMPLOYEE__PRINT_EMPLOYEE_TARGET);
//        $safeFormHandler->storeSafeValue('employeeId', $employeeId);
//        $safeFormHandler->addIntegerInputFormatType('show_cycle');
//        $safeFormHandler->finalizeDataDefinition();
//
//        // interface object
//        $interfaceObject = EmployeeAssessmentCyclePrintOptionDetail::create($displayWidth, self::DETAIL_OPTIONS_INDENTATIONS, true);
//        $interfaceObject->setCurrentValue(AssessmentCyclePrintOption::CURRENT_CYCLE);
//        // TODO: opgeslagen "vorige" waarden terughalen en voorselecteren...
//
//        // vullen template
//        global $smarty;
//        $template = $smarty->createTemplate('employee/print/employeeTargetPrintGroup.tpl');
//        $template->assign('interfaceObject', $interfaceObject);
//        $contentHtml = $smarty->fetch($template);
//
//        return array($safeFormHandler, $contentHtml);
//    }
}
?>
