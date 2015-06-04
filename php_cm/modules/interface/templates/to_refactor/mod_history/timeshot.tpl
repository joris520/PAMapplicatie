<!-- timeshot.tpl -->
<table>
    <tr>
        <td><strong>{'CONVERSATION_DATE'|TXT_UCF} :</strong></td>
        <td>{$conversation_date}</td>
        {if $showFunction}
        <td style="padding-left: 20px;"><strong>{'JOB_PROFILE'|TXT_UCF} :</strong></td>
        <td>{$job_profile}</td>
        {/if}
    </tr>
</table>

{if $showTotalScoreHistory}
    <table width="99%">
        <tr style="text-align: left">
            <th class="bottom_line ehp_tdbg">{'FINAL_RESULT'|TXT_UCW}</th>
            <th class="bottom_line ehp_tdbg centered" width="7.5%">{'CUSTOMER_MGR_SCORE_LABEL'|constant|TXT_UCF}</th>
            {if $showRemarks}
            <th class="bottom_line ehp_tdbg">{'REMARKS'|TXT_UCF}</th>
            {/if}
        </tr>
        <tr>
            <td class="ehp_bottom_line">{'TOTAL_RESULT'|TXT_UCF}</td>
            <td class="ehp_bottom_line centered">{$total_result_score}</td>
            {if $showRemarks}
            <td class="ehp_bottom_line">
                {if $total_result_comment != ''}
                    {$total_result_comment|nl2br}
                {else}
                    &nbsp;
                {/if}
            </td>
            {/if}
        </tr>
        <tr>
            <td class="ehp_bottom_line">&nbsp;&nbsp;&nbsp;&nbsp;{'BEHAVIOUR'|TXT_UCF}</td>
            <td class="ehp_bottom_line centered">{$behaviour_score}</td>
            {if $showRemarks}
            <td class="ehp_bottom_line">
                {if $behaviour_comment}
                    {$behaviour_comment|nl2br}
                {else}
                    &nbsp;
                {/if}
            </td>
            {/if}
        </tr>
        <tr>
            <td class="ehp_bottom_line">&nbsp;&nbsp;&nbsp;&nbsp;{'RESULTS'|TXT_UCF}</td>
            <td class="ehp_bottom_line centered">{$results_score}</td>
            {if $showRemarks}
            <td class="ehp_bottom_line">
                {if $results_comment != ''}
                    {$results_comment|nl2br}
                {else}
                    &nbsp;
                {/if}
            </td>
            {/if}
        </tr>
    </table>
    <br />
{/if}

{if $showRemarks}
    {assign var='comp_width' value='40%'}
{else}
    {assign var='comp_width' value='85%'}
{/if}
<table width="99%" cellspacing="0" cellpadding="2">
    <tr style="text-align: left">
        <th class="bottom_line ehp_tdbg" width="{$comp_width}">&nbsp;</th>
        <th class="bottom_line ehp_tdbg centered" width="7.5%">{'CUSTOMER_MGR_SCORE_LABEL'|constant|TXT_UCF}</th>
        {if $showNorm}
            <th class="bottom_line ehp_tdbg centered" width="7.5%">{'NORM'|TXT_UCF}</th>
        {/if}
        {if $showRemarks}
            <th class="bottom_line ehp_tdbg">{'REMARKS'|TXT_UCF}</th>
        {/if}
    </tr>

    {assign var='old_cluster' value=''}
    {foreach $emp_points as $point}
        {assign var='main_cluster_class' value=''}

        {if $point.cluster != $old_cluster}
            {assign var='old_cluster' value= $point.cluster}

            {assign var='prefix' value=''}
            {assign var='next_prefix' value=''}



            {if $point.is_cluster_main == 1}
                {assign var='next_prefix' value='KSP_INDENT'|constant}
                {assign var='main_cluster_class' value='main_competence'}
            {/if}

            <tr>
                <td class="ehp_bottom_line ehp_tdbg" colspan="100%"><span style="font-weight: bold">{$point.cluster}</span></td>
            </tr>
        {/if}

        <tr>
            <td class="ehp_bottom_line {$main_cluster_class}">{'KSP_INDENT'|constant}{$prefix}{$point.knowledge_skill_point}</td>
            <td class="ehp_bottom_line centered {$main_cluster_class}">{$module_utils_object->ScorepointTextDescriptionNew($point.standard_assessment)}</td>
            {if $showNorm}
                <td class="ehp_bottom_line centered {$main_cluster_class}">{$module_utils_object->ScorepointTextDescriptionNew($point.standard_function)}</td>
            {/if}
            {if $showRemarks}
                <td class="ehp_bottom_line {$main_cluster_class}" style="padding-left: 5px;">{$point.note|nl2br}&nbsp;</td>
            {/if}
        </tr>

        {assign var='prefix' value=$next_prefix}
    {/foreach}
</table>
<table width="99%" cellspacing="0" cellpadding="2">
    {foreach $misc_questions as $misc_question}
    <tr>
        <td class="ehp_bottom_line" width="25%"><strong>{$misc_question.question|ucfirst}&nbsp;:</strong></td>
        <td class="ehp_bottom_line">{$misc_question.answer|nl2br}</td>
    </tr>
    {/foreach}
</table>
<!-- /timeshot.tpl -->