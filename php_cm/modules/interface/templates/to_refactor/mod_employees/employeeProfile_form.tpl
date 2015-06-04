<!-- employeeProfile_form.tpl -->
<table class="form-layout" width="100%" border="0" cellspacing="0" cellpadding="2">
    <tr>
        <td class="form-label">{'FIRST_NAME'|TXT_UCF} {'REQUIRED_FIELD_INDICATOR'|constant} : </td>
        <td class="form-value"><input type="text" id="firstname" name="firstname" size="30" value="{$employeeProfile.firstname}" tabindex="1"></td>
        <td class="form-label">{'STREET'|TXT_UCF} : </td>
        <td class="form-value"><input name="address" type="text" id="address" size="30" value="{$employeeProfile.address}" tabindex="13"></td>
    </tr>
    <tr>
        <td class="form-label">{'LAST_NAME'|TXT_UCF} {'REQUIRED_FIELD_INDICATOR'|constant} : </td>
        <td class="form-value"><input name="lastname" type="text" id="lastname" size="30" value="{$employeeProfile.lastname}" tabindex="2"></td>
        <td class="form-label">{'ZIP_CODE'|TXT_UCF} : </td>
        <td class="form-value"><input name="postal_code" type="text" id="postal_code" size="30" value="{$employeeProfile.postal_code}" tabindex="14"></td>
    </tr>
    <tr>
        <td class="form-label">{'SOCIAL_NUMBER'|TXT_UCF} : </td>
        <td class="form-value"><input name="SN" type="text" id="SN" size="30" value="{$employeeProfile.SN}" tabindex="3"></td>
        <td class="form-label">{'CITY'|TXT_UCF} : </td>
        <td class="form-value"><input name="city" type="text" id="city" size="30" value="{$employeeProfile.city}" tabindex="15"></td>
    </tr>
    <tr>
        <td class="form-label">{'GENDER'|TXT_UCF} : </td>
        <td class="form-value">{$gender_selector}</td>
        <td class="form-label">{'TELEPHONE_NUMBER'|TXT_UCF} : </td>
        <td class="form-value"><input name="phone_number" type="text" id="phone_number" size="30" value="{$employeeProfile.phone_number}" tabindex="16"></td>
    </tr>
    <tr>
        <td class="form-label">{'DATE_OF_BIRTH'|TXT_UCF} : </td>
        <td class="form-value">
            <input name="birthdate" type="text" id="birthdate" size="18" maxlength="10" value="{$employeeProfile.birthdate}" tabindex="5">
            {$birthdate_calendar_edit}
        </td>
        <td class="form-label">{'E_MAIL_ADDRESS'|TXT_UCF} {$email_required_indicator} : </td>
        <td class="form-value"><input name="email_address" maxlength="78" type="text" id="email_address" size="30" value="{$employeeProfile.email_address}" tabindex="17">
        </td>
    </tr>
    <tr>
        <td class="form-label">{'NATIONALITY'|TXT_UCF} : </td>
        <td class="form-value"><input name="nationality" type="text" id="nationality" size="30" value="{$employeeProfile.nationality}" tabindex="6"></td>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
        <td class="form-label">{'DEPARTMENT'|TXT_UCF} {'REQUIRED_FIELD_INDICATOR'|constant} : </td>
        <td class="form-value">{$department_selector}</td>
        <td class="form-label">{'PHONE_WORK'|TXT_UCF} : </td>
        <td class="form-value"><input name="phone_number_work" type="text" id="phone_number_work" size="30" value="{$employeeProfile.phone_number_work}" tabindex="18"></td>
    </tr>
    <tr>
        <td class="form-label">{'BOSS'|TXT_UCF} : </td>
        <td class="form-value">{$boss_selector}</td>
        <td class="form-label">{'EMPLOYMENT_DATE'|TXT_UCF} : </td>
        <td class="form-value">
            <input name="employment_date" type="text" id="employment_date" size="18" maxlength="0" value="{$employeeProfile.employment_date}" tabindex="19" readonly="readonly">
            {$employment_calendar_edit}
        </td>
    </tr>
    <tr>
        <td class="form-label">{'IS_SELECTABLE_AS_BOSS'|TXT_UCF} : </td>
        <td class="form-value">{$is_boss_selector}</td>
        <td class="form-label">{'EMPLOYMENT_PERCENTAGE'|TXT_UCF} : </td>
        <td class="form-value">
            <input name="employment_FTE" maxlength="4" type="text" id="employment_FTE" size="30" value="{$module_utils_object->FTEText($employeeProfile.employment_FTE)}" tabindex="20">
        </td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
        <td class="form-label">{'EDUCATION_LEVEL'|TXT_UCF} : </td>
        <td class="form-value">{$education_level_selector}</td>
    </tr>
    <tr>
        <td colspan="2" rowspan="6">{$functions_profile_selector}</td>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <!--<td colspan="2"> 2 </td>-->
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <!--<td colspan="2"> 3 </td>-->
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <!--<td colspan="2"> 4 </td>-->
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <!--<td colspan="2"> 5 </td>-->
        <td colspan="2" rowspan="10">{'ADDITIONAL_INFO'|TXT_UCF} : <br>
            <textarea name="additional_info" id="additional_info" cols="40" rows="5" tabindex="22">{$employeeProfile.additional_info}</textarea>
            <br /><br />
            {if $allowed_edit_managers_comments}
            {'MANAGERS_COMMENTS'|TXT_UCF} :<br />
            <textarea name="hidden_info" id="hidden_info" cols="40" rows="5" tabindex="23">{$employeeProfile.hidden_info}</textarea>
            {/if}
        </td>
    </tr>
    <tr>
        <!--<td colspan="2"> 6 </td>-->
    </tr>
    <tr>
        <td class="form-label">{'MAIN_JOB_PROFILE'|TXT_UCF} {'REQUIRED_FIELD_INDICATOR'|constant} :  </td>
        <td class="form-value">{$main_profile_selector}</td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td class="form-label">{'CONTRACT_STATE'|TXT_UCF} :  </td>
        <td class="form-value">{$contract_state_selector}</td>
    </tr>
    <tr>
        {if $rating_selector_visible}
            {assign var='display_rating_selector' value=''}
        {else}
            {assign var='display_rating_selector' value=' style="display:none"'}
        {/if}
        <td class="form-label" {$display_rating_selector}>{'RATING'|TXT_UCF} {'REQUIRED_FIELD_INDICATOR'|constant} : </td>
        <td class="form-value" {$display_rating_selector}>{$rating_selector}</td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    {if $allowed_add_user}
    <tr>
        <td class="form-label">{'USERNAME'|TXT_UCF} : </td>
        <td class="form-value"><input name="username" type="text" id="username" size="30" value="" tabindex="23"></td>
    </tr>
    <tr>
        <td class="form-label">{'PASSWORD'|TXT_UCF} : </td>
        <td class="form-value"><input name="password" type="password" id="password" size="30" value="" tabindex="24"></td>
    </tr>
    <tr>
        <td class="form-label">{'SECURITY'|TXT_UCF} : </td>
        <td class="form-value">{$user_level_selector}</td>
    </tr>
    {/if}
    <tr>
        <td colspan="4">&nbsp;</td>
    </tr>
</table>
<!-- /employeeProfile_form.tpl -->