<!-- questionGroup.tpl -->
<table class="content-table" cellpadding="4" style="width:{$interfaceObject->getDisplayWidth()};">
    <tr>
        <th class="bottom_line shaded_title centered" width="80">{'ORDER'|TXT_UCF}</th>
        <th class="bottom_line shaded_title">{'ASSESSMENT_QUESTION'|TXT_UCF}</th>
        <th class="bottom_line shaded_title actions" width="100">&nbsp;</td>
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
<!-- /questionGroup.tpl -->