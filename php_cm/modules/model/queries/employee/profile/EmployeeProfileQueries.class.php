<?php

/**
 * Description of EmployeeProfileQueries
 *
 * @author ben.dokter
 */
class EmployeeProfileQueries
{
    const ID_FIELD = 'ID_E';

    static function selectEmployeeProfilePersonal($i_employeeId)
    {
        $sql = 'SELECT
                    *
                FROM
                    employees
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_E = ' . $i_employeeId . '
                LIMIT 1';

        return BaseQueries::performSelectQuery($sql);
    }

    static function selectEmployeeProfileOrganisation($i_employeeId)
    {
        return self::selectEmployeeProfilePersonal($i_employeeId);
    }

    static function selectEmployeeProfileInformation($i_employeeId)
    {
        return self::selectEmployeeProfilePersonal($i_employeeId);
    }

    static function getBossSubordinateCount($i_bossId)
    {
        $sql = 'SELECT
                    count(e.ID_E) as subordinate_count
                FROM
                    employees e
                WHERE
                    e.customer_id = ' . CUSTOMER_ID . '
                    AND e.is_inactive = ' . EMPLOYEE_IS_ACTIVE . '
                    AND e.boss_fid = ' . $i_bossId;

        return BaseQueries::performSelectQuery($sql);
    }

    static function updateProfilePersonal(  $i_employeeId,
                                            $s_firstName,
                                            $s_lastName,
                                            $s_employeeName,
                                            $s_gender,
                                            $d_birthDate,
                                            $s_bsn,
                                            $s_nationality,
                                            $s_street,
                                            $s_postcode,
                                            $s_city,
                                            $s_phoneNumber,
                                            $s_emailAddress)
    {
        $savedByUserId = USER_ID;
        $savedByUser   = USER;
        $savedDatetime = MODIFIED_DATETIME;

        $sql = 'UPDATE
                    employees
                SET
                    firstname = "' . mysql_real_escape_string($s_firstName) . '",
                    lastname = "' . mysql_real_escape_string($s_lastName) . '",
                    employee = "' . mysql_real_escape_string($s_employeeName) . '",
                    rating = ' . RATING_FUNCTION_PROFILE . ',
                    SN = "' . mysql_real_escape_string($s_bsn) . '",
                    sex = "' . mysql_real_escape_string($s_gender) . '",
                    birthdate = "' . mysql_real_escape_string($d_birthDate) . '",
                    nationality = "' . mysql_real_escape_string($s_nationality) . '",
                    address = "' . mysql_real_escape_string($s_street) . '",
                    postal_code = "' . mysql_real_escape_string($s_postcode) . '",
                    city = "' . mysql_real_escape_string($s_city) . '",
                    phone_number = "' . mysql_real_escape_string($s_phoneNumber) . '",
                    email_address = "' . mysql_real_escape_string($s_emailAddress) . '",
                    saved_by_user_id = ' . $savedByUserId . ',
                    saved_by_user = "' . mysql_real_escape_string($savedByUser) . '",
                    saved_datetime = "' . $savedDatetime . '",
                    database_datetime = NOW()
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_E = ' . $i_employeeId;

        return BaseQueries::performUpdateQuery($sql);
    }

    static function updateEmailAddress( $i_employeeId,
                                        $s_emailAddress)
    {
        $savedByUserId = USER_ID;
        $savedByUser   = USER;
        $savedDatetime = MODIFIED_DATETIME;

        $sql = 'UPDATE
                    employees
                SET
                    email_address = "' . mysql_real_escape_string($s_emailAddress) . '",
                    saved_by_user_id = ' . $savedByUserId . ',
                    saved_by_user = "' . mysql_real_escape_string($savedByUser) . '",
                    saved_datetime = "' . $savedDatetime . '",
                    database_datetime = NOW()
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_E = ' . $i_employeeId;

        return BaseQueries::performUpdateQuery($sql);
    }

