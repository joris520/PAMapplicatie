<?php

/**
 * Description of EmailHtmlBuilder
 *
 * @author ben.dokter
 */
class EmailHtmlBuilder
{
    // todo: emailInterfaceObjecten ?
    static function generateHtmlMessage($mailContent)
    {
        // vullen template
        global $smarty;
        $template = $smarty->createTemplate('htmlEmail/htmlEmailBody.tpl');
        $template->assign('message', nl2br($mailContent));
        return $smarty->fetch($template);

    }
}

?>
