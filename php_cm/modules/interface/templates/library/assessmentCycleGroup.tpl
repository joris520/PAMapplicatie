<!-- assessmentCycleGroup.tpl -->
<table class="content-table" style="width:{$interfaceObject->getDisplayWidth()};">
    <tr>
        <th class="bottom_line shaded_title">{'NAME'|TXT_UCF}</th>
        <th class="bottom_line shaded_title" style="width:150px;">{'START_DATE'|TXT_UCF}</th>
        <th class="bottom_line shaded_title" style="width:150px;">{'END_DATE'|TXT_UCF}</th>
        <th class="bottom_line shaded_title actions" style="width:120px;">&nbsp;</th>
    </tr>
    {if $interfaceObject->getInterfaceObjects()|count > 0}
        {foreach $interfaceObject->getInterfaceObjects() as $viewObject}
            {$viewObject->fetchHtml()}
        {/foreach}
    {else}
    <tr>
        <td colspan="100%">{$interfaceObject->displayEmptyMessage()}</td>
    </tr>
    {/if}
</table>

<!-- /assessmentCycleGroup.tpl -->