<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EmployeePdpActionController
 *
 * @author ben.dokter
 */
class EmployeePdpActionController
{
    static function processRemove(  $employeeId,
                                    $employeePdpActionId)
    {
        $hasError = true;
        $messages = array();

        BaseQueries::startTransaction();

        EmployeePdpActionService::removeEmployeePdpAction(  $employeeId,
                                                            $employeePdpActionId);

        BaseQueries::finishTransaction();

        $hasError = false;

        return array($hasError, $messages);
    }

    static function processEditUserDefined( $employeeId,
                                            $employeePdpActionId,
                                            EmployeePdpActionUserDefinedValueObject $valueObject)
    {
        $hasError = false;
        $messages = array();

        BaseQueries::startTransaction();

        list($hasError, $messages) = EmployeePdpActionService::validateUserDefined($valueObject);
        if (!$hasError) {
            EmployeePdpActionService::updateValidatedUserDefined(   $employeeId,
                                                                    $employeePdpActionId,
                                                                    $valueObject);

            BaseQueries::finishTransaction();
        }
        return array($hasError, $messages);
    }

    //put your code here
}

?>
