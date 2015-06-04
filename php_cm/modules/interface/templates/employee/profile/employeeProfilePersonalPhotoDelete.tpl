<!-- employeeProfilePersonalPhotoDelete.tpl -->
{assign var=valueObject value=$interfaceObject->getValueObject()}
<p>{$interfaceObject->getConfirmQuestion()}</p>
<table border="0" cellspacing="0" cellpadding="2" style="width:{$interfaceObject->getDisplayWidth()}">
    <tr style="text-align:center;">
        <td>
            <div class="" style="padding: 4px; margin:10px;">
                <img src="{$interfaceObject->getDisplayablePhoto()}" alt="{'CURRENT_PHOTO'|TXT_UCF}" width="{$interfaceObject->getPhotoWidth()}" height="{$interfaceObject->getPhotoHeight()}">
            </div>
        </td>
    </tr>
</table><!-- /employeeProfilePersonalPhotoDelete.tpl -->