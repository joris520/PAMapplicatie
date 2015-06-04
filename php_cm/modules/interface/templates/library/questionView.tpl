<!-- questionView.tpl -->
{assign var=valueObject value=$interfaceObject->getValueObject()}
{if $interfaceObject->hiliteRow()}
    {assign var='new_row_indicator' value='class="short_hilite"'}
{else}
    {assign var='new_row_indicator' value=''}
{/if}

<tr {$new_row_indicator} id="detail_row_{$valueObject->getId()}" onmouseover="activateThisRow(this);" onmouseout="deactivateThisRow(this);">
    <td class="bottom_line centered">
        {$valueObject->getSortOrder()}
    </td>
    <td class="bottom_line">
        {$valueObject->getQuestion()|nl2br}
    </td>
    <td class="bottom_line actions">
        {$interfaceObject->getEditLink()}&nbsp;{$interfaceObject->getRemoveLink()}
    </td>
</tr>
<!-- /questionView.tpl -->