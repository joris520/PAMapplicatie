<?php

/**
 * Description of EmployeeProfileQueriesDeprecated
 *
 * @author ben.dokter
 */
class EmployeeProfileQueriesDeprecated {

    static function getEmployeeProfileInfo($i_employee_id)
    {
        $sql = 'SELECT
                    e.*,
                    f.function as function_name,
                    d.department as department_name,
                    b.employee as boss_name,
                    b.email_address as boss_email,
                    cel.LABEL_REF as education_level_label,
                    ccs.LABEL_REF as contract_state_label,
                    u.user_level,
                    u.username
                FROM
                    employees e
                    LEFT JOIN department d
                        ON d.ID_DEPT = e.ID_DEPTID
                    LEFT JOIN functions f
                        ON f.ID_F = e.ID_FID
                    LEFT JOIN employees b
                        ON b.ID_E = e.boss_fid
                            AND b.is_inactive = ' . EMPLOYEE_IS_ACTIVE . '
                    LEFT JOIN choice_education_levels cel
                        ON cel.ID = e.education_level_fid
                    LEFT JOIN choice_contract_states ccs
                        ON ccs.ID = e.contract_state_fid
                    LEFT JOIN users u
                        ON e.ID_E = u.ID_E
                WHERE
                    e.customer_id = ' . CUSTOMER_ID . '
                    AND e.ID_E = ' . $i_employee_id . '
                    AND e.is_inactive = ' . EMPLOYEE_IS_ACTIVE . '
                LIMIT 1';

        return BaseQueries::performSelectQuery($sql);
    }

    static function getAdditionalFunctions($i_employee_id)
    {
        $sql = 'SELECT
                    f.function as function_name,
                    f.ID_F
                FROM
                    functions f
                    INNER JOIN employees_additional_functions eaf
                        ON eaf.ID_F = f.ID_F
                WHERE
                    eaf.customer_id = ' . CUSTOMER_ID . '
                    AND eaf.ID_E = ' . $i_employee_id . '
                ORDER BY
                    function';

        return BaseQueries::performSelectQuery($sql);
    }

    static function getSelectableBosses($i_exclude_employee_id)
    {
        // hbd: TODO: check USER_LEVEL ?!
        $employee_exlude_filter = empty($i_exclude_employee_id) ? '' : ' AND ID_E <> ' . $i_exclude_employee_id ;
        $sql = 'SELECT
                    ID_E,
                    firstname,
                    lastname
                FROM
                    employees
                WHERE
                    customer_id= ' . CUSTOMER_ID .
                    $employee_exlude_filter . '
                    AND is_inactive = ' . EMPLOYEE_IS_ACTIVE . '
                    AND is_boss = ' . EMPLOYEE_IS_MANAGER . '
                ORDER BY
                    lastname,
                    firstname';

        return BaseQueries::performSelectQuery($sql);
    }

    static function getBossEmailInfoByCustomer($i_customer_id, $i_employee_id)
    {
        $sql = 'SELECT
                    b.email_address as boss_email,
                    b.employee as boss_name
                FROM
                    employees e
                    LEFT JOIN employees b
                        ON e.boss_fid = b.ID_E
                WHERE
                    e.customer_id = ' . $i_customer_id . '
                    AND e.ID_E = ' . $i_employee_id;

        return BaseQueries::performSelectQuery($sql);
    }

    static function getAvailableEducationalLevels()
    {
        $sql = 'SELECT
                    *
                FROM
                    choice_education_levels
                WHERE
                    deprecated is null';

        return BaseQueries::performSelectQuery($sql);
    }

    static function getAvailableContractStates()
    {
        $sql = 'SELECT
                    *
                FROM
                    choice_contract_states
                WHERE
                    deprecated IS NULL';

        return BaseQueries::performSelectQuery($sql);
    }

    static function getEmployeePhotoInfo($i_customer_id, $i_employee_id)
    {
        $sql = 'SELECT
                    foto_thumbnail,
                    id_contents
                FROM
                    employees
                WHERE
                    customer_id = ' . $i_customer_id . '
                    AND id_e = ' . $i_employee_id . '
                LIMIT 1';

        return BaseQueries::performSelectQuery($sql);
    }

    static function getEmployeePhotoContents($i_customer_id, $i_employee_id)
    {
        $sql = 'SELECT
                    dc.id_contents,
                    dc.contentsBase64,
                    dc.contents_size,
                    dc.filename,
                    dc.file_extension,
                    e.foto_thumbnail
                FROM
                    employees e
                    INNER JOIN document_contents dc
                        ON e.id_contents = dc.id_contents
                WHERE
                    e.customer_id = ' . $i_customer_id . '
                    AND e.id_e = ' . $i_employee_id . '
                LIMIT 1';

        return BaseQueries::performSelectQuery($sql);
    }


