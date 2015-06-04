<?php

/**
 * Description of EmployeeProfileOrganisationView
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');

class EmployeeProfileOrganisationView extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'employee/profile/employeeProfileOrganisationView.tpl';

    static function createWithValueObject(  EmployeeProfileOrganisationValueObject $valueObject,
                                            $displayWidth)
    {
        return new EmployeeProfileOrganisationView( $valueObject,
                                                    $displayWidth,
                                                    self::TEMPLATE_FILE);
    }

}

?>
