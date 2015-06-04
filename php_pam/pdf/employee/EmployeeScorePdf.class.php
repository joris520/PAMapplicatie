<?php
require_once('pdf/objects/common/pdfUtils.inc.php');
require_once('pdf/objects/common/pdfConsts.inc.php');
require_once('modules/model/service/to_refactor/ScoreQuestionsService.class.php');
require_once('modules/model/service/to_refactor/PdpActionSkillServiceDeprecated.class.php');

require_once('pdf/objects/employee/print_employees_table.php');
require_once('pdf/employee/EmployeeActionFormPdf.class.php');

require_once('modules/model/service/library/AssessmentCycleService.class.php');
require_once('modules/model/service/employee/competence/EmployeeAssessmentService.class.php');
require_once('modules/model/service/employee/competence/EmployeeCompetenceService.class.php');

require_once('application/interface/converter/DateConverter.class.php');
require_once('modules/interface/converter/employee/competence/ScoreStatusConverter.class.php');
require_once('modules/interface/converter/library/competence/ScoreConverter.class.php');
require_once('modules/interface/converter/library/competence/NormConverter.class.php');

class EmployeeScorePdf
{

    const NOTE_TITLE_WIDTH = 0;
    const NOTE_WIDTH = 210;
    const PAGE_WIDTH = 277;

    static function printScore( PdfEmployeeTable $pdf,
                                $employeeId,
                                $rating,
                                $showThreeSixty,
                                $showPdpAction,
                                $showRemarks,
                                $isInvited,
                                EmployeeCompetenceCategoryClusterScoreCollection $employeeCategoryScoreCollection = NULL,
                                EmployeeAnswerCollection $employeeAnswerCollection = NULL)
    {

        // score pagina aanmaken
        $pdf->EmployeePageType(PdfEmployeeTable::PAGETYPE_SCORE);
        $pdf->PageTitle(TXT_UCF('EVALUATION_FORM')); //296
        $pdf->fillDataHeaderScore(  $showThreeSixty,
                                    CUSTOMER_OPTION_SHOW_NORM,
                                    (CUSTOMER_OPTION_SHOW_ACTIONS  && (PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_PDP_ACTIONS))),
                                    FALSE );
        $pdf->ActivatePrintHeader();
        $pdf->ActivatePrintHeaderOnNewPage();
        $pdf->ActivateDataHeader();

        // fillHeader controleert zelf op valide employeeId
        $pdf->PageHeaderData($pdf->FillHeader($employeeId, ($rating == RATING_FUNCTION_PROFILE) ? 1 : 0));  // bij rating = 2 (functieprofiel) deze in header tonen
        $pdf->AddPage('L');
        $pdf->ActivatePrintFooter();