    static function updateEmployeePhotoInfo($i_employee_id, $i_id_contents, $s_photo_name)
    {
        $modified_by_user = USER;
        $modified_time = MODIFIED_TIME;
        $modified_date = MODIFIED_DATE;

        $sql = 'UPDATE
                    employees
                SET
                    foto_thumbnail = "' . mysql_real_escape_string($s_photo_name) . '",
                    id_contents = ' . $i_id_contents . ',
                    modified_by_user = "' . $modified_by_user . '",
                    modified_time = "' . $modified_time . '",
                    modified_date= "' . $modified_date . '"
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_E = ' . $i_employee_id . '
                LIMIT 1';

        return BaseQueries::performUpdateQuery($sql);
    }

    static function deleteEmployeePhotoInfo($i_employee_id)
    {
        $modified_by_user = USER;
        $modified_time = MODIFIED_TIME;
        $modified_date = MODIFIED_DATE;

        $sql = 'UPDATE
                    employees
                SET
                    foto_thumbnail = null,
                    id_contents = null,
                    modified_by_user = "' . $modified_by_user . '",
                    modified_time = "' . $modified_time . '",
                    modified_date= "' . $modified_date . '"
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_E = ' . $i_employee_id . '
                LIMIT 1';

        return BaseQueries::performDeletQuery($sql);
    }


    static function insertEmployeeProfile($i_ID_FID,
                                          $i_ID_DEPTID,
                                          $s_firstname,
                                          $s_lastname,
                                          $s_employee,
                                          $i_rating,
                                          $s_SN,
                                          $s_sex,
                                          $s_birthdate,
                                          $s_nationality,
                                          $s_address,
                                          $s_postal_code,
                                          $s_city,
                                          $s_phone_number,
                                          $s_email_address,
                                          $s_additional_info,
                                          $s_hidden_info,
                                          $s_phone_number_work,
                                          $s_employment_date,
                                          $i_boss_fid,
                                          $i_education_level_fid,
                                          $i_contract_state_fid,
                                          $s_employment_FTE,
                                          $i_is_boss,
                                          $i_id_pd)
    {
        $modified_by_user = USER;
        $modified_time = MODIFIED_TIME;
        $modified_date = MODIFIED_DATE;

        $sql = 'INSERT INTO
                    employees
                    (   customer_id,
                        ID_FID,
                        ID_DEPTID,
                        firstname,
                        lastname,
                        employee,
                        rating,
                        SN,
                        sex,
                        birthdate,
                        nationality,
                        address,
                        postal_code,
                        city,
                        phone_number,
                        email_address,
                        foto_thumbnail,
                        additional_info,
                        hidden_info,
                        modified_by_user,
                        modified_time,
                        modified_date,
                        is_inactive,
                        phone_number_work,
                        employment_date,
                        boss_fid,
                        education_level_fid,
                        contract_state_fid,
                        employment_FTE,
                        ID_PD,
                        is_boss
                    ) VALUES (
                         ' . CUSTOMER_ID . ',
                         ' . $i_ID_FID . ',
                         ' . $i_ID_DEPTID . ',
                        "' . mysql_real_escape_string($s_firstname) . '",
                        "' . mysql_real_escape_string($s_lastname) . '",
                        "' . mysql_real_escape_string($s_employee) . '",
                         ' . $i_rating . ',
                        "' . mysql_real_escape_string($s_SN) . '",
                        "' . mysql_real_escape_string($s_sex) . '",
                        "' . mysql_real_escape_string($s_birthdate) . '",
                        "' . mysql_real_escape_string($s_nationality) . '",
                        "' . mysql_real_escape_string($s_address) . '",
                        "' . mysql_real_escape_string($s_postal_code) . '",
                        "' . mysql_real_escape_string($s_city) . '",
                        "' . mysql_real_escape_string($s_phone_number) . '",
                        "' . mysql_real_escape_string($s_email_address) . '",
                         null,
                        "' . mysql_real_escape_string($s_additional_info) . '",
                        "' . mysql_real_escape_string($s_hidden_info) . '",
                        "' . $modified_by_user . '",
                        "' . mysql_real_escape_string($modified_time) . '",
                        "' . mysql_real_escape_string($modified_date) . '",
                         ' . EMPLOYEE_IS_ACTIVE . ',
                        "' . mysql_real_escape_string($s_phone_number_work) . '",
                        "' . mysql_real_escape_string($s_employment_date) . '",
                         ' . $i_boss_fid . ',
                         ' . $i_education_level_fid . ',
                         ' . $i_contract_state_fid . ',
                        "' . mysql_real_escape_string($s_employment_FTE) . '",
                         ' . $i_id_pd . ',
                         ' . $i_is_boss . '
                    )';

        return BaseQueries::performInsertQuery($sql);
    }

    static function updateEmployeeProfile($i_employee_id,
                                          $i_ID_FID,
                                          $i_ID_DEPTID,
                                          $s_firstname,
                                          $s_lastname,
                                          $s_employee,
                                          $i_rating,
                                          $s_SN,
                                          $s_sex,
                                          $s_birthdate,
                                          $s_nationality,
                                          $s_address,
                                          $s_postal_code,
                                          $s_city,
                                          $s_phone_number,
                                          $s_email_address,
                                          $s_additional_info,
                                          $s_hidden_info,
                                          $s_phone_number_work,
                                          $s_employment_date,
                                          $i_boss_fid,
                                          $i_education_level_fid,
                                          $i_contract_state_fid,
                                          $s_employment_FTE,
                                          $i_is_boss)
    {
        $modified_by_user = USER;
        $modified_time = MODIFIED_TIME;
        $modified_date = MODIFIED_DATE;

        $boss_fields_update = (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_PROFILE_MANAGER_COMMENTS)) ?
                                'hidden_info = "' . mysql_real_escape_string($s_hidden_info) . '",' :
                                ' ';

