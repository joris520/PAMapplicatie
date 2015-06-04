<!-- lastSaved.tpl -->
{assign var=valueObject value=$interfaceObject->getValueObject()}
<table width="300" border="0" cellspacing="1" cellpadding="1" class="border1px">
    <tr>
        <td width="130" class="bottom_line shaded_title">{'LAST_MODIFIED_BY'|TXT_UCF}</td>
        <td width="150" class="activated">{$valueObject->getSavedByUserName()}</td>
    </tr>
    <tr>
        <td class="bottom_line shaded_title">{'LAST_MODIFIED_ON'|TXT_UCF}</td>
        <td class="activated">{DateTimeConverter::display($valueObject->getSavedDateTime)}</td>
    </tr>
</table>
<!-- /lastSaved.tpl -->