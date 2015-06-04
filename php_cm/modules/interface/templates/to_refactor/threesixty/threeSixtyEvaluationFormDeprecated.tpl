<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- threeSixtyEvaluationFormDeprecated.tpl -->
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=7" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>{'SITE_NAME'|constant}</title>
        {$xajaxJavascript}
        <link rel="stylesheet" type="text/css" href="css/general.css" />
        <link rel="stylesheet" type="text/css" href="css/layout.css" />
        <link rel="stylesheet" type="text/css" href="css/{'THEME'|constant}.css" />
    </head>
    <body>
        <div id="mainframe" style="width:980px; margin-left:auto; margin-right:auto">
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
                        {literal}
                        <script type="text/javascript">
                            xajax.callback.global.onRequest = function() {xajax.$('global_loading1').style.display = 'block';}
                            xajax.callback.global.beforeResponseProcessing = function() {xajax.$('global_loading1').style.display='none';}
                        </script>
                        {/literal}
                        {if $hash_found}
                            {* hash gevonden *}
                            {* <div id="eval_header"> *}
                            {if $completed or $deprecated}
                            {* evaluatie al ingevuld*}
                            <div id="eval" style="width:980px; margin-left:auto; margin-right:auto;">

                                {assign var=logo value="<img src=\"{'SITE_URL'|constant}{$customer_logo_path}\" border=\"0\" vspace=\"5\" hspace=\"5\" />"}
                                <br>
                                <table align="center" border="0" cellspacing="2" cellpadding="2" style="border: 1px solid #cccccc;">
                                    <tr>
                                        <td width="330px" rowspan="5">{$logo}</td>
                                        <td colspan="2" style="font-size:18px;"><strong>{'EVALUATION_FORM'|TXT_UCF}</strong></td>
                                    </tr>
                                    <tr>
                                        <td width="150px" class="bottom_line"><strong>{'EMPLOYEE_NAME'|TXT_UCF} :</strong> </td>
                                        <td class="bottom_line">{$employeeInfo.lastname}, {$employeeInfo.firstname}&nbsp;&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td class="bottom_line"><strong>{'COMPANY_NAME'|TXT_UCF} :</strong> </td>
                                        <td class="bottom_line">{$employeeInfo.company_name}&nbsp;&nbsp;</td>
                                    </tr>
                                    {if $show_department}
                                    <tr>
                                        <td class="bottom_line"><strong>{'DEPARTMENT'|TXT_UCF} :</strong> </td>
                                        <td class="bottom_line">{$employeeInfo.department}&nbsp;&nbsp;</td>
                                    </tr>
                                    {else}
                                    <tr>
                                        <td colspan="2">&nbsp;</td>
                                    </tr>
                                    {/if}
                                    {if $show_job_profile}
                                    <tr>
                                        <td class="bottom_line"><strong>{'JOB_PROFILE'|TXT_UCF} : </strong> </td>
                                        <td class="bottom_line">{$functionInfo.function}&nbsp;&nbsp;</td>
                                    </tr>
                                    {else}
                                    <tr>
                                        <td colspan="2">&nbsp;</td>
                                    </tr>
                                    {/if}
                                    <tr>
                                        <td colspan="3" align="center"><br><br></td>
                                    </tr>
                                </table>
                                <br>
                                <br>
                                <p style="font-size:16px; margin-bottom:100px; text-align:center;">
                                {if $completed}
                                    {'ALREADY_COMPLETED_360_INVITATION'|TXT_UCF}.
                                {elseif $deprecated}
                                    {'DEPRECATED_360_INVITATION'|TXT_UCF}.
                                {/if}
                                </p>
                            </div><!-- eval -->

                            {else}
                            <div id="msg"></div>

                            {* sdj: misschien header ook in threeSixyEvaluationFormCompetences.html, zodat deze ook voor mail wordt aangemaakt ... *}
                            <div id="eval">

                                <form id="scoreEmployeesForm" name="scoreEmployeesForm" action="javascript:void(0);" method="post">
                                    <input type="hidden" name="formHash" value="{$formHash}">

                                    <div class="mod_employees_Score" style="text-align:left">

                                    {if !$competencesInfo}
                                        {'NO_COMPETENCE_RETURN'|TXT_UCF}.
                                    {else}
                                        {include file='to_refactor/threesixty/threeSixtyEvaluationFormCompetencesDeprecated.tpl'}
                                    {/if}

                                    </div>

                                    {if $allow_change_evaluator_info}
                                    <table width="650" border="0" cellspacing="2" cellpadding="2" class="border1px">
                                        <tr>
                                            <td class="bottom_line" width="30%"><b>{'EVALUATOR'|TXT_UCF} {'NAME'|TXT} :</b></td>
                                            {* sdj: TODO: moet ipv $evaluatorInfo.name waarschijnlijk iets als .firstname .lastname worden*}
                                            <td class="bottom_line" width="70%"><input type="text" size="35" name="evaluator_name" id="evaluator_name" value="{$evaluatorInfo.firstname} {$evaluatorInfo.lastname}"></td>
                                        </tr>
                                        <tr>
                                            <td><b>{'EVALUATOR'|TXT_UCF}  e-mail :</b></td>
                                            <td><input type="text" size="35" name="evaluator_email" id="evaluator_email" value="{$evaluatorInfo.email}"></td>
                                        </tr>
                                    </table>
                                    {else}
                                    <input type="hidden" name="evaluator_name" id="evaluator_name" value="{$evaluatorInfo.firstname} {$evaluatorInfo.lastname}">
                                    <input type="hidden" name="evaluator_email" id="evaluator_email" value="{$evaluatorInfo.email}">
                                    {/if}

                                    {if $competencesInfo}
                                    <table align="center">
                                        <tr>
                                            <td>
                                                <br />
                                                <input type="button" name="btnsubmit2" id="btnsubmit2" value=" {'SEND'|TXT_BTN} " class="btn btn_width_80" onclick="xajax_module360_saveEvaluation_deprecated(xajax.getFormValues('scoreEmployeesForm'));return false;">
                                                <br /><br /><br /><br /><br />
                                            </td>
                                            <td>
                                                <div id="global_loading1" style="display: none;"><img src="images/bload.gif" /></div>
                                            </td>
                                        </tr>
                                    </table>
                                    {/if}
                                </form>

                            </div> <!-- EINDE div 'eval' -->
                            <div id="msg_bottom"></div>
                            {/if}
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
<!-- /threeSixtyEvaluationFormDeprecated.tpl -->