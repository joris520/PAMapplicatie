<!-- threeSixtyEvaluationFormCompetences.tpl -->
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
<br />
<br />
<div style="width:980px; margin-left:auto; margin-right:auto; text-align:center;">
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
{capture scale_Y_N assign=scale_Y_N_legend}
[{$module_utils_object->ScoreNormText('Y')}]-{'SCALE_YES'|constant} &nbsp;&nbsp;
[{$module_utils_object->ScoreNormText('N')}]-{'SCALE_NO'|constant}
{/capture}
{$scale_Y_N_legend}
{/if}
</div>

{assign var='competence_width' value='55%'}
{assign var='score_width' value='45%'}
{if $show_remarks}
    {assign var='competence_width' value='35%'}
    {assign var='score_width' value='55%'}
{/if}


<table align="center" border="0" cellspacing="2" cellpadding="2" style="width: 100%; margin-top:5px; margin-bottom:5px; border: 1px solid #cccccc;" >
    {*
    <tr>module_utils_object
        <td width="60%" style="border-bottom: 1px solid #dddddd; background:#eeeeee;"><strong>{'CATEGORY'|TXT_UCF} / {'CLUSTER'|TXT_UCF} / {'COMPETENCE'|TXT_UCF}: </strong></td>
        <td width="40%" style="border-bottom: 1px solid #dddddd; background:#eeeeee;"><strong>{'SCORE'|TXT_UCF}: </strong></td>
    </tr>
    *}

{assign var='old_cat' value='notset'}
{assign var='old_cluster' value='notset'}
{assign var='prefix_competence' value=''}


