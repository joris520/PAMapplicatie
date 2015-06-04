<!-- assessmentCycleView.tpl -->
{assign var=valueObject value=$interfaceObject->getValueObject()}
{if $interfaceObject->hiliteRow()}
    {assign var='new_row_indicator' value='short_hilite'}
{else}
    {assign var='new_row_indicator' value=''}
{/if}
{if $interfaceObject->isCurrentCycle()}
    {assign var='current_row_indicator' value='MESSAGE_INFO'|constant}
{else}
    {assign var='current_row_indicator' value=''}
{/if}

<tr class="{$new_row_indicator} {$current_row_indicator}" id="detail_row_{$valueObject->getId()}" onmouseover="activateThisRow(this);" onmouseout="deactivateThisRow(this);">
    <td class="bottom_line">
        {$valueObject->getAssessmentCycleName()}
    </td>
    <td class="bottom_line">
        {DateConverter::display($valueObject->getStartDate())}
    </td>
    <td class="bottom_line">
        {DateConverter::display($valueObject->getEndDate())}
    </td>
    <td class="bottom_line actions">
        {$interfaceObject->getEditLink()}&nbsp;{$interfaceObject->getRemoveLink()}
    </td>
</tr>
<!-- /assessmentCycleView.tpl -->