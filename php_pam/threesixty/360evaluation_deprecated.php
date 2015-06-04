<?php

require_once('threesixty/EvaluationHelper.class.php');
require_once('modules/model/service/library/AssessmentCycleService.class.php');
require_once('modules/model/service/threesixty/ThreesixtyService.class.php');

$hash_get   = $_GET['h'];
$hash_found = false;
$hasError   = true;

// hbd: controle toegevoegd op geldig hash formaat
if (!empty($hash_get) && ModuleUtils::IsMd5HashValidFormat($hash_get)) {
    require_once('modules/common/moduleConsts.inc.php');
    require_once('application/library/PamApplication.class.php');
    require_once('application/library/PamExceptionProcessor.class.php');
    require_once('application/library/PamValidators.class.php');
    require_once('application/application_setup/database/openConnection.inc.php');


    $hash_found = false;
    try {
        $evaluationHelper = EvaluationHelper::createHelperObject($hash_get);
        if (!empty($evaluationHelper)) {
            $hash_found = $evaluationHelper->hasValidHashInfo();
            $evaluationHelper->setThreesixtyEnvironment();
        }
    } catch (TimecodeException $timecodeException) {
        $message = 'Ophalen evaluatieformulier lukt niet: ' . $hash_get;
        PamExceptionProcessor::handleCronException($timecodeException, $message);
    }

    if ($hash_found) {
        require_once('application/application_setup/language_config.inc.php');

        // Smarty initialiseren
        require_once ('application/application_setup/smarty_config.inc.php');

        include_once('application/application_setup/basic_includes.inc.php');

        require_once("xajax/xajax_core/xajaxAIO.inc.php"); // xajax compiled
        //require_once("xajax/xajax_core/xajax.inc.php");    // xajax minimal
        $xajax = new xajax();

        //$xajax->configure('debug', true); // uitzetten wanneer in productie!!

        define('MODULE_SUBSET', MODULE_SUBSET_THREESIXTY);
        require_once('application/application_setup/pam_config.inc.php');

        include_once('application/application_setup/xajax_config.inc.php');
        // TODO: alleen benodigde files includen!
        //include_once('application/application_setup/xajax_function_registrations.inc.php');
        try {
            $main_logo_path = '';
            $customer_logo_path = '';
            $site_info = '';

            $main_logo_path = 'images/logo/default_logo.jpg';
            $site_info = 'to_refactor/site_information/site_information.tpl';

            if (!empty($evaluationHelper->logo)) {
                $customer_logo_path = 'user_logo/c' . CUSTOMER_ID . '/' . $evaluationHelper->logo;
            } else {
                $customer_logo_path = $main_logo_path;
            }

            list($hasError) = AssessmentCycleService::validateInCurrentAssessmentCycle($evaluationHelper->invitation_date);
            // er is al een is_deprecated, dus kun je gewoon die toevoegen
            $evaluationHelper->is_deprecated = $evaluationHelper->is_deprecated || $hasError;

            global $smarty;
            $tpl = $smarty->createTemplate('to_refactor/threesixty/threeSixtyEvaluationFormDeprecated.tpl');
            $tpl->assign('xajaxJavascript', $xajax->getJavascript());
            $tpl->assign('environment_is_production', APPLICATION_IS_PRODUCTION_ENVIRONMENT);
            $tpl->assign('environment_detail', ENVIRONMENT_DETAIL);
            $tpl->assign('environment_color', ENVIRONMENT_COLOR);
            $tpl->assign('site_name', SITE_NAME);
            $tpl->assign('site_info_template', $site_info);
            $tpl->assign('main_logo_path', $main_logo_path);
            $tpl->assign('customer_logo_path', $customer_logo_path);

            $tpl->assign('hash_found', $hash_found);
            $tpl->assign('formHash', $evaluationHelper->hash);
            $tpl->assign('employeeInfo',     $evaluationHelper->employeeInfo);
            $tpl->assign('functionInfo',     $evaluationHelper->functionInfo);
            $tpl->assign('evaluatorInfo',    $evaluationHelper->evaluatorInfo);
            $tpl->assign('competencesInfo',  $evaluationHelper->competencesInfo);
            $tpl->assign('show_help',  true);
            $tpl->assign('completed', $evaluationHelper->was_completed);
            $tpl->assign('deprecated', $evaluationHelper->is_deprecated);
            $tpl->assign('has_YN_questions', $evaluationHelper->has_YN_questions);
            $tpl->assign('has_1_5_questions', $evaluationHelper->has_1_5_questions);
            $tpl->assign('has_key_competences', $evaluationHelper->has_key_competences);
            $tpl->assign('allow_change_evaluator_info', ($evaluationHelper->is_external_email && !$evaluationHelper->is_self_evaluation));
            $tpl->assign('is_self_evaluation', $evaluationHelper->is_self_evaluation);
            $tpl->assign('show_cat_header', $evaluationHelper->show_category_header);
            $tpl->assign('show_job_profile', $evaluationHelper->show_job_profile);
            $tpl->assign('show_department',  $evaluationHelper->show_department);
            $tpl->assign('show_main_competence',  $evaluationHelper->show_main_competence);
            $tpl->assign('show_remarks', $evaluationHelper->show_remarks);
            $tpl->assign('show_competence_details', $evaluationHelper->show_competence_details);
            echo $smarty->fetch($tpl);
        } catch (TimecodeException $timecodeException) {
            $message = 'Tonen evaluatieformulier lukt niet: ' . $hash_get;
            PamExceptionProcessor::handleCronException($timecodeException, $message);
        }
    } // if ($hash_found)

}



