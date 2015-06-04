<!-- employeeProfilePersonalView.tpl -->
{assign var=valueObject value=$interfaceObject->getValueObject()}
{assign var=styleLabelWidth value='style="width:220px;"'}
<table class="content-table employee" style="width:{$interfaceObject->getDisplayWidth()};" >
    <tr>
        <td class="content-label" {$styleLabelWidth}>{'EMPLOYEE_NAME'|TXT_UCF}:</td>
        <td class="content-value">{EmployeeNameConverter::display($valueObject->getFirstname(), $valueObject->getLastname())}</td>
        <td class="" rowspan="9" style="width:250px;">
            {assign var=displayablePhoto value=$interfaceObject->getDisplayablePhoto()}
            {if !empty($displayablePhoto)}
            {assign var=deletePhotoLink value=$interfaceObject->getDeletePhotoLink()}
            <table>
                <tr id="employee_photo" {if !empty($deletePhotoLink)}onmouseover="activateThisRow(this);" onmouseout="deactivateThisRow(this);"{/if}>
                    <td>
                        <div style="padding: 4px; margin:10px;">
                            <img src="{$displayablePhoto}" alt="{'PHOTO_EMPLOYEE'|TXT_UCF}" width="{$interfaceObject->getPhotoWidth()}" height="{$interfaceObject->getPhotoHeight()}">
                        </div>
                    </td>
                    <td>
                        <span class="activeRow">{$deletePhotoLink}</span>
                    </td>
                </tr>
            </table>
            {else}
                <span title="{'NO_CURRENT_PHOTO'|TXT_UCF}">&nbsp;</span>
            {/if}
        </td>
    </tr>
    {assign var=extraRows value=0}
    {assign var=bsn value=$valueObject->getBsn()}
    {if !empty($bsn)}
    <tr>
        <td class="content-label">{'SOCIAL_NUMBER'|TXT_UCF}:</td>
        <td class="content-value">{$bsn}</td>
    </tr>
    {else}
        {assign var=extraRows value=$extraRows+1}
    {/if}
    {assign var=gender value=$valueObject->getGender()}
    {if !empty($gender)}
    <tr>
        <td class="content-label">{'GENDER'|TXT_UCF}:</td>
        <td class="content-value">{EmployeeGenderConverter::display($gender)}</td>
    </tr>
    {else}
        {assign var=extraRows value=$extraRows+1}
    {/if}
    {assign var=birthDate value=$valueObject->getBirthDate()}
    {if !empty($birthDate)}
    <tr>
        <td class="content-label">{'DATE_OF_BIRTH'|TXT_UCF}:</td>
        <td class="content-value">{$birthDate}</td>
    </tr>
    {else}
        {assign var=extraRows value=$extraRows+1}
    {/if}
    {assign var=nationality value=$valueObject->getNationality()}
    {if !empty($nationality)}
    <tr>
        <td class="content-label">{'NATIONALITY'|TXT_UCF}:</td>
        <td class="content-value">{$valueObject->getNationality($nationality)}</td>
    </tr>
    {else}
        {assign var=extraRows value=$extraRows+1}
    {/if}
    <tr>
        <td class="content-label">&nbsp;</td>
        <td class="content-value">&nbsp;</td>
    </tr>
    {assign var=emailAddress value=$valueObject->getEmailAddress()}
    {if !empty($emailAddress)}
    <tr>
        <td class="content-label">{'E_MAIL_ADDRESS'|TXT_UCF}:</td>
        <td class="content-value">{$emailAddress}</td>
    </tr>
    {else}
        {assign var=extraRows value=$extraRows+1}
    {/if}
    {assign var=street value=$valueObject->getStreet()}
    {assign var=postcode value=$valueObject->getPostcode()}
    {assign var=city value=$valueObject->getCity()}
    {if !empty($street) || !empty($postcode) || !empty($city)}
    <tr>
        <td class="content-label">{'ADDRESS'|TXT_UCF}:</td>
        <td class="content-value">
            {$street}<br/>
            {$postcode}{if !empty($postcode)}&nbsp;&nbsp;{/if}{$city}
        </td>
    </tr>
    {else}
        {assign var=extraRows value=$extraRows+1}
    {/if}
    {assign var=phoneNumber value=$valueObject->getPhoneNumber()}
    {if !empty($phoneNumber)}
    <tr>
        <td class="content-label">{'TELEPHONE_NUMBER'|TXT_UCF}:</td>
        <td class="content-value">{$phoneNumber}</td>
    </tr>
    {else}
        {assign var=extraRows value=$extraRows+1}
    {/if}
    {if !empty($displayablePhoto)}
    {for $extraRow=1 to $extraRows}
    <tr>
        <td>&nbsp;</td>
    </tr>
    {/for}
    {/if}
</table>
<!-- /employeeProfilePersonalView.tpl -->