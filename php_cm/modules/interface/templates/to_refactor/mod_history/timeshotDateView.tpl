<!-- timeshotDateView.tpl -->
    <tr>
        <td colspan="100%" class="bottom_line ehp_tdbg">{$assessmentCycleDescriptionHtml}</td>
    </tr>
    <tr style="text-align:left">
        <td class="bottom_line shaded_title">&nbsp;</td>
        <td class="bottom_line shaded_title" style="width:125px;">{'TIMESHOT_DATE'|TXT_UCF}</td>
        <td class="bottom_line shaded_title" style="width:125px;">{'CONVERSATION_DATE'|TXT_UCF}</td>
        {if $showFunction}
            <td class="bottom_line shaded_title" style="width:250px;">{'JOB_PROFILE'|TXT_UCF}</td>
        {/if}
    </tr>
    {foreach $timeshots as $timeshot}
    <tr>
        {assign var="historical_note_rowspan_correction" value=''}
        {if $timeshot.historical_note != ''}
            {assign var='historical_note_rowspan_correction' value=' rowspan="2"'}
        {/if}
        <td class="bottom_line" style="text-align:center;"{$historical_note_rowspan_correction}>
            {if $isDeleteAllowed}
            <input type="checkbox" name="id_ehpd[]" value="{$timeshot.ID_EHPD}"/>
            {else}
            &nbsp;
            {/if}
        </td>

        <td class="bottom_line" style="width:125px;">
            <div class="" id="mod_pdp_tasklib_cat_left2{$timeshot.ID_EHPD}" {if $timeshot.selected}style="background-color: #ffffff;"{/if}>
                <div id="eh_date{$timeshot.ID_EHPD}" style="float:left">
                                    <a href="" id="link2{$timeshot.ID_EHPD}" {if $timeshot.selected}style="color: #d21344"{/if}
                                        onclick="xajax_moduleHistory_showSelectedEmployeeHistory({$id_e}, {$timeshot.ID_EHPD}, '{$mode}', {$showEmployeeName}); return false;">
                                        {$timeshot.eh_date_display}</a>
                </div>
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
        <td >&nbsp;</td>
        <td colspan="3" class="ehp_bottom_line">{$timeshot.historical_note|nl2br}</td>
    </tr>
    {/if}

    {/foreach}
<!-- /timeshotDateView.tpl -->