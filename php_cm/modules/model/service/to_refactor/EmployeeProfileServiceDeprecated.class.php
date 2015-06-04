<?php

/**
 * Description of EmployeeProfile
 *
 * @author ben.dokter
 */

require_once('gino/DateUtils.class.php');
require_once('modules/model/queries/to_refactor/EmployeeProfileQueriesDeprecated.class.php');
require_once('modules/model/service/to_refactor/UsersService.class.php');
require_once('modules/model/service/to_refactor/AlertsService.class.php');

class EmployeeProfileServiceDeprecated {

    static function getEmployeeProfileInfo($employee_id)
    {
        $employeeProfileResult = EmployeeProfileQueriesDeprecated::getEmployeeProfileInfo($employee_id);
        $employeeProfileInfo = @mysql_fetch_assoc($employeeProfileResult);
        $employee_photo = new PhotoContent();
        list($employeeProfileInfo['displayable_photo'],
             $employeeProfileInfo['photo_width'],
             $employeeProfileInfo['photo_height']) = $employee_photo->getEmployeeDisplayablePhoto($employeeProfileInfo['foto_thumbnail']);

        return $employeeProfileInfo;
    }

    static function getAdditionalFunctions($employee_id)
    {
        $additionalFunctions = array();
        $additionFunctionsResult = EmployeeProfileQueriesDeprecated::getAdditionalFunctions($employee_id);
        while ($additionalFunction = @mysql_fetch_assoc($additionFunctionsResult)) {
            $additionalFunctions[] = $additionalFunction['function_name'];
        }
        return $additionalFunctions;
    }

    static function getAdditionalFunctionIds($employee_id)
    {
        $additionalFunctionsIds = array();
        $additionFunctionsResult = EmployeeProfileQueriesDeprecated::getAdditionalFunctions($employee_id);
        while ($additionalFunction = @mysql_fetch_assoc($additionFunctionsResult)) {
            $additionalFunctionsIds[] = $additionalFunction['ID_F'];
        }
        return $additionalFunctionsIds;
    }


    static function getSelectableBosses($employee_id)
    {
        $bosses_result = EmployeeProfileQueriesDeprecated::getSelectableBosses($employee_id);
        $bosses = array();
        while ($boss = @mysql_fetch_assoc($bosses_result)) {
            $boss['bossname'] = EmployeeProfileServiceDeprecated::formatBossName($boss['firstname'], $boss['lastname']);
            $bosses[] = $boss;
        }
        return $bosses;
    }

    static function formatBossName($firstname, $lastname)
    {
        return EmployeeProfileServiceDeprecated::formatEmployeeName($firstname, $lastname);
    }

    /**
     *
     * Om loze ',' te voorkomen kan deze functie helpen
     * @param <type> $first_name
     * @param <type> $last_name
     * @return string
     */
    static function formatEmployeeName($first_name, $last_name, $formatMode = EMPLOYEENAME_FORMAT_LASTNAME_FIRST)
    {
        $employee_name = $last_name;
        if (!empty($first_name)) {
            if ($formatMode == EMPLOYEENAME_FORMAT_FIRSTNAME_FIRST) {
                $employee_name = $first_name . ' ' . $employee_name;
            } else {
                $employee_name .= ', ' . $first_name;
            }
        }
        return $employee_name;
    }

    static function getEmployeeName($employee_id)
    {
        $nameQuery = EmployeesQueries::getEmployeeInfo($employee_id);
        $employeeInfo = mysql_fetch_assoc($nameQuery);
        $lastname  = $employeeInfo['lastname'];
        $firstname = $employeeInfo['firstname'];
        return EmployeeProfileServiceDeprecated::formatEmployeeName($firstname, $lastname);
    }

    static function getAvailableEducationalLevels()
    {
        $education_levels_result = EmployeeProfileQueriesDeprecated::getAvailableEducationalLevels();

        $education_levels = array();
        while ($education_level = @mysql_fetch_assoc($education_levels_result)) {
            $education_level['display_name'] = TXT_UCF($education_level[LABEL_REF]);
            $education_levels[] = $education_level;
        }
        return $education_levels;
    }

