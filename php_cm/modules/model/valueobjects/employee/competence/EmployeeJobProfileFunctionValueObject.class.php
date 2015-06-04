<?php

/**
 * Description of EmployeeJobProfileFunctionValueObject
 *
 * @author ben.dokter
 */
require_once('application/model/valueobjects/BaseValueObject.class.php');

class EmployeeJobProfileFunctionValueObject extends BaseEmployeeValueObject
{

    private $jobProfileId;

    private $functionId;
    private $functionName;
    private $isMainFunction;


    static function createWithData( $employeeId,
                                    $jobProfileId,
                                    $functionData)
    {
        return new EmployeeJobProfileFunctionValueObject(   $employeeId,
                                                            $jobProfileId,
                                                            $functionData[EmployeeJobProfileFunctionQueries::ID_FIELD],
                                                            $functionData);
    }

    static function createWithValues(   $employeeId,
                                        $jobProfileId,
                                        $jobProfileFunctionId,
                                        $functionId,
                                        $functionName,
                                        $isMainFunction)
    {
        $functionData = array();
        $functionData[EmployeeJobProfileQueries::ID_FIELD]          = $jobProfileId;            // parent
        $functionData[EmployeeJobProfileFunctionQueries::ID_FIELD]  = $jobProfileFunctionId;
        $functionData['ID_F']                                       = $functionId;
        $functionData['function']                                   = $functionName;
        $functionData['is_main_function']                           = $isMainFunction;

        return new EmployeeJobProfileFunctionValueObject(   $employeeId,
                                                            $jobProfileId,
                                                            $functionData[EmployeeJobProfileFunctionQueries::ID_FIELD],
                                                            $functionData);
    }
    /**
     * constructor
     * @param type $employeeId
     * @param type $mainFunctionId
     * @param type $functionData
     */
    function __construct(   $employeeId,
                            $jobProfileId,
                            $jobProfileFunctionId,
                            $functionData)
    {
        parent::__construct($employeeId,
                            $jobProfileFunctionId,
                            $functionData['saved_by_user_id'],
                            $functionData['saved_by_user'],
                            $functionData['saved_datetime']);

        $this->jobProfileId     = $jobProfileId;
        $this->functionId       = $functionData['ID_F'];
        $this->functionName     = $functionData['function'];
        $this->isMainFunction   = $functionData['is_main_function'] == 1;
    }

    function getFunctionId()
    {
        return $this->functionId;
    }

    function getFunctionName()
    {
        return $this->functionName;
    }

    function isMainFunction()
    {
        return $this->isMainFunction;
    }

}

?>
