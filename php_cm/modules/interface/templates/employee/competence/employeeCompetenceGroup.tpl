<!-- employeeCompetenceGroup.tpl -->
{* group is een competentie cluster *}
{* todo: styles naar css *}
{* alle categorien uitklappen *}
{if $interfaceObject->getInterfaceObjects()|count > 0}
<span id="{$interfaceObject->getToggleNotesHtmlId()}">
    <table class="content-table employee" style="width:{$interfaceObject->getDisplayWidth()};" >
        {foreach $interfaceObject->getInterfaceObjects() as $categoryInterfaceObject}
            {$categoryInterfaceObject->fetchHtml()}
        {/foreach}{* categoryInterfaceObject *}
    </table>
</span>
{else}{* count > 0 *}
<table class="content-table employee" style="width:{$interfaceObject->getDisplayWidth()};" >
    <tr>
        <td colspan="100%">
            {$interfaceObject->displayEmptyMessage()}
        </td>
    </tr>
</table>
{/if}
<!-- /employeeCompetenceGroup.tpl -->