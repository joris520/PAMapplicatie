<?php

/**
 * Description of EmployeeNameConverter
 *
 * @author ben.dokter
 */

//require_once('application/interface/converter/AbstractBaseConverter.class.php');

class EmployeeNameConverter //extends AbstractBaseConverter
{
    const FORMAT_LASTNAME_FIRST     = 1;
    const FORMAT_FIRSTNAME_FIRST    = 2;

    static function display($firstName, $lastName, $formatMode = self::FORMAT_FIRSTNAME_FIRST)
    {
        $display = $lastName;
        if (!empty($firstName)) {
            if ($formatMode == self::FORMAT_FIRSTNAME_FIRST) {
                $display = $firstName . ' ' . $display;
            } else {
                $display .= ', ' . $firstName;
            }
        }
        return $display;
    }

    static function displaySortable($firstName, $lastName)
    {
        return self::display($firstName, $lastName, self::FORMAT_LASTNAME_FIRST);
    }

    // default de display
    static function input($firstName, $lastName)
    {
        return self::displaySortable($firstName, $lastName);
    }

}
?>
