<!-- employeePdpActionCompetenceSelectGroup.tpl -->
{assign var=isFirst value=true}
<div style=" background-color:white;width:680px;height:200px; overflow:auto;">
    <table style="padding: 4px;width:650px;">
    {foreach $interfaceObject->getInterfaceObjects() as $categoryInterfaceObject}
        {$categoryInterfaceObject->fetchHtml()}
        {assign var=isFirst value=false}
    {/foreach}
    </table>
</div>
<!-- /employeePdpActionCompetenceSelectGroup.tpl -->