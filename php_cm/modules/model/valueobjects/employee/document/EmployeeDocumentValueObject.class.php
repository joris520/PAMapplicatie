<?php

/**
 * Description of EmployeeDocumentValueObject
 *
 * @author ben.dokter
 */

require_once('modules/model/valueobjects/employee/BaseEmployeeValueObject.class.php');

class EmployeeDocumentValueObject extends BaseEmployeeValueObject
{
    //private $bla

    static function createWithData($employeeId, $employeeDocumentData)
    {
        return new EmployeeDocumentValueObject( $employeeId,
                                                $employeeDocumentData[EmployeeDocumentQueries::ID_FIELD],
                                                $employeeDocumentData);
    }


    protected function __construct( $employeeId,
                                    $employeeDocumentId,
                                    $employeeDocumentData)
    {
//        parent::__construct($employeeId,
//                            $employeeDocumentId,
//                            $employeeDocumentData['saved_by_user_id'],
//                            $employeeDocumentData['saved_by_user'],
//                            $employeeDocumentData['saved_datetime']);
//
    }

}

?>
