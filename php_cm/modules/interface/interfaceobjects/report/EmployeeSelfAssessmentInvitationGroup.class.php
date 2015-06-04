<?php

/**
 * Description of EmployeeSelfAssessmentInvitationGroup
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseGroupInterfaceObject.class.php');

class EmployeeSelfAssessmentInvitationGroup extends BaseGroupInterfaceObject
{
    const TEMPLATE_FILE = 'report/employeeSelfAssessmentReportGroup.tpl';

    static function create($displayWidth)
    {
        return new EmployeeSelfAssessmentInvitationGroup(   $displayWidth,
                                                            self::TEMPLATE_FILE);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function addInterfaceObject(SelfAssessmentReportView $interfaceObject)
    {
        parent::addInterfaceObject($interfaceObject);
    }

}

?>
