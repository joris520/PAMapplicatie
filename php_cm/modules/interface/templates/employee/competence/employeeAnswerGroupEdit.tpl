<!-- employeeAnswerGroupEdit.tpl -->
<table border="0" cellspacing="0" cellpadding="2" style="width:{$interfaceObject->getDisplayWidth()};">
    {if $interfaceObject->getInterfaceObjects()|count > 0}
    {foreach $interfaceObject->getInterfaceObjects() as $answerInterfaceObject}
        {$answerInterfaceObject->fetchHtml()}
    {/foreach}
    {else}{* count > 0 *}
    <tr>
        <td colspan="100%">{$interfaceObject->displayEmptyMessage()}</td>
    </tr>
    {/if}
</table>
<!-- /employeeAnswerGroupEdit.tpl -->