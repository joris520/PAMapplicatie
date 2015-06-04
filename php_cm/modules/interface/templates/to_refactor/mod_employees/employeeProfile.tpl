{* employeeProfile *}
<!-- employeeProfile.tpl -->
<table width="100%" border="0" cellspacing="2" cellpadding="0">
    <tr>
        <td class="content-label" width="20%">{'EMPLOYEE_NAME'|TXT_UCF} : </td>
        <td class="content-value" width="25%">{$employeeProfile.firstname} {$employeeProfile.lastname}</td>
        <td class="content-label" width="20%">{'STREET'|TXT_UCF} : </td>
        <td class="content-value" width="35%">{$employeeProfile.address}</td>
    </tr>
    <tr>
        <td class="content-label">{'SOCIAL_NUMBER'|TXT_UCF} : </td>
        <td class="content-value">{$employeeProfile.SN}</td>
        <td class="content-label">{'ZIP_CODE'|TXT_UCF} : </td>
        <td class="content-value">{$employeeProfile.postal_code}</td>
    </tr>
    <tr>
        <td class="content-label">{'GENDER'|TXT_UCF} : </td>
        <td class="content-value">{$module_utils_object->GenderText($employeeProfile.sex)}</td>
        <td class="content-label">{'CITY'|TXT_UCF} : </td>
        <td class="content-value">{$employeeProfile.city}</td>
    </tr>
    <tr>
        <td class="content-label">{'DATE_OF_BIRTH'|TXT_UCF} : </td>
        <td class="content-value">{$employeeProfile.birthdate}</td>
        <td class="content-label">{'TELEPHONE_NUMBER'|TXT_UCF} : </td>
        <td class="content-value">{$employeeProfile.phone_number}</td>
    </tr>
    <tr>
        <td class="content-label">{'NATIONALITY'|TXT_UCF} : </td>
        <td class="content-value">{$employeeProfile.nationality}</td>
        <td class="content-label">{'E_MAIL_ADDRESS'|TXT_UCF} : </td>
        <td class="content-value">{$employeeProfile.email_address}</td>
    </tr>
    {if $employeeProfile.username}
    <tr>
        <td colspan="2">&nbsp;</td>
        <td class="content-label">{'USERNAME'|TXT_UCF} : </td>
        <td class="content-value"{$employeeProfile.username}</td>
    </tr>
    {/if}
    <tr>
        <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
        <td class="content-label">{'DEPARTMENT'|TXT_UCF} : </td>
        <td class="content-value">{$employeeProfile.department_name}</td>
        <td class="content-label">{'PHONE_WORK'|TXT_UCF} : </td>
        <td class="content-value">{$employeeProfile.phone_number_work}</td>
    </tr>
    <tr>
        <td class="content-label">{'BOSS'|TXT_UCF} : </td>
        <td class="content-value">{$employeeProfile.boss_name}</td>
        <td class="content-label">{'EMPLOYMENT_DATE'|TXT_UCF} : </td>
        <td class="content-value">{$employeeProfile.employment_date}</td>
    </tr>
    <tr>
        <td class="content-label">{'IS_SELECTABLE_AS_BOSS'|TXT_UCF} : </td>
        <td class="content-value">{$module_utils_object->IsBossText($employeeProfile.is_boss)}</td>
        <td class="content-label">{'EMPLOYMENT_PERCENTAGE'|TXT_UCF} : </td>
        <td class="content-value">{$module_utils_object->FTEText($employeeProfile.employment_FTE)}</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td class="content-label" height="100%">{'EDUCATION_LEVEL'|TXT_UCF} : </td>
        <td class="content-value">{$module_utils_object->LabelText($employeeProfile.education_level_label)}</td>
    </tr>
    <tr>
        <td class="content-label">{'MAIN_JOB_PROFILE'|TXT_UCF} : </td>
        <td class="content-value">{$employeeProfile.function_name}</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td class="content-label">{'ADDITIONAL_JOB_PROFILES'|TXT_UCF} : </td>
        <td class="content-value">{$module_utils_object->ArrayAsText($employeeAdditionalFunctions, '<br/>')}</td>
        <td colspan="2" rowspan="11">
            {if !empty($employeeProfile.displayable_photo)}
            <table>
                <tr>
                    <td>
                        <div class="border1px" style="padding: 4px;">
                            <img src="{$employeeProfile.displayable_photo}" alt="foto" width="{$employeeProfile.photo_width}" height="{$employeeProfile.photo_height}">
                        </div>
                    </td>
                </tr>
            </table>
            {else}
                &nbsp;
            {/if}
        </td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td class="content-label">{'CONTRACT_STATE'|TXT_UCF} :</td>
        <td class="content-value">{$module_utils_object->LabelText($employeeProfile.contract_state_label)}</td>
    </tr>
    <tr>
        {if $display_rating}
        <td class="content-label">{'RATING'|TXT_UCF} : </td>
        <td class="content-value">{$module_utils_object->RatingText($employeeProfile.rating)}</td>
        {else}
        <td colspan="2">&nbsp;</td>
        {/if}
    </tr>
    <tr>
        <td class="content-label"><br>{'ADDITIONAL_INFO'|TXT_UCF} : </td>
        <td class="content-value">&nbsp;</td>
    </tr>
    <tr>
    <td colspan="2">{$employeeProfile.additional_info|html_entity_decode|nl2br}</td>
    </tr>
    {if $display_manager_comments}
    <tr>
        <td class="content-label"><br>{'MANAGERS_COMMENTS'|TXT_UCF} : </td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2">{$employeeProfile.hidden_info|html_entity_decode|nl2br}</td>
    </tr>
    {/if}
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
</table>
<div id="logs" align="right">{$lastModifiedHtml}</div>
<!-- /employeeProfile.tpl -->
