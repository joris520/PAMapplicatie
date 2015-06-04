<?php

/**
 * Description of PdpActionSelectGroup
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseGroupInterfaceObject.class.php');

class PdpActionSelectGroup extends BaseGroupInterfaceObject
{
    const TEMPLATE_FILE = 'library/pdpActionSelectGroup.tpl';

    private $contentHeight;

    static function create( $displayWidth,
                            $contentHeight)
    {
        return new PdpActionSelectGroup($displayWidth,
                                        $contentHeight);
    }

    protected function __construct( $displayWidth,
                                    $contentHeight)
    {
        parent::__construct($displayWidth,
                            self::TEMPLATE_FILE);

        $this->contentHeight = $contentHeight;

        $this->setEmptyMessage(TXT_UCF('NO_PDP_ACTION_ADDED_FROM_PDP_ACTION_LIBRARY_YET'));
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function addInterfaceObject(PdpActionSelectClusterGroup $interfaceObject)
    {
        parent::addInterfaceObject($interfaceObject);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getContentHeight()
    {
        return $this->getDisplayStyle($this->contentHeight);
    }

}

?>
