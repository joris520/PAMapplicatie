<?php

/**
 * Description of EmployeeFinalResultController
 *
 * @author ben.dokter
 */
require_once('modules/model/service/employee/finalResult/EmployeeFinalResultService.class.php');

class EmployeeFinalResultController
{

    static function processEdit($employeeId,
                                EmployeeFinalResultValueObject $valueObject)
    {
        $hasError = false;
        $messages = array();

        BaseQueries::startTransaction();

        list($hasError, $messages) = EmployeeFinalResultService::validate($valueObject);
        if (!$hasError) {
            EmployeeFinalResultService::updateValidated($employeeId, $valueObject);

            BaseQueries::finishTransaction();
        }
        return array($hasError, $messages);
    }
}

?>
