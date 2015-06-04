<?php

/**
 * Description of EmployeeSelectService
 *
 * @author ben.dokter
 */

require_once('modules/model/valueobjects/employee/EmployeeInfoValueObject.class.php');

require_once('modules/model/service/list/EmployeeFilterService.class.php');
require_once('modules/model/queries/employee/profile/EmployeeProfileQueries.class.php');
require_once('modules/model/queries/employee/EmployeeInfoQueries.class.php');
require_once('modules/model/service/assessmentInvitation/SelfAssessmentInvitationFilterService.class.php');

require_once('modules/interface/converter/employee/profile/EmployeeNameConverter.class.php');
require_once('modules/interface/converter/list/BossFilterConverter.class.php');


// todo: eigenlijk EmployeeInfoService
class EmployeeSelectService
{
    const ALL_BOSSES        = NULL;
    const ALL_NAMES         = NULL;
    const ALL_DEPARTMENTS   = NULL;
    const ALL_FUNCTIONS     = NULL;
    const ALL_EMPLOYEEIDS   = NULL;
    const IGNORE_EMAIL      = FALSE;

    const RETURN_AS_STRING  = TRUE;
    const RETURN_AS_ARRAY   = FALSE;

    const ONLY_WITH_BOSS        = FALSE;
    const INCLUDE_HAS_NO_BOSS   = TRUE;

    const CHECK_REQUIRED_EMPLOYEES   = TRUE;
    const PRECHECKED_EMPLOYEES       = FALSE;

    static function getValueObject($employeeId)
    {
        $query = EmployeeInfoQueries::getEmployeesInfo($employeeId);
        $employeeInfoData = @mysql_fetch_assoc($query);
        $valueObject = EmployeeInfoValueObject::createWithData($employeeId, $employeeInfoData);
        mysql_free_result($query);

        return $valueObject;
    }

    private static function getValueObjects($employeeIds)
    {
        $valueObjects = array();

        $query = EmployeeInfoQueries::getEmployeesInfo($employeeIds);
        while ($employeeInfoData = @mysql_fetch_assoc($query)) {
            $valueObjects[] = EmployeeInfoValueObject::createWithData($employeeId, $employeeInfoData);
        }
        mysql_free_result($query);

        return $valueObjects;
    }

    // haal alle toegestane employeeIds op in array
    static function getAllAllowedEmployeeIds(   $returnType = self::RETURN_AS_ARRAY,
                                                $filteredEmployeeIds = self::ALL_EMPLOYEEIDS)
    {
        return EmployeeFilterService::getAllowedEmployeeIds(self::ALL_BOSSES,
                                                            $filteredEmployeeIds,
                                                            self::ALL_NAMES,
                                                            self::ALL_DEPARTMENTS,
                                                            self::ALL_FUNCTIONS,
                                                            self::IGNORE_EMAIL,
                                                            $returnType);
    }

    // haal alle toegestane employeeIds van een leidinggevende op in array
    static function getBossEmployeeIds( $bossId,
                                        $returnType = self::RETURN_AS_ARRAY,
                                        $filteredEmployeeIds = self::ALL_EMPLOYEEIDS)
    {
        return EmployeeFilterService::getAllowedEmployeeIds($bossId,
                                                            $filteredEmployeeIds,
                                                            self::ALL_NAMES,
                                                            self::ALL_DEPARTMENTS,
                                                            self::ALL_FUNCTIONS,
                                                            self::IGNORE_EMAIL,
                                                            $returnType);
    }

    static function isAllowedBossId($bossId,
                                    $mode = BossFilterValue::MODE_DISPLAY)
    {
        $isAllowed = (in_array($bossId, BossFilterValue::values($mode))) ||
                     self::isAllowedEmployeeId($bossId);
        return $isAllowed;
    }

    static function isAllowedEmployeeId($employeeId)
    {
        $isAllowed = false;

        if (!empty($employeeId) && is_numeric($employeeId)) {
            $employeeId = intval($employeeId);
            // controle of we deze id mogen zien door de id op proberen te halen
            $allowedEmployeeIds = self::getAllAllowedEmployeeIds(self::RETURN_AS_ARRAY, $employeeId);
            // gevonden als er 1 id gevonden is de id's matchen
            $isAllowed = (count($allowedEmployeeIds) == 1 && $allowedEmployeeIds[0] == $employeeId);
        }
        return $isAllowed;
    }