        if (!empty($employeeId) && !empty($employeeCategoryScoreCollection)) {

            $hasAdditionalFunctions = false;
            $hasKeyCompetences = false;

            $scoreStatusValue   = $employeeCategoryScoreCollection->getScoreStatusValue();
            $isAllowedViewCurrentScore          = EmployeeCompetenceService::isAllowedViewManagerScore($employeeId, $scoreStatusValue);
            $isAllowedViewCurrentEmployeeScore  = EmployeeCompetenceService::isAllowedViewEmployeeScore($employeeId, $scoreStatusValue);

            $showScoreDifference = CUSTOMER_OPTION_SHOW_360_DIFFERENCE && $isAllowedViewCurrentEmployeeScore && $isAllowedViewCurrentScore;
            $assessmentDate     = $employeeCategoryScoreCollection->getAssessmentDate();
            $categoryIds        = $employeeCategoryScoreCollection->getCategoryIds();


            // alleen zelfevaluatie scores tonen als score status definitief
            $allowedThreeSixtyScore = $showThreeSixty;
            if (CUSTOMER_OPTION_USE_SELFASSESSMENT) {
                $allowedThreeSixtyScore = $allowedThreeSixtyScore && $isAllowedViewCurrentEmployeeScore;
            }

            foreach($categoryIds as $categoryId) {

                $categoryName = $employeeCategoryScoreCollection->getCategoryName($categoryId);
                $pdf->SetFont('Arial', '', 9);
                $pdf->SetWidths(array(self::PAGE_WIDTH));
                $pdf->SetAligns(array('L'));
                if (CUSTOMER_OPTION_SHOW_KS) {
                    $pdf->SingleRow('', '1', array(CategoryConverter::display($categoryName)));
                    $pdf->Ln(3);
                }

                // alle clusters in de category ophalen
                $clusterCollections = $employeeCategoryScoreCollection->getCategoryClusters($categoryId);
                foreach($clusterCollections as $clusterCollection) {
                    // reset main competence want nieuw/volgend cluster
                    $competencePrefix = '';
                    $rowBackground = '';
                    $isFirst = true;

                    $clusterName = $clusterCollection->getClusterName();

                    // alle competentie scores in het cluster ophalen
                    $scoreCollections = $clusterCollection->getEmployeeScoreCollections();
                    foreach($scoreCollections as $scoreCollection) {

                        $employeeCompetenceValueObject   = $scoreCollection->getCompetenceValueObject();
                        $scoreValueObject                = $scoreCollection->getScoreValueObject();
                        $selfAssessmentScoreValueObject  = $scoreCollection->getSelfAssessmentScoreValueObject();

                        // waarden ophalen
                        $score                  = $scoreValueObject->getScore();
                        $scoreNote              = $isAllowedViewCurrentScore ? $scoreValueObject->getNote() : NULL;
                        $selfAssessmentScore    = $allowedThreeSixtyScore ? $selfAssessmentScoreValueObject->getScore() : NULL;
                        $selfAssessmentNote     = $allowedThreeSixtyScore ? $selfAssessmentScoreValueObject->getNote() : NULL;

                        $competenceName     = $employeeCompetenceValueObject->getCompetenceName();
                        $competenceNorm     = $employeeCompetenceValueObject->getCompetenceFunctionNorm();

                        // display stuff toevoegen
                        //$displayScore               = ScoreConverter::scoreText($score);
                        $displayScore               = ScoreConverter::employeeScoreText($score, $isAllowedViewCurrentScore);
                        //$displaySelfAssessmentScore = ScoreConverter::employeeScoreText($selfAssessmentScore, $allowedThreeSixtyScore);
                        $displaySelfAssessmentScore = $isInvited ? ScoreConverter::employeeScoreText($selfAssessmentScore, $allowedThreeSixtyScore) : '-';
                        $displayNorm                = NormConverter::scoreText( $competenceNorm);

                        if ($employeeCompetenceValueObject->getCompetenceIsKey()) {
                            $keySymbol = '*';
                            $hasKeyCompetences = true;
                        } else {
                            $keySymbol = '';
                        }

                        if ($employeeCompetenceValueObject->getCompetenceFunctionIsMain()) {
                            $additionalSymbol = '';
                        } else {
                            $additionalSymbol = '#';
                            $hasAdditionalFunctions = true;
                        }

                        if ($isFirst) {
                            $isFirst = false;
                            $clusterHasMainCompetence = $employeeCompetenceValueObject->getCompetenceIsMain() == COMPETENCE_CLUSTER_IS_MAIN;

                            // hoofdcompetentie aangeven
                            if (CUSTOMER_OPTION_USE_CLUSTER_MAIN_COMPETENCE) {
                                if ($clusterHasMainCompetence) {
                                    $competencePrefix = '    '; //KSP_INDENT;
                                    $rowBackground = '1';
                                } else {
                                    $competenceName = $competencePrefix . $competenceName;
                                }
                            }
                        } else {
                            $clusterName = '';
                        }

                        $pdf->SetFont('Arial', '', 9);

                        $categoryWidth      = 5;//CUSTOMER_OPTION_SHOW_KS ? 25 : 2;
                        $competenceWidth    = 75;// - $categoryWidth;

                        $rowWidths = array($categoryWidth, 52, $competenceWidth, 10, 10, 10, 14);
                        $rowAligns = array('L',            'L','L'              ,'C','C','C','C');//,'C','C','C','L');
                        $rowValues = array('[-]',
                                            $clusterName . '[-]',
                                            $keySymbol . '' . $competenceName . '' . $additionalSymbol . '[-]',
                                            '',
                                            '',
                                            '',
                                            '' . $displayScore . '[-]');
                        if ($showThreeSixty) {
                            //$noteWidth -= 14;
                            $rowWidths[] = 14;
                            $rowAligns[] = 'C';
                            $displaySelfAssessmentScore = $displaySelfAssessmentScore . '[-]';
                            if ($showScoreDifference && !empty($selfAssessmentScore) && $score != $selfAssessmentScore) {
                                $displaySelfAssessmentScore .= '[x]';
                            }
                            $rowValues[] = $displaySelfAssessmentScore;

                        }
                        if (CUSTOMER_OPTION_SHOW_NORM) {
                            //$noteWidth -= 12;
                            $rowWidths[] = 12;
                            $rowAligns[] = 'C';
                            $rowValues[] = $displayNorm . '[-]';
                        }
                        if (CUSTOMER_OPTION_SHOW_ACTIONS && PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_PDP_ACTIONS)) {
                            //$noteWidth -= 13;
                            $rowWidths[] = 13;
                            $rowAligns[] = 'C';
                            $rowValues[] = $actions_count . '[-]';
                        }
                        if (!CUSTOMER_OPTION_SHOW_KS) {
                            //$noteWidth += 23;
                        }

                        $pdf->SetWidths($rowWidths);
                        $pdf->SetAligns($rowAligns);
                        $pdf->RowT('1', $competenceBackground, $rowValues);
                        $pdf->Ln(1);

                        if (CUSTOMER_OPTION_USE_SKILL_NOTES && $showRemarks && !empty($scoreNote)) {
                            self::printRemark($pdf, TXT_UCF('MANAGER_REMARKS'), $scoreNote);
//                            $gap_width = self::PAGE_WIDTH - self::NOTE_WIDTH;
//
//                            $pdf->SetWidths(array($gap_width, self::NOTE_WIDTH));
//                            $pdf->SetAligns(array('R', 'L'));
//                            $pdf->SetFont('Arial', 'B', 9);
//                            $pdf->RowT('1', $rowBackground, array('[-]', TXT_UCF('MANAGER_REMARKS') . '[-]'));
//                            $pdf->SetFont('Arial', '', 9);
//                            $pdf->RowT('1', $rowBackground, array('[-]', $scoreNote . '[-]'));
//                            $white_width = 80;
//                            $stripe_width = 285 - $white_width;
//                            $pdf->SetTextColorHex(COLOR_GRAY);
//                            $pdf->SetFont('Arial', 'B', 8.5);
//                            $pdf->Cell(0, 4, str_repeat(' ', $white_width) . str_repeat('¯', $stripe_width));
//                            $pdf->SetTextColorHex(COLOR_BLACK);
//                            $pdf->SetFont('Arial', '', 9);
//                            $pdf->Ln(3);
                        }


                        // ?? dit gaat nu toch al automatisch?
                        if ($pdf->GetY() > 175) {
                            $pdf->AddPage('L');

                        }

                        if ($showThreeSixty && $showRemarks && CUSTOMER_OPTION_SHOW_360_REMARKS) {

                            if (!empty($selfAssessmentNote)) {
                                self::printRemark($pdf, TXT_UCF('EMPLOYEE_REMARKS'), $selfAssessmentNote);
//                                $gap_width = self::PAGE_WIDTH - self::NOTE_WIDTH;
//                                $pdf->SetWidths(array($gap_width, self::NOTE_WIDTH));
//                                $pdf->SetAligns(array('R', 'L'));
//                                $pdf->RowT('1', $rowBackground, array('[-]', TXT_UCF('EMPLOYEE_REMARKS') . ':' . "\n" . $selfAssessmentNote));
//                                $pdf->Ln(2);
                            }

                            if ($pdf->GetY() > 175) {
                                $pdf->AddPage('L');
                            }
                        }

                    }
                }
                $pdf->Ln(2);
            }

