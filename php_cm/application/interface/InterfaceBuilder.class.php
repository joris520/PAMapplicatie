<?php

/**
 * Description of InterfaceBuilder
 *
 * @author ben.dokter
 */

require_once('application/interface/InterfaceConsts.inc.php');

class InterfaceBuilder
{
    static function MasterRow($s_row_id,
                              $s_row_class,
                              $s_link_title,
                              $s_link_action,
                              $s_link_name,
                              $s_row_buttons)
    {
        global $smarty;
        // TODO: maar 1 keer createn!
        $tpl_master_row = $smarty->createTemplate('components/masterRow.tpl');

        $tpl_master_row->assign('master_row_id', $s_row_id);
        $tpl_master_row->assign('row_class', $s_row_class);
        $tpl_master_row->assign('row_prefix', '&nbsp;&nbsp;');
        $tpl_master_row->assign('link_action', $s_link_action);
        $tpl_master_row->assign('link_title', $s_link_title);
        $tpl_master_row->assign('link_name', $s_link_name);
        $tpl_master_row->assign('row_buttons', $s_row_buttons);

        return $smarty->fetch($tpl_master_row);
    }

    static function iconHover($hover_id,
                              $title,
                              $icon_src)
    {
        return InterfaceBuilder::IconGeneric($hover_id, $title, $icon_src);
    }

    static function IconHelpButton($button_id,
                                   $title,
                                   $onclick_action,
                                   $icon_src,
                                   $link_class='activeRow',
                                   $help_id = null)
    {
        // dit alleen voor icons
        $use_icon = true;
        $link_label = '';
        return self::IconGenericButton($button_id, $title, $onclick_action, $link_class, $icon_src, $use_icon, $help_id, $link_label);
    }

    static function activeRowIconLink($button_id,
                                      $title,
                                      $onclick_action,
                                      $icon_src = null,
                                      $link_class = 'activeRow')
    {
        $use_icon = false;
        $link_label = '';
        $help_id = null;
        return self::IconGenericButton($button_id, $title, $onclick_action, $link_class, $icon_src, $use_icon, $help_id, $link_label);
    }

    static function iconLink($button_id,
                             $title,
                             $onclick_action,
                             $icon_src)
    {
        $use_icon = true;
        $link_class = '';
        $help_id = null;
        $link_label = '';
        return self::IconGenericButton($button_id, $title, $onclick_action, $link_class, $icon_src, $use_icon, $help_id, $link_label);

    }

    static function iconLabelLink(  $button_id,
                                    $title,
                                    $onclick_action,
                                    $icon_src,
                                    $link_label)
    {
        $use_icon = true;
        $link_class = 'icon-link-label';
        $help_id = null;
        return self::IconGenericButton($button_id, $title, $onclick_action, $link_class, $icon_src, $use_icon, $help_id, $link_label);

    }

    static function IconButton($button_id,
                               $title,
                               $onclick_action,
                               $icon_src = null,
                               $button_class = NO_BUTTON_CLASS,
                               $use_icon = false,
                               $link_class = '')
    {
        $icon_src_or_button_class = $use_icon ? $icon_src : $button_class;
        $help_id = null;
        $link_label = '';
        return self::IconGenericButton($button_id, $title, $onclick_action, $link_class, $icon_src_or_button_class, $use_icon, $help_id, $link_label);
    }

    private static function IconGeneric($img_id,
                                        $title,
                                        $icon_src)
    {
        $icon_img = '<img id="' . $img_id . '" src="' . $icon_src . '" title="' . $title . '"  border="0">';

        return $icon_img;
    }

    private static function IconGenericButton($button_id,
                                              $title,
                                              $onclick_action,
                                              $link_or_icon_class,
                                              $icon_src_or_button_class,
                                              $use_icon,
                                              $help_id,
                                              $link_label)
    {
        $icon_button = '' . $help_id; // om van de unused param warning af te zijn...
        if ($use_icon) {
            $img_class = $link_or_icon_class . ' icon-style';
            $icon_img = empty($icon_src_or_button_class) ? $title : '<img align="absmiddle" src="' . $icon_src_or_button_class . '" class="' . $img_class . '" border="0">';
            if (!empty($onclick_action)) { // alleen icon
                $link_class = $link_or_icon_class;
                $icon_button = '<a id="' . $button_id . '" class="' . $link_class . '" href="" onclick="' . $onclick_action . 'return false;" title="' . $title . '"><span class="icon-link-label">' . $link_label . $icon_img . '</span></a>&nbsp;';
            } else {
                $icon_button = $icon_img;
            }
        } else {
            $button_class = empty($icon_src_or_button_class) ? 'btn_width_150' : $icon_src_or_button_class;
            $icon_button = '<input type="button" value="' . $title . '" id="' . $button_id . '" class="btn ' . $button_class . '" onclick="' . $onclick_action . ';return false;">&nbsp;';
        }
        return $icon_button;
    }


    static function LogHtmlFromArray($a_modified_info)
    {
        $log_html = '';
        if (!empty($a_modified_info)) {
            $log_html = InterfaceBuilder::LogHtml($a_modified_info['modified_by_user'],
                                                 $a_modified_info['modified_date'],
                                                 $a_modified_info['modified_time']);
        }
        return $log_html;
    }

    static function LogHtml($modified_by, $modified_date, $modified_time)
    {
        global $smarty;

        $date_display = ($modified_date > 0) ? date("d-m-Y", strtotime($modified_date)) : '';

        $tpl_log = $smarty->createTemplate('components/modifiedLog.tpl');
        $tpl_log->assign('modifiedBy', $modified_by);
        $tpl_log->assign('modifiedDate', $date_display);
        $tpl_log->assign('modifiedTime', $modified_time);

        return $smarty->fetch($tpl_log);
    }

    static function lastSavedHtml($interfaceObject)
    {
        global $smarty;
        $lastSavedTemplate = $smarty->createTemplate('components/lastSaved.tpl');
        $lastSavedTemplate->assign('interfaceObject', $interfaceObject);

        return $smarty->fetch($lastSavedTemplate);

    }
}

?>
