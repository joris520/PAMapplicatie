<?php

/**
 * Description of BaseCollection
 *
 * @author ben.dokter
 */

require_once('application/model/valueobjects/BaseValueObject.class.php');

class BaseCollection
{
    protected $id;
    protected $valueObjects;

    protected function __construct($id = NULL)
    {
        $this->id           = $id;
        $this->valueObjects = array();
    }

    protected function addValueObject(/*BaseValueObject*/ $valueObject)
    {
        $this->valueObjects[] = $valueObject;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getId()
    {
        return $this->id;
    }

    /**
     *
     * @return BaseValueObject
     */
    function getValueObjects()
    {
        return $this->valueObjects;
    }

    function hasValueObjects()
    {
        return count($this->valueObjects) > 0;
    }

}

?>
