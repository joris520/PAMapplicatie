<?php

/**
 * Description of DateUtils
 *
 * @author ben.dokter
 */

class DateUtils
{
    const MAX_DATE = '9999-12-12';
    const ValiDateCodeOK = 0;
    const ValiDateCodeDate = 1;
    const ValiDateCodeFormat = 2;

    static function getCurrentDisplayDate()
    {
        return date(APPLICATION_DATE_DISPLAY_FORMAT, time());
    }

    static function getCurrentTimecode()
    {
        return date(APPLICATION_DATETIME_FLAT_FORMAT, time());
    }

    static function getCurrentDisplayDateTime()
    {
        return date(APPLICATION_DATETIME_DISPLAY_FORMAT, time());
    }

    static function convertToDisplayDate($databaseDate, $emptyText = '')
    {
        return ($databaseDate > 0 && $databaseDate != self::MAX_DATE) ? date(APPLICATION_DATE_DISPLAY_FORMAT, strtotime($databaseDate)) : $emptyText;
    }

    static function convertToInputDate($datebaseDate)
    {
        return self::convertToDisplayDate($datebaseDate);
    }

    static function convertToDisplayDateTime($databaseDateTime, $emptyText = '')
    {
        return ($databaseDateTime > 0) ? date(APPLICATION_DATETIME_DISPLAY_FORMAT, strtotime($databaseDateTime)) : $emptyText;
    }

    static function convertToDisplayTime($databaseDateTime, $emptyText = '')
    {
        return ($databaseDateTime > 0) ? date(APPLICATION_TIME_DISPLAY_FORMAT, strtotime($databaseDateTime)) : $emptyText;
    }

    static function calculateRelativeDisplayDate($date, $daysOffset)
    {
        return date(APPLICATION_DATE_DISPLAY_FORMAT, strtotime($daysOffset . ' day', strtotime($date)));
    }

    // geeft error-code terug (empty == ok). voorkeurnotatie: dd-mm-yyyy;
    static function ValidateDisplayDate($date_string) {
        // lengte check...
        $validate_code = self::ValiDateCodeOK; // ok
        if ((strlen($date_string)<10 || strlen($date_string)>10)  ||
            (substr_count($date_string, '-') != 2)) {
            $validate_code = self::ValiDateCodeDate; //$validate_message .= 'niet het juiste formaat: dd-mm-yyyy';
        } else {
            $validate_code = self::ValiDateCodeFormat; //$validate_message .= ' geen geldige datum';
            $date_fields = explode('-', $date_string);
            if (count($date_fields) == 3) {
                if (ereg('^[0-9]+$',   $date_fields[0]) && // dag
                    ereg('^[0-9]+$', $date_fields[1])   && // maand
                    ereg('^[0-9]+$',  $date_fields[2])) {  // jaar
                    if (checkdate($date_fields[1] , $date_fields[0], $date_fields[2])) {
                        $validate_code = self::ValiDateCodeOK; // ok
                    }
                }
            }
        }
        return $validate_code;
    }

    static function getCurrentDatabaseDate()
    {
        return date(APPLICATION_DATE_DATABASE_FORMAT, time());
    }


    // TODO: exceptie gooien
    static function convertToDatabaseDate($displayDate)
    {
        $convertedDate = null;
        if (DateUtils::ValidateDisplayDate($displayDate) == self::ValiDateCodeOK) {
            $convertedDate = date(APPLICATION_DATE_DATABASE_FORMAT, strtotime($displayDate));
        }
        return $convertedDate;
    }

    static function getMaxNowOrDate($checkDate)
    {
        $todayDate = date("Y-m-d");
        $compare = strtotime($checkDate);
        $today = strtotime($todayDate);
        return ($today > $compare) ? $todayDate: $checkDate;
    }

    static function getMaxOfDates($date1, $date2)
    {
        $resultDate = $date2;
        if (!empty($date1) && $date1 > 0) {
            $date = strtotime($date1);
            $compare = strtotime($date2);
            $resultDate = ($date > $compare) ? $date1 : $date2;
        }
        return $resultDate;
    }

    static function isBefore($beforeDateTime, $checkDateTime)
    {
        $isBefore = false;
        if (!empty($beforeDateTime)) {
            $compare = strtotime($beforeDateTime);
            $date    = strtotime($checkDateTime);
            $isBefore = ($date < $compare);
        }
        return $isBefore;
    }

    static function isBeforeDate($beforeDate, $checkDate)
    {
        $isBefore = false;
        if (!empty($beforeDate)) {
            $beforeDate = date_format(date_create($beforeDate), APPLICATION_DATE_DATABASE_FORMAT);
            $checkDate    = date_format(date_create($checkDate),APPLICATION_DATE_DATABASE_FORMAT);
            $isBefore = self::isBefore($beforeDate, $checkDate);
        }
        return $isBefore;
    }
}

?>
