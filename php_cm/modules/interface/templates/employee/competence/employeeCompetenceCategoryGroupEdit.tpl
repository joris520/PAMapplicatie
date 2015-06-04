<!-- employeeCompetenceCategoryGroupEdit.tpl -->
{* group is een catetory *}
{* todo: styles naar css *}
<table class="content-table" border="0" cellspacing="0" cellpadding="2" style="width:{$interfaceObject->getDisplayWidth()};" >
    {if $interfaceObject->showCategoryName()}
    <tr>
        <th colspan="100%">
            <h2>{CategoryConverter::display($interfaceObject->getCategoryName())}</h2>
        </th>
    </tr>
    {/if}
    {foreach $interfaceObject->getInterfaceObjects() as $clusterInterfaceObject}
        {$clusterInterfaceObject->fetchHtml()}
    {/foreach}{* clusterInterfaceObject *}
</table>
<!-- /employeeCompetenceCategoryGroupEdit.tpl -->