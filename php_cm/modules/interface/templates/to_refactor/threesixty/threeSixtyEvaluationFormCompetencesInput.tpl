<!-- threeSixtyEvaluationFormCompetencesInput.tpl -->
<form id="scoreEmployeesForm" name="scoreEmployeesForm" action="javascript:void(0);" method="post">

<input type="hidden" name="hash" value="{$hash_id}" />

{literal}
<script type="text/javascript">
    xajax.callback.global.onRequest = function() {xajax.$('global_loading1').style.display = 'block';}
    xajax.callback.global.beforeResponseProcessing = function() {xajax.$('global_loading1').style.display='none';}
</script>
{/literal}

{assign var='old_cat' value='notset'}
{assign var='old_cluster' value='notset'}
{assign var='prefix_competence' value=''}

<table border="0" cellspacing="2" cellpadding="2" style="width: 100%; margin-top:5px; margin-bottom:5px; border: 1px solid #cccccc;" >
    {foreach $competencesInfo as $competence}
        {assign var='cat' value={$competence.category|upper|replace:' ':'_'|TXT_UCF}}
        {if $cat <> $old_cat}
            <tr>
                <td colspan="2" style="border-bottom: 1px solid #dddddd; background:#eeeeee;" >{if $show_cat_header}<strong>{$cat} </strong>{else}&nbsp;{/if}</td>
                <td colspan="2" style="width: 350px; border-bottom: 1px solid #dddddd; background:#eeeeee;">{if $show_cat_header}<strong>{'SCORE'|TXT_UCF} </strong>{else}&nbsp;{/if}</td>
                {if $show_remarks}
                <td style="width: 200px; border-bottom: 1px solid #dddddd; background:#eeeeee;">{if $show_cat_header}<strong>{'REMARKS'|TXT_UCF}</strong>{else}&nbsp;{/if}</td>
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
                {$competence.competence_detail_link}
                {else}
                {$competence.knowledge_skill_point}
                {/if}
            </td>
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
        </tr>
        <tr id="detail_row_{$competence.ID_KSP}" class="hidden-info">
            <td id="compID{$competence.ID_KSP}" colspan="100%"></td>
        </tr>
        {if $show_main_competence}
            {if $competence.is_cluster_main == 1}
            {assign var='prefix_competence' value='&nbsp;&nbsp;&nbsp;'}
            {/if}
        {/if}

    {/foreach}

    {if $has_key_competences}
        <tr>
            <td colspan="100%">{'NOTE'|TXT_UCF} : {'SIGN_IS_KEY_COMP'|constant} = {'COLLECTIVE_KEY_COMPETENCE'|TXT_UCF}<br /><br />
        </tr>
    {/if}

    <tr>
        <td colspan="100%">
    {if $allow_change_evaluator_info}
            <table width="650" border="0" cellspacing="2" cellpadding="2" class="border1px">
                <tr>
                    <td class="bottom_line" width="30%"><b>{'EVALUATOR'|TXT_UCF} {'NAME'|TXT} :</b></td>
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
        </td>
    </tr>

    <tr>
        <td colspan="100%">
            <table align="center">
            <tr>
                <td>
                    <input type="button" name="btnsubmit2" id="btnsubmit2" value=" {'SEND'|TXT_BTN} " class="btn btn_width_80" onclick="xajax_module360EvaluationNew_saveEvaluation(xajax.getFormValues('scoreEmployeesForm'));return false;">
                </td>
                <td>
                    <div id="global_loading1" style="display: none;"><img src="images/bload.gif" /></div>
                </td>
            </tr>
            </table>
        </td>
    </tr>
    </table>
</form>

<!-- /threeSixtyEvaluationFormCompetencesInput.tpl -->