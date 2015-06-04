<?php

/**
 * Description of AssessmentActionService
 *
 * @author ben.dokter
 */

require_once('modules/model/value/assessmentProcess/AssessmentProcessStatusValue.class.php');
require_once('modules/model/state/assessmentProcess/AssessmentProcessActionState.class.php');

class AssessmentActionService
{
    // naar service
    static function getAssessmentStates($boss_id)
    {
        $assessment_states = array();
        if (!empty($boss_id)) {
            $query_result = EmployeesQueries::getAssessmentsStates($boss_id);
            while ($assessment_state = @mysql_fetch_assoc($query_result)) {
                $assessment_states[$assessment_state['assessment_status']] = $assessment_state['assessment_status'];
            }
        }
        return $assessment_states;
    }

    static function getPossibleAction($currentAssessmentState)
    {
        return AssessmentProcessActionState::determineNextAction($currentAssessmentState);
    }

    static function getPossibleUndoAction($currentAssessmentState)
    {
        return AssessmentProcessActionState::determineUndoAction($currentAssessmentState);
    }

    function isMarkAssessmentDoneUseful($assessment_states)
    {
        return in_array(AssessmentProcessStatusValue::INVITED, $assessment_states);
    }

    function isUndoMarkAssessmentDoneUseful($assessment_states)
    {
        return in_array(AssessmentProcessStatusValue::SELFASSESSMENT_COMPLETED, $assessment_states);
    }

    function isMarkEvaluationsSelectedUseful($assessment_states)
    {
        return in_array(AssessmentProcessStatusValue::SELFASSESSMENT_COMPLETED, $assessment_states);
    }

    function isUndoMarkEvaluationsSelectedUseful($assessment_states)
    {
        return in_array(AssessmentProcessStatusValue::EVALUATION_SELECTED, $assessment_states);
    }


}

?>
