<?php

/**
 * Description of TimeConverter
 *
 * @author ben.dokter
 */
class TimeConverter
{

    static function display($databaseDateTime, $empty = '-')
    {
        return DateUtils::convertToDisplayTime($databaseDateTime, $empty);
    }

    static function input($databaseDateTime, $empty = '')
    {
        return self::display($databaseDateTime, $empty);
    }

}

?>
