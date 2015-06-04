{* smarty *}

<!-- threeSixtyEvaluationFormCompetences.tpl -->
{* sdj: misschien header ook in threeSixyEvaluationFormCompetences.html, zodat deze ook voor mail wordt aangemaakt ... *}

{assign var=logo value="<img src=\"{'SITE_URL'|constant}{$customer_logo_path}\" border=\"0\" vspace=\"5\" hspace=\"5\" />"}
<br />
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
<br />
<br />
<div style="width:980px; margin-left:auto; margin-right:auto;text-align:center;">
{if $show_help}
<img src="{'ICON_INFO'|constant}" class="icon-style" border="0" height="14" width="14">
&nbsp;&nbsp;<strong>{'PLEASE_ASSESS_THE_FOLLOWING_COMPETENCES_AND_CLICK_SEND'|TXT_UCF}</strong>
{if $show_competence_details}
<br><strong>{'CLICK_ON_THE_COMPETENCES_FOR_MORE_INFORMATION'|TXT_UCF}</strong>
{/if}
{/if}
<br />
<br />
{if $has_1_5_questions || $has_YN_questions}
<strong>{'SCALE'|TXT_UCF}:</strong>
{/if}
{if $has_1_5_questions}
[1] {'SCALE_NONE'|constant} &nbsp;&nbsp;
[2] {'SCALE_BASIC'|constant} &nbsp;&nbsp;
[3] {'SCALE_AVERAGE'|constant} &nbsp;&nbsp;
[4] {'SCALE_GOOD'|constant} &nbsp;&nbsp;
[5] {'SCALE_SPECIALIST'|constant} &nbsp;&nbsp;
{/if}
{if $has_YN_questions}
[{$module_utils_object->ScoreNormText('Y')}]-{'SCALE_YES'|constant} &nbsp;&nbsp;
[{$module_utils_object->ScoreNormText('N')}]-{'SCALE_NO'|constant}
{/if}
</div>

{$competences_html}
<!-- /threeSixtyEvaluationFormCompetences.tpl -->






