            $pdf->Ln(2);

            // legenda voor score
            $legenda =  '  [1] ' . SCALE_NONE .
                        '  [2] ' . SCALE_BASIC .
                        '  [3] ' . SCALE_AVERAGE .
                        '  [4] ' . SCALE_GOOD .
                        '  [5] ' . SCALE_SPECIALIST;
            $pdf->SetWidths(array(210, 70));
            $pdf->SingleRow('', '', array(TXT_UCF('SCALE') . ':'. $legenda ));

            // uitzetten dataheader op evt nieuwe pagina's
            $pdf->ActivateDataHeader(0);
            if ($rating == RATING_FUNCTION_PROFILE) {
                $pdf->SetWidths(array(210, 70));
                if ($hasAdditionalFunctions) {
                    $jobProfileValueObject = $employeeCategoryScoreCollection->getJobProfileValueObject();
                    $additionalFunctionNames = $jobProfileValueObject->getAdditionalFunctionNames();
                    $neven_functies = implode(', ' ,$additionalFunctionNames);
                    $pdf->SingleRow('', '', array('# = ' . TXT_UCF('ADDITIONAL_JOB_PROFILES') . ': ' . $neven_functies));
                }
            }

            if ($hasKeyCompetences) {
                $pdf->SetWidths(array(210, 70));
                $pdf->SingleRow('', '', array('* = ' .TXT_UCF('KEY_COMPETENCE'), ''));
                $pdf->SingleRow('', '', array('', ''));
            }