function module360_saveEvaluation_deprecated($evaluationForm)
{
    global $smarty;

    $hasError = true;
    $error_message = '';

    $objResponse = new xajaxResponse();

    // de hash ophalen en controleren, form moet gelijk aan get zijn.
    $hash = $evaluationForm['formHash'];
    $hash_get = $_GET['h'];
    if (!empty($hash) && ($hash_get == $hash) && ModuleUtils::IsMd5HashValidFormat($hash)) {

        $hasError = true;

        $hash_found = false;
        try {
            $evaluationHelper = EvaluationHelper::createHelperObject($hash);
            if (!empty($evaluationHelper)) {
                $hash_found = $evaluationHelper->hasValidHashInfo();
                $evaluationHelper->setThreesixtyEnvironment();
            }
        } catch (TimecodeException $timecodeException) {
            $message = 'Ophalen evaluatieformulier lukt niet: ' . $hash;
            PamExceptionProcessor::handleCronException($timecodeException, $message);
        }

        if ($hash_found) {
            $evaluator       = $evaluationForm['evaluator_name'];
            $evaluator_email = $evaluationForm['evaluator_email'];

            $hasError = false;
            if (empty($evaluator)) {
                $error_message = TXT_UCF('PLEASE_ENTER_A_NAME') . "\n";
                $objResponse->script('xajax.$("evaluator_name").focus();');
                $hasError = true;
            } elseif (!$evaluationHelper->is_self_evaluation) {
                if (empty($evaluator_email)) {
                    $error_message = TXT_UCF('PLEASE_ENTER_AN_EMAIL_ADDRESS') . "\n";
                    $objResponse->script('xajax.$("evaluator_email").focus();');
                    $hasError = true;
                } elseif (!PamValidators::IsEmailAddressValidFormat ($evaluator_email)) {
                    $error_message = TXT_UCF('EMAIL_ADDRESS_IS_INVALID') . "\n";
                    $objResponse->script('xajax.$("evaluator_email").focus();');
                    $hasError = true;
                }
            } else {

                // controleer verplicht in te vullen scores
                $error_message = TXT_UCF('PLEASE_ENTER_A_VALUE_FOR_THE_SCORES') . ' :' . "\n";
                foreach($evaluationHelper->competencesInfo as $competence) {
                    $score = $evaluationForm['scale' . $competence['ID_KSP']];
                    if (empty($score)) {
                        $error_message .= '- ' . $competence['knowledge_skill_point'] . "\n";
                        $hasError = true;
                    }
                }
            }

            if (!$hasError) {

                $messagex = '<table width="980" border="0" cellspacing="2" cellpadding="2">
                                <tr>
                                    <td style="text-align:center;">';
                switch(LANG_ID) {
                    case 2:
                    case 3:
                        $messagex .= '<strong>Bedankt voor het invullen van het evaluatieformulier';
                        if (!$evaluationHelper->is_self_evaluation) {
                            $messagex .= ' van ' . $evaluationHelper->employeeInfo['firstname'] . ' ' . $evaluationHelper->employeeInfo['lastname'];
                        }
                        break;

                    default:
                        $messagex .= '<strong>Thank You for filling out the evaluation form';
                        if (!$evaluationHelper->is_self_evaluation) {
                            $messagex .= ' of ' . $evaluationHelper->employeeInfo['firstname'] . ' ' . $evaluationHelper->employeeInfo['lastname'];
                        }
                        break;
                }
                $messagex .= '
                                        <br /><br />
                                    </td>
                                </tr>
                            </table>';

                $main_logo_path = '';
                $customer_logo_path = '';


                $main_logo_path = 'images/logo/default_logo.jpg';

                if (!empty($evaluationHelper->logo)) {
                    $customer_logo_path = 'user_logo/c' . $evaluationHelper->customer_id . '/' . $evaluationHelper->logo;
                }
                else {
                    $customer_logo_path = $main_logo_path;
                }

                $tpl_result = $smarty->createTemplate('to_refactor/threesixty/threeSixtyEvaluationFormCompetencesDeprecated.tpl');
                $tpl_result->assign('hash_found', $hash_found);
                $tpl_result->assign('formHash', $evaluationHelper->hash);
                $tpl_result->assign('employeeInfo',   $evaluationHelper->employeeInfo);
                $tpl_result->assign('functionInfo',   $evaluationHelper->functionInfo);
                //$tpl_result->assign('evaluatorInfo',  $evaluatorInfo);
                $tpl_result->assign('competencesInfo',  $evaluationHelper->competencesInfo);
                $tpl_result->assign('show_help',  false);
                $tpl_result->assign('post_data',  $evaluationForm);
                $tpl_result->assign('customer_logo_path', $customer_logo_path);
                $tpl_result->assign('has_YN_questions', $evaluationHelper->has_YN_questions);
                $tpl_result->assign('has_1_5_questions', $evaluationHelper->has_1_5_questions);
                $tpl_result->assign('has_key_competences', $evaluationHelper->has_key_competences);
                $tpl_result->assign('is_self_evaluation', $evaluationHelper->is_self_evaluation);
                $tpl_result->assign('allow_change_evaluator_info', ($evaluationHelper->is_external_email && !$evaluationHelper->is_self_evaluation));
                $tpl_result->assign('show_cat_header', $evaluationHelper->show_category_header);
                $tpl_result->assign('show_job_profile', $evaluationHelper->show_job_profile);
                $tpl_result->assign('show_department',  $evaluationHelper->show_department);
                $tpl_result->assign('show_main_competence',  $evaluationHelper->show_main_competence);
                $tpl_result->assign('show_remarks', $evaluationHelper->show_remarks);
                $message = $smarty->fetch($tpl_result);

                // verwerken in database
                try {
                    $hasError = true;
                    BaseQueries::startTransaction();

                    // opruimen 'oude' invoer bij dezelfde hash_id
                    $sql = 'DELETE
                            FROM
                                threesixty_evaluation
                            WHERE
                                customer_id = ' . $evaluationHelper->customer_id . '
                                AND hash_id = "' . mysql_real_escape_string($evaluationHelper->hash) . '"';

                    BaseQueries::performDeleteQuery($sql);

                    // invoer opslaan bij hash_id
                    foreach ($evaluationHelper->competencesInfo as $competence) {
                        $score = $evaluationForm['scale' . $competence['ID_KSP']];
                        // correctie NA:
                        if ($score == 'NA') $score = ''; // nvt is leeg in database

                        $remarks = $evaluationForm['remarks' . $competence['ID_KSP']];
                        // Toevoegen query
                        $sql = 'INSERT INTO
                                    threesixty_evaluation
                                    (   customer_id,
                                        ID_KSP,
                                        ID_E,
                                        hash_id,
                                        evaluator,
                                        evaluator_email,
                                        threesixty_score,
                                        notes,
                                        date_sentback
                                    ) VALUES (
                                        ' . $evaluationHelper->customer_id . ',
                                        ' . $competence['ID_KSP'] . ',
                                        ' . $evaluationHelper->employee_id . ',
                                    "' . mysql_real_escape_string($evaluationHelper->hash) . '" ,
                                    "' . mysql_real_escape_string($evaluator) . '",
                                    "' . mysql_real_escape_string($evaluator_email) . '",
                                    "' . mysql_real_escape_string($score) . '",
                                    "' . mysql_real_escape_string($remarks) . '",
                                    "' . MODIFIED_DATETIME . '"
                                    )';
                        BaseQueries::performInsertQuery($sql);
                    }

                    $sql = 'UPDATE
                                threesixty_invitations
                            SET
                                completed = ' . AssessmentInvitationCompletedValue::COMPLETED . ',
                                date_sentback = "' . MODIFIED_DATETIME . '"
                            WHERE
                                customer_id = ' . $evaluationHelper->customer_id . '
                                AND hash_id = "' . mysql_real_escape_string($evaluationHelper->hash) . '"';
                    BaseQueries::performUpdateQuery($sql);

                    BaseQueries::finishTransaction();
                    $hasError = false;


                    $objResponse->assign('msg',        'innerHTML', $messagex);
                    $objResponse->assign('msg_bottom', 'innerHTML', $messagex);
                    $objResponse->assign('eval',       'innerHTML', $message);
                } catch (TimecodeException $timecodeException) {
                    $message = 'Opslaan evaluatieformulier lukt niet: ' . $hash;
                    PamExceptionProcessor::handleInterfaceException($objResponse, $timecodeException, $message);
                }

            } else {
                $objResponse->alert($error_message);
            }
        }
    }
    return $objResponse;
} // END FUNCTION module360_saveEvaluation()


