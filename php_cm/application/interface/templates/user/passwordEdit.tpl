<!-- passwordEdit.tpl -->
 <p>{'VALID_PASSWORD_FORMAT'|TXT_UCF}.</p>
<table border="0" cellspacing="0" cellpadding="2" style="width:{$interfaceObject->getDisplayWidth()};">
    {* hack om browser wachtwoord opslaan bij de juiste gebruikersnaam te krijgen*}
    <tr style="display:none;">
        <td class="form-label">
            <label for="user_name">{'USERNAME'|TXT_UCF} {$interfaceObject->getRequiredFieldIndicator()}</label>
        </td>
        <td class="form-value">
            <input id="user_name" name="user_name" type="text" size="30" value="{$interfaceObject->getUserName()}" readonly="readonly">
        </td>
    </tr>
    <tr>
        <td class="form-label" style="width:150px;">
            <label for="current">{'OLD_PASSWORD'|TXT_UCF} {$interfaceObject->getRequiredFieldIndicator()}</label>
        </td>
        <td class="form-value">
            <input  id="current" name="current" type="password" size="30" value="">
        </td>
    </tr>
    <tr>
        <td class="form-label">
            <label for="new">{'NEW_PASSWORD'|TXT_UCF} {$interfaceObject->getRequiredFieldIndicator()}</label>
        </td>
        <td class="form-value">
            <input  id="new" name="new" type="password" size="30" value="">
        </td>
    </tr>
    <tr>
        <td class="form-label">
            <label for="confirm">{'CONFIRM_PASSWORD'|TXT_UCF} {$interfaceObject->getRequiredFieldIndicator()}</label>
        </td>
        <td class="form-value">
            <input  id="confirm" name="confirm" type="password" size="30" value="">
        </td>
    </tr>
</table>
<!-- /passwordEdit.tpl -->