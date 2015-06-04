<!-- threeSixtyEvaluationFormCompetencesInput.tpl -->

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
            <tr style="border-bottom: 1px solid #dddddd;" >
                    <td colspan="100%" style="border-bottom: 1px solid #dddddd;"><strong>{$competence.cluster}</strong></td>
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
                {$prefix_competence}
                {$competence.knowledge_skill_point}
            </td>
            <td style="border-bottom: 1px solid #dddddd;" colspan="2">
                &nbsp;
                {assign var='result' value=$competence.score}
                {if $result == 'Y'}
                    {$module_utils_object->ScoreNormText('Y')}{*'SCALE_YES'|constant*}
                {elseif $result == 'N'}
                    {$module_utils_object->ScoreNormText('N')}{*'SCALE_NO'|constant*}
                {elseif $result == 'NA'}
                    -
                {else}
                    {$result}
                {/if}
            </td>
            {if $show_remarks}
            <td style="border-bottom: 1px solid #dddddd;">
                {assign var='competence_remark' value=$competence.remarks}
                {if $competence_remark != ''}
                    {$competence_remark|nl2br}
                {else}
                    &nbsp;
                {/if}
            </td>
            {/if}
        </tr>
        {if $show_main_competence}
            {if $competence.is_cluster_main == 1}
            {assign var='prefix_competence' value='&nbsp;&nbsp;&nbsp;'}
            {/if}
        {/if}

    {/foreach}

    {if $has_key_competences}
        <tr>
            <td colspan="100%">
                {'NOTE'|TXT_UCF} : {'SIGN_IS_KEY_COMP'|constant} = {'COLLECTIVE_KEY_COMPETENCE'|TXT_UCF}<br /><br />
            </td>
        </tr>
    {/if}
</table>
<!-- /threeSixtyEvaluationFormCompetencesInput.tpl -->