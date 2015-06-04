<?php

define('REPORT_YES', TXT_UCF('YES'));
define('REPORT_NO', TXT_UCF('NO'));

class OrganisationSelfassessmentReportService
{
    // return array with values for function profile
    static function createEvaluationReport($id_f, $function_name)
    {
        $competences_count = self::getFunctionCompetencesCount($id_f);
        $report = self::getHeader($competences_count);
        $report .= "\r\n";

        $sql = 'SELECT
                    e1.*,
                    e2.employee as boss_name,
                    e2.email_address as boss_email,
                    d.department
                FROM
                    employees e1
                    INNER JOIN department d
                        ON e1.ID_DEPTID = d.ID_DEPT
                    LEFT JOIN employees e2
                        ON e1.boss_fid = e2.ID_E
                WHERE
                    e1.customer_id = ' . CUSTOMER_ID . '
                    AND e1.ID_FID = '. $id_f . '
                    AND e1.is_inactive = 0
                ORDER BY
                    e1.lastname, e1.firstname';
        $employeeQuery = BaseQueries::performQuery($sql);

        while ($employee = @mysql_fetch_assoc($employeeQuery)) {
            $report .= self::getEmployeeLine($employee, $function_name, $competences_count);
            $report .= "\r\n";
        }
        return $report;
    }

    static function createEvaluationReportAllJobProfiles()
    {
        $report = self::getHeader(SHOW_NO_SCORES_FOR_COMPETENCES);
        $report .= "\r\n";

        $sql = 'SELECT
                    e1.*,
                    e2.employee as boss_name,
                    e2.email_address as boss_email,
                    d.department,
                    IF(f.function IS NULL, "-", f.function) AS function
                FROM
                    employees e1
                    INNER JOIN department d
                        ON e1.ID_DEPTID = d.ID_DEPT
                    LEFT JOIN functions f
                        ON f.ID_F = e1.ID_FID
                    LEFT JOIN employees e2
                        ON e1.boss_fid = e2.ID_E
                WHERE
                    e1.customer_id = ' . CUSTOMER_ID . '
                    AND e1.is_inactive = 0
                ORDER BY
                    e1.lastname, e1.firstname';
        $employeeQuery = BaseQueries::performQuery($sql);

        while ($employee = @mysql_fetch_assoc($employeeQuery)) {
            $report .= self::getEmployeeLine($employee, $employee['function'], SHOW_NO_SCORES_FOR_COMPETENCES);
            $report .= "\r\n";
        }
        return $report;
    }

    private static function getFunctionCompetencesCount($id_f)
    {
        $sql = 'SELECT
                    count(distinct(ksp.id_ksp)) as ksp_count
                FROM
                    function_points fp
                    INNER JOIN knowledge_skills_points ksp
                        ON fp.ID_KSP = ksp.ID_KSP
                WHERE
                    fp.customer_id = ' . CUSTOMER_ID . '
                    AND fp.id_f = ' . $id_f;
        $competenceCountQuery = BaseQueries::performQuery($sql);

        $competences_count_res = @mysql_fetch_assoc($competenceCountQuery);
        return $competences_count_res['ksp_count'];
    }



    private static function getHeader($competences_count)
    {
        // het aantal competenties ophalen
        $header = '"' . TXT_UCF('BOSS') . '";'.
                  '"' . TXT_UCF('EMAIL_BOSS') . '";'.
                  '"' . TXT_UCF('EMPLOYEE') . '";'.
                  '"' . TXT_UCF('DATE_OF_BIRTH') . '";'.
                  '"' . TXT_UCF('GENDER') . '";'.
                  '"' . TXT_UCF('EMAIL_EMPLOYEE') . '";'.
                  '"' . TXT_UCF('TELEPHONE_NUMBER') . '";'.
                  '"' . TXT_UCF('STREET') . '";'.
                  '"' . TXT_UCF('ZIP_CODE') . '";'.
                  '"' . TXT_UCF('CITY') . '";'.
                  '"' . TXT_UCF('DEPARTMENT') . '";'.
                  '"' . TXT_UCF('MAIN_JOB_PROFILE') . '";'.
                  '"' . TXT_UCF('INVITED') . '";'.
                  '"' . TXT_UCF(CUSTOMER_MGR_SCORE_LABEL) . ' ' .  TXT_LC('COMPLETED') . '";'.
                  '"' . TXT_UCF(CUSTOMER_360_SCORE_LABEL) . ' ' . TXT_LC('COMPLETED') . '";';
          for ($i = 1; $i <= $competences_count; $i++) {
              $header .= '"' . sprintf(TXT_UCF(CUSTOMER_MGR_SCORE_LABEL) .' %02d', $i) . '";';
          }
          for ($i = 1; $i <= $competences_count; $i++) {
              $header .= '"' . sprintf(TXT_UCF(CUSTOMER_360_SCORE_LABEL) . ' %02d', $i) . '";';
          }

        return $header;
    }


