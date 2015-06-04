<?php

/**
 * Description of EmployeeFilterQueries
 *
 * @author ben.dokter
 */
class EmployeeFilterQueries
{
    const ID_FIELD = 'ID_E';

    // de id's ophalen van de niet verwijderde medewerkers die we mogen zien...
    static function selectAllowedEmployeeIds(   $searchFilter = null,
                                                $filteredEmployeeIds = null,
                                                $filterBossId = null,
                                                $selectOnlyIfHasNoBoss = false,
                                                $selectOnlyIfIsBoss = false,
                                                $filterDepartmentId = null,
                                                $filterMainFunctionId = null,
                                                $onlyWithEmail = false,
                                                $useLimit = true,
                                                $i_limit = null)
    {
        // afhankelijk van het user level zit er een beperking op de medewerkers die je mag zien.
        $sqlFilterBossId    =  !$selectOnlyIfHasNoBoss ? ''               : ' AND e.boss_fid is NULL';
        $sqlFilterBossId    =   empty($filterBossId)   ? $sqlFilterBossId : ' AND e.boss_fid = ' . $filterBossId;
        $sqlFilterIsBoss    =  !$selectOnlyIfIsBoss    ? ''               : ' AND e.is_boss  = ' . EMPLOYEE_IS_MANAGER;
        $sqlFilterName      =   empty($searchFilter)   ? ''               : ' AND (lastname LIKE "%' . mysql_real_escape_string($searchFilter) . '%"
                                                                                   OR firstname LIKE "%' . mysql_real_escape_string($searchFilter) . '%")';
        $sqlFilterDepartmentId  =   empty($filterDepartmentId)      ? '' : ' AND e.ID_DEPTID = ' . $filterDepartmentId;
        $sqlFilterFunctionId    =   empty($filterMainFunctionId)    ? '' : ' AND e.ID_FID = ' . $filterMainFunctionId;
        $sqlFilterHasEmail      =   !$onlyWithEmail                 ? '' : ' AND e.email_address <> ""';
        $sqlFilterEmployeeIds   =   empty($filteredEmployeeIds)     ? '' : ' AND e.ID_E in (' . $filteredEmployeeIds . ')';

        // als admin of als je alle afdelingen mag zien mogen alle niet verwijderde medewerkers
        if (USER_LEVEL == UserLevelValue::CUSTOMER_ADMIN || USER_ALLOW_ACCESS_ALL_DEPARTMENTS) {
            $sql = 'SELECT SQL_CALC_FOUND_ROWS
                        e.ID_E
                    FROM
                        employees e
                    WHERE
                        e.customer_id = ' . CUSTOMER_ID . '
                        AND e.is_inactive = ' . EMPLOYEE_IS_ACTIVE . '
                        ' . $sqlFilterBossId . '
                        ' . $sqlFilterIsBoss . '
                        ' . $sqlFilterName . '
                        ' . $sqlFilterDepartmentId . '
                        ' . $sqlFilterFunctionId . '
                        ' . $sqlFilterHasEmail . '
                        ' . $sqlFilterEmployeeIds . '
                    GROUP BY
                        e.ID_E';

        } elseif (USER_LEVEL == UserLevelValue::HR ||
                  USER_LEVEL == UserLevelValue::MANAGER) {
            // alle niet verwijderde medewerkers op de toegestane afdelingen of waar je leidinggevende over bent.
            $sqlEmployeeIsBossFilter = USER_EMPLOYEE_IS_BOSS ? ' OR e_allowed.boss_fid = ' . EMPLOYEE_ID : '';

            $sql = 'SELECT SQL_CALC_FOUND_ROWS
                        e.ID_E
                    FROM
                        employees e
                    WHERE
                        e.customer_id=  ' . CUSTOMER_ID  . '
                        AND e.ID_E IN   (   SELECT
                                                DISTINCT (e_allowed.ID_E)
                                            FROM
                                                users u_allowed
                                                LEFT JOIN users_department ud_allowed
                                                    ON u_allowed.user_id = ud_allowed.id_uid
                                                INNER JOIN employees e_allowed
                                                        ON (ud_allowed.id_dept = e_allowed.ID_DEPTID
                                                            ' . $sqlEmployeeIsBossFilter . ')
                                            WHERE
                                                e_allowed.customer_id     = ' . CUSTOMER_ID  . '
                                                AND e_allowed.is_inactive = ' . EMPLOYEE_IS_ACTIVE . '
                                                AND u_allowed.user_id     = ' . USER_ID . '
                                        )
                        ' . $sqlFilterBossId . '
                        ' . $sqlFilterIsBoss . '
                        ' . $sqlFilterName . '
                        ' . $sqlFilterDepartmentId . '
                        ' . $sqlFilterFunctionId . '
                        ' . $sqlFilterHasEmail . '
                        ' . $sqlFilterEmployeeIds . '
                    GROUP BY
                        e.ID_E';
        } else {
            // alleen jezelf
            $sql = 'SELECT SQL_CALC_FOUND_ROWS
                        e.ID_E
                    FROM
                        employees e
                    WHERE
                        e.customer_id = ' . CUSTOMER_ID . '
                        AND e.is_inactive = ' . EMPLOYEE_IS_ACTIVE . '
                        AND e.ID_E = ' . EMPLOYEE_ID . '
                        ' . $sqlFilterBossId . '
                        ' . $sqlFilterIsBoss . '
                        ' . $sqlFilterName . '
                        ' . $sqlFilterHasEmail;
        }
        //END USER VALIDATION
        if (!empty($i_limit)) {
            $sql .= ' LIMIT ' . $i_limit;
        } else {
            if (CUSTOMER_OPTION_USE_EMPLOYEES_LIMIT && $useLimit) {
                $sql .= ' LIMIT ' . CUSTOMER_OPTION_USE_EMPLOYEES_LIMIT_NUMBER;
            }
        }

        return BaseQueries::performSelectQuery($sql);
    }

}

?>