        $sql = 'UPDATE
                    employees
                SET
                    ID_FID = ' . $i_ID_FID . ',
                    ID_DEPTID = ' . $i_ID_DEPTID . ',
                    firstname = "' . mysql_real_escape_string($s_firstname) . '",
                    lastname = "' . mysql_real_escape_string($s_lastname) . '",
                    employee = "' . mysql_real_escape_string($s_employee) . '",
                    rating = ' . $i_rating . ',
                    SN = "' . mysql_real_escape_string($s_SN) . '",
                    sex = "' . mysql_real_escape_string($s_sex) . '",
                    birthdate = "' . mysql_real_escape_string($s_birthdate) . '",
                    nationality = "' . mysql_real_escape_string($s_nationality) . '",
                    address = "' . mysql_real_escape_string($s_address) . '",
                    postal_code = "' . mysql_real_escape_string($s_postal_code) . '",
                    city = "' . mysql_real_escape_string($s_city) . '",
                    phone_number = "' . mysql_real_escape_string($s_phone_number) . '",
                    email_address = "' . mysql_real_escape_string($s_email_address) . '",
                    additional_info = "' . mysql_real_escape_string($s_additional_info) . '",
                    is_boss = ' . $i_is_boss . ', ' .
                    $boss_fields_update . '
                    phone_number_work = "' . mysql_real_escape_string($s_phone_number_work) . '",
                    employment_date = "' . mysql_real_escape_string($s_employment_date) . '",
                    boss_fid = ' . $i_boss_fid . ',
                    education_level_fid = ' . $i_education_level_fid . ',
                    contract_state_fid = ' . $i_contract_state_fid . ',
                    employment_FTE = "' . mysql_real_escape_string($s_employment_FTE) . '",
                    modified_by_user= "' . $modified_by_user . '",
                    modified_time = "' . $modified_time . '",
                    modified_date = "' . $modified_date . '"
                WHERE
                    customer_id = ' . CUSTOMER_ID  . '
                    AND ID_E = ' . $i_employee_id . '
                LIMIT 1';

        return BaseQueries::performUpdateQuery($sql);
    }

    static function insertAdditionalFunction($i_employee_id,
                                             $i_function_id)
    {
        $sql = 'INSERT INTO
                    employees_additional_functions
                    (   customer_id,
                        ID_E,
                        ID_F
                    ) VALUES (
                        ' . CUSTOMER_ID . ',
                        ' . $i_employee_id . ',
                        ' . $i_function_id . '
                    )';

        return BaseQueries::performInsertQuery($sql);
    }

    static function deleteAdditionalFunctionsIds($i_employee_id,
                                                 $ia_additional_function_id)
    {
        if (is_array($ia_additional_function_id)) {
            $id_f_list = implode(',' , $ia_additional_function_id);
        } else {
            $id_f_list = $ia_additional_function_id;
        }
        $sql = 'DELETE
                FROM
                    employees_additional_functions
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_E = ' . $i_employee_id . '
                    AND ID_F in (' . $id_f_list . ')';

        return BaseQueries::performDeleteQuery($sql);
    }

    static function insertTaskOwnershipForNewEmployee($i_employee_id,
                                                      $s_employee_name)
    {
        //insert pdp_task_ownership
        $modified_by_user = USER;
        $modified_time = MODIFIED_TIME;
        $modified_date = MODIFIED_DATE;

        $sql = 'INSERT INTO
                    pdp_task_ownership
                    (   customer_id,
                        name,
                        ID_E,
                        modified_by_user,
                        modified_time,
                        modified_date
                    )  VALUES (
                         ' . CUSTOMER_ID . ',
                        "' . mysql_real_escape_string($s_employee_name) . '",
                         ' . $i_employee_id . ',
                        "' . $modified_by_user . '",
                        "' . $modified_time . '",
                        "' . $modified_date . '")';

        return BaseQueries::performInsertQuery($sql);
    }

    static function updateTaskOwnershipForEmployee($i_employee_id, $s_employee)
    {
        $modified_by_user = USER;
        $modified_time = MODIFIED_TIME;
        $modified_date = MODIFIED_DATE;

        $sql = 'UPDATE
                    pdp_task_ownership
                SET
                    name = "' . mysql_real_escape_string($s_employee) . '",
                    modified_by_user = "' . $modified_by_user . '",
                    modified_time = "' . $modified_time . '",
                    modified_date = "' . $modified_date . '"
                WHERE
                    customer_id = ' . CUSTOMER_ID  . '
                    AND ID_E = ' . $i_employee_id . '
                LIMIT 1';

        return BaseQueries::performUpdateQuery($sql);
    }
}

?>
