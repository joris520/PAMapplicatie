<?php

/**
 * Description of DateTimeConverter
 *
 * @author ben.dokter
 */
class DateTimeConverter
{

    static function display($databaseDateTime, $empty = '-')
    {
        return DateUtils::convertTodisplayDateTime($databaseDateTime, $empty);
    }

    static function input($databaseDateTime, $empty = '')
    {
        return DateUtils::convertTodisplayDateTime($databaseDateTime, $empty);
    }

}

?>
