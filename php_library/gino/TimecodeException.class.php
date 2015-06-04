<?php

require_once('gino/DateUtils.class.php');
require_once('application/model/value/system/PamExceptionCodeValue.class.php');

class TimecodeException extends Exception
{
    protected $timecode;

    // $code = PamExceptionCodeValue
    static function raise($message, $code)
    {
        throw new TimecodeException($message, $code);
    }

    // $code = PamExceptionCodeValue
    function __construct ($message, $code)
    {
        parent::__construct($message, $code, NULL);
        $this->timecode = DateUtils::getCurrentTimecode();
    }

}
?>
