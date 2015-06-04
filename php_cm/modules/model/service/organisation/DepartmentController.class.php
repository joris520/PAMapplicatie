<?php

/**
 * Description of DepartmentController
 *
 * @author ben.dokter
 */

require_once('modules/model/service/organisation/DepartmentService.class.php');

class DepartmentController
{

    static function processAdd(DepartmentValueObject $valueObject)
    {
        $hasError = false;
        $messages = array();

        BaseQueries::startTransaction();

        list($hasError, $messages) = DepartmentService::validate($valueObject);
        if (!$hasError) {
            $newDepartmentId = DepartmentService::addValidated($valueObject);

            BaseQueries::finishTransaction();
        }
        return array($hasError, $messages, $newDepartmentId);
    }

    static function processEdit($departmentId,
                                DepartmentValueObject $valueObject)
    {
        $hasError = false;
        $messages = array();

        BaseQueries::startTransaction();

        list($hasError, $messages) = DepartmentService::validate($valueObject);
        if (!$hasError) {
            DepartmentService::updateValidated($departmentId, $valueObject);

            BaseQueries::finishTransaction();
        }
        return array($hasError, $messages);
    }

    static function processRemove($departmentId)
    {
        $hasError = false;
        $messages = array();

        BaseQueries::startTransaction();

        list($hasError, $messages) = DepartmentService::validateRemove($departmentId);
        if (!$hasError) {
            DepartmentService::remove($departmentId);

            BaseQueries::finishTransaction();
        }
        return array($hasError, $messages);
    }

}

?>
