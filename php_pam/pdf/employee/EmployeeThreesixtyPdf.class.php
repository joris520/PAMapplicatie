<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once('pdf/pdf_config.inc.php');
require_once('pdf/objects/common/pdfUtils.inc.php');
require_once('pdf/objects/print_threesixty_table.php');

/**
 * Description of employeeThreesixty
 *
 * @author wouter.storteboom
 */
class EmployeeThreesixtyPdf {

    static function printThreesixty ($pdf, $id_e)
    {
        $customer_id = CUSTOMER_ID;
        $pdf->EmployeePageType(PdfEmployeeTable::PAGETYPE_THREESIXTY);
        $pdf->PageTitle('360');
        $pdf->PageHeaderData($pdf->FillHeader($id_e));


        $header_widths = array(54, 35, 85, 20);
        $header_titles = array(TXT_UCF('EVALUATOR'),  // 408
                               TXT_UCF('DATE_SENT'),    // 409
                               TXT_UCF('COMPETENCE'), // 45
                               ModuleUtils::Abbreviate(TXT_UCF(CUSTOMER_360_SCORE_LABEL), 5, '.')   // 'SCORE'
                              );

        if (CUSTOMER_OPTION_USE_SKILL_NOTES) {
            $header_widths[] = 55;
            $header_titles[] = TXT_UCF('REMARKS');
        }

        $pdf->DataHeaderValues($header_widths, $header_titles);

        $pdf->AddPage('L');

        if (!empty($id_e)) {


            $deg_q = '
                SELECT
                    ti.completed,
                    ksp.knowledge_skill_point,
                    te.ID_TSE,
                    te.hash_id,
                    te.date_sentback,
                    te.evaluator,
                    te.threesixty_score,
                    te.notes,
                    et.score_status,
                    ti.is_self_evaluation,
                    ti.threesixty_scores_status
                FROM
                    threesixty_evaluation te
                    INNER JOIN threesixty_invitations ti
                        ON ti.hash_id = te.hash_id
                    INNER JOIN employees e
                        ON e.ID_E = te.ID_E
                    INNER JOIN employees_topics et
                        ON e.ID_E = et.ID_E
                    INNER JOIN knowledge_skills_points ksp
                        ON ksp.ID_KSP = te.ID_KSP
                WHERE
                    te.ID_E = ' . $id_e . '
                    AND te.customer_id = ' . $customer_id . '
                    AND ti.completed <> ' . AssessmentInvitationCompletedValue::NOT_COMPLETED . '
                ORDER BY
                    te.date_sentback DESC,
                    te.evaluator,
                    ti.hash_id,
                    ksp.knowledge_skill_point';

            $deg = PdfUtils::getData($deg_q, true);

            $pdf->SetFont('Arial', '', 8);
            if ($deg) {
                foreach ($deg as $e) {
                    $is_deleted =  $e['completed'] == AssessmentInvitationCompletedValue::RESULT_DELETED;
                    $is_self_evaluation = $e['is_self_evaluation'] == AssessmentInvitationTypeValue::IS_SELF_EVALUATION;
                    $is_actual_evaluation = $e['threesixty_scores_status'] < AssessmentInvitationStatusValue::HISTORICAL;

                    // TODO: deze is fout want kijkt nog naar employees_topics !!
                    $is_score_display_allowed = (CUSTOMER_OPTION_USE_SELFASSESSMENT && $is_self_evaluation && $is_actual_evaluation) ? ($e['score_status'] == ScoreStatusValue::FINALIZED) : true;

                    $remarks = nl2br($e['notes']);

                    // omdat de $is_score_display_allowed niet goed werkt mag alleen de HR/admin de tab inzien (zie module_access tabel).
                    // daarom mag de score altijd getoond worden
                    $employeeScoreDisplay = $is_deleted ? 'X' : ModuleUtils::ScorepointLetter($e['threesixty_score']);
                    $employeeNoteDisplay =  $is_deleted ? 'X' : $remarks ;
//                    $employeeScoreDisplay = $is_deleted ? 'X' : ($is_score_display_allowed ? ModuleUtils::ScorepointLetter($e['threesixty_score']) : '!');
//                    $employeeNoteDisplay =  $is_deleted ? 'X' : ($is_score_display_allowed ? $remarks : '');

                    $oldEvaluator = $NewEvaluator;
                    $NewEvaluator = $e[evaluator];
                    $oldSentback = $NewSentback;
                    $NewSentback = $e['date_sentback'];
                    $evaluator = $NewEvaluator <> $oldEvaluator ? $NewEvaluator : '';

                    $shaded = ($NewEvaluator <> $oldEvaluator) || ($NewSentback <> $oldSentback) ? 1 : '';
                    $notes_shading = $NewEvaluator <> $oldEvaluator ? '[x]' : '';

                    // wel tonen bij andere evaluator met dezelfde datum
                    $sentBackLabel = $NewSentback <> $oldSentback ? date("d-m-Y", strtotime($NewSentback)) : ($NewEvaluator <> $oldEvaluator ? date("d-m-Y", strtotime($NewSentback)) : '');

                    $row_widths = array(54, 35.5, 88, 15);
                    $row_values = array($evaluator, $sentBackLabel, $e['knowledge_skill_point'], $employeeScoreDisplay);
                    if (CUSTOMER_OPTION_USE_SKILL_NOTES) {
                        $row_widths[] = 80;
                        $row_values[] = $employeeNoteDisplay . '[-]' . $notes_shading;
                    }

                    $pdf->SetWidths($row_widths);
                    $pdf->RowT('', $shaded, $row_values);
                    $pdf->Ln(1);
                }
            }
        }
    }
}

?>
