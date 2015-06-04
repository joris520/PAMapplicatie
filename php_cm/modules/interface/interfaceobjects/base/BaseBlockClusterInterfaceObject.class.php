<?php

/**
 * Description of BaseBlockClusterInterfaceObject
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseBlockInterfaceObject.class.php');

class BaseBlockClusterInterfaceObject extends BaseBlockInterfaceObject
{
    const TEMPLATE_FILE = 'base/baseBlockCluster.tpl';

    static function create( BaseInterfaceObject $dataInterfaceObject,
                            $headerTitle,
                            $displayWidth)
    {
        return new BaseBlockClusterInterfaceObject( $dataInterfaceObject,
                                                    $headerTitle,
                                                    $displayWidth,
                                                    self::TEMPLATE_FILE);
    }

    function getHeaderTitleStyled()
    {
        return '<h3>' . self::getHeaderTitle() . '</h3>';
    }
}

?>
