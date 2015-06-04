<?php

/**
 * Description of EmployeeScoreSafeFormProcessor
 *
 * @author ben.dokter
 */

class EmployeeScoreSafeFormProcessor
{

    static function processBulkEdit($objResponse, $safeFormHandler)
    {
        $hasError = true;
        $messages = array();

        if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_SCORES)) {
            $employeeId             = $safeFormHandler->retrieveSafeValue('employeeId');
            $competenceValueObjects = $safeFormHandler->retrieveSafeValue('competenceValueObjects');

            $showRemarks = CUSTOMER_OPTION_USE_SKILL_NOTES;

//            // Functie en competenties ophalen voor employee
//            $functionValueObject = EmployeeJobProfileService::getValueObject($employeeId);
//            $competenceValueObjects = EmployeeCompetenceService::getValueObjects(   $employeeId,
//                                                                                    $functionValueObject->getMainFunctionId());

            // voor elke competentie de score ophalen uit het scherm
            $scoreValueObjects = array();
            foreach($competenceValueObjects as $competenceValueObject) {
                $competenceId   = $competenceValueObject->competenceId;
                $scale          = $competenceValueObject->competenceScaleType;

                $score = $safeFormHandler->retrieveInputValue(EmployeeScoreInterfaceBuilderComponents::getEditScorePrefix($scale) . $competenceId);
                $note = '';
                if ($showRemarks) {
                    $note = $safeFormHandler->retrieveInputValue(EmployeeScoreInterfaceBuilderComponents::getEditNotePrefix($scale) . $competenceId);
                }
                $scoreValueObject = EmployeeScoreValueObject::createWithValues($employeeId, $competenceId, $score, $note);
                $scoreValueObject->setCompetenceValueObject($competenceValueObject);
                $scoreValueObjects[] = $scoreValueObject;
            }

            ///////////////////////////////////////////////////////////////
            // opslaan $scoreValueObjects
            list($hasError, $messages) = EmployeeCompetenceController::processEditScores($employeeId, $scoreValueObjects);
            if (!$hasError) {
                // klaar met edit
                $safeFormHandler->finalizeSafeFormProcess();
                EmployeeCompetenceInterfaceProcessor::finishEditBulkScore($objResponse, $employeeId);
            }
        }
        return array($hasError, $messages);
    }

    static function processClusterEdit($objResponse, $safeFormHandler)
    {

        $hasError = true;
        $messages = array();

        if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_SCORES)) {
            ///////////////////////////////////////////////////////////////
            $employeeId             = $safeFormHandler->retrieveSafeValue('employeeId');
            $clusterId              = $safeFormHandler->retrieveSafeValue('clusterId');
            $competenceValueObjects   = $safeFormHandler->retrieveSafeValue('competenceValueObjects');

            $showRemarks = CUSTOMER_OPTION_USE_SKILL_NOTES;

            // Functie en competenties ophalen voor employee
//            $functionValueObject = EmployeeJobProfileService::getValueObject($employeeId);
//            $competenceValueObjects = EmployeeCompetenceService::getValueObjects(   $employeeId,
//                                                                                    $functionValueObject->getMainFunctionId(),
//                                                                                    $clusterId);

            // voor elke competentie de score ophalen uit het scherm
            $scoreValueObjects = array();
            foreach($competenceValueObjects as $competenceValueObject) {
                $competenceId = $competenceValueObject->competenceId;
                $scale = $competenceValueObject->competenceScaleType;

                $score = $safeFormHandler->retrieveInputValue(EmployeeScoreInterfaceBuilderComponents::getEditScorePrefix($scale) . $competenceId);
                $note = '';
                if ($showRemarks) {
                    $note = $safeFormHandler->retrieveInputValue(EmployeeScoreInterfaceBuilderComponents::getEditNotePrefix($scale) . $competenceId);
                }
                $scoreValueObject = EmployeeScoreValueObject::createWithValues($employeeId, $competenceId, $score, $note);
                $scoreValueObject->setCompetenceValueObject($competenceValueObject);
                $scoreValueObjects[] = $scoreValueObject;
            }

            ///////////////////////////////////////////////////////////////
            // opslaan $scoreValueObjects
            list($hasError, $messages) = EmployeeCompetenceController::processEditScores($employeeId, $scoreValueObjects);
            if (!$hasError) {
                // klaar met edit
                $safeFormHandler->finalizeSafeFormProcess();
                EmployeeCompetenceInterfaceProcessor::finishEditClusterScore($objResponse, $employeeId, $clusterId);
            }
        }
        return array($hasError, $messages);

    }

}

?>
