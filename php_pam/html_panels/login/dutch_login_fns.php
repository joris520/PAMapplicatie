<?php
require_once('application/model/service/UserLoginService.class.php');
require_once('application/model/service/EmailService.class.php');

function login_form()
{
    global $smarty;
?>
    <div id="login">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td width="40%" class="left_panel" style="padding: 30px; height: 300px; font-weight: normal; font-size:12px;">
                    <?php
                        $tpl = $smarty->createTemplate('to_refactor/site_information/site_information.tpl');
                        $tpl->assign('language_id', LanguageValue::LANG_ID_NL);
                        $tpl->assign('forgotten', false);
                        echo $smarty->fetch($tpl);
                    ?>
                </td>
                <td width="60%" style="padding: 30px;" class="" id="forgotten">
                <?php
                if (PAM_DISABLED) { ?>
                    <table width="450" border="0" cellspacing="0" cellpadding="2">
                        <tr>
                            <td><strong><?php echo SITE_TITLE; ?> is momenteel niet beschikbaar wegens onderhoud.</strong></td>
                        </tr>
                    </table>
                <?php
                } else {
                ?>
                    <form id="loginForm" action="javascript:void(null);" onsubmit="submitLogin();">
                        <input type="hidden" name="language_id" value="<?php echo LanguageValue::LANG_ID_NL; ?>">
                        <div class="font_s18"><strong>Inloggen</strong></div>
                        <table width="449" border="0" cellspacing="0" cellpadding="2">
                            <tr>
                                <td colspan="2"><strong>Voer alstublieft uw gebruikersnaam en wachtwoord in </strong></td>
                            </tr>
                            <tr>
                                <td width="103">Gebruikersnaam : </td>
                                <td width="281"><input type="text" id="username" name="username" size="30" onkeypress="return handleEnter(this, event)"/></td>
                            </tr>
                            <tr>
                                <td>Wachtwoord : </td><td><input type="password" id="password" name="password" size="30" onkeypress="return handleEnter(this, event)"/></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td><input type="checkbox" value="yes" onkeypress="return handleEnter(this, event)"> sla registratie op voor gebruik op deze computer </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td><input id="submitButton" type="submit" value=" Inloggen " class="btn btn_width_80"/></td>
                            </tr>
                        </table>
                    </form>
                <?php
                } // not disabled

                ?>
                </td>
            </tr>
        </table>
    </div>
<?php
}
?>