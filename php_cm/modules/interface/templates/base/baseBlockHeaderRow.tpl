<!-- baseBlockHeaderRow.tpl -->
{if $interfaceObject->hiliteRow()}
    {assign var='new_row_indicator' value='class="short_hilite"'}
{else}
    {assign var='new_row_indicator' value=''}
{/if}
    <tr {$new_row_indicator}>
        <td>
            {$interfaceObject->getContentInterfaceObject()->fetchHtml()}
        </td>
        <td id="{$interfaceObject->getActionId()}" style="width:{$interfaceObject->getActionsWidth()}; text-align:right">
            {$interfaceObject->getActionLinks()}
        </td>
    </tr>

<!-- /baseBlockHeaderRow.tpl -->