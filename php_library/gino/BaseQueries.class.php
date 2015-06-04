<?php

/**
 * Description of baseQueries
 *
 * @author ben.dokter
 */

require_once('gino/MessageLogger.class.php');
require_once('gino/TimecodeException.class.php');
require_once('gino/PhpApplication.class.php');

class BaseQueries
{


    /**
     * gebruikt om de datum van het scherm naar een insertable waarde om te zetten
     * @param type $displayDate
     * @return type
     */
    static function convertDisplayDate($displayDate)
    {
        return 'STR_TO_DATE("' . mysql_real_escape_string($displayDate) . '", "' . APPLICATION_DATE_DISPLAY_TO_DATABASE_FORMAT . '")';
    }

    static function nullableValue($value)
    {
        return empty($value) ? 'NULL' : $value;
    }

    static function nullableString($value)
    {
        return empty($value) ? 'NULL' : '"' . $value . '"';
    }

    /**
     * static functions om text in en uit de database te krijgen
     */
    static function safeTextToDb($toDbText)
    {
        return ($toDbText);
    }

    static function safeTextFromDb($fromDbText)
    {
        return ($fromDbText);
    }

    static function safeTextFromDb2Html($fromDbText)
    {
        // nl2br
        return ($fromDbText);
    }

    static function startTransaction()
    {
        $sql = 'START TRANSACTION';
        return self::performQuery($sql);
    }

    static function finishTransaction()
    {
        $sql = 'COMMIT';
        return self::performQuery($sql);
    }

    static function rollbackTransaction()
    {
        $sql = 'ROLLBACK';
        return mysql_query($sql); // zonder die want deze zit meestal al in een DieOnError oid
    }

    static function performTransactionalQuery($sql)
    {
        return BaseQueries::performQuery($sql, true, true);
    }

    // geeft het result $query terug, zonder transactie
    static function performSelectQuery($sql)
    {
        return self::performQuery($sql, false, true);
    }

    static function performTransactionalSelectQuery($sql)
    {
        return $query = self::performQuery($sql, true, true);
    }

    // geeft het ingevoegde ID terug
    static function performInsertQuery($sql)
    {
        self::performQuery($sql, true, true);
        return @mysql_insert_id();
    }

    // geeft het aantal aangepaste rijen terug
    static function performUpdateQuery($sql)
    {
        self::performQuery($sql, true, true);
        return mysql_affected_rows();
    }

    // geeft het aantal verwijderde rijen terug
    static function performDeleteQuery($sql)
    {
        self::performQuery($sql, true, true);
        return mysql_affected_rows();
    }

    static function performQuery($sql, $rollbackOnError = false, $throwException = false)
    {
        $query = mysql_query($sql) or self::handleSqlError($sql, $rollbackOnError, $throwException);
        return $query;
    }

    static function getDataRow($query)
    {
        return mysql_fetch_assoc($query);
    }

    /**
     * static function handleSqlError($sql, , $rollbackOnError = false, $throwException = false)
     *
     * functie die bij een query error ipv de 'OR die(mysql_error()); aangeroepen moet worden.
     * Als de 'display_errors' op 1 gezet is wordt de debug informatie getoont,
     * anders alleen de melding 'Database Error'.
     * Er komt altijd een melding in (apache) error log file.
     *
     * TODO:
     * - logging wegschrijven naar door Gino leesbare directory zodat we ook eenvoudig op productie hierbij kunnen!
     * -
     *
     * $sql: de betreffende $sql tekst
     * $rollbackOnError: als true dan wordt er een rollback gedaan. Er moet dan wel een transactie gestart zijn, maar dat is eerst nog aan de programmeur!
     * $throwException: gooit een exceptie ipv die();
     *
     * TODO:
     * "zinvolle" errorcode in exceptie meegeven die een gebruiker eventueel via de helpdesk kan melden
     *
     * dus gebruik:
     *         $query = BaseQueries::performQuery($sql);
     */

    private static function handleSqlError($sql, $rollbackOnError = false, $throwException = false)
    {
        $error_msg = mysql_error();

        $function_log = MessageLogger::getCallerLogString(debug_backtrace(false));
        $error_message  = ' ## callstack: ' . $function_log .
                          ' ## query error: ' . $error_msg .
                          ' ## sql: ' . preg_replace('/\s+/', ' ', $sql) . "\n";
        $error_message = str_replace(array("\n","\r"), ' ', $error_message);
        MessageLogger::logError($error_message);


        if (PhpApplication::isDisplayErrorsAllowed()) {
            $die_message = '<pre>'.
                             '<strong>'.
                               '<em>** callstack: ' . $function_log . ':</em>'.
                               '<br />'.
                               '<span style="color:red;">' . $error_msg . '</span>'.
                             '</strong> :<br />' . $sql .
                             '<br /><br />'.
                             '<strong>' .
                               '<em>** call stack:</em>' .
                             '</strong>'.
                             '<br />' .
                             print_r(debug_backtrace(), true) .
                           '</pre>';
        } else {
            $die_message = 'Database Error';
        }
        if ($rollbackOnError) {
            MessageLogger::logWarning('Rollback requested');
            BaseQueries::rollbackTransaction();
        }
        if ($throwException) {
            // exception gooien
            TimecodeException::raise($error_message, PamExceptionCodeValue::SQL_ERROR);
            // TODO: catch!
        } else {
            die($die_message);
        }
    }


    static function LogOnError($sql)
    {
        $error_msg = mysql_error();
        list($caller, $callInFunction) = debug_backtrace(false);
        $function_call = $callInFunction['function'] . '@' . $caller['line'];

        $error_message  = ' SQL error from ' . $function_call . ': ' . $error_msg . "\n";
        $error_message .= ' caused by query: ' . preg_replace('/\s+/', ' ', $sql) . "\n"; // compact spaces
        MessageLogger::logError($error_message);

        return $error_message;
    }
}
?>
