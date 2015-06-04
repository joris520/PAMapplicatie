<?php

/**
 * Description of EmployeeProfileInterfaceBuilder
 *
 * @author ben.dokter
 */

require_once('modules/interface/builder/employee/AbstractEmployeeInterfaceBuilder.class.php');
require_once('modules/interface/builder/employee/profile/EmployeeProfileInterfaceBuilderComponents.class.php');
require_once('modules/interface/builder/list/EmployeeListInterfaceBuilderComponents.class.php');


class EmployeeProfileInterfaceBuilder extends AbstractEmployeeInterfaceBuilder
{
    static function getEmployeeInfoHeaderHtml(  $displayWidth,
                                                $employeeId,
                                                EmployeeInfoValueObject $infoValueObject,
                                                EmployeeJobProfileValueObject $jobProfileValueObject = NULL)
    {
        $groupInterfaceObject = parent::getGroupInterfaceObject($displayWidth,
                                                                $employeeId,
                                                                $infoValueObject,
                                                                $jobProfileValueObject);

        $groupInterfaceObject->getInfoInterfaceObject()->setIsAllowedAddPhoto();
        // de verwijder medewerker link toevoegen
        $groupInterfaceObject->getInfoInterfaceObject()->addActionLink( '<br/><br/>' . EmployeeListInterfaceBuilderComponents::getDeleteLink($employeeId));

        return $groupInterfaceObject->fetchHtml();
    }

}

?>
