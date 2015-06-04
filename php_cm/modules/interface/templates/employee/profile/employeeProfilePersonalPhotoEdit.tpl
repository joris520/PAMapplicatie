<!-- employeeProfilePersonalPhotoEdit.tpl -->
{assign var=valueObject value=$interfaceObject->getValueObject()}
<table border="0" cellspacing="0" cellpadding="2" style="width:{$interfaceObject->getDisplayWidth()}">
    <tr>
        <td>
            <iframe id="upload_photo" class="border1px" src="upload_photo.php" width="99%" frameBorder="0" >
                <p>Your browser does not support iframes.</p>
            </iframe>
        </td>
    </tr>
</table>
<!-- /employeeProfilePersonalPhotoEdit.tpl -->