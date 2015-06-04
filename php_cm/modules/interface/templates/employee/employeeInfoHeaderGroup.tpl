<!-- employeeInfoHeaderGroup.tpl -->
<div class="application-content block-title" style="width:{$interfaceObject->getDisplayWidth()};">
    {assign var=infoInterfaceObject         value=$interfaceObject->getInfoInterfaceObject()}
    {$infoInterfaceObject->fetchHtml()}
    {if $interfaceObject->showJobProfile()}

    {* ruimte boven tabel *}
    <div style="height:5px;"></div>
    {assign var=jobProfileInterfaceObject   value=$interfaceObject->getJobProfileInterfaceObject()}
    {$jobProfileInterfaceObject->fetchHtml()}
    {/if}
</div>
<!-- /employeeInfoHeaderGroup.tpl -->