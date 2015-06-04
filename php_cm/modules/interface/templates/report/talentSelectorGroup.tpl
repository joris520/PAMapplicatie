<!-- talentSelectorGroup.tpl -->
<div id="talent_selector_grid">
    <table style="width:{$interfaceObject->getDisplayWidth()};" align="center">
        <tr>
            <th class="bottom_line shaded_title">&nbsp;</th>
            <th class="bottom_line shaded_title">{'COMPETENCE'|TXT_UCF}</th>
            <th class="bottom_line shaded_title">{'SCALE'|TXT_UCF}&nbsp;</th>
            <th class="bottom_line shaded_title" colspan="2">{'CRITERIA'|TXT_UCF}</th>
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
</div>
<!-- /talentSelectorGroup.tpl -->