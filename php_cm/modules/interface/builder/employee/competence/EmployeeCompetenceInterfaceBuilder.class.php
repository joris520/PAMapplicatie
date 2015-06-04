<?php

/**
 * Description of EmployeeCompetenceInterfaceBuilder
 *
 * @author hans.prins
 */

require_once('modules/interface/builder/employee/AbstractEmployeeInterfaceBuilder.class.php');

// components
require_once('modules/interface/builder/employee/competence/EmployeeCompetenceInterfaceBuilderComponents.class.php');
require_once('modules/interface/builder/employee/print/EmployeePrintInterfaceBuilderComponents.class.php');

// interfaceObject
require_once('modules/interface/interfaceobjects/employee/competence/EmployeeJobProfileHeaderView.class.php');
require_once('modules/interface/interfaceobjects/employee/EmployeeInfoHeaderView.class.php');
require_once('modules/interface/interfaceobjects/employee/EmployeeInfoHeaderGroup.class.php');

class EmployeeCompetenceInterfaceBuilder extends AbstractEmployeeInterfaceBuilder
{

}

?>