    static function getEmployeeIdValues($filteredEmployeeIds)
    {
        $employees = array();

        if (!empty($filteredEmployeeIds)) {
            $allowedFilteredEmployeeIds = self::getAllAllowedEmployeeIds(self::RETURN_AS_STRING, $filteredEmployeeIds);
            $query = EmployeeInfoQueries::getEmployeesInfo($allowedFilteredEmployeeIds);
            while ($employeeData = @mysql_fetch_assoc($query)) {
                $employees[] = IdValue::create( $employeeData['ID_E'],
                                                EmployeeNameConverter::displaySortable($employeeData['firstname'], $employeeData['lastname']));
            }
            mysql_free_result($query);
        }
        return $employees;

    }

    static function getEmployeeDisplayName($employeeId)
    {
        $employeeName = NULL;

        if (!empty($employeeId)) {
            $employees = self::getEmployeeIdValues($employeeId);
            $employeeName = $employees[0]->getValue();
        }
        return $employeeName;

    }

    static function getEmployeeIdsForSelectComponent(   $bossId,
                                                        $employeeSearch,
                                                        $departmentId,
                                                        $functionId,
                                                        $onlyWithEmail,
                                                        $onlyWithoutInvitation,
                                                        AssessmentCycleValueObject $currentCycle)
    {
        $allowedEmployeeIds = EmployeeFilterService::getAllowedEmployeeIds( $bossId,
                                                                            self::ALL_EMPLOYEEIDS,
                                                                            $employeeSearch,
                                                                            $departmentId,
                                                                            $functionId,
                                                                            $onlyWithEmail,
                                                                            true);
        if ($onlyWithoutInvitation && !empty($allowedEmployeeIds)) {
            $selectedEmployeeIds = SelfAssessmentInvitationFilterService::getEmployeesWithoutInvitation($allowedEmployeeIds,
                                                                                                        $currentCycle);
        } else {
            $selectedEmployeeIds = $allowedEmployeeIds;
        }
        return $selectedEmployeeIds;
    }

    static function getEmployeeInfos($selectedEmployeeIds)
    {
        $employees = array();
        if (!empty($selectedEmployeeIds)) {
            $query = EmployeeInfoQueries::getEmployeesInfo($selectedEmployeeIds);
            while ($employeeData = @mysql_fetch_assoc($query)) {
                $employees[] = $employeeData;
            }
            mysql_free_result($query);
        }
        return $employees;
    }

    static function getBossSubordinateCount($bossId)
    {
        $query = EmployeeProfileQueries::getBossSubordinateCount($bossId);
        $countData = mysql_fetch_assoc($query);
        mysql_free_result($query);

        return $countData['subordinate_count'];
    }

    static function getBossIdValues($includeNoBoss = self::ONLY_WITH_BOSS)
    {
        $bosses = array();

        if ($includeNoBoss == self::INCLUDE_HAS_NO_BOSS) {
            $bosses[] = IdValue::create(BossFilterValue::HAS_NO_BOSS,
                                        BossFilterConverter::display(BossFilterValue::HAS_NO_BOSS));
        }

        $allowedBossIds = EmployeeFilterService::getAllowedEmployeeIds(BossFilterValue::IS_BOSS);
        if (!empty($allowedBossIds)) {

            // van alle gevonden ids de info ophalen
            $query = EmployeeInfoQueries::getEmployeesInfo($allowedBossIds);
            while ($employeeInfo = @mysql_fetch_assoc($query)) {
                $bosses[] = IdValue::create($employeeInfo['ID_E'],
                                            EmployeeNameConverter::displaySortable($employeeInfo['firstname'], $employeeInfo['lastname']));
            }

            mysql_free_result($query);
        }
        return $bosses;
    }

    static function getBossIdValue($bossId)
    {
        $bossName = '';
        if ($bossId == BossFilterValue::HAS_NO_BOSS) {
            $bossName = BossFilterConverter::display(BossFilterValue::HAS_NO_BOSS);

        } else {//if (is_numeric($bossId)) {
            $bossIdValues = self::getEmployeeIdValues($bossId);
            if (!empty($bossIdValues[0])) {
                $bossName = $bossIdValues[0]->getValue();
            }
        }
        return IdValue::create($bossId, $bossName);
    }

}

?>
