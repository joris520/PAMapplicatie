<?php

/**
 * Description of DateConverter
 *
 * @author ben.dokter
 */
class DateConverter
{

    static function display($databaseDate, $empty = '-')
    {
        return DateUtils::convertTodisplayDate($databaseDate, $empty);
    }

    static function displayDateTime($valueObjectDateTime, $emptyText = '-')
    {
        return DateUtils::convertTodisplayDateTime($valueObjectDateTime, $emptyText);
    }

    static function input($databaseDate, $empty = '')
    {
        return DateUtils::convertTodisplayDate($databaseDate, $empty);
    }


}

?>
