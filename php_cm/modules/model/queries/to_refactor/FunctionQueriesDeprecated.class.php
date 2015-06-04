<?php

/**
 * Description of FunctionQueries
 *
 * @author ben.dokter
 */

require_once('gino/BaseQueries.class.php');
require_once('modules/model/queries/to_refactor/DataQueries.class.php');

class FunctionQueriesDeprecated extends DataQueries {

    static function getKnowledgeSkillPoint($knowledgeSkillPoint_id)
    {
        $sql = 'SELECT
                    *
                FROM
                    knowledge_skills_points
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_KSP = ' . $knowledgeSkillPoint_id;

        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }

    static function getKnowledgeSkill($knowledgeSkill_id)
    {
        $sql = 'SELECT
                    *
                FROM
                    knowledge_skill
                WHERE
                    ID_KS = ' . $knowledgeSkill_id;

        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }

    static function getKnowledgeSkillCluster($cluster_id)
    {
        $sql = 'SELECT
                    *
                FROM
                    knowledge_skill_cluster
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_C = ' . $cluster_id;

        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }

    static function getFunction($i_function_id = null)
    {
        $filter_function = empty($i_function_id) ? '' : ' AND f.ID_F = ' . $i_function_id . ' ';

        $sql = 'SELECT
                    f.*
                FROM
                    functions f
                WHERE
                    f.customer_id = ' . CUSTOMER_ID .
                    $filter_function . '
                GROUP BY
                    f.function
                ORDER BY
                    f.function';

        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }

    static function getFunctions($i_employee_id = null)
    {
        $filter_function = empty($i_employee_id) ? '' : ' INNER JOIN employees e ON e.ID_FID = f.ID_F AND e.ID_E = ' . $i_employee_id . ' ';

        $sql = 'SELECT
                    f.*
                FROM
                    functions f ' .
                    $filter_function . '
                WHERE
                    f.customer_id = ' . CUSTOMER_ID . '
                GROUP BY
                    f.function
                ORDER BY
                    f.function';

        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }

    static function getEditFunctionCompetences()
    {
        $sql = 'SELECT
                    ksp.*,
                    ks.knowledge_skill,
                    CASE
                        WHEN ksc.cluster is null
                        THEN "zzz"
                        ELSE ksc.cluster
                    END as cluster
                FROM
                    knowledge_skills_points ksp
                    LEFT JOIN knowledge_skill ks
                        ON ks.ID_KS = ksp.ID_KS
                    LEFT JOIN knowledge_skill_cluster ksc
                        on ksc.ID_C = ksp.ID_C
                WHERE
                    ksp.customer_id= ' . CUSTOMER_ID . '
                ORDER BY
                    ks.knowledge_skill,
                    cluster,
                    ksp.is_cluster_main DESC,
                    ksp.knowledge_skill_point';
        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }

    static function getCompetencesForFunction($i_function_id)
    {
        $sql = 'SELECT
                    ks.knowledge_skill,
                    CASE
                        WHEN ksc.cluster is null
                        THEN "zzz"
                        ELSE ksc.cluster
                    END AS cluster,
                    ksp.ID_KSP,
                    ksp.is_key,
                    ksp.knowledge_skill_point,
                    ksp.scale as ksp_scale,
                    ksp.is_cluster_main,
                    fp.key_com,
                    fp.ID_FP,
                    fp.scale,
                    fp.weight_factor,
                    fp.modified_by_user,
                    fp.modified_date,
                    fp.modified_time
                FROM
                    function_points fp
                    JOIN knowledge_skills_points ksp
                        ON fp.ID_KSP = ksp.ID_KSP
                    LEFT JOIN knowledge_skill ks
                        ON ks.ID_KS = ksp.ID_KS
                    LEFT JOIN knowledge_skill_cluster ksc
                        ON ksc.ID_C = ksp.ID_C
                WHERE
                        fp.ID_F = ' . $i_function_id . '
                        AND fp.customer_id= ' . CUSTOMER_ID . '
                GROUP BY
                    ksp.ID_KSP
                    ORDER BY
                    ks.knowledge_skill,
                    cluster,
                    ksp.is_cluster_main DESC,
                    ksp.knowledge_skill_point';

        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }

    public function getFunctionsBasedOnUserLevel($s_employee = null,
                                                 $ia_employee_id = null,
                                                 $ia_function_id = null,
                                                 $ia_department_id = null,
                                                 $b_is_boss = null,
                                                 $ia_boss_id = null,
                                                 $b_use_additional_job_profiles = true)
    {
        $filter_function_ids = '';
        if (!empty($ia_function_id)) {
            if (is_array($ia_function_id)) {
                $filter_function_ids = ' AND e.ID_FID IN (' . implode(',', $ia_function_id) . ')';
            } else {
                $filter_function_ids = ' AND e.ID_FID = ' . $ia_function_id;
            }
        }

        $filter_department_ids = '';
        if (!empty($ia_department_id)) {
            if (is_array($ia_department_id)) {
                $filter_department_ids = ' AND e.ID_DEPTID IN (' . implode(',', $ia_department_id) . ')';
            } else {
                $filter_department_ids = ' AND e.ID_DEPTID = ' . $ia_department_id;
            }
        }

        $additional_job_profiles_employees_sql = '';

        if (USER_LEVEL == UserLevelValue::CUSTOMER_ADMIN || USER_ALLOW_ACCESS_ALL_DEPARTMENTS) {
            $sql = '
                (
                SELECT
                    f.ID_F,
                    f.function
                FROM
                    functions f
                    LEFT JOIN employees e
                        ON (f.ID_F = e.ID_FID)
                WHERE
                    f.customer_id = ' . CUSTOMER_ID . '
                    ' . $filter_department_ids . '
                    ' . $filter_function_ids . '
                GROUP BY
                    f.ID_F,
                    f.function
                )
                ';
        } else {
            $employee_result = $this->getDataBasedOnUserLevel($s_employee,
                                                              $ia_employee_id,
                                                              $ia_function_id,
                                                              $ia_department_id,
                                                              $b_is_boss,
                                                              $ia_boss_id,
                                                              false,
                                                              null);

            $employees  = $this->getEmployeeIdsForResult($employee_result);


            if ($b_use_additional_job_profiles) {
                $additional_job_profiles_employees_sql .= ' AND eaf.id_e IN ('. implode(',', $employees) . ')';
            }

            $sql = '
                (SELECT
                    f.ID_F,
                    f.function
                FROM
                    functions f
                    INNER JOIN employees e
                        ON (e.id_fid = f.id_f)
                WHERE
                    e.id_e IN ('. implode(',', $employees) . ')
                    AND e.customer_id = ' . CUSTOMER_ID . '
                    ' . $filter_department_ids . '
                    ' . $filter_function_ids . '
                GROUP BY
                    f.ID_F,
                    f.function
                )
                ';
        }

        $additional_job_profiles_sql = '';
        if ($b_use_additional_job_profiles) {
            $additional_job_profiles_sql = '
                UNION DISTINCT
                    (SELECT
                        f.ID_F,
                        f.function
                    FROM
                        functions f
                        INNER JOIN employees_additional_functions eaf
                            ON (eaf.id_f = f.id_f)
                        INNER JOIN employees e
                            ON (eaf.id_e = e.id_e)
                    WHERE
                        eaf.customer_id = ' . CUSTOMER_ID . '
                        ' . $filter_department_ids . '
                        ' . $filter_function_ids . '
                        ' . $additional_job_profiles_employees_sql. '
                    )';
        }

        $sql .= $additional_job_profiles_sql;

        $sql .= '
                ORDER BY
                    function';
        //die($sql);
        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }

    static function getFunctionsForEmployeeProfile($i_employee_id)
    {
        $sql = 'SELECT
                    ID_F,
                    function
                FROM
                    functions
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_F = (    SELECT
                                        ID_FID
                                    FROM
                                        employees
                                    WHERE
                                        ID_E = ' . $i_employee_id . '
                                )
                    OR ID_F IN (    SELECT
                                        ID_F
                                    FROM
                                        employees_additional_functions
                                    WHERE
                                        ID_E = ' . $i_employee_id . '
                                )
                ORDER BY
                    function';

        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }

    static function getAllFunctionsNotUsedByEmployeeProfile($i_employee_id)
    {
        // hier moeten alle functieprofielen minus de hoofd- en nevenfunctieprofielen in lijstje getoond worden
        $filter_sql = '';
        if ($i_employee_id != 0) {
            // hier moeten alle profielen van id_e uitgesloten worden.
            $filter_sql = ' AND ID_F NOT IN (   SELECT
                                                    ID_FID
                                                FROM
                                                    employees
                                                WHERE
                                                    ID_E = ' . $i_employee_id . '
                                         )
                            AND ID_F NOT IN (   SELECT
                                                    ID_F
                                                FROM
                                                    employees_additional_functions
                                                WHERE
                                                    ID_E = ' . $i_employee_id . '
                                            )';
        }

        $sql = 'SELECT
                    ID_F,
                    function
                FROM
                    functions
                WHERE
                    customer_id = ' . CUSTOMER_ID .
                    $filter_sql . '
                ORDER BY
                    function';

        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }

    static function getAdditionalFunctions($i_employee_id)
    {
        $sql = 'SELECT
                    f.ID_F,
                    f.function
                FROM
                    functions f
                    INNER JOIN employees_additional_functions eaf
                        ON f.ID_F = eaf.ID_F
                            AND eaf.ID_E = ' .  $i_employee_id . '
                ORDER BY
                    f.function';

        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }

    static function getEmployeesConnectedCount ($i_function_id)
    {
        // main en neven
        $sql = 'SELECT
                    count(*) as employee_count
                FROM
                    employees e
                    LEFT JOIN employees_additional_functions eaf
                        ON e.id_e = eaf.id_e
                WHERE
                    e.customer_id = ' . CUSTOMER_ID . '
                    AND (e.id_fid = ' . $i_function_id . '
                        OR eaf.id_f = ' . $i_function_id . ')';

        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }

    static function getInvitationsConnectedCount ($i_function_id)
    {
        // invitations
        $sql = 'SELECT
                     count(*) as invitation_count
                FROM
                    threesixty_invitations
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND id_f = ' . $i_function_id;

        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }

}

?>