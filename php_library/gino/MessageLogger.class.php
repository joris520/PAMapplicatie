<?php

/**
 * Description of MessageLogger
 *
 * @author ben.dokter
 */
class MessageLogger {

    static function logError($message, $stacktrace = null)
    {
        if (!empty($stacktrace)) {
            $functionLog = '   ## callstack:   ' . MessageLogger::getCallerLogString($stacktrace);
        }
        error_log('*** PAM ERROR: ' . $message . $functionLog);
    }

    static function logWarning($message)
    {
        error_log('=== PAM WARNING: ' . $message);
    }


    static function getCallerLogString($stacktrace)
    {
        list($caller0, $caller1, $caller2, $caller3, $caller4) = $stacktrace;
        $functionCall0  = basename($caller0['file']) . '@' . $caller0['line'] . ':' . $caller0['function'];
        $functionCall1  = basename($caller1['file']) . '@' . $caller1['line'] . ':' . $caller1['function'];
        $functionCall2  = basename($caller2['file']) . '@' . $caller2['line'] . ':' . $caller2['function'];
        $functionCall3  = basename($caller3['file']) . '@' . $caller3['line'] . ':' . $caller3['function'];
        $functionCall4  = basename($caller4['file']) . '@' . $caller4['line'] . ':' . $caller4['function'];

        return $functionCall4 . ' >> ' . $functionCall3 . ' >> ' . $functionCall2 . ' >> ' . $functionCall1. ' >> ' . $functionCall0;
    }

}

?>
