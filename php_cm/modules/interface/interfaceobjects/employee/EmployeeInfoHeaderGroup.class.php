<?php

/**
 * Description of EmployeeInfoHeaderGroup
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseGroupInterfaceObject.class.php');
require_once('modules/interface/interfaceobjects/report/AssessmentProcessDashboardView.class.php');

class EmployeeInfoHeaderGroup extends BaseGroupInterfaceObject
{
    const TEMPLATE_FILE = 'employee/employeeInfoHeaderGroup.tpl';

    private $infoInterfaceObject;
    private $jobProfileInterfaceObject;
    private $showJobProfile;

    static function create( EmployeeInfoHeaderView $infoInterfaceObject,
                            EmployeeJobProfileView $jobProfileInterfaceObject = NULL,
                            $displayWidth = '')
    {
        return new EmployeeInfoHeaderGroup( $infoInterfaceObject,
                                            $jobProfileInterfaceObject,
                                            $displayWidth);
    }

    protected function __construct( EmployeeInfoHeaderView $infoInterfaceObject,
                                    EmployeeJobProfileView $jobProfileInterfaceObject = NULL,
                                    $displayWidth = '')
    {
        parent::__construct($displayWidth,
                            self::TEMPLATE_FILE);

        $this->infoInterfaceObject          = $infoInterfaceObject;
        $this->jobProfileInterfaceObject    = $jobProfileInterfaceObject;
        $this->showJobProfile               = (!is_null($jobProfileInterfaceObject));
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getInfoInterfaceObject()
    {
        return $this->infoInterfaceObject;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setShowJobProfile($showJobProfile)
    {
        return $this->showJobProfile = $showJobProfile;
    }

    function showJobProfile()
    {
        return $this->showJobProfile;
    }
    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getJobProfileInterfaceObject()
    {
        return $this->jobProfileInterfaceObject;
    }

}

?>