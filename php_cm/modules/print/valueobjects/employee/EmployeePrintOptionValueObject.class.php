<?php

/**
 * Description of EmployeePrintOptionValueObject
 *
 * @author hans.prins
 */

require_once('modules/print/valueobjects/BasePrintOptionValueObject.class.php');

class EmployeePrintOptionValueObject extends BasePrintOptionValueObject
{
    private $employeeIds;
    private $assessmentCycleValueObject;

    private $selectedModules;
    private $detailPrintOptionValueObjects;


    static function create( Array $employeeIds,
                            Array $printOptions,
                            AssessmentCycleValueObject $assessmentCycleValueObject)
    {
        return new EmployeePrintOptionValueObject(  $employeeIds,
                                                    $printOptions,
                                                    $assessmentCycleValueObject);
    }

    protected function __construct( Array $employeeIds,
                                    Array $printOptions,
                                    AssessmentCycleValueObject $assessmentCycleValueObject)
    {
        parent::__construct($printOptions);
        $this->assessmentCycleValueObject   = $assessmentCycleValueObject;
        $this->employeeIds                  = $employeeIds;

        $this->init($printOptions);
    }

    protected function init(Array $printOptions)
    {
        foreach($printOptions as $printOption) {
            $this->selectedModules[$printOption] = BooleanValue::FALSE;
        }
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setDetailPrintOptionValueObject($printOption,
                                             BaseDetailPrintOptionValueObject $detailPrintOptionValueObjects)
    {
        $this->detailPrintOptionValueObjects[$printOption] = $detailPrintOptionValueObjects;
    }

    function getDetailPrintOptionValueObject($printOption)
    {
        return $this->detailPrintOptionValueObjects[$printOption];
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getAssessmentCycleValueObject()
    {
        return $this->assessmentCycleValueObject;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getEmployeeIds()
    {
        return $this->employeeIds;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setSelectedModuleOption($printOption, $moduleOptionValue)
    {
         $this->selectedModules[$printOption] = $moduleOptionValue;
    }

    function getSelectedModuleOption($printOption)
    {
        return $this->selectedModules[$printOption];
    }

    function selectedModuleOption($printOption)
    {
        return $this->selectedModules[$printOption]  == BooleanValue::TRUE;
    }

//    //////////////////////////////////////////////////////////////////////////////////////////////////////////
//    function setModuleAttachment($moduleAttachment)
//    {
//        $this->moduleAttachment = $moduleAttachment;
//    }
//
//    function getShowModuleAttachment()
//    {
//        return $this->moduleAttachment;
//    }
//
//    function showModuleAttachment()
//    {
//        return $this->moduleAttachment  == BooleanValue::TRUE;
//    }
//
//    //////////////////////////////////////////////////////////////////////////////////////////////////////////
//    function setModuleProfile($moduleProfile)
//    {
//        $this->moduleProfile = $moduleProfile;
//    }
//
//    function getShowModuleProfile()
//    {
//        return $this->moduleProfile;
//    }
//
//    function showModuleProfile()
//    {
//        return $this->moduleProfile == BooleanValue::TRUE;
//    }
//
//    //////////////////////////////////////////////////////////////////////////////////////////////////////////
//    function setModuleCompetence($moduleCompetence)
//    {
//        $this->moduleCompetence = $moduleCompetence;
//    }
//
//    function getShowModuleCompetence()
//    {
//        return $this->moduleCompetence;
//    }
//
//    function showModuleCompetence()
//    {
//        return $this->moduleCompetence == BooleanValue::TRUE;
//    }
//
//    //////////////////////////////////////////////////////////////////////////////////////////////////////////
//    function setModulePdpAction($modulePdpAction)
//    {
//        $this->modulePdpAction = $modulePdpAction;
//    }
//
//    function getShowModulePdpAction()
//    {
//        return $this->modulePdpAction;
//    }
//
//    function showModulePdpAction()
//    {
//        return $this->modulePdpAction == BooleanValue::TRUE;
//    }
//
//    //////////////////////////////////////////////////////////////////////////////////////////////////////////
//    function setModulePdpCost($modulePdpCost)
//    {
//        $this->modulePdpCost = $modulePdpCost;
//    }
//
//    function getShowModulePdpCost()
//    {
//        return $this->modulePdpCost;
//    }
//
//    function showModulePdpCost()
//    {
//        return $this->modulePdpCost == BooleanValue::TRUE;
//    }
//
//    //////////////////////////////////////////////////////////////////////////////////////////////////////////
//    function setModuleTarget($moduleTarget)
//    {
//        $this->moduleTarget = $moduleTarget;
//    }
//
//    function getShowModuleTarget()
//    {
//        return $this->moduleTarget;
//    }
//
//    function showModuleTarget()
//    {
//        return $this->moduleTarget == BooleanValue::TRUE;
//    }
//
//    //////////////////////////////////////////////////////////////////////////////////////////////////////////
//    function setModule360($module360)
//    {
//        $this->module360 = $module360;
//    }
//
//    function getShowModule360()
//    {
//        return $this->module360;
//    }
//
//    function showModule360()
//    {
//        return $this->module360 == BooleanValue::TRUE;
//    }
//
//    //////////////////////////////////////////////////////////////////////////////////////////////////////////
//    function setModuleSignature($moduleSignature)
//    {
//        $this->moduleSignature = $moduleSignature;
//    }
//
//    function getShowModuleSignature()
//    {
//        return $this->moduleSignature;
//    }
//
//    function showModuleSignature()
//    {
//        return $this->moduleSignature == BooleanValue::TRUE;
//    }
//
//    //////////////////////////////////////////////////////////////////////////////////////////////////////////
//    function setCompetenceOptionsValueObject(EmployeeCompetenceDetailPrintOptionValueObject $competenceOptionsValueObject)
//    {
//        $this->competenceOptionsValueObject = $competenceOptionsValueObject;
//    }
//
//    function getCompetenceOptionsValueObject()
//    {
//        return $this->competenceOptionsValueObject;
//    }
//
//    //////////////////////////////////////////////////////////////////////////////////////////////////////////
//    function setTargetOptionsValueObject(EmployeeAssessmentCycleDetailPrintOptionValueObject $targetOptionsValueObject)
//    {
//        $this->targetOptionsValueObject = $targetOptionsValueObject;
//    }
//
//    function getTargetOptionsValueObject()
//    {
//        return $this->targetOptionsValueObject;
//    }
}

?>
