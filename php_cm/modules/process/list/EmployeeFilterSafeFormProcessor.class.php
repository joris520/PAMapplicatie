<?php

/**
 * Description of EmployeeFilterSafeFormProcessor
 *
 * @author ben.dokter
 */

require_once('modules/process/list/EmployeeFilterInterfaceProcessor.class.php');

class EmployeeFilterSafeFormProcessor
{

    static function actionFilter($objResponse, $safeFormHandler)
    {
        $hasError = true;
        $messages = array();

        if (PermissionsService::isViewAllowed(PERMISSION_MODULE_EMPLOYEES)) {

            $showSearch             = $safeFormHandler->retrieveSafeValue('showSearch');
            $employeeSearchValue    = !$showSearch ? NULL : $safeFormHandler->retrieveInputValue('search_employee');

            // alleen als de filters zichtbaar zijn kunnen we de waardes overnemen
            $filtersVisible = EmployeeFilterService::retrieveIsFiltersVisible();
            if ($filtersVisible) {
                $showAssessmentFilter   = $safeFormHandler->retrieveSafeValue('showAssessmentFilter');
                $showBossFilter         = $safeFormHandler->retrieveSafeValue('showBossFilter');
                $showDepartmentFilter   = $safeFormHandler->retrieveSafeValue('showDepartmentFilter');
                $showFunctionFilter     = $safeFormHandler->retrieveSafeValue('showFunctionFilter');
                $showSortFilter         = $safeFormHandler->retrieveSafeValue('showSortFilter');

                // filter waarden ophalen en valideren, opslaan in sessie via EmployeeFilterService
                $assessmentFilterValue  = !$showAssessmentFilter    ? NULL : $safeFormHandler->retrieveInputValue('filter_assessment');
                $bossFilterValue        = !$showBossFilter          ? NULL : $safeFormHandler->retrieveInputValue('filter_boss');
                $departmentFilterValue  = !$showDepartmentFilter    ? NULL : $safeFormHandler->retrieveInputValue('filter_department');
                $functionFilterValue    = !$showFunctionFilter      ? NULL : $safeFormHandler->retrieveInputValue('filter_function');
                $sortFilterValue        = !$showSortFilter          ? EmployeeSortFilterValue::SORT_ALPHABETICAL : $safeFormHandler->retrieveInputValue('filter_sort');

                // $bossFilterValue mag 'no_boss', 'is_boss' of numeriek zijn...
                $hasError = !bossFilterValue::isValidValue($bossFilterValue);
            } else {
                $hasError = false;
            }

            if (!$hasError) {
                EmployeeFilterService::storeEmployeeSearch($employeeSearchValue);
                if ($filtersVisible) {
                    EmployeeFilterService::storeAssessmentFilter($assessmentFilterValue);
                    EmployeeFilterService::storeBossFilter($bossFilterValue);
                    EmployeeFilterService::storeDepartmentFilter($departmentFilterValue);
                    EmployeeFilterService::storeFunctionFilter($functionFilterValue);
                    EmployeeFilterService::storeSortFilter($sortFilterValue);
                }
                // klaar met actie
                // let op: safeFormHandler laten bestaan!
                EmployeeFilterInterfaceProcessor::finishProcessAction($objResponse);
            }
        }
        return array($hasError, $messages);
    }

}

?>