    /**
     *
     * @param string $employee: bevat een employees record
     * @param <type> $function_name
     * @return string
     */
    private static function getEmployeeLine($employee, $function_name, $competences_count)
    {
        // converteren
        $gender = TXT_UCF(strtoupper($employee['sex']));

        $employeeLine =
            '"' . $employee['boss_name'] . '";'.
            '"' . $employee['boss_email'] . '";'.
            '"' . ModuleUtils::EmployeeName($employee['firstname'], $employee['lastname']) . '";'.
            '"' . $employee['birthdate'] . '";'.
            '"' . $gender . '";'.
            '"' . $employee['email_address'] . '";'.
            '"' . $employee['phone_number'] . '";'.
            '"' . $employee['address'] . '";'.
            '"' . $employee['postal_code'] . '";'.
            '"' . $employee['city'] . '";'.
            '"' . $employee['department'] . '";'.
            '"' . $function_name . '";';


        $id_e = $employee['ID_E'];
        $id_f = $employee['ID_FID'];

        // opzoeken scores
        $sql = 'SELECT
                    DISTINCT(ksp.id_ksp),
                    CASE WHEN ep.scale IS null
                              OR ep.scale = ""
                         THEN 0
                         ELSE ep.scale
                    END as boss_score
                FROM
                    functions f
                    INNER JOIN function_points fp
                        ON f.id_f = fp.id_f
                    INNER JOIN knowledge_skills_points ksp
                        ON fp.ID_KSP = ksp.ID_KSP
                    LEFT JOIN employees_points ep
                        ON ep.ID_KSP = ksp.ID_KSP
                WHERE
                    f.customer_id = ' . CUSTOMER_ID . '
                    AND f.id_f = ' . $id_f . '
                    AND ep.ID_E = ' . $id_e . '
                ORDER BY
                    ksp.knowledge_skill_point';
        $competencesBossScoreQuery = BaseQueries::performQuery($sql);

        $bossScoreLine = '';
        $bossFilled = @mysql_num_rows($competencesBossScoreQuery) > 0 ? REPORT_YES : REPORT_NO;
        if (@mysql_num_rows($competencesBossScoreQuery) == $competences_count) {
            while ($competences_boss_score = @mysql_fetch_assoc($competencesBossScoreQuery)) {
                $bossScoreLine .= $competences_boss_score['boss_score'] . ';';
            }
        } else {
            for ($i = 1; $i <= $competences_count; $i++) {
                $bossScoreLine .= '0;';
            }
        }

        $sql = 'SELECT
                    hash_id,
                    invitation_date,
                    completed,
                    competences
                FROM
                    threesixty_invitations
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND id_e = ' . $id_e . '
                    AND id_f = ' . $id_f . '
                    AND is_self_evaluation = ' . AssessmentInvitationTypeValue::IS_SELF_EVALUATION;
        $invitation360Query = BaseQueries::performQuery($sql);

        if (@mysql_num_rows($invitation360Query) > 0) {
            $invitation_360 = @mysql_fetch_assoc($invitation360Query);
            $invitedFilled = $invitation_360['invitation_date'] > 0 ? REPORT_YES : REPORT_NO;
            $hash_id = $invitation_360['hash_id']; // voor ophalen ingevulde scores
            $completed = $invitation_360['completed'];
            $empFilled = REPORT_NO;
            if ($completed == AssessmentInvitationCompletedValue::COMPLETED) {
                $empFilled = REPORT_YES;
                $sql = 'SELECT
                            te.threesixty_score
                        FROM
                            threesixty_evaluation te
                            INNER JOIN knowledge_skills_points ksp
                                ON te.ID_KSP = ksp.ID_KSP
                        WHERE
                            te.customer_id = ' . CUSTOMER_ID . '
                            AND te.hash_id = "' . $hash_id . '"
                            AND te.ID_E = ' . $id_e . '
                        ORDER BY
                            ksp.knowledge_skill_point';
                $competences360ScoreQuery = BaseQueries::performQuery($sql);

                $empScoreLine = '';
                if (@mysql_num_rows($competences360ScoreQuery) == $competences_count) {
                    while ($competences_360_score = @mysql_fetch_assoc($competences360ScoreQuery)) {
                        $empScoreLine .= $competences_360_score['threesixty_score'] . ';';
                    }
                }
            }

        } else {
            $invitedFilled = REPORT_NO;
            $empFilled = REPORT_NO;
        }

        if ($empFilled == REPORT_NO) {
            $empScoreLine = '';
            for ($i = 1; $i <= $competences_count; $i++) {
              $empScoreLine .= '0;';
            }
        }

        // regel verder aanvullen
        $employeeLine .= '"' . $invitedFilled .'";' .
                         '"' . $bossFilled . '";' .
                         '"' . $empFilled . '";' .
                         $bossScoreLine .
                         $empScoreLine;


        return $employeeLine;
    }
}
?>