    static function updateProfileOrganisation(  $i_employeeId,
                                                $i_boss,
                                                $i_isBoss,
                                                $i_department,
                                                $s_phoneNumberWork,
                                                $d_employmentDate,
                                                $f_fte,
                                                //$employeeNumber,
                                                $i_contractState)
    {
        $savedByUserId = USER_ID;
        $savedByUser   = USER;
        $savedDatetime = MODIFIED_DATETIME;

        $sql = 'UPDATE
                    employees
                SET
                    boss_fid = ' . BaseQueries::nullableValue($i_boss) . ',
                    is_boss = ' . $i_isBoss . ',
                    ID_DEPTID = ' . $i_department . ',
                    phone_number_work = "' . mysql_real_escape_string($s_phoneNumberWork) . '",
                    employment_date  ="' . mysql_real_escape_string($d_employmentDate) . '",
                    employment_FTE = ' . BaseQueries::nullableString($f_fte) . ',
                    contract_state_fid = ' . BaseQueries::nullableValue($i_contractState) . ',
                    saved_by_user_id = ' . $savedByUserId . ',
                    saved_by_user = "' . mysql_real_escape_string($savedByUser) . '",
                    saved_datetime = "' . $savedDatetime . '",
                    database_datetime = NOW()
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_E = ' . $i_employeeId;

        return BaseQueries::performUpdateQuery($sql);
    }

    static function updateProfileInformation(   $i_employeeId,
                                                $b_isEditAllowedManagerInfo,
                                                $i_educationLevel,
                                                $s_additionalInfo,
                                                $s_managerInfo)
    {
        $savedByUserId = USER_ID;
        $savedByUser   = USER;
        $savedDatetime = MODIFIED_DATETIME;

        $hidden_info_sql = $b_isEditAllowedManagerInfo ? 'hidden_info = "' . mysql_real_escape_string($s_managerInfo) . '",' : '';

        $sql = 'UPDATE
                    employees
                SET
                    education_level_fid = ' . BaseQueries::nullableValue($i_educationLevel) . ',
                    additional_info = "' . mysql_real_escape_string($s_additionalInfo) . '",
                    ' . $hidden_info_sql . '
                    saved_by_user_id = ' . $savedByUserId . ',
                    saved_by_user = "' . mysql_real_escape_string($savedByUser) . '",
                    saved_datetime = "' . $savedDatetime . '",
                    database_datetime = NOW()
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_E = ' . $i_employeeId;

        return BaseQueries::performUpdateQuery($sql);
    }


    static function archiveEmployee(    $i_employeeId,
                                        $i_archiveStatus)
    {
        $savedByUserId = USER_ID;
        $savedByUser   = USER;
        $savedDatetime = MODIFIED_DATETIME;

        $sql = 'UPDATE
                    employees
                SET
                    is_inactive = ' . $i_archiveStatus . ',
                    saved_by_user_id = ' . $savedByUserId . ',
                    saved_by_user = "' . mysql_real_escape_string($savedByUser) . '",
                    saved_datetime = "' . $savedDatetime . '",
                    database_datetime = NOW()
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_E = ' . $i_employeeId;

        return BaseQueries::performUpdateQuery($sql);
    }


    static function removeProfilePersonalPhoto($i_employeeId)
    {
        $savedByUserId = USER_ID;
        $savedByUser   = USER;
        $savedDatetime = MODIFIED_DATETIME;

        $sql = 'UPDATE
                    employees
                SET
                    foto_thumbnail = null,
                    id_contents = null,
                    saved_by_user_id = ' . $savedByUserId . ',
                    saved_by_user = "' . mysql_real_escape_string($savedByUser) . '",
                    saved_datetime = "' . $savedDatetime . '",
                    database_datetime = NOW()
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_E = ' . $i_employeeId . '
                LIMIT 1';

        return BaseQueries::performUpdateQuery($sql);
    }

    static function updateProfilePersonalPhoto($i_employeeId, $s_photoFile, $i_contentId)
    {
        $savedByUserId = USER_ID;
        $savedByUser   = USER;
        $savedDatetime = MODIFIED_DATETIME;

        $sql = 'UPDATE
                    employees
                SET
                    foto_thumbnail = "' . $s_photoFile . '",
                    id_contents = ' . $i_contentId . ',
                    saved_by_user_id = ' . $savedByUserId . ',
                    saved_by_user = "' . mysql_real_escape_string($savedByUser) . '",
                    saved_datetime = "' . $savedDatetime . '",
                    database_datetime = NOW()
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_E = ' . $i_employeeId . '
                LIMIT 1';

        return BaseQueries::performUpdateQuery($sql);
    }

}

?>
