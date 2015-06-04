<?php

/**
 * Description of TalentSelectorSafeFormProcessor
 *
 * @author hans.prins
 */

require_once('modules/model/service/report/TalentSelectorController.class.php');

class TalentSelectorSafeFormProcessor
{
    static function processExecute($objResponse, $safeFormHandler)
    {
        $hasError = true;
        $messages = array();
        $valueObjects = array();

        if (PermissionsService::isAccessAllowed(PERMISSION_TALENT_SELECTOR)) {

            $currentAssessmentCycle = AssessmentCycleService::getCurrentValueObject();

            // TODO: vragen aan CompetenceService
            $competenceValueObjects = TalentSelectorCompetenceService::getValueObjects();

            foreach($competenceValueObjects as $competenceValueObject) {
                $competenceId   = $competenceValueObject->competenceId;
                $competenceName = $safeFormHandler->retrieveInputValue('competence_name_' . $competenceId);
                $operator       = $safeFormHandler->retrieveInputValue('operator_' . $competenceId);
                $score          = $safeFormHandler->retrieveInputValue('score_' . $competenceId);

                if(!empty($competenceName)) {
                    $valueObject = TalentSelectorRequestedValueObject::createWithValues($competenceId, $competenceName, $operator, $score);
                    $valueObjects[] = $valueObject;
                }
            }

            list($hasError, $messages, $resultCollection) = TalentSelectorController::processExecute($valueObjects, $currentAssessmentCycle);

            // klaar met execute
            TalentSelectorInterfaceProcessor::finishExecute($objResponse, $hasError, $resultCollection);

        }
        return array($hasError, $messages);
    }

    static function processPrint($objResponse, $safeFormHandler)
    {
        $resultCollection = $safeFormHandler->retrieveInputValue('resultCollection');

        $_SESSION['print_talent_selector_object'] = $resultCollection;

        InterfaceXajax::openInWindow($objResponse, 'print/print_talent_selector.php', 800, 800);
        InterfaceXajax::enableButton($objResponse, PROCESS_BUTTON);
    }

}

?>