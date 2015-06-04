<?php
    require_once('application/library/PamSmarty.class.php');
    require_once('modules/common/moduleUtils.class.php');

    $smarty = new PamSmarty();
    $smarty->pam_module_utils = new ModuleUtils();

    $smarty->setTemplateDir( array( PAM_BASE_DIR . 'php_cm/modules/interface/templates',
                                    PAM_BASE_DIR . 'php_cm/application/interface/templates',
                                    PAM_BASE_DIR . 'php_cm/application/email/templates'));
    $smarty->setCompileDir(PAM_BASE_DIR . 'smarty_cache');

?>
