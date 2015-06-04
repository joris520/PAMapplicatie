<!-- pdpActionUserDefinedClusterGroup.tpl -->
{if $interfaceObject->hasInterfaceObjects()}
<table border="0" cellspacing="0" cellpadding="4" style="width:{$interfaceObject->getDisplayWidth()};">
    {foreach $interfaceObject->getInterfaceObjects() as $pdpActionInterfaceObject}
        {$pdpActionInterfaceObject->fetchHtml()}
    {/foreach}
</table>
{else}
    {$interfaceObject->displayEmptyMessage()}
{/if}
<!-- /pdpActionUserDefinedClusterGroup.tpl -->