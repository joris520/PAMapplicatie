<?php

/**
 * Description of EvaluationHelper
 *
 * @author ben.dokter
 */

require_once('gino/BaseQueries.class.php');
require_once('gino/MysqlUtils.class.php');

class EvaluationHelper {

    public $hash;
    public $customer_id;
    public $language_id;
    public $employee_id;
    public $persondata_id;
    public $function_id;
    public $competences;
    public $was_completed;
    public $is_deprecated;
    public $is_self_evaluation;
    public $is_external_email;

    public $employeeInfo    = array();
    public $functionInfo    = array();
    public $evaluatorInfo   = array();
    public $competencesInfo = array();

    // competences details
    public $has_YN_questions    = false;
    public $has_1_5_questions   = false;
    public $has_key_competences = false;

    public $logo;
    // customeroptions
    public $show_category_header;
    public $show_job_profile;
    public $show_department;
    public $show_main_competence;
    public $show_remarks;
    public $show_competence_details;


    // factory methode

    static function createHelperObject($hash)
    {
        $evaluationHelper = NULL;
        $hash_info = EvaluationHelper::getInvitationInfoForHash($hash);
        if (!empty($hash_info)) {
            $evaluationHelper = new EvaluationHelper($hash, $hash_info);
        }
        return $evaluationHelper;
    }

    function __construct($hash, $hash_info)
    {
        $this->hash = $hash;
        $this->customer_id        = $hash_info['customer_id'];
        $this->language_id        = $hash_info['lang_id'];
        $this->employee_id        = $hash_info['id_e'];
        $this->persondata_id      = $hash_info['id_pd'];
        $this->function_id        = $hash_info['id_f'];
        $this->competences        = $hash_info['competences'];
        $this->was_completed      = !($hash_info['completed'] == AssessmentInvitationCompletedValue::NOT_COMPLETED);
        $this->is_deprecated      = !($hash_info['threesixty_scores_status'] == AssessmentInvitationStatusValue::CURRENT &&
                                    $hash_info['deprecated'] == 0);
        $this->is_self_evaluation = $hash_info['is_self_evaluation'] == AssessmentInvitationTypeValue::IS_SELF_EVALUATION;
        $this->is_external_email  = $hash_info['ID_EC'] == ID_EC_EXTERNAL;
        $this->invitation_date    = $hash_info['invitation_date'];
    }

    function hasValidHashInfo()
    {
        return ( !(empty($this->employee_id) ||
                   empty($this->function_id) ||
                   empty($this->language_id) ||
                   empty($this->customer_id)) );
    }

    function setThreesixtyEnvironment()
    {
        define('CUSTOMER_ID', empty($this->customer_id) ? 'no_customer_id' : $this->customer_id);
        if (!empty($this->customer_id)) {
            ModuleUtils::DefineScales(CUSTOMER_ID);
        }
        define('LANG_ID',  empty($this->language_id) ? DEFAULT_LANG_ID : $this->language_id);

        $this->fetchEmployeeInfo();
        $this->fetchFunctionInfo();
        $this->fetchPersonDataInfo();
        $this->fetchCompetencesInfo();
    }

    function getInvitationInfoForHash($hash)
    {
        $hash_info = NULL;
        $sql = 'SELECT
                    ti.*,
                    pd.ID_EC,
                    c.lang_id,
                    CASE WHEN DATEDIFF(CURRENT_DATE, ti.invitation_date) < co.selfassessment_validity_period
                        THEN 0
                        ELSE 1
                    END as deprecated
                FROM
                    threesixty_invitations ti
                    INNER JOIN person_data pd
                        ON ti.id_pd = pd.ID_PD
                    INNER JOIN customers c
                        ON c.customer_id = ti.customer_id
                    INNER JOIN customers_options co
                        ON co.customer_id = ti.customer_id
                WHERE
                    ti.hash_id = "' . mysql_real_escape_string($hash) . '"
                LIMIT 1';

        $queryResult = BaseQueries::performSelectQuery($sql);

        if (@mysql_num_rows($queryResult) == 1) {
            $hash_info = mysql_fetch_assoc($queryResult);
        }
        return $hash_info;
    }

