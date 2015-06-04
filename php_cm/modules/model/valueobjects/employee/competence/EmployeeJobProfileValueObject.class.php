<?php

/**
 * Description of EmployeeJobProfileValueObject
 *
 * @author ben.dokter
 */
require_once('modules/model/valueobjects/employee/BaseEmployeeValueObject.class.php');

class EmployeeJobProfileValueObject extends BaseEmployeeValueObject
{

    private $note;
    private $functionDate;

    // job profile functions
    private $mainFunctionValueObject;
    private $additionalFunctionValueObjects;

    // afgeleiden


    static function createWithData($employeeId, $jobProfileData)
    {
        return new EmployeeJobProfileValueObject(   $employeeId,
                                                    $jobProfileData[EmployeeJobProfileQueries::ID_FIELD],
                                                    $jobProfileData);
    }

    static function createWithValues(   $employeeId,
                                        $jobProfileId,
                                        $note)
    {
        $jobProfileData = array();
        $jobProfileData[EmployeeJobProfileQueries::ID_FIELD]    = $jobProfileId;
        $jobProfileData['note']                                 = $note;
        $jobProfileData['function_date']                        = DateUtils::getCurrentDatabaseDate();

        return new EmployeeJobProfileValueObject(   $employeeId,
                                                    $jobProfileData[EmployeeJobProfileQueries::ID_FIELD],
                                                    $jobProfileData);
    }

    function __construct(   $employeeId,
                            $jobProfileId,
                            $jobProfileData)
    {
        parent::__construct($employeeId,
                            $jobProfileId,
                            $jobProfileData['saved_by_user_id'],
                            $jobProfileData['saved_by_user'],
                            $jobProfileData['saved_datetime']);

        $this->note         = $jobProfileData['note'];
        $this->functionDate = $jobProfileData['function_date'];

        $this->mainFunctionValueObject = NULL;
        $this->additionalFunctionValueObjects = array();
    }


    function setMainFunction(EmployeeJobProfileFunctionValueObject $functionValueObject)
    {
//        if (!empty($this->mainFunctionValueObject)) {
//            $this->addAdditionalFunction($this->mainFunctionValueObject);
//        }
        $this->mainFunctionValueObject = $functionValueObject;
    }

    function getMainFunction()
    {
        return $this->mainFunctionValueObject;
    }

    function getMainFunctionId()
    {
        return $this->mainFunctionValueObject->getFunctionId();
    }

    function addAdditionalFunction(EmployeeJobProfileFunctionValueObject $functionValueObject)
    {
        $this->additionalFunctionValueObjects[] = $functionValueObject;
    }

    function getAdditionalFunctions()
    {
        return $this->additionalFunctionValueObjects;
    }

    function getAdditionalFunctionNames()
    {
        $functionNames = array();
        foreach($this->additionalFunctionValueObjects as $valueObject) {
            $functionNames[] = $valueObject->getFunctionName();
        }
        return $functionNames;
    }

    function hasAdditionalFunctions()
    {
        return count((array)$this->additionalFunctionValueObjects) > 0;
    }

    function getNote()
    {
        return $this->note;
    }

    function setNote($note)
    {
        $this->note = $note;
    }

    function hasNote()
    {
        return !empty($this->note);
    }

    function getFunctionDate()
    {
        return $this->functionDate;
    }

    function setFunctionDate($functionDate)
    {
        $this->functionDate = $functionDate;
    }


}

?>
