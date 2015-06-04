<?php

/**
 * Description of Threesixty
 *
 * @author wouter.storteboom
 */

require_once('modules/model/queries/threesixty/ThreesixtyQueries.class.php');

class ThreesixtyService {

    const THREESIXTY_COMPETENCE_SCORE = 'threesixty_competence_score';
    const THREESIXTY_COMPETENCE_ID = 'threesixty_competence_id';
    const THREESIXTY_COMPETENCE_NAME = 'threesixty_competence_description';
    const THREESIXTY_COMPETENCE_SCALE = 'threesixty_competence_scale';
    const THREESIXTY_COMPETENCE_REMARKS = 'threesixty_competence_remarks';


    static function validateAndSaveEvaluation($evaluator, $evaluator_email, $competence_scores, $hash_id, $employee_id)
    {
        $error_message = '';
        $hasError = false;

        if (empty($evaluator)) {
            $error_message = TXT_UCF('PLEASE_ENTER_A_NAME');
            $hasError = true;
        } elseif (empty($evaluator_email)) {
            $error_message = TXT_UCF('PLEASE_ENTER_AN_EMAIL_ADDRESS');
            $hasError = true;
        } elseif (!ModuleUtils::IsEmailAddressValidFormat ($evaluator_email)) {
            $error_message = TXT_UCF('EMAIL_ADDRESS_IS_INVALID');
            $hasError = true;
        } else {
            // controleer verplicht in te vullen scores
            $error_message = TXT_UCF('PLEASE_ENTER_A_VALUE_FOR_THE_SCORES') . ' :' . "\n";
            foreach ($competence_scores as $key => $competence_score) {
                $score = $competence_score[self::THREESIXTY_COMPETENCE_SCORE];
                $ksp_scale = $competence_score[self::THREESIXTY_COMPETENCE_SCALE];

                if (empty($score) ||
                    !ModuleUtils::isScoreValid($score, $ksp_scale)) {
                    $error_message .= '- ' . $competence_score[self::THREESIXTY_COMPETENCE_NAME] . "\n";
                    $hasError = true;
                }
            }
        }

        if (!$hasError) {
            ThreesixtyQueries::deletePreviousEvaluationScores($hash_id);

            // invoer opslaan bij hash_id
            foreach ($competence_scores as $key => $competence_score) {
                $score = $competence_score[self::THREESIXTY_COMPETENCE_SCORE];
                // correctie NA:
                if ($score == 'NA') $score = ''; // nvt is leeg in database

                $competence_id = $competence_score[self::THREESIXTY_COMPETENCE_ID];
                $remarks = $competence_score[self::THREESIXTY_COMPETENCE_REMARKS];
                ThreesixtyQueries::addNewEvaluationScore($employee_id, $competence_id, $hash_id, $evaluator, $evaluator_email, $score, $remarks);
            }

            ThreesixtyQueries::setEvaluationComplete($hash_id);
        }

        return array($hasError, $error_message);
    }

//    static function sendScoresCopyEmail($to, $subject, $message, $headers) {
//        mail($to, $subject, $message, $headers, '-f'. APPLICATION_NO_REPLY_EMAIL_ADDRESS);
//    }

    static function loadAllThreesixtyInformation($hash_info)
    {
        $employeeInfo  = array();
        $functionInfo  = array();
        $evaluatorInfo = array();
        $competencesInfo = array();

        $EmployeeInfoResult = ThreesixtyQueries::getEmployeeInformation($hash_info['id_e']);
        $employeeInfo = @mysql_fetch_assoc($EmployeeInfoResult);

        $functionInfo = FunctionsServiceDeprecated::getFunction($hash_info['id_f']);

        $evaluatorInfo = personDataService::getPersonData($hash_info['id_pd']);

        if (!empty($hash_info['competences'])) {
            $competencesInfoResult = ThreesixtyQueries::get360Competences($hash_info['id_f'], $hash_info['competences']);
            $competencesInfo = MysqlUtils::getAllData($competencesInfoResult);
        }

        // hbd: bepalen of er 1-5, y/n en kerncompetenties zijn
        $has_YN_questions = false;
        $has_1_5_questions = false;
        $has_key_competences = false;
        foreach($competencesInfo as $competencesInfo_rec) {
            if ($competencesInfo_rec['ksp_scale'] == ScaleValue::SCALE_Y_N) {
                $has_YN_questions = true;
            }
            if ($competencesInfo_rec['ksp_scale'] == ScaleValue::SCALE_1_5) {
                $has_1_5_questions = true;
            }
            if ($competencesInfo_rec['is_key'] == 1) {
                $has_key_competences = true;
            }
        }

        return array($employeeInfo,
                     $functionInfo,
                     $evaluatorInfo,
                     $competencesInfo,
                     $has_YN_questions,
                     $has_1_5_questions,
                     $has_key_competences);
    }

    static function getHashInformation($hash_id)
    {
        return @mysql_fetch_assoc(ThreesixtyQueries::getHashInformation($hash_id));
    }

    static function isHashIdValid($hash_id)
    {
        $isHashIdValid = false;
        if (PamValidators::IsMd5HashValidFormat($hash_id)) {
            $isCompleted = @mysql_fetch_assoc(ThreesixtyQueries::getThreesixtyIsCompleted($hash_id));
            $isHashIdValid = ($isCompleted != AssessmentInvitationCompletedValue::COMPLETED);
        }
        return $isHashIdValid;
    }

    static function hasHash($hash_id)
    {
        $foundHash = false;
        if (PamValidators::IsMd5HashValidFormat($hash_id)) {
            $foundHashInfo = @mysql_fetch_assoc(ThreesixtyQueries::getHashFromInvitations($hash_id));
            $foundHash  = $foundHashInfo > 0;
        }
        return $foundHash;
    }
}

?>
