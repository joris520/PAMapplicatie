{strip}
<!-- masterRow.tpl -->
{if $buttons_on_mouseover}
    {assign var='mouseover_actions' value='onmouseover="activateThisRow(this);" onmouseout="deactivateThisRow(this);"'}
{else}
    {assign var='mouseover_actions' value=''}
{/if}
<tr id="{$masterRow.master_row_id}" class="master-header-row {$masterRow.row_class}" {$mouseover_actions}>
    <td id="master_row_title{$masterRow.master_row_id}" class="master-row-title spaced" {if !$masterRow.show_buttons}colspan="100%"{/if}>
        {$masterRow.row_prefix}<a href="" onClick="{$masterRow.link_action};return false;" title="{$masterRow.link_title}">{$masterRow.link_name}</a>
    </td>
    {if $masterRow.show_buttons}
    <td id="master_row_buttons{$masterRow.master_row_id}" class="master-row-buttons spaced{if $buttons_on_mouseover} activeRow{/if}">
        {$masterRow.row_buttons}
    </td>
    {/if}
</tr>
<!-- /masterRow.tpl -->
{/strip}