function module360Evaluation_showCompetenceDetails_deprecated($competence_id, $hash)
{
    $objResponse = new xajaxResponse();
    if (is_numeric($competence_id) && ThreesixtyService::isHashIdValid($hash)) {
        $competence_id = intval($competence_id);

        $evaluationHelper = EvaluationHelper::createHelperObject($hash);
        if ($evaluationHelper->hasValidHashInfo()) {

            $show_competence_detail = intval($show_competence_detail);

            $sql = 'SELECT
                        ks.knowledge_skill,
                        CASE
                            WHEN ksc.cluster is null
                            THEN "-"
                            ELSE ksc.cluster
                        END as cluster,
                        ksp.knowledge_skill_point,
                        ksp.description,
                        ksp.1none,
                        ksp.2basic,
                        ksp.3average,
                        ksp.4good,
                        ksp.5specialist,
                        ksp.scale,
                        ksp.modified_by_user,
                        ksp.modified_date,
                        ksp.modified_time
                    FROM
                        knowledge_skills_points ksp
                        INNER JOIN knowledge_skill ks
                            ON ks.ID_KS = ksp.ID_KS
                        LEFT JOIN knowledge_skill_cluster ksc
                            ON ksc.ID_C = ksp.ID_C
                    WHERE
                        ksp.customer_id = ' . $evaluationHelper->customer_id . '
                        AND ksp.ID_KSP = ' . $competence_id . '
                    LIMIT 1';

            $competenceInfoResult = BaseQueries::performQuery($sql);
            $competenceInfo = @mysql_fetch_assoc($competenceInfoResult);

            $html = '
            <table width="100%" border="0" cellpadding="2" cellspacing="0" class="border1px">
                <tr>
                    <td class="bottom_line shaded_title"><strong>' . TXT_UCF('DESCRIPTION') . ' : </strong></td>
                    <td colspan="4" class="bottom_line shaded_title">' . nl2br($competenceInfo['description']) . '</td>
                </tr>';
            if ($competenceInfo['scale'] == ScaleValue::SCALE_1_5) {
                $html .= '
                <tr>
                    <td class="bottom_line shaded_title" width="20%"><strong>[1] ' . SCALE_NONE . '</strong></td>
                    <td class="bottom_line shaded_title" width="20%"><strong>[2] ' . SCALE_BASIC . '</strong></td>
                    <td class="bottom_line shaded_title" width="20%"><strong>[3] ' . SCALE_AVERAGE . '</strong></td>
                    <td class="bottom_line shaded_title" width="20%"><strong>[4] ' . SCALE_GOOD . '</strong></td>
                    <td class="bottom_line shaded_title" width="20%"><strong>[5] ' . SCALE_SPECIALIST . '</strong></td>
                </tr>
                <tr>
                    <td class="bottom_line shaded_title">' . nl2br($competenceInfo['1none']) . '</td>
                    <td class="bottom_line shaded_title">' . nl2br($competenceInfo['2basic']) . '</td>
                    <td class="bottom_line shaded_title">' . nl2br($competenceInfo['3average']) . '</td>
                    <td class="bottom_line shaded_title">' . nl2br($competenceInfo['4good']) . '</td>
                    <td class="bottom_line shaded_title">' . nl2br($competenceInfo['5specialist']) . '</td>
                </tr>';
            } elseif ($competenceInfo['scale'] == ScaleValue::SCALE_Y_N) {
                $html .= '
                <tr>
                    <td class="bottom_line shaded_title" width="20%"><strong>[' . ModuleUtils::ScoreNormLetter('Y') . '] ' . SCALE_YES . '</strong></td>
                    <td class="bottom_line shaded_title" width="20%"><strong>[' . ModuleUtils::ScoreNormLetter('N') . '] ' . SCALE_NO . '</strong></td>
                    <td class="bottom_line shaded_title" width="20%">&nbsp;</td>
                    <td class="bottom_line shaded_title" width="20%">&nbsp;</td>
                    <td class="bottom_line shaded_title" width="20%">&nbsp;</td>
                </tr>';
            }
            $html .=  '
            </table>';

            $competenceName = $competenceInfo['knowledge_skill_point'];

            $objResponse->assign('click_competence_detail' . $competence_id, 'innerHTML', '<a href="" id="link' . $competence_id . '" onclick="xajax_module360Evaluation_hideCompetenceDetails_deprecated(' . $competence_id . ',\'' . $hash . '\');return false;" title="' . TXT_UCF('HIDE_DETAILS') . '" class="activated" style="font-weight:bold;">' . $competenceName . '</a>');
            $objResponse->assign('competencedetail' . $competence_id, 'innerHTML', $html);
        }
    }
    return $objResponse;
}