            // hbd: Hier de extra open vragen toevoegen
            $employeeAnswerValueObjects = $employeeAnswerCollection->getValueObjects();
            //die('$employeeAnswerValueObjects'.print_r($employeeAnswerValueObjects,true));
            foreach($employeeAnswerValueObjects as $employeeAnswerValueObject) {
                $pdf->Ln(1);
                $assessmentQuestion = $employeeAnswerValueObject->getAssessmentQuestion();
                $employeeAnswer     = $employeeAnswerValueObject->getAnswer();
                if (empty($employeeAnswer)) {
                    $employeeAnswer = "\n".'[-]'; // bij lege opmerkingen veld ook geen kader tonen
                }

                $pdf->SetWidths(array(70, 209));
                $pdf->SetWidths(array(70, 210));
                $pdf->RowT('1', '', array($assessmentQuestion . ': [-]',
                                          $employeeAnswer));
            }
            // -- end open vragen

            $pdf->Ln(4);
            $pdf->SetWidths(array(69, 210));
            $date_display = DateConverter::display($assessmentDate);
            $status_display = ScoreStatusConverter::display($scoreStatusValue);
            $pdf->SingleRow('', '', array(TXT_UCF('CONVERSATION_DATE') . ': ', $date_display));
            $pdf->SingleRow('', '', array(TXT_UCF('SCORE_STATUS') . ': ', $status_display));
            // IF ACTION FORM SELECTED
            if ($showPdpAction) {
                // ophalen open acties...
                $sql = 'SELECT
                            epa.ID_PDPEA,
                            epa.action,
                            epa.end_date,
                            users.name
                        FROM
                            employees_pdp_actions epa
                            LEFT JOIN users on users.user_id = epa.ID_PDPTOID
                        WHERE
                            epa.ID_E = ' . $employeeId . '
                            AND is_completed = ' . PdpActionCompletedStatusValue::NOT_COMPLETED . '
                        ORDER BY epa.end_date desc';
                $employee_action_data = BaseQueries::performQuery($sql);

                $open_actions_array = array();
                while ($action_data = @mysql_fetch_assoc($employee_action_data)) {
                    $open_action = array();
                    $action_id = $action_data[ID_PDPEA];

                    $open_action[action] = $action_data[action];
                    $open_action[action_owner] = $action_data[name];
                    $open_action[deadline_date] = $action_data[end_date];

                    // opzoeken welke skills hierbij horen
                    $action_skills = PdpActionSkillServiceDeprecated::getSkillsByAction($employeeId, $action_id);
                    $skillsNames = '';
                    foreach((array)$action_skills as $action_skill) {
                        if (!empty($skillsNames)) $skillsNames .= ', ';
                        $skillsNames .= $action_skill[skill_name];
                    }
                    $open_action[comptetences] = $skillsNames;

                    $open_actions_array[] = $open_action;
                }

                EmployeeActionFormPdf::printActionForm($pdf, $employeeId, $question_answer_array, $open_actions_array);
            }
            $pdf->ActivateDataHeader(0);

        } else {
//            $pdf->HR('190', 'T');
//            $pdf->Ln(10);
//            $pdf->SetFont('Arial', '', 10);
//            $pdf->Cell(0, -10, TXT_UCF('NO_EMPLOYEES_RETURN'), 0, 0, 'L'); // 116
        }
    } // printScore


    private function printRemark(&$pdf, $remarkLabel, $remarkContent)
    {
        $gap_width = self::PAGE_WIDTH - self::NOTE_WIDTH;

        $pdf->SetWidths(array($gap_width, self::NOTE_WIDTH));
        $pdf->SetAligns(array('R', 'L'));
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->RowT('1', '', array('[-]', $remarkLabel . '[-]'));
        $pdf->SetFont('Arial', '', 9);
        $pdf->RowT('1', '', array('[-]', $remarkContent . '[-]'));
        $white_width = 80;
        $stripe_width = 285 - $white_width;
        $pdf->SetTextColorHex(COLOR_GRAY);
        $pdf->SetFont('Arial', 'B', 8.5);
        $pdf->Cell(0, 4, str_repeat(' ', $white_width) . str_repeat('¯', $stripe_width));
        $pdf->SetTextColorHex(COLOR_BLACK);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(3);
    }
} // class
?>
