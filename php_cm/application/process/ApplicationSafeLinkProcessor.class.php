<?php

require_once('gino/MessageLogger.class.php');
require_once('application/library/safeLinkConsts.inc.php');
require_once('application/library/SafeLinkHandler.class.php');


class ApplicationSafeLinkProcessor {

    // Aplication methods

    static function logSafeLinkDebugError($objResponse, $linkIdentifier, $safeLinkHandler, $message)
    {
        $errorLog = $linkIdentifier . ' >> ' . $message;
        if (is_object($safeLinkHandler)) {
            $errorLog .= $safeLinkHandler->getErrorMessage();

            $errorStack  = 'Invalid link' . "\n\n";
            $errorStack .= 'Error: ' . $safeLinkHandler->getErrorText() . "\n\n";
            $errorStack .= 'Input formats: ' . print_r($safeLinkHandler->getInputFormats(), true) . "\n\n";
            $errorStack .= 'Clean values:  ' . print_r($safeLinkHandler->retrieveCleanedValues(), true) . "\n\n";
            $errorStack .= 'Link values:   ' . print_r($raw_request_link, true) . "\n\n";
            $errorStack .= 'Trace:' . print_r(debug_backtrace(), true) . "\n\n";

        } else {
            $errorLog .= '$safeLinkHandler is not an object';

            $errorStack  = $errorLog . "\n\n";
            $errorStack .= 'Trace:' . print_r(debug_backtrace(), true) . "\n\n";
        }
        MessageLogger::logError($errorLog, debug_backtrace());

        if (XAJAX_DEBUG_SETTING) {
            InterfaceXajax::alertMessage($objResponse, $errorStack);
        }
    }

    static function process_moduleSafeLink($objResponse, $linkIdentifier, $safeLinkHandler)
    {
        $hasError = false;
        $message = '';
        $enable_button = true;

        try {
            switch ($linkIdentifier) {
                case SAFEFORM_ORGANISATION__PDPACTIONS_ADD_BATCH:
                    list($hasError, $message) = organisation__processSafeLink_addPdpActionsBatch($objResponse, $safeLinkHandler);
                    break;
            }

            if (!empty($message)) {
                InterfaceXajax::alertMessage($objResponse, $message);
            }
        } catch (TimecodeException $timecodeException) {
            PamExceptionProcessor::handleInterfaceException($objResponse, $timecodeException, $message);
        }

        if ($enable_button) {
            InterfaceXajax::enableButton($objResponse, PROCESS_BUTTON);
        }
    }

}

?>