function module360Evaluation_hideCompetenceDetails_deprecated($competence_id, $hash)
{
    $objResponse = new xajaxResponse();
    if (is_numeric($competence_id) && ThreesixtyService::isHashIdValid($hash)) {
        $competence_id = intval($competence_id);

        $evaluationHelper = EvaluationHelper::createHelperObject($hash);
        if ($evaluationHelper->hasValidHashInfo()) {

            $sql = 'SELECT
                        knowledge_skill_point
                    FROM
                        knowledge_skills_points
                    WHERE
                        customer_id = ' . $evaluationHelper->customer_id . '
                        AND ID_KSP = ' . $competence_id . '
                    LIMIT 1';
            $competenceInfoResult = BaseQueries::performQuery($sql);
            $competenceInfo = @mysql_fetch_assoc($competenceInfoResult);

            $objResponse->assign('competencedetail' . $competence_id, 'innerHTML', '');
            $objResponse->assign('click_competence_detail' . $competence_id, 'innerHTML', '<a href="" id="link_score_' . $competence_id . '"  onclick="xajax_module360Evaluation_showCompetenceDetails_deprecated(' . $competence_id . ',\'' . $hash . '\');return false;">' . $competenceInfo['knowledge_skill_point'] . '</a>');
        }
    }

    return $objResponse;
}

?>
