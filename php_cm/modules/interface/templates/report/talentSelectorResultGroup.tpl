<!-- talentSelectorResultGroup.tpl -->
<table class="ts_table" class="border1px" style="width:{$interfaceObject->getDisplayWidth()}">
    <tr>
        <th class="bottom_line shaded_title">{'EMPLOYEE'|TXT_UCF}</th>
        <th class="bottom_line shaded_title">{'SCORE'|TXT_UCF}</th>
    </tr>

    {foreach $interfaceObject->getInterfaceObjects() as $talentSelectorCompetence}
        {$talentSelectorCompetence->fetchHtml()}
    {/foreach}
</table>
<!-- /talentSelectorResultGroup.tpl -->