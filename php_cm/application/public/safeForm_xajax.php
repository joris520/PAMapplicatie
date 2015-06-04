<?php

require_once('gino/MessageLogger.class.php');
require_once('application/library/safeFormConsts.inc.php');
require_once('application/library/safeDirectConsts.inc.php');
require_once('application/library/SafeFormHandler.class.php');
require_once('application/process/ApplicationSafeFormProcessor.class.php');

function moduleApplication_processSafeForm($formIdentifier, $raw_request_form)
{
    return _processSafeForm($formIdentifier, $raw_request_form, false);
}

function moduleApplication_processPopupSafeForm($formIdentifier, $raw_request_form)
{
    return _processSafeForm($formIdentifier, $raw_request_form, true);
}

function moduleApplication_processFilterSafeForm($formIdentifier, $raw_request_form)
{
    return _processFilterSafeForm($formIdentifier, $raw_request_form);

}

function moduleApplication_processActionSafeForm($formIdentifier, $raw_request_form, $button_id)
{
    return _processActionSafeForm($formIdentifier, $raw_request_form, $button_id);

}


function _processSafeForm($formIdentifier, $raw_request_form, $inPopup)
{
    $objResponse = new xajaxResponse();

    if (PamApplication::hasValidSession($objResponse)) {
        //handig debug regeltje:
        //die('_processSafeForm $formIdentifier: ' . $formIdentifier . "\n" . '$raw_request_form: ' . print_r($raw_request_form, true));
        list($isValidForm, $safeFormHandler, $message) = SafeFormHandler::retrieveAndValidate($formIdentifier, $raw_request_form);

        if ($isValidForm) {
            if (MODULE_SUBSET == MODULE_SUBSET_CUSTOMERS && PamApplication::isSysAdminUser()) {
                ApplicationSafeFormProcessor::process_sysAdminSafeForm($objResponse, $formIdentifier, $safeFormHandler);
            } else {
                ApplicationSafeFormProcessor::process_moduleSafeForm($objResponse, $formIdentifier, $safeFormHandler, $inPopup);
            }
        } else {
            ApplicationSafeFormProcessor::logSafeFormDebugError($objResponse, $formIdentifier, $safeFormHandler, $message);
        }
    }
    return $objResponse;
}

function _processFilterSafeForm($formIdentifier, $raw_request_form)
{
    $objResponse = new xajaxResponse();

    if (PamApplication::hasValidSession($objResponse)) {
        //handig debug regeltje:
        //die('_processFilterSafeForm $formIdentifier: ' . $formIdentifier . "\n" . '$raw_request_form: ' . print_r($raw_request_form, true));
        list($isValidForm, $safeFormHandler, $message) = SafeFilterHandler::retrieveAndValidate($formIdentifier, $raw_request_form);

        if ($isValidForm) {
            ApplicationSafeFormProcessor::process_filterSafeForm($objResponse, $formIdentifier, $safeFormHandler);
        } else {
            ApplicationSafeFormProcessor::logSafeFormDebugError($objResponse, $formIdentifier, $safeFormHandler, $message);
        }
    }
    return $objResponse;
}

function _processActionSafeForm($formIdentifier, $raw_request_form, $button_id)
{
    $objResponse = new xajaxResponse();

    if (PamApplication::hasValidSession($objResponse)) {
        //handig debug regeltje:
        //die('_processFilterSafeForm $formIdentifier: ' . $formIdentifier . "\n" . '$raw_request_form: ' . print_r($raw_request_form, true));
        list($isValidForm, $safeFormHandler, $message) = SafeActionHandler::retrieveAndValidate($formIdentifier, $raw_request_form);

        if ($isValidForm) {
            ApplicationSafeFormProcessor::process_actionSafeForm($objResponse, $formIdentifier, $safeFormHandler, $button_id);
        } else {
            ApplicationSafeFormProcessor::logSafeFormDebugError($objResponse, $formIdentifier, $safeFormHandler, $message);
        }
    }
    return $objResponse;
}


?>
