<?php

/**
 * Description of CompetenceInterfaceBuilderComponents
 *
 * @author ben.dokter
 */
class CompetenceInterfaceBuilderComponents
{
    static function getDetailLinkId($competenceId)
    {
        return 'click_' . $competenceId;
    }

    static function getShowDetailOnClick($competenceId, $mode)// = DISPLAY_MODE_NORMAL)
    {
        return 'xajax_public_library__showCompetenceDetail(' . $competenceId .', ' . $mode . ')';

    }
    static function getHideDetailOnClick($competenceId, $mode)// = DISPLAY_MODE_NORMAL)
    {
        return 'xajax_public_library__hideCompetenceDetail(' . $competenceId .', ' . $mode . ')';
    }
}

?>