    static function getAvailableContractStates()
    {
        $contract_state_result = EmployeeProfileQueriesDeprecated::getAvailableContractStates();

        $contract_states = array();
        while ($contract_state = @mysql_fetch_assoc($contract_state_result)) {
            $contract_state['display_name'] = TXT_UCF($contract_state[LABEL_REF]);
            $contract_states[] = $contract_state;
        }
        return $contract_states;
    }

    static function getPhotoInfo($customer_id, $employee_id)
    {
        return @mysql_fetch_assoc(EmployeeProfileQueriesDeprecated::getEmployeePhotoInfo($customer_id, $employee_id));
    }

    static function getPhotoContents($customer_id, $employee_id)
    {
        return @mysql_fetch_assoc(EmployeeProfileQueriesDeprecated::getEmployeePhotoContents($customer_id, $employee_id));
    }

    static function updatePhotoInfo($employee_id, $id_contents, $photo_name)
    {
        return EmployeeProfileQueriesDeprecated::updateEmployeePhotoInfo($employee_id, $id_contents, $photo_name);
    }

    static function deletePhoto($employee_id)
    {
        $old_photo = EmployeeProfileServiceDeprecated::getPhotoInfo(CUSTOMER_ID, $employee_id);
        EmployeeProfileQueriesDeprecated::deleteEmployeePhotoInfo($employee_id);

        // Na het updaten de oude Contents verwijderen
        if (!empty($old_photo['foto_thumbnail'])) {
            @unlink(CUSTOMER_PHOTO_PATH . $old_photo['foto_thumbnail']);
        }
        if (!empty($old_photo['id_contents'])) {
            DocumentQueries::deleteDocumentContent($old_photo['id_contents']);
        }
    }

    static function validateEditProfile($employee_id,
                                        $email_address)
    {
        $hasError = false;
        $message = '';

        if (empty($email_address) && AlertsService::hasOpenAlertsAsSender($employee_id)) { // hbd: email verplicht als er nog een alert uit staat
            $message = TXT_UCF('PLEASE_ENTER_AN_EMPLOYEE_EMAIL_WITH_UNSEND_ALERTS');
            $hasError = true;
        } elseif (empty($email_address) && EmployeesService::hasRelatedUser($employee_id)) { // hbd: email verplicht als er een user aan hangt
            $message = TXT_UCF('PLEASE_ENTER_AN_EMPLOYEE_EMAIL');
            $hasError = true;
        }

        return array($hasError, $message);
    }