    function fetchEmployeeInfo()
    {
        $sql = 'SELECT
                    e.firstname,
                    e.lastname,
                    d.department,
                    f.function,
                    c.logo,
                    c.company_name,
                    c.customer_id,
                    c.email_address AS customer_email,
                    co.show_360_eval_category_header,
                    co.show_360_eval_job_profile,
                    co.show_360_eval_department,
                    co.use_cluster_main_competence,
                    co.use_skill_notes,
                    co.show_360_competence_details
                FROM
                    employees e
                    INNER JOIN department d
                        ON d.ID_DEPT = e.ID_DEPTID
                    INNER JOIN functions f
                        ON f.ID_F = e.ID_FID
                    INNER JOIN customers c
                        ON c.customer_id = e.customer_id
                    INNER JOIN customers_options co
                        ON co.customer_id = c.customer_id
                WHERE
                    e.customer_id = ' . CUSTOMER_ID . '
                    AND e.ID_E = ' . $this->employee_id;

        $employeeInfoResult  = BaseQueries::performSelectQuery($sql);
        $this->employeeInfo  = @mysql_fetch_assoc($employeeInfoResult);

        $this->logo                     = $this->employeeInfo['logo'];
        // customer options instellen
        $this->show_category_header     = $this->employeeInfo['show_360_eval_category_header'] == 1;
        $this->show_job_profile         = $this->employeeInfo['show_360_eval_job_profile'] == 1;
        $this->show_department          = $this->employeeInfo['show_360_eval_department'] == 1;
        $this->show_main_competence     = $this->employeeInfo['use_cluster_main_competence'] == 1;
        $this->show_remarks             = $this->employeeInfo['use_skill_notes'];
        $this->show_competence_details  = $this->employeeInfo['show_360_competence_details'];

    }

    function fetchFunctionInfo()
    {
        $sql = 'SELECT
                    f.function
                FROM
                    functions f
                WHERE
                    f.customer_id = ' . CUSTOMER_ID . '
                    AND f.ID_F = ' . $this->function_id;

        $functionInfoResult = BaseQueries::performSelectQuery($sql);
        $this->functionInfo = @mysql_fetch_assoc($functionInfoResult);
    }

    function fetchPersonDataInfo()
    {
        $sql = 'SELECT
                    pd.*
                FROM
                    person_data pd
                WHERE
                    pd.customer_id = ' . CUSTOMER_ID . '
                    AND pd.ID_PD = ' . $this->persondata_id;

        $evaluatorInfoResult  = BaseQueries::performSelectQuery($sql);
        $this->evaluatorInfo = @mysql_fetch_assoc($evaluatorInfoResult);

    }

    function fetchCompetencesInfo()
    {
        $this->competencesInfo = array();
        if (!empty($this->competences)) {
            $sql = 'SELECT
                        fp.ID_FP,
                        fp.scale as fp_scale,
                        fp.ID_F,
                        fp.ID_KSP,
                        ksp.is_key,
                        ksp.ID_KSP,
                        ksp.ID_KS,
                        ksp.knowledge_skill_point,
                        ksp.scale as ksp_scale,
                        ksp.is_na_allowed,
                        ksp.is_cluster_main,
                        CASE
                            WHEN ksc.cluster is null
                            THEN "&mdash;"
                            ELSE ksc.cluster
                        END AS cluster,
                        ks.knowledge_skill as category
                    FROM
                        function_points fp
                        JOIN knowledge_skills_points ksp ON ksp.ID_KSP = fp.ID_KSP
                        LEFT JOIN knowledge_skill ks          ON ksp.ID_KS = ks.ID_KS
                        LEFT JOIN knowledge_skill_cluster ksc ON ksp.ID_C  = ksc.ID_C
                    WHERE
                        fp.customer_id = ' . CUSTOMER_ID . '
                        AND fp.ID_F = ' . $this->function_id . '
                        AND ksp.ID_KSP IN (' . $this->competences . ')
                    GROUP BY
                        ksp.ID_KSP
                    ORDER BY
                        ks.knowledge_skill,
                        CASE
                            WHEN ksc.cluster is null
                            THEN "zzz"
                            ELSE ksc.cluster
                        END,
                        ksp.is_cluster_main DESC,
                        ksp.knowledge_skill_point';

            $competencesInfoResult  = BaseQueries::performSelectQuery($sql);
            // TODO: anders
            $this->competencesInfo = MysqlUtils::result2Array2D($competencesInfoResult);
        }

        $this->has_YN_questions = false;
        $this->has_1_5_questions = false;
        $this->has_key_competences = false;
        foreach($this->competencesInfo as $competence) {
            if ($competence['ksp_scale'] == ScaleValue::SCALE_Y_N) {
                $this->has_YN_questions = true;
            }
            if ($competence['ksp_scale'] == ScaleValue::SCALE_1_5) {
                $this->has_1_5_questions = true;
            }
            if ($competence['is_key'] == 1) {
                $this->has_key_competences = true;
            }
        }
    }
}

?>
