<?php

    require_once('application/application_setup/PamSetup.class.php');
    require_once('application/model/value/system/PamExceptionCodeValue.class.php');
    require_once('application/library/PamExceptionProcessor.class.php');

    $pamSetup = PamSetup::create();
    $pamSetup->setupPamEnvironment(PAM_BASE_DIR . DIRECTORY_SEPARATOR . application_config);
    set_error_handler("PamExceptionProcessor::handleWarning", E_WARNING);
    set_error_handler("PamExceptionProcessor::handleError",   E_RECOVERABLE_ERROR);

    require_once('application/application_setup/database/openConnection.inc.php');
    require_once('application/library/sessionHandler.inc.php');
?>
