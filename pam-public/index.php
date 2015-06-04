<?php
    require_once("./root_pam_config.inc.php");
    global $pam_ini_done;
    if ($pam_ini_done != TRUE) die('pam configuratie niet gelukt');

    require_once('modules/common/moduleUtils.class.php');

    if (PAM_DISABLED) {
        ModuleUtils::ForceLogout();
    }

    // Smarty initialiseren
    require_once('application/application_setup/smarty_config.inc.php');

    require_once('application/application_setup/basic_includes.inc.php');

    require_once('plot/phplot/phplot.php');
    require_once('application/application_setup/pam_config.inc.php');

    require_once("xajax/xajax_core/xajaxAIO.inc.php"); // xajax compiled
    //require_once("xajax/xajax_core/xajax.inc.php");    // xajax minimal
    $xajax = new xajax();
    $xajax->configure('debug', XAJAX_DEBUG_SETTING);
    require_once('application/application_setup/xajax_config.inc.php');

    $onLoad = getBodyOnload($message);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <?php
        require_once('html_panels/html_head.inc.php');
    ?>

    <body <?php echo $onLoad ?>>
    <?php
        // het opbouwen van de panels op de pagina
        require_once('html_panels/application_header.inc.php');
        require_once('html_panels/module_navigation.inc.php');
        require_once('html_panels/module_content.inc.php');
        require_once('html_panels/application_footer.inc.php');
    ?>
    </body>
</html>
<?php
    require_once('application/application_setup/database_close.inc.php');
?>