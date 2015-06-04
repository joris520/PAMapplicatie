<!-- departmentGroup.tpl -->
<table class="content-table" style="width:{$interfaceObject->getDisplayWidth()};">
    <tr>
        <th class="bottom_line shaded_title">{'DEPARTMENT'|TXT_UCF}</th>
        <th class="bottom_line shaded_title centered" style="width:100px;">{'EMPLOYEES'|TXT_UCF}</th>
        <th class="bottom_line shaded_title centered" style="width:100px;">{'USERS'|TXT_UCF}</th>
        <th class="bottom_line shaded_title actions"  style="width:100px;">&nbsp;</td>
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
<!-- /departmentGroup.tpl -->