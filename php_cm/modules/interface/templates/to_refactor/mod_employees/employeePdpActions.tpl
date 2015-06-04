<!-- employeePdpActions.tpl -->
<h1>{$title}</h1>
<table width="100%" border="0" cellspacing="0" cellpadding="2">
    <tr>
        <th width="30%" class="content-title">{'ACTION'|TXT_UCF}</th>
        <th class="content-title">{'STATUS'|TXT_UCF}</th>
        <th class="content-title centered">{'TASKS'|TXT_UCF}</th>
        <th class="content-title">{'DEADLINE_DATE'|TXT_UCF}</th>
        <th class="content-title">{'PROVIDER'|TXT_UCF}</th>
        <th class="content-title">{'DURATION'|TXT_UCF}</th>
        <th class="content-title">{'COST'|TXT_UCF}</th>
        <th class="content-title">&nbsp;</th>
    </tr>
    {foreach $pdpActions as $pdpAction}
    {if $pdpAction.hilite}
        {assign var='new_row_indicator' value='class="short_hilite" style="display:none"'}
    {else}
        {assign var='new_row_indicator' value=''}
    {/if}
    <tr {$new_row_indicator} id="pdpaction_row_{$pdpAction.pdpaction_id}" onmouseover="activateThisRow(this);" onmouseout="deactivateThisRow(this);">
        <td class="content-line" >
            <span id="click{$pdpAction.pdpaction_id}">{$pdpAction.actionLink}</span>
            <span class="activeRow icon-style"><img src="{'ICON_INFO'|constant}" title="KLIK VOOR DETAILS"></span>
        </td>
        <td class="content-line">{$pdpAction.stateHtml}</td>
        <td class="content-line centered">{if $pdpAction.number_of_tasks > 0}{$pdpAction.number_of_tasks}{else}&nbsp;{/if}</td>
        <td class="content-line">{$pdpAction.end_date}</td>
        <td class="content-line">{$pdpAction.provider}</td>
        <td class="content-line">{$pdpAction.duration}</td>
        <td class="content-line">{$pdpAction.costsHtml}</td>
        <td class="content-line action-buttons activeRow">{$pdpAction.actionButtons}</td>
    </tr>
    <tr id="detail_row_{$pdpAction.pdpaction_id}" class="hidden-info">
        <td colspan="100%" id="detail_content_{$pdpAction.pdpaction_id}" style="padding-left: 10px;"></td>
    </tr>

    {/foreach}
</table>


<!-- employeePdpActions.tpl -->