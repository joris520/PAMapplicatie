<?php


/**
 * Description of AbstractBaseInterfaceState
 *
 * @author ben.dokter
 */

abstract class AbstractBaseInterfaceState
{


    // om er zeker van te zijn dat deze functies aanwezig zijn
    // TODO: eigenlijk is dit een php::interface
    abstract static function isValidState($state);
    abstract static function states();


    protected static function isAllowedState($state, $states)
    {
        return !empty($state) && in_array($state, $states);
    }
}

?>
