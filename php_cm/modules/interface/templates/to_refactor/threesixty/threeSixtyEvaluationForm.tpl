{* smarty *}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- threeSixtyEvaluationForm.tpl -->
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=7" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>{'SITE_NAME'|constant}</title>
        {if !$completed && $hash_found}
        {$xajaxJavascript}
        <script type="text/javascript" src="js/libraries/jquery-1.8.0.min.js"></script>
        <script type="text/javascript" src="js/feedback_animations.js"></script>
        {/if}
        <link href="css/general.css" rel="stylesheet" type="text/css" />
        <link href="css/{'THEME'|constant}.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <div id="mainframe" style="width:980px; margin-left:auto; margin-right:auto;">
            {if !$environment_is_production}
            <div style="background-color:{$environment_color}; text-align:center;"> >>{$environment_detail} << </div>
            {/if}
            {if !$is_self_evaluation}
            <table>
                <tr>
                    <td>
                        <div id="header_left" style="margin-top: 10px;">
                            <img src="{$main_logo_path}" border="0" />
                        </div>
                    </td>
                </tr>
            </table>
            {/if}
            <table style="width: 100%" border="0" cellspacing="0" cellpadding="0">
                {assign var=LANGUAGE_ID value=LANG_ID|constant}
                {assign var=FORGOTTEN value=false}

                {if !$is_self_evaluation}
                <tr>
                    <td class="left_panel top_border1px" style="padding: 30px; height: 200px; font-weight: normal; font-size:12px; width:100%; border-left:1px solid #999999;">
                        {include file="$site_info_template"}
                    </td>
                </tr>
                {/if}
                <tr>
                    <td style="padding: 0px; padding-top: 30px;" class="top_border1px" id="forgotten">
                    {if $hash_found}
                        {* hash gevonden *}
                        {* <div id="eval_header"> *}
                        <div id="eval" style="width:980px; margin-left:auto; margin-right:auto;">
                        {if $completed || $deprecated}}
                            {* evaluatie al ingevuld of verlopen*}
                            <br />
                            <br />
                            {if $completed}
                                <p style="font-size:16px; margin-bottom:100px; text-align:center;">{'ALREADY_COMPLETED_360_INVITATION'|TXT_UCF}.</p>
                            {elseif $deprecated}
                                <p style="font-size:16px; margin-bottom:100px; text-align:center;">{'DEPRECATED_360_INVITATION'|TXT_UCF}.</p>
                            {/if}
                        {else}
                            {if !$competencesInfo}
                            {'NO_COMPETENCE_RETURN'|TXT_UCF}.
                            {else}
                            {include file='to_refactor/threesixty/threeSixtyEvaluationFormCompetences.tpl'}
                            {/if}
                        {/if}
                        </div> <!-- EINDE DIV 'eval' -->
                        <div id="msg_bottom">
                        </div>
                    {else}
                        {* hash niet gevonden ... *}
                        {* De door u gebruikte uitnodiging is verouderd of incorrect *}
                        {'INVALID_OR_UNKNOWN_360_INVITATION'|TXT_UCF}.
                    {/if}
                    </td>
                </tr>
            </table>

        </div> <!-- EINDE DIV 'mainframe' -->
    </body>
</html>
<!-- /threeSixtyEvaluationForm.tpl -->