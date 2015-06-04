<?php

/**
 * Description of EmployeePdpActionUserDefinedValueObject
 *
 * @author ben.dokter
 */
require_once('modules/model/valueobjects/library/PdpActionValueObject.class.php');

class EmployeePdpActionUserDefinedValueObject extends PdpActionValueObject
{

    private $employeePdpActionId;
    private $employeeId;

    private $todoBeforeDate;
    private $completedStatus;

    private $userDefinedActionName;
    private $userDefinedProvider;
    private $userDefinedDuration;
    private $userDefinedCost;

    private $isCustomerLibrary;
    private $isUserDefined;

    private $libraryActionName;
    private $libraryProvider;
    private $libraryDuration;
    private $libraryCost;

    private $employeeFirstName;
    private $employeeLastName;
    private $bossFirstName;
    private $bossLastName;
    private $department;

    static function createWithData( $pdpActionUserDefinedData)
    {
        return new EmployeePdpActionUserDefinedValueObject( $pdpActionUserDefinedData[EmployeePdpActionQueries::PDP_ACTION_ID_FIELD],
                                                            $pdpActionUserDefinedData[EmployeePdpActionQueries::ID_FIELD],
                                                            $pdpActionUserDefinedData);
    }

    static function createWithValues(   $employeeId,
                                        $employeePdpActionId,
                                        $pdpActionId,
                                        $userDefinedActionName,
                                        $userDefinedProvider,
                                        $userDefinedDuration,
                                        $userDefinedCost,
                                        $isCustomerLibrary,
                                        $isUserDefined)
    {
        $pdpActionUserDefinedData = array();
        $pdpActionUserDefinedData['ID_E']                   = $employeeId;
        $pdpActionUserDefinedData['user_action']            = $userDefinedActionName;
        $pdpActionUserDefinedData['user_provider']          = $userDefinedProvider;
        $pdpActionUserDefinedData['user_duration']          = $userDefinedDuration;
        $pdpActionUserDefinedData['user_costs']             = $userDefinedCost;
        $pdpActionUserDefinedData['is_customer_library']    = $isCustomerLibrary ? PDP_ACTION_LIBRARY_CUSTOMER : PDP_ACTION_LIBRARY_SYSTEM;
        $pdpActionUserDefinedData['is_user_defined']        = $isUserDefined ? PDP_ACTION_USER_DEFINED : PDP_ACTION_FROM_LIBRARY;

        return new EmployeePdpActionUserDefinedValueObject( $pdpActionId,
                                                            $employeePdpActionId,
                                                            $pdpActionUserDefinedData);

    }

    protected function __construct( $pdpActionId,
                                    $employeePdpActionId,
                                    $pdpActionUserDefinedData)
    {
        parent::__construct($pdpActionId,
                            $pdpActionUserDefinedData);

        $this->employeePdpActionId              = $employeePdpActionId;
        $this->todoBeforeDate                   = $pdpActionUserDefinedData['end_date'];
        $this->completedStatus                  = $pdpActionUserDefinedData['is_completed'];

        $this->userDefinedActionName            = $pdpActionUserDefinedData['user_action'];
        $this->userDefinedProvider              = $pdpActionUserDefinedData['user_provider'];
        $this->userDefinedDuration              = $pdpActionUserDefinedData['user_duration'];
        $this->userDefinedCost                  = $pdpActionUserDefinedData['user_costs'];
        $this->isCustomerLibrary                = $pdpActionUserDefinedData['is_customer_library'] == PDP_ACTION_LIBRARY_CUSTOMER;
        $this->isUserDefined                    = $pdpActionUserDefinedData['is_user_defined'] == PDP_ACTION_USER_DEFINED;

        $this->libraryActionName                = $pdpActionUserDefinedData['action'];
        $this->libraryProvider                  = $pdpActionUserDefinedData['provider'];
        $this->libraryDuration                  = $pdpActionUserDefinedData['duration'];
        $this->libraryCost                      = $pdpActionUserDefinedData['costs'];

        $this->employeeId                       = $pdpActionUserDefinedData['ID_E'];
        $this->employeeFirstName                = $pdpActionUserDefinedData['employee_first_name'];
        $this->employeeLastName                 = $pdpActionUserDefinedData['employee_last_name'];
        $this->bossFirstName                    = $pdpActionUserDefinedData['boss_first_name'];
        $this->bossLastName                     = $pdpActionUserDefinedData['boss_last_name'];
        $this->department                       = $pdpActionUserDefinedData['department'];

    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getEmployeePdpActionId()
    {
        return $this->employeePdpActionId;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getEmployeeId()
    {
        return $this->employeeId;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getUserDefinedActionName()
    {
        return $this->userDefinedActionName;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getUserDefinedProvider()
    {
        return $this->userDefinedProvider;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getUserDefinedDuration()
    {
        return $this->userDefinedDuration;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getUserDefinedCost()
    {
        return $this->userDefinedCost;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function isUserDefined()
    {
        return $this->isUserDefined;
    }

    function isCustomerLibrary()
    {
        return $this->isCustomerLibrary;
    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getLibraryActionName()
    {
        return $this->libraryActionName;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getLibraryProvider()
    {
        return $this->libraryProvider;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getLibraryDuration()
    {
        return $this->libraryDuration;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getLibraryCost()
    {
        return $this->libraryCost;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getTodoBeforeDate()
    {
        return $this->todoBeforeDate;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getIsCompletedStatus()
    {
        return $this->completedStatus;
    }

    function isNotCompleted()
    {
        return $this->completedStatus == PdpActionCompletedStatusValue::NOT_COMPLETED;
    }

    function isCompleted()
    {
        return $this->completedStatus == PdpActionCompletedStatusValue::COMPLETED;
    }

    function isCancelled()
    {
        return $this->completedStatus == PdpActionCompletedStatusValue::CANCELLED;
    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getEmployeeFirstName()
    {
        return $this->employeeFirstName;
    }

    function getEmployeeLastName()
    {
        return $this->employeeLastName;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getBossFirstName()
    {
        return $this->bossFirstName;
    }

    function getBossLastName()
    {
        return $this->bossLastName;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getDepartmentName()
    {
        return $this->department;
    }

}

?>
