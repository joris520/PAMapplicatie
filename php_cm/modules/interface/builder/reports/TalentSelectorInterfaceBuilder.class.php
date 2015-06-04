<?php

/**
 * Description of TalentSelectorInterfaceBuilder
 *
 * @author hans.prins
 */

require_once('modules/model/service/report/TalentSelectorCompetenceService.class.php');

// zoeken
require_once('modules/interface/interfaceobjects/report/TalentSelectorGroup.class.php');
require_once('modules/interface/interfaceobjects/report/TalentSelectorView.class.php');
// resultaat
require_once('modules/interface/interfaceobjects/report/TalentSelectorResultGroup.class.php');
require_once('modules/interface/interfaceobjects/report/TalentSelectorResultCompetenceGroup.class.php');
require_once('modules/interface/interfaceobjects/report/TalentSelectorResultView.class.php');

require_once('modules/interface/builder/reports/TalentSelectorInterfaceBuilderComponents.class.php');

require_once('modules/interface/converter/report/OperatorConverter.class.php');
require_once('modules/model/value/report/OperatorValue.class.php');
require_once('modules/interface/converter/library/competence/ScaleConverter.class.php');


class TalentSelectorInterfaceBuilder
{
    const LEFT_PANEL_HTML_ID  = 'talent_selector_left_panel';
    const RIGHT_PANEL_HTML_ID = 'talent_selector_right_panel';

    static function getViewHtml($displayWidth)
    {
        $valueObjects = TalentSelectorCompetenceService::getValueObjects();

        // safeForm
        $safeFormHandler = SafeFormHandler::create(SAFEFORM_REPORT__EXECUTE_TALENT_SELECTOR);

        $safeFormHandler->addPrefixStringInputFormatType('competence_name_');
        $safeFormHandler->addPrefixStringInputFormatType('operator_');
        $safeFormHandler->addPrefixStringInputFormatType('score_');

        $safeFormHandler->finalizeDataDefinition();

        // omzetten naar template data
        // groep
        $groupInterfaceObject = TalentSelectorGroup::create($displayWidth);
        foreach($valueObjects as $valueObject) {
            $interfaceObject = TalentSelectorView::createWithValueObject(   $valueObject,
                                                                            $displayWidth);
            $groupInterfaceObject->addInterfaceObject($interfaceObject);
        }

        $contentHtml = $groupInterfaceObject->fetchHtml();

        return array($safeFormHandler, $contentHtml);
    }

    static function getResultViewHtml(  $displayWidth,
                                        TalentSelectorResultCollection $resultCollection)
    {
        // safeForm
        $safeFormHandler = SafeFormHandler::create(SAFEFORM_REPORT__PRINT_TALENT_SELECTOR, SAFEFORM_REPORT__EXECUTE_TALENT_SELECTOR);
        $safeFormHandler->storeSafeValue('resultCollection', serialize($resultCollection));
        $safeFormHandler->finalizeDataDefinition();

        // interface object
        $talentSelectorResultGroup = TalentSelectorResultGroup::create($displayWidth);

        $employeesMatchCount = $resultCollection->getEmployeesMatchCount();
        $requestedCount = $resultCollection->getRequestedCount();
        $resultObjects = $resultCollection->getResultObjects();

        foreach($resultObjects as $resultObject) {
            if ($resultObject->hasScoreObjects()) {

                $groupInterfaceObject = TalentSelectorResultCompetenceGroup::createWithValueObject( $resultObject->getValueObject(),
                                                                                                    $displayWidth);

                $scoreObjects = $resultObject->getScoreObjects();
                foreach ($scoreObjects as $scoreObject) {
                    $employeeId = $scoreObject->getEmployeeId();
                    if ($employeesMatchCount[$employeeId] == $requestedCount) {
                        $viewInterfaceObject = TalentSelectorResultView::createWithValueObject( $scoreObject,
                                                                                                $displayWidth);
                        $groupInterfaceObject->addInterfaceObject($viewInterfaceObject);
                    }
                }
                $talentSelectorResultGroup->addInterfaceObject($groupInterfaceObject);
            }
        }

        $contentHtml = $talentSelectorResultGroup->fetchHtml();

        return array($safeFormHandler, $contentHtml);
    }
}

?>
