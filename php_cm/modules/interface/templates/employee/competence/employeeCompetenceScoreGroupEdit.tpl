<!-- employeeCompetenceScoreGroupEdit.tpl -->
<span id="{$interfaceObject->getToggleNotesHtmlId()}">
<table border="0" cellspacing="0" cellpadding="2" style="width:{$interfaceObject->getDisplayWidth()};">
    <tr>
        <th class="content-title" style="width:{$interfaceObject->getCompetenceWidth()};">&nbsp;</th>
        <th class="content-title" style="width:{$interfaceObject->getScoreWidth()};">&nbsp;</th>
        <th class="content-title actions" style="width:{$interfaceObject->getActionsWidth()}; padding-bottom:10px;">
            {if $interfaceObject->showRemarks()}
                {$interfaceObject->getToggleNotesVisibilityLink()}
            {else}
                &nbsp;
            {/if}
        </th>
    </tr>
    {if $interfaceObject->getInterfaceObjects()|count > 0}
    {foreach $interfaceObject->getInterfaceObjects() as $scoreInterfaceObject}
        {$scoreInterfaceObject->fetchHtml()}
    {/foreach}
    {else}{* count > 0 *}
    <tr>
        <td colspan="100%">{$interfaceObject->displayEmptyMessage()}</td>
    </tr>
    {/if}
</table>
</span>
<!-- /employeeCompetenceScoreGroupEdit.tpl -->
