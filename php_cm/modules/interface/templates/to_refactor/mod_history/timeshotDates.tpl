<!-- timeshotDates.tpl -->
<form action="javascript:void(0);" id="dateForm" onsubmit="delEHPD({$showEmployeeName});">
<input type="hidden" name="empid" value="{$id_e}"/>
<input type="hidden" name="mode" value="{$mode}"/>
{if $showEmployeeName}
<table style="margin-top: 38px;">

    <tr>
        <td>
            <b><font size="3">{$name}</font></b>
            <p>{if $mode == 'function'}{'BASED_ON_JOB_PROFILE'|TXT_UCF}
               {elseif $mode == 'competence'}{'BASED_ON_DICTIONARY'|TXT_UCF}{/if}
            </p>
        </td>
    </tr>
</table>
{/if}
<!--<table cellspacing="0" cellpadding="0" style="width:{$displayWidth}px">
    <tr>
        <th class="bottom_line shaded_title" style="padding:5px;" >{'NAME'|TXT_UCF}</th>
        <th class="bottom_line shaded_title" style="padding:5px; width:150px;">{'START_DATE'|TXT_UCF}</th>
        <th class="bottom_line shaded_title" style="padding:5px; width:150px;">{'END_DATE'|TXT_UCF}</th>
        <th class="bottom_line shaded_title actions" style="padding:5px; width:120px;">&nbsp;</th>
    </tr>
</table>-->
<table cellspacing="0" cellpadding="0">
    {assign var=raqID value=0}
    {foreach $evaluationPeriods as $evaluationPeriod}
        <tr>
            <td colspan="100%" class="bottom_line ehp_tdbg">{$evaluationPeriod.assessmentCycle}</td>
        </tr>
        {if $evaluationPeriod.timeshotCount > 0}
            {foreach $evaluationPeriod.timeshots as $timeshot}
            <tr style="text-align:left">
                <td class="bottom_line shaded_title">&nbsp;</td>
                <td class="bottom_line shaded_title" style="width:125px;">{'TIMESHOT_DATE'|TXT_UCF}</td>
                <td class="bottom_line shaded_title" style="width:125px;">{'CONVERSATION_DATE'|TXT_UCF}</td>
                {if $showFunction}
                    <td class="bottom_line shaded_title" style="width:250px;">{'JOB_PROFILE'|TXT_UCF}</td>
                {/if}
            </tr>
            <tr>
                {assign var="historical_note_rowspan_correction" value=''}
                {if $timeshot.historical_note != ''}
                    {assign var='historical_note_rowspan_correction' value=' rowspan="2"'}
                {/if}
                <td class="bottom_line" style="text-align:center;"{$historical_note_rowspan_correction}>
                    <input type="checkbox" name="id_ehpd[]" value="{$timeshot.ID_EHPD}"/>
                </td>
                <td class="bottom_line" style="width:125px;">
                    <div class="" id="mod_pdp_tasklib_cat_left2{$timeshot.ID_EHPD}" {if $timeshot.selected}style="background-color: #ffffff"{/if}>
                        <div id="eh_date{$timeshot.ID_EHPD}" style="float:left">
                                           <a href="" id="link2{$timeshot.ID_EHPD}" {if $timeshot.selected}style="color: #d21344"{/if}
                                               onclick="xajax_moduleHistory_showSelectedEmployeeHistory({$id_e}, {$timeshot.ID_EHPD}, '{$mode}', {$showEmployeeName}); return false;">
                                               {$timeshot.eh_date_display}</a></div>
                        <div id="eh_dateRaq{$raqID}" style="float:left">
                            {if $timeshot.selected}
                                &nbsp;<img src="images/arrow.gif" align="absmiddle" border="0" alt=""/>
                            {/if}
                        </div>
                    </div>
                </td>
                <td class="bottom_line" style="width:125px;">
                    {$timeshot.conversation_date}&nbsp;
                </td>
                {if $showFunction}
                    <td class="bottom_line" style="width:250px;">{$timeshot.function}</td>
                {/if}
            </tr>
            {assign var='raqID' value=$raqID+1}
            {if $timeshot.historical_note != ''}
            <tr>
                <td colspan="3" class="ehp_bottom_line">{$timeshot.historical_note|nl2br}</td>
            </tr>
            {/if}
            {/foreach}
        {else}
            <td class="bottom_line" colspan="100%">
                {'NO_TIMESHOTS_IN_EVALUATION_PERIODS'|TXT_UCF}
            </td>
        {/if}
    {foreachelse}
    <tr>
        <td class="bottom_line" colspan="100%">
            <font color="red">&nbsp;*{'NO_EMPLOYEE_HISTORY_SAVED'|TXT_UCF}</font>
        </td>
    </tr>
    {/foreach}
</table>
<table>
    <tr>
        <td align="right" width="100%">
        {if $show_btn_add_del}
            <input type="submit" class="btn btn_width_80" value="{'DELETE'|TXT_BTN}" id="delbtn" name="delbtn"
                   onclick="return confirm('{'ARE_YOU_SURE_YOU_WANT_TO_DELETE_THE_SELECTED_HISTORY'|TXT_UCF}');"/>
        {/if}
        </td>
    </tr>
</table>

</form>
<!-- /timeshotDates.tpl -->