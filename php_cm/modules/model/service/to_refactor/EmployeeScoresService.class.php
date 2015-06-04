<?php

/**
 * Description of EmployeeScores
 *
 * @author ben.dokter
 */

require_once('modules/model/queries/to_refactor/EmployeeScoresQueries.class.php');
require_once('modules/model/service/to_refactor/FunctionsServiceDeprecated.class.php');

class EmployeeScoresService {


    static function getRatingText($rating)
    {
        if ($rating == RATING_DICTIONARY) {
            $ratingText = TXT_UCF('BASED_ON_DICTIONARY');
        } else {
            $ratingText = TXT_UCF('BASED_ON_JOB_PROFILE');
        }
        return $ratingText;
    }

    static function getScoreInfo($employee_id)
    {
        list ($mainFunctionId, $mainFunctionName, $additionalFunctionNames) = FunctionsServiceDeprecated::getFunctionNames($employee_id);

        $scoreInfoQuery = EmployeeScoresQueries::getEmployeeScoreInfo($employee_id);
        $scoreInfo = @mysql_fetch_assoc($scoreInfoQuery);
        $scoreInfo['main_function_id'] = $mainFunctionId;
        $scoreInfo['main_function_name'] = $mainFunctionName;
        $scoreInfo['additional_function_names'] = $additionalFunctionNames;

        return $scoreInfo;
    }

    static function getScores($employee_id, $rating, $main_function_id, $cluster_id = null)
    {
        $scores = array();

        if ($rating == RATING_DICTIONARY) {
            $scoresResult = EmployeeScoresQueries::getEmployeeScoresDictionary($employee_id, $main_function_id);
        } else {
            $scoresResult = EmployeeScoresQueries::getEmployeeScoresFunctions($employee_id, $main_function_id);
        }

        $previous_cluster = '';
        $cluster_has_main = false;
        while ($score = @mysql_fetch_assoc($scoresResult)) {
            if (empty($cluster_id) || $cluster_id == $score['cluster_id']) {
                $cluster_name = empty($score['cluster']) ? EMPTY_CLUSTER_LABEL : $score['cluster'];
                if ($cluster_name != $previous_cluster) {
                    $cluster_has_main = ($score['is_cluster_main'] == 1);
                }
                $score['cluster'] = $cluster_name;
                $score['cluster_has_main'] = $cluster_has_main;
                // gemiddelde score 360 voor Y/N terugzetten
                if ($score['scale'] == ScaleValue::SCALE_Y_N) {
                    if (!empty($score['employee_score'])) {
                        $score['employee_score'] = ModuleUtils::averageYN($score['employee_score'], $score['scale']);
                    }
                }
                $scores[] = $score;

                $previous_cluster = $cluster_name;
            }
        }

        return $scores;
    }

    static function getBossScore($employee_id, $competence_id)
    {
        return @mysql_fetch_assoc(EmployeeScoresQueries::getBossScore($employee_id, $competence_id));

    }

    static function validateAndUpdateBossScore($employee_id, $competence_id, $score_id, $score)
    {
        $hasError = false;
        $message = '';

        if (empty($score)) {
            $hasError = true;
            $message = TXT_UCF('PLEASE_ENTER_A_VALUE_FOR_THE_SCORES');
        }
        if (!$hasError) {
            $store_score = $score == 'NA' ? '' : $score;
            if (empty($score_id)) {
                $score_id = EmployeeScoresQueries::insertBossScore($employee_id, $competence_id, $store_score);
            } else {
                EmployeeScoresQueries::updateBossScore($employee_id, $competence_id, $score_id, $store_score);
            }
        }
        return array($hasError, $message, $score_id);
    }

    static function getBossNote($employee_id, $competence_id)
    {
        return @mysql_fetch_assoc(EmployeeScoresQueries::getBossNote($employee_id, $competence_id));

    }

    static function validateAndUpdateBossNote($employee_id, $competence_id, $score_id, $boss_note)
    {
        $hasError = false;
        $message = '';

        // er moet al een score zijn voordat er een toelichting bijgezet kan worden. dit ivm NA controle, zie validateAndUpdateBossScore!
        if (empty($score_id)) {
            $hasError = true;
            $message = TXT_UCF('PLEASE_ENTER_A_VALUE_FOR_THE_SCORES'); // TODO: betere melding
        }

        if (!$hasError) {
//            if (empty($score_id)) {
//                $score_id = EmployeeScoresQueries::insertBossNote($employee_id, $competence_id, $boss_note);
//            } else {
                EmployeeScoresQueries::updateBossNote($employee_id, $competence_id, $score_id, $boss_note);
//            }
        }
        return array($hasError, $message, $score_id);
    }


    static function getEvaluationDate($employee_id)
    {
        $scoreInfoResult = EmployeeScoresQueries::getEmployeeScoreInfo($employee_id);
        $scoreInfo = @mysql_fetch_assoc($scoreInfoResult);
        return $scoreInfo['conversation_date'];
    }

    static function validateAndProcessEvaluationDate($employee_id, $evaluationDate, $evaluationDate_description)
    {
        $hasError = false;
        $message = '';

        // er moet al een score zijn voordat er een toelichting bijgezet kan worden. dit ivm NA controle, zie validateAndUpdateBossScore!
        if (empty($evaluationDate)) {
            $hasError = true;
            $message = TXT_UCF('PLEASE_ENTER_A_CONVERSATION_DATE'); // TODO: betere melding
        }

        if (!$hasError) {
            EmployeeScoresQueries::updateEvaluationDate($employee_id, $evaluationDate);

            $scoreInfoResult = EmployeeScoresQueries::getEmployeeScoreInfo($employee_id);
            $scoreInfo = @mysql_fetch_assoc($scoreInfoResult);
            $rating = $scoreInfo['rating']; // TODO: rename

            // voorlopig altijd
            if ($rating == RATING_FUNCTION_PROFILE) {
                addTimeshotFunctionMode($employee_id, $evaluationDate_description, $evaluationDate);
            } elseif ($rating == RATING_DICTIONARY) {
                addTimeshotCompetenceMode($employee_id, $evaluationDate_description, $evaluationDate);
            }
        }
        return array($hasError, $message);

    }


}

?>