{foreach $competencesInfo as $competence}
    {assign var='cat'   value={$competence.category|upper|replace:' ':'_'|TXT_UCF}}
    {if $cat <> $old_cat}
        <tr>
            <td colspan="2" style="border-bottom: 1px solid #dddddd; background:#eeeeee;" >{if $show_cat_header}<strong>{$cat} </strong>{else}&nbsp;{/if}</td>
            <td colspan="2" style="width: 350px; border-bottom: 1px solid #dddddd; background:#eeeeee;">{if $show_cat_header}<strong>{'SCORE'|TXT_UCF}: </strong>{else}&nbsp;{/if}</td>
            {if $show_remarks}
            <td style="width: 200px; border-bottom: 1px solid #dddddd; background:#eeeeee;"><strong>{'REMARKS'|TXT_UCF}</strong></td>
            {/if}
        </tr>
    {/if}
    {assign var='old_cat' value=$cat}

    {assign var='cluster' value={$competence.cluster}}
    {if $cluster <> $old_cluster}
        {*if $competence.cluster <> '&mdash;'*}
        <tr style="border-bottom: 1px solid #dddddd;" >
                <td colspan="100%" style="border-bottom: 1px solid #dddddd;"><strong>{$competence.cluster}</strong></td>
        {*            <td width="40%" colspan="2"  style="border-bottom: 1px solid #dddddd;"><strong>{'SCORE'|TXT_UCF}: </strong></td>*}
        </tr>
        {assign var='prefix_competence' value=''}
        {assign var='main_bgcolor' value='#ffffff'}
    {/if}
    {assign var='old_cluster' value=$cluster}

    {if $show_main_competence}
        {if $competence.is_cluster_main == 1}
            {assign var='main_bgcolor' value='#eeeeee'}
        {else}
            {assign var='main_bgcolor' value='#ffffff'}
        {/if}
    {/if}

    <tr onMouseOver="this.style.backgroundColor='#fcf9d2'" onMouseOut="this.style.backgroundColor='{$main_bgcolor}'" style="background-color:{$main_bgcolor};">
        <td width="2%" style="text-align: right; border-bottom: 1px solid #dddddd; padding-left: 5px;">{if $competence.is_key == '1'}{'SIGN_IS_KEY_COMP'|constant}{else}{'SIGN_IS_NOT_KEY_COMP'|constant}{/if}</td>

        <td style="border-bottom: 1px solid #dddddd;">
            <input type="hidden" name="ksp{$competence.ID_KSP}" value="{$competence.ID_KSP}">
            {$prefix_competence}
            {if $show_competence_details}
            <span id="click_competence_detail{$competence.ID_KSP}"><a href="#" onclick="xajax_module360Evaluation_showCompetenceDetails_deprecated({$competence.ID_KSP}, '{$formHash}'); return false">{$competence.knowledge_skill_point}</a></span>
            {else}
            {$competence.knowledge_skill_point}
            {/if}
        </td>
        {if !$post_data}
            <td style="border-bottom: 1px solid #dddddd;">
                {if $competence.fp_scale == 'Y' || $competence.fp_scale == 'N'}
                    <input id="ksp{$competence.ID_KSP}Y" title="{$module_utils_object->ScoreDescription('Y')}" type="radio" name="scale{$competence.ID_KSP}" value="Y"><label title="{$module_utils_object->ScoreDescription('Y')}" for="ksp{$competence.ID_KSP}Y">&nbsp;{$module_utils_object->ScoreNormText('Y')}</label>{*&nbsp;{'SCALE_YES'|constant}*}
                    <input id="ksp{$competence.ID_KSP}N" title="{$module_utils_object->ScoreDescription('N')}" type="radio" name="scale{$competence.ID_KSP}" value="N"><label title="{$module_utils_object->ScoreDescription('N')}" for="ksp{$competence.ID_KSP}N">&nbsp;{$module_utils_object->ScoreNormText('N')}</label>{*&nbsp;{'SCALE_NO'|constant}*}
                {else}
                    {section name=loop start=1 loop=6}
                        <input id="ksp{$competence.ID_KSP}{$smarty.section.loop.index}" title="{$module_utils_object->ScoreDescription($smarty.section.loop.index)}" type="radio" name="scale{$competence.ID_KSP}" value="{$smarty.section.loop.index}"><label title="{$module_utils_object->ScoreDescription($smarty.section.loop.index)}" for="ksp{$competence.ID_KSP}{$smarty.section.loop.index}">&nbsp;{$smarty.section.loop.index}&nbsp;</label>
                    {/section}
                {/if}
            </td>
            <td style="border-bottom: 1px solid #dddddd;">
            {if $competence.is_na_allowed}
                <input id="ksp{$competence.ID_KSP}na" type="radio" name="scale{$competence.ID_KSP}" value="NA" checked="checked"><label for="ksp{$competence.ID_KSP}na">&nbsp;{'NOT_APPLICABLE'|TXT}</label>
            {else}
                &nbsp;
            {/if}
            </td>
            {if $show_remarks}
            <td style="border-bottom: 1px solid #dddddd;"><textarea style="width: 100%;" name="remarks{$competence.ID_KSP}"></textarea></td>
            {/if}
        {else}
            <td style="border-bottom: 1px solid #dddddd;" colspan="2">
                &nbsp;
                {assign var='result' value=$post_data.{'scale'|cat:$competence.ID_KSP}}
                {if $post_data.{"scale"|cat:$competence.ID_KSP} == 'Y'}
                    {$module_utils_object->ScoreNormText('Y')}{*'SCALE_YES'|constant*}
                {elseif $post_data.{"scale"|cat:$competence.ID_KSP} == 'N'}
                    {$module_utils_object->ScoreNormText('N')}{*'SCALE_NO'|constant*}
                {elseif $post_data.{"scale"|cat:$competence.ID_KSP} == 'NA'}
                    -
                {else}
                    {$post_data.{"scale"|cat:$competence.ID_KSP}}
                {/if}
            </td>
            {if $show_remarks}
            <td style="border-bottom: 1px solid #dddddd;">
                {assign var='competence_remark' value=$post_data.{'remarks'|cat:$competence.ID_KSP}}
                {if $competence_remark != ''}
                    {$competence_remark|nl2br}
                {else}
                    &nbsp;
                {/if}
            </td>
            {/if}
        {/if}
    </tr>
    <tr>
        <td id="competencedetail{$competence.ID_KSP}" colspan="100%"></td>
    </tr>
    {if $show_main_competence}
        {if $competence.is_cluster_main == 1}
        {assign var='prefix_competence' value='&nbsp;&nbsp;&nbsp;'}
        {/if}
    {/if}

{/foreach}

</table>
{if $has_key_competences}
{'NOTE'|TXT_UCF} : {'SIGN_IS_KEY_COMP'|constant} = {'COLLECTIVE_KEY_COMPETENCE'|TXT_UCF}<br /><br />
{else}
<br />
{/if}
<!-- /threeSixtyEvaluationFormCompetences.tpl -->