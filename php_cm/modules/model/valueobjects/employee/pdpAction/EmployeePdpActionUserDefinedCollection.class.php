<?php

/**
 * Description of EmployeePdpActionUserDefinedCollection
 * alle userdefined employee pdp acties met dezelfde basis pdp action
 *
 * @author ben.dokter
 */

require_once('modules/model/valueobjects/BaseCollection.class.php');

require_once('modules/model/valueobjects/employee/pdpAction/EmployeePdpActionUserDefinedValueObject.class.php');


class EmployeePdpActionUserDefinedCollection extends BaseCollection
{
    private $pdpActionName;
    private $isCustomerLibrary;

    static function create( $pdpActionId,
                            $pdpActionName,
                            $isCustomerLibrary)
    {
        return new EmployeePdpActionUserDefinedCollection(  $pdpActionId,
                                                            $pdpActionName,
                                                            $isCustomerLibrary);
    }

    protected function __construct( $pdpActionId,
                                    $pdpActionName,
                                    $isCustomerLibrary)
    {
        parent::__construct($pdpActionId);
        $this->pdpActionName        = $pdpActionName;
        $this->isCustomerLibrary    = $isCustomerLibrary;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getPdpActionName()
    {
        return $this->pdpActionName;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function isCustomerLibrary()
    {
        return $this->isCustomerLibrary;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function addValueObject(EmployeePdpActionUserDefinedValueObject $valueObject)
    {
        parent::addValueObject($valueObject);
    }


}

?>
