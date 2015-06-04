<!-- timeshotDateGroup.tpl -->
{if $isDeleteAllowed}
<form action="javascript:void(0);" id="dateForm" onsubmit="delEHPD({$showEmployeeName});">
<input type="hidden" name="empid" value="{$id_e}"/>
<input type="hidden" name="mode" value="{$mode}"/>
{/if}
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
<table cellspacing="0" cellpadding="2">
    {assign var=raqID value=0}
    {$timeshotDatesHtml}
</table>
{if $isDeleteAllowed}
<table>
    <tr>
        <td align="right" width="100%">
            <input type="submit" class="btn btn_width_80" value="{'DELETE'|TXT_BTN}" id="delbtn" name="delbtn"
                   onclick="return confirm('{'ARE_YOU_SURE_YOU_WANT_TO_DELETE_THE_SELECTED_HISTORY'|TXT_UCF}');"/>
        </td>
    </tr>
</table>

</form>
{/if}
<!-- /timeshotDateGroup.tpl -->