<!-- employeeAnswerView.tpl -->
{assign var=valueObject value=$interfaceObject->getValueObject()}
<tr id="answer_row_{$valueObject->getId()}" onmouseover="activateThisRow(this);" onmouseout="deactivateThisRow(this);">
    <th class="shaded_title-new" style="text-align:left;">
        {$interfaceObject->displayEmployeeQuestion()}
    </th>
    <th class="shaded_title-new" style="text-align:right; width:{$interfaceObject->getActionsWidth()}">
       {$interfaceObject->getActionLinks()}
    </th>
</tr>
<tr>
    <td style="padding-left: 20px;">
        {assign var=answer value=$valueObject->getAnswer()}
        {if !empty($answer)}
        <div style="{$interfaceObject->getDisplayWidth()}" >{$answer|nl2br}</div</td>
        {/if}
</tr>
<tr>
    <td colspan="100%">&nbsp;</td>
</tr>
<!-- /employeeAnswerView.tpl -->