<?php

/**
 * Description of BaseGroupInterfaceObject
 *
 * @author ben.dokter
 */
require_once('modules/interface/interfaceobjects/base/BaseInterfaceObject.class.php');

class BaseGroupInterfaceObject extends BaseInterfaceObject
{
    private $interfaceObjects;

    protected function __construct( $displayWidth,
                                    $templateFile)
    {
        parent::__construct($displayWidth,
                            $templateFile);

        $this->interfaceObjects = array();
    }

    // het liefst deze gebruiken
    protected function addInterfaceObject(BaseInterfaceObject $interfaceObject)
    {
        $this->interfaceObjects[] = $interfaceObject;
    }

    // eventueel deze...
    function setInterfaceObjects($interfaceObjects)
    {
        $this->interfaceObjects = $interfaceObjects;
    }

    //
    function getInterfaceObjects()
    {
        return $this->interfaceObjects;
    }

    function hasInterfaceObjects()
    {
        return count($this->interfaceObjects) > 0;
    }

    function getCount()
    {
        return count($this->interfaceObjects);
    }



}

?>
