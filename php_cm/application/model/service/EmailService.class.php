<?php

/**
 * Description of SendEmail
 *
 * @author wouter.storteboom
 */
require_once('application/library/PamValidators.class.php');

class EmailService
{
    static function validateEmailAddress($emailAddress, $isEmailRequired = false)
    {
        $hasError = false;
        $messages = array();

       if ($isEmailRequired && empty($emailAddress)) {
            $hasError = true;
            $messages[] = TXT_UCF('PLEASE_ENTER_AN_EMAIL_ADDRESS');
        }
        if (!empty($emailAddress) && !PamValidators::IsEmailAddressValidFormat($emailAddress)) {
            $hasError = true;
            $messages[] = TXT_UCF('EMAIL_ADDRESS_IS_INVALID');
        }
        return array($hasError, $messages);
    }

    static function formatEmailHeader ($name, $emailAddress)
    {
        $formattedEmailHeader = '';

        if (!empty($name)) {
            $formattedEmailHeader = '"' . $name . '" <' . $emailAddress . '>';
        } else {
            $formattedEmailHeader = $emailAddress;
        }

        return $formattedEmailHeader;
    }

    static function buildHeaders ($fromField, $replyToField, $bccField)
    {
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

        if (!empty($fromField)) {
            $headers .= 'From: '. $fromField . "\r\n";
        }

        if (!empty($replyToField)) {
            $headers .= 'Reply-To: ' . $replyToField . "\r\n";
        }

        if (!empty($bccField)) {
            $headers .= 'Bcc: ' . $bccField . "\r\n";
        }

        return $headers;
    }

    static function sendEmail ($toField, $subject, $message, $headers)
    {
        $mailtext = '*** senddate: ' . DateUtils::getCurrentDisplayDateTime() . "\n" .
                    'to: ' . $toField . "\n" .
                    'headers: ' . $headers . "\n" .
                    'subject: ' . $subject. "\n" .
                    'message: ' . $message . "\n\n\n";

        $path = ModuleUtils::getTempPath();
        $handle = fopen($path . 'mail.txt', 'a');
        fwrite($handle, $mailtext);
        fclose($handle);
        return true;
    }
}

?>
