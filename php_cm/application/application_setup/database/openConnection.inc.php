<?php
require_once('application/application_setup/PamSetup.class.php');

if (!PAM_DISABLED) {

    global $pamSetup;
    $dbhost = $pamSetup->databaseHostname;
    $dbuser = $pamSetup->databaseUsername;
    $dbpass = $pamSetup->databasePassword;
    $dbname = $pamSetup->databaseName;

    $conn = mysql_connect($dbhost, $dbuser, $dbpass) or die(mysql_error());
    mysql_set_charset('utf8',$conn);
    mysql_select_db($dbname);

}
?>