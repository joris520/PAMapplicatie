<!-- employeeCompetenceClusterGroupEdit.tpl -->
<table border="0" cellspacing="0" cellpadding="2" style="width:{$interfaceObject->getDisplayWidth()};">
    {if $interfaceObject->showClusterInfo()}
    <tr>
        <td class="shaded_title-new" colspan="100%">
            <h2>{$interfaceObject->getClusterName()}</h2>
        </td>
    </tr>
    {/if}
    <tr>{* om de uitlijning van de radiobuttons te helpen *}
        <th class="content-title" style="width:{$interfaceObject->getCompetenceWidth()};">&nbsp;</th>
        <th class="content-title" style="width:{$interfaceObject->getScoreWidth()};">&nbsp;</th>
        <th class="content-title" style="width:{$interfaceObject->getActionsWidth()};">&nbsp;</th>
    </tr>
    {* alle competentie scores in het cluster *}
    {if $interfaceObject->getInterfaceObjects()|count > 0}
    {foreach $interfaceObject->getInterfaceObjects() as $scoreInterfaceObject}
        {$scoreInterfaceObject->fetchHtml()}
    {/foreach}
    {if $interfaceObject->showClusterInfo()}
    <tr>
        <td colspan="100%">
            <hr/>
            <br/>
        </td>
    </tr>
    {/if}
    {else}{* count > 0 *}
    <tr>
        <td colspan="100%">{$interfaceObject->displayEmptyMessage()}</td>
    </tr>
    {/if}
</table>
<!-- /employeeCompetenceClusterGroupEdit.tpl -->
