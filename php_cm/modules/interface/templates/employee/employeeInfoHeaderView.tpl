<!-- employeeInfoHeaderView.tpl -->
{assign var=valueObject value=$interfaceObject->getValueObject()}
<table border="0" cellspacing="0" cellpadding="2" style="width:{$interfaceObject->getDisplayWidth()};">
    <tr>
        {assign var=displayablePhoto value=$interfaceObject->getDisplayablePhoto()}
        {if !empty($displayablePhoto)}
        <td style="width:{$interfaceObject->getPhotoWidth()}px; padding-right:10px;">
            {if $interfaceObject->showAddPhotoLink()}
            <a href="" onClick="{$interfaceObject->getAddPhotoLink()};return false" title="{'UPLOAD_PHOTO_THUMBNAIL'|TXT_UCF}" style="border:0">
            {/if}
                <img src="{$displayablePhoto}" alt="{$valueObject->getEmployeeName()}" width="{$interfaceObject->getPhotoWidth()}" height="{$interfaceObject->getPhotoHeight()}">
            {if $interfaceObject->showAddPhotoLink()}
            </a>
            {/if}

        </td>
        {/if}
        <td style="vertical-align:middle">
            <h1 title="{'EMPLOYEE'|TXT_UCF}">{$valueObject->getEmployeeName()}</h1>
            {assign var=department value=$valueObject->getDepartmentName()}
            {if !empty($department)}
            <div title="{'DEPARTMENT'|TXT_UCF}">{$department}</div>
            {/if}
            {assign var=bossName value=$valueObject->getBossName()}
            {if !empty($bossName)}
            <div title="{'MANAGER'|TXT_UCF}">{$bossName}</div>
            {/if}
        </td>
        <td style="width:50px; text-align:right; vertical-align:top;">
            {$interfaceObject->getActionLinks()}
        </td>
    </tr>
</table>
<!-- /employeeInfoHeaderView.tpl -->