    static function validateProfile($firstname,
                                    $lastname,
                                    $email_address,
                                    $department_id,
                                    $selectedFunctions,
                                    $function_id,
                                    $rating,
                                    $birthdate,
                                    $employment_FTE,
                                    $username,
                                    $password,
                                    $user_level)
    {
        $hasError = false;
        $message = '';
        if (empty($firstname)) {
            $message = TXT_UCF('PLEASE_ENTER_AN_EMPLOYEE_FIRST_NAME');
            $hasError = true;
        } elseif (empty($lastname)) {
            $message = TXT_UCF('PLEASE_ENTER_AN_EMPLOYEE_LAST_NAME');
            $hasError = true;
        } elseif (CUSTOMER_OPTION_REQUIRED_EMP_EMAIL && empty($email_address)) { // hbd: email ook verplicht
            $message = TXT_UCF('PLEASE_ENTER_AN_EMPLOYEE_EMAIL');
            $hasError = true;
        } elseif (!empty($email_address) && !ModuleUtils::IsEmailAddressValidFormat($email_address)) {
            $message = TXT_UCF('EMAIL_ADDRESS_IS_INVALID');
            $hasError = true;
        } elseif (empty($department_id)) {
            $message = TXT_UCF('PLEASE_SELECT_A_DEPARTMENT');
            $hasError = true;
        } elseif (empty($selectedFunctions)) { // om te kijken of lijst met functies niet leeg is.
            $message = TXT_UCF('PLEASE_SELECT_A_JOB_PROFILE');
            $hasError = true;
        } elseif (!in_array($function_id, $selectedFunctions)) {
            $message = TXT_UCF('SELECTED_MAIN_JOB_PROFILE_NOT_IN_LIST_JOB_PROFILES_OF_EMPLOYEE');
            $hasError = true;
        } elseif (CUSTOMER_OPTION_USE_RATING_DICTIONARY && empty($rating)) {
            $message = TXT_UCF('PLEASE_SELECT_A_RATING');
            $hasError = true;
        }
        // hier "afwijkende controles, dus niet in de elseif
        if (! $hasError  && ! empty($birthdate)) {
            $validateResult = DateUtils::ValidateDisplayDate($birthdate);
            if ($validateResult > 0) {
                $error_message = TXT_UCF('DATE_OF_BIRTH');
                switch ($validateResult) {
                    case 1: $error_message .= ': ' . TXT('INVALID_DATE_FORMAT');
                        break;
                    case 2: $error_message .= ': ' . TXT('INVALID_DATE');
                        break;
                    default: $error_message .= ': ' . TXT('INVALID_DATE_FORMAT');
                }
                $message = $error_message;
                $hasError = true;
            }
        }
        if (! $hasError  && ! empty($employment_FTE)) {
            $check_employment_FTE = floatval(str_replace(',', '.', $employment_FTE));
            if (empty($check_employment_FTE) || $check_employment_FTE < 0.0 || $check_employment_FTE > 1.0 ) {
                $message = TXT_UCF('EMPLOYMENT_PERCENTAGE'). ': ' . TXT_UCF('INVALID_FTE_VALUE');
                $hasError = true;
            }
        }
        if (! $hasError) {
            if (!empty($username)) {
                list($hasError, $message) = UsersService::checkValidEmployeeUser($username, $password, $email_address, $user_level);
            }
        }
        return array($hasError, $message);
    }

    static function insertProfile($function_id,
                                  $department_id,
                                  $firstname,
                                  $lastname,
                                  $employee,
                                  $rating,
                                  $SN,
                                  $gender,
                                  $birthdate,
                                  $nationality,
                                  $address,
                                  $postal_code,
                                  $city,
                                  $phone_number,
                                  $email_address,
                                  $additional_info,
                                  $hidden_info,
                                  $phone_number_work,
                                  $employment_date,
                                  $boss_fid,
                                  $education_level_fid,
                                  $contract_state_fid,
                                  $employment_FTE,
                                  $is_boss,
                                  $selectedFunctionIds)
    {
        $id_pd = personDataService::insertPersonalData(CUSTOMER_ID,
                                                ID_EC_INTERNAL,
                                                $firstname,
                                                $lastname,
                                                $email_address);

        $new_employee_id = EmployeeProfileQueriesDeprecated::insertEmployeeProfile($function_id,
                                                                         $department_id,
                                                                         $firstname,
                                                                         $lastname,
                                                                         $employee,
                                                                         $rating,
                                                                         $SN,
                                                                         $gender,
                                                                         $birthdate,
                                                                         $nationality,
                                                                         $address,
                                                                         $postal_code,
                                                                         $city,
                                                                         $phone_number,
                                                                         $email_address,
                                                                         $additional_info,
                                                                         $hidden_info,
                                                                         $phone_number_work,
                                                                         $employment_date,
                                                                         $boss_fid,
                                                                         $education_level_fid,
                                                                         $contract_state_fid,
                                                                         $employment_FTE,
                                                                         $is_boss,
                                                                         $id_pd);

            // nieuwe neven functieprofielen toevoegen aan database
            foreach ($selectedFunctionIds as $selectedFunctionId) {
                if ($selectedFunction != $function_id) {
                    EmployeeProfileQueriesDeprecated::insertAdditionalFunction($new_employee_id,
                                                                     $selectedFunctionId);
                }
            }
            // TODO: refactor naar andere klasse
            EmployeeProfileQueriesDeprecated::insertTaskOwnershipForNewEmployee($new_employee_id,
                                                                      $employee);

            return $new_employee_id;
    }

    static function validateAndInsertEmployeeProfile($function_id,
                                                     $department_id,
                                                     $firstname,
                                                     $lastname,
                                                     $employee,
                                                     $rating,
                                                     $SN,
                                                     $gender,
                                                     $birthdate,
                                                     $nationality,
                                                     $address,
                                                     $postal_code,
                                                     $city,
                                                     $phone_number,
                                                     $email_address,
                                                     $additional_info,
                                                     $hidden_info,
                                                     $phone_number_work,
                                                     $employment_date,
                                                     $boss_fid,
                                                     $education_level_fid,
                                                     $contract_state_fid,
                                                     $employment_FTE,
                                                     $is_boss,
                                                     $selectedFunctionIds,
                                                     $username,
                                                     $password,
                                                     $user_level)
    {

        list($hasError, $message) = EmployeeProfileServiceDeprecated::validateProfile($firstname,
                                                                     $lastname,
                                                                     $email_address,
                                                                     $department_id,
                                                                     $selectedFunctionIds,
                                                                     $function_id,
                                                                     $rating,
                                                                     $birthdate,
                                                                     $employment_FTE,
                                                                     $username,
                                                                     $password,
                                                                     $user_level);
        if (!$hasError) {
            $hasError = true;
            BaseQueries::startTransaction();

            $new_employee_id = EmployeeProfileServiceDeprecated::insertProfile($function_id,
                                                              $department_id,
                                                              $firstname,
                                                              $lastname,
                                                              $employee,
                                                              $rating,
                                                              $SN,
                                                              $gender,
                                                              $birthdate,
                                                              $nationality,
                                                              $address,
                                                              $postal_code,
                                                              $city,
                                                              $phone_number,
                                                              $email_address,
                                                              $additional_info,
                                                              $hidden_info,
                                                              $phone_number_work,
                                                              $employment_date,
                                                              $boss_fid,
                                                              $education_level_fid,
                                                              $contract_state_fid,
                                                              $employment_FTE,
                                                              $is_boss,
                                                              $selectedFunctionIds);

            if (!empty($username)) {
                UsersService::insertUserForEmployee($new_employee_id,
                                             $employee,
                                             $email_address,
                                             $username,
                                             $password,
                                             $user_level);
            }
            BaseQueries::finishTransaction();
            $hasError = false;

        } else {
            $new_employee_id = null;
        }
        return array($hasError, $message, $new_employee_id);
    }

    static function updateAdditionalFunctions($employee_id,
                                              $function_id,
                                              $selectedFunctionIds)
    {
        $additionalFunctionIds = EmployeeProfileServiceDeprecated::getAdditionalFunctionIds($employee_id);
        // verwijderen gedeselecteerde neven functieprofielen
        $removeAdditionalFunctionIds = array();
        foreach ($additionalFunctionIds as $additionalFunctionId) {
            if ($additionalFunctionId == $function_id  ||
                !in_array($additionalFunctionId, $selectedFunctionIds) ) {
                    $removeAdditionalFunctionIds[] = $additionalFunctionId;
            }

        }
        if (count($removeAdditionalFunctionIds) > 0) {
            EmployeeProfileQueriesDeprecated::deleteAdditionalFunctionsIds($employee_id, $removeAdditionalFunctionIds);
        }

        // nog niet opgeslagen toevoegen
        foreach ($selectedFunctionIds as $selectedFunctionId) {
            if ($selectedFunctionId != $function_id  &&
                !in_array($selectedFunctionId, $additionalFunctionIds) ) {
                    EmployeeProfileQueriesDeprecated::insertAdditionalFunction($employee_id, $selectedFunctionId);
            }
        }
    }

    static function updateProfile($employee_id,
                                  $function_id,
                                  $department_id,
                                  $firstname,
                                  $lastname,
                                  $employee,
                                  $rating,
                                  $SN,
                                  $gender,
                                  $birthdate,
                                  $nationality,
                                  $address,
                                  $postal_code,
                                  $city,
                                  $phone_number,
                                  $email_address,
                                  $additional_info,
                                  $hidden_info,
                                  $phone_number_work,
                                  $employment_date,
                                  $boss_fid,
                                  $education_level_fid,
                                  $contract_state_fid,
                                  $employment_FTE,
                                  $is_boss,
                                  $selectedFunctionIds)
    {
        $updated_records = EmployeeProfileQueriesDeprecated::updateEmployeeProfile($employee_id,
                                                                         $function_id,
                                                                         $department_id,
                                                                         $firstname,
                                                                         $lastname,
                                                                         $employee,
                                                                         $rating,
                                                                         $SN,
                                                                         $gender,
                                                                         $birthdate,
                                                                         $nationality,
                                                                         $address,
                                                                         $postal_code,
                                                                         $city,
                                                                         $phone_number,
                                                                         $email_address,
                                                                         $additional_info,
                                                                         $hidden_info,
                                                                         $phone_number_work,
                                                                         $employment_date,
                                                                         $boss_fid,
                                                                         $education_level_fid,
                                                                         $contract_state_fid,
                                                                         $employment_FTE,
                                                                         $is_boss);

        personDataService::updateForEmployee($employee_id, $firstname, $lastname, $email_address);
        EmployeeProfileServiceDeprecated::updateAdditionalFunctions($employee_id, $function_id, $selectedFunctionIds);

        // TODO: refactor naar andere klasse
        EmployeeProfileQueriesDeprecated::updateTaskOwnershipForEmployee($employee_id, $employee);

        UsersService::updateUserForEmployee($employee_id, $employee, $email_address);

        return $updated_records;
    }

    static function validateAndUpdateEmployeeProfile($employee_id,
                                                     $function_id,
                                                     $department_id,
                                                     $firstname,
                                                     $lastname,
                                                     $employee,
                                                     $rating,
                                                     $SN,
                                                     $gender,
                                                     $birthdate,
                                                     $nationality,
                                                     $address,
                                                     $postal_code,
                                                     $city,
                                                     $phone_number,
                                                     $email_address,
                                                     $additional_info,
                                                     $hidden_info,
                                                     $phone_number_work,
                                                     $employment_date,
                                                     $boss_fid,
                                                     $education_level_fid,
                                                     $contract_state_fid,
                                                     $employment_FTE,
                                                     $is_boss,
                                                     $selectedFunctions,
                                                     $username,
                                                     $password,
                                                     $user_level)
    {

        list($hasError, $message) = EmployeeProfileServiceDeprecated::validateProfile($firstname,
                                                                     $lastname,
                                                                     $email_address,
                                                                     $department_id,
                                                                     $selectedFunctions,
                                                                     $function_id,
                                                                     $rating,
                                                                     $birthdate,
                                                                     $employment_FTE,
                                                                     $username,
                                                                     $password,
                                                                     $user_level);
        if (!$hasError) {
            list($hasError, $message) = EmployeeProfileServiceDeprecated::validateEditProfile($employee_id,
                                                                             $email_address);
        }
        if (!$hasError) {
            $hasError = true;
            BaseQueries::startTransaction();

            $updated_records = EmployeeProfileServiceDeprecated::updateProfile($employee_id,
                                                              $function_id,
                                                              $department_id,
                                                              $firstname,
                                                              $lastname,
                                                              $employee,
                                                              $rating,
                                                              $SN,
                                                              $gender,
                                                              $birthdate,
                                                              $nationality,
                                                              $address,
                                                              $postal_code,
                                                              $city,
                                                              $phone_number,
                                                              $email_address,
                                                              $additional_info,
                                                              $hidden_info,
                                                              $phone_number_work,
                                                              $employment_date,
                                                              $boss_fid,
                                                              $education_level_fid,
                                                              $contract_state_fid,
                                                              $employment_FTE,
                                                              $is_boss,
                                                              $selectedFunctions);

            if (!empty($username)) {
                $found_user = UsersService::findUserByEmployeeId($employee_id);
                if (empty($found_user)) {
                    UsersService::insertUserForEmployee($employee_id, $employee, $email_address,
                                                $username, $password, $user_level);
                }
            }

            BaseQueries::finishTransaction();
            $hasError = false;
        }
        return array($hasError, $message);
    }
}

?>
