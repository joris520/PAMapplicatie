<?php


/**
 * Description of AbstractBasePrintOption
 *
 * @author ben.dokter
 */

abstract class AbstractBasePrintOption
{

    // om er zeker van te zijn dat deze functies aanwezig zijn
    // TODO: eigenlijk is dit een php::interface
    abstract static function isValidOption($option);
    abstract static function options();


    protected static function isAllowedOption($option, $options)
    {
        return !empty($option) && in_array($option, $options);
    }
}

?>
