<?php
require_once('smarty/libs/Smarty.class.php');

/**
 * PamSmarty class voorziet in convenience functies bovenop de Smarty class
 * zodat bijvoorbeeld altijd gebruikte assigns eenmalig gedaan hoeven worden.
 */
class PamSmarty extends Smarty
{
    var $pam_module_utils;

    /**
     * definitie overgenomen uit Smarty.class.php
     *
     * Hier kunnen de "standaard" assigns gedaan worden zodat deze altijd beschikbaar zijn in een template.
     * - $module_utils_object = ModuleUtils()
     *
     * @global <type> $glob_module_utils
     */
    public function createTemplate($template, $cache_id = null, $compile_id = null, $parent = null, $do_clone = true)
    {
        $new_tpl = parent::createTemplate($template, $cache_id, $compile_id, $parent, $do_clone);
        $new_tpl->assign("module_utils_object", $this->pam_module_utils);
        return $new_tpl;
    }

}
?>
