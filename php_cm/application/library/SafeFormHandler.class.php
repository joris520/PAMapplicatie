<?php

/**
 * Description of SafeFormHandler
 *
 * @author wouter.storteboom
 */

require_once('application/library/AbstractSafeFormHandler.class.php');

// TODO: classes in eigen bestand


class SafeFormHandler extends AbstractSafeFormHandler
{
    const SESSION_SAFEFORM_STORE  = 'SessionSafeFormStore';

    static function create($s_formIdentifier, $keep_formIdentifier = NULL)
    {
        return new SafeFormHandler(self::SESSION_SAFEFORM_STORE, $s_formIdentifier, $keep_formIdentifier);
    }

    /**
     *
     * @return SafeFormHandler
     */
    static function retrieveAndValidate($formIdentifier, $formValues)
    {
        return self::retrieveSafeFormHandlerAndProcessValues(self::SESSION_SAFEFORM_STORE, $formIdentifier, $formValues);
    }
}

class SafeUploadFormHandler extends AbstractSafeFormHandler
{
    const SESSION_SAFEFUPLOAD_STORE  = 'SessionSafeUploadStore';

    static function create($s_formIdentifier, $keep_formIdenfier = NULL)
    {
        return new SafeUploadFormHandler(self::SESSION_SAFEFUPLOAD_STORE, $s_formIdentifier, $keep_formIdenfier);
    }

    /**
     *
     * @return SafeUploadFormHandler
     */
    static function retrieveAndValidate($formIdentifier, $formValues)
    {
        return self::retrieveSafeFormHandlerAndProcessValues(self::SESSION_SAFEFUPLOAD_STORE, $formIdentifier, $formValues);
    }

}

class SafeGridHandler extends AbstractSafeFormHandler
{
    const SESSION_SAFEGRID_STORE  = 'SessionSafeGridStore';

    static function create($s_formIdentifier, $keep_formIdenfier = NULL)
    {
        return new SafeGridHandler(self::SESSION_SAFEGRID_STORE, $s_formIdentifier, $keep_formIdenfier);
    }

    /**
     *
     * @return SafeGridHandler
     */
    static function retrieveAndValidate($formIdentifier, $formValues)
    {
        return self::retrieveSafeFormHandlerAndProcessValues(self::SESSION_SAFEGRID_STORE, $formIdentifier, $formValues);
    }
}

class SafeFilterHandler extends AbstractSafeFormHandler
{
    const SESSION_SAFEFILTER_STORE  = 'SessionSafeFilterStore';

    static function create($s_formIdentifier, $keep_formIdenfier = NULL)
    {
        return new SafeFilterHandler(self::SESSION_SAFEFILTER_STORE, $s_formIdentifier, $keep_formIdenfier);
    }

    /**
     *
     * @return SafeFilterHandler
     */
    static function retrieveAndValidate($formIdentifier, $formValues)
    {
        return self::retrieveSafeFormHandlerAndProcessValues(self::SESSION_SAFEFILTER_STORE, $formIdentifier, $formValues);
    }
}

class SafeActionHandler extends AbstractSafeFormHandler
{
    const SESSION_SAFEACTION_STORE  = 'SessionSafeActionStore';

    static function create($s_formIdentifier, $keep_formIdenfier = NULL)
    {
        return new SafeActionHandler(self::SESSION_SAFEACTION_STORE, $s_formIdentifier, $keep_formIdenfier);
    }

    /**
     *
     * @return SafeActionHandler
     */
    static function retrieveAndValidate($formIdentifier, $formValues)
    {
        return self::retrieveSafeFormHandlerAndProcessValues(self::SESSION_SAFEACTION_STORE, $formIdentifier, $formValues);
    }
}
?>
