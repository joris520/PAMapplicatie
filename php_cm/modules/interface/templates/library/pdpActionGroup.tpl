<!-- pdpActionGroup.tpl -->
{if $interfaceObject->getInterfaceObjects()|count > 0}
    {foreach $interfaceObject->getInterfaceObjects() as $clusterInterfaceObject}
        {$clusterInterfaceObject->fetchHtml()}
    {/foreach}
{/if}
<!-- /pdpActionGroup.tpl -->