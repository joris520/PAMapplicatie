<?php

/**
 * Description of EmployeeJobProfileInterfaceBuilder
 *
 * @author ben.dokter
 */
require_once('modules/interface/builder/employee/competence/EmployeeJobProfileInterfaceBuilderComponents.class.php');

require_once('modules/model/service/library/FunctionService.class.php');
require_once('modules/model/service/employee/competence/EmployeeJobProfileService.class.php');

require_once('modules/interface/interfaceobjects/employee/competence/EmployeeJobProfileView.class.php');
require_once('modules/interface/interfaceobjects/employee/competence/EmployeeJobProfileEdit.class.php');
require_once('modules/interface/interfaceobjects/employee/competence/EmployeeJobProfileHistory.class.php');

class EmployeeJobProfileInterfaceBuilder
{
    static function getViewHtml($displayWidth,
                                $employeeId,
                                EmployeeJobProfileValueObject $valueObject)
    {

        $interfaceObject = EmployeeJobProfileView::createWithValueObject(   $valueObject,
                                                                            $displayWidth);

        // en dat alles in een mooi blok laten zien
        $blockInterfaceObject = BaseBlockInterfaceObject::create(   $interfaceObject,
                                                                    TXT_UCF('JOB_PROFILE'),
                                                                    $displayWidth);
        $blockInterfaceObject->addActionLink(   EmployeeJobProfileInterfaceBuilderComponents::getEditLink(      $employeeId));
        $blockInterfaceObject->addActionLink(   EmployeeJobProfileInterfaceBuilderComponents::getHistoryLink(   $employeeId));

        return $blockInterfaceObject->fetchHtml();

    }

    // het ophalen van "standaard" gevulde interface objecten
    static function getHeaderViewInterfaceObject(   $displayWidth,
                                                    $employeeId,
                                                    EmployeeJobProfileValueObject $valueObject)
    {
        $interfaceObject = EmployeeJobProfileHeaderView::createWithValueObject( $valueObject,
                                                                                $displayWidth);
        $interfaceObject->setEditLink(      EmployeeJobProfileInterfaceBuilderComponents::getEditLink($employeeId));
        $interfaceObject->setHistoryLink(   EmployeeJobProfileInterfaceBuilderComponents::getHistoryLink($employeeId));
        return $interfaceObject;
    }


    static function getEditHtml($displayWidth,
                                $employeeId)
    {
        $valueObject = EmployeeJobProfileService::getValueObject($employeeId);

        // safeForm
        $safeFormHandler = SafeFormHandler::create(SAFEFORM_EMPLOYEE__EDIT_FUNCTION);

        $safeFormHandler->storeSafeValue('employeeId', $employeeId);
        $safeFormHandler->addStringInputFormatType('selectedID_Fs');
        $safeFormHandler->addIntegerInputFormatType('ID_FID');
        $safeFormHandler->addStringInputFormatType('note');
        $safeFormHandler->finalizeDataDefinition();

        $interfaceObject = EmployeeJobProfileEdit::createWithValueObject($valueObject, $displayWidth);
        $interfaceObject->setAllFunctionIdValues(FunctionService::getFunctionIdValues());

        $contentHtml = $interfaceObject->fetchHtml();

        return array($safeFormHandler, $contentHtml);

    }

    /// HISTORY
    static function getHistoryHtml( $displayWidth,
                                    $employeeId)
    {
        $historyInterfaceObject = EmployeeJobProfileHistory::create($displayWidth);

        $valueObjects = EmployeeJobProfileService::getValueObjects($employeeId);
        foreach ($valueObjects as $valueObject) {
            $historyPeriod = AssessmentCycleService::getCurrentValueObject($valueObject->getSavedDatetime());
            $valueObject->setAssessmentCycleValueObject($historyPeriod);
            $historyInterfaceObject->addValueObject($valueObject);
        }

        return $historyInterfaceObject->fetchHtml();
    }
}

?>
