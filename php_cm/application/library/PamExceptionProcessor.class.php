<?php

require_once('application/interface/InterfaceXajax.class.php');
require_once('gino/MessageLogger.class.php');
require_once('gino/TimecodeException.class.php');

class PamExceptionProcessor extends TimecodeException
{
    static function handleInterfaceException($objResponse, $timecodeException, $interfaceMessage = null)
    {
        if (!empty($interfaceMessage)) {
            $interfaceMessage .= "\n\n";
        }
        if (PamApplication::isDisplayErrorsAllowed()) {
            InterfaceXajax::alertMessage($objResponse, $interfaceMessage .
                                                       'meldcode: '  . $timecodeException->code . '-' . $timecodeException->timecode . "\n\n" .
                                                       $timecodeException->getMessage());
        } else {
            InterfaceXajax::alertMessage($objResponse, $interfaceMessage .
                                                       'Uw verzoek kon niet verwerkt worden, meldcode: '  . $timecodeException->code . '-' . $timecodeException->timecode);
        }
    }

    static function handleCronException($timecodeException, $cronMessage = null)
    {
        if (!empty($cronMessage)) {
            $cronMessage .= ' >>> ';
        }
        $cronMessage = $cronMessage . 'meldcode: '  . $timecodeException->code . '-' . $timecodeException->timecode;
        MessageLogger::logError($cronMessage . ' >>> ' .
                                $timecodeException->getMessage());
        if (PamApplication::isDisplayErrorsAllowed()) {
            echo $cronMessage;
        }
        return $cronMessage;
    }

    static function handleWarning($code, $message)
    {
        MessageLogger::logWarning('handleWarning: ' . $code . ' - ' . $message);
        if (PamApplication::isDisplayErrorsAllowed()) {
            MessageLogger::logWarning('handleWarning: THROWING EXCEPTION:');
            TimecodeException::raise('handleWarning: ' . $code . ' - ' . $message, PamExceptionCodeValue::WARNING_HANDLER);
        } else {
            MessageLogger::logWarning('handleWarning: JUST LOGGING WARNING, KEEP BREATHING...');
        }
    }

    static function handleError($code, $message, $errfile, $errline)
    {
        $logMessage = $message . ' file: ' . $errfile . '@' . $errline;
        MessageLogger::logError('handleError: ' . $code . ' - ' . $logMessage);
        MessageLogger::logError('handleError: RETHROWING EXCEPTION:');

        TimecodeException::raise('handleError: ' . $code . ' - ' . $logMessage, PamExceptionCodeValue::ERROR_HANDLER);

//        // Implements just-in-time classes for broad type hinting
//        if (TypeHint::handleTypehint($errno, $errstr)){
//            return true;
//        }

    }
}
?>
