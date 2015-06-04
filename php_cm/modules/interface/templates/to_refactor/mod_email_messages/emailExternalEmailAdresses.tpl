<!-- emailExternalEmailAdresses.tpl -->
    <div id="tabNav">
        {$emailMenu}
    </div>
    <br/>
    <table border="0" cellspacing="0" cellpadding="5" width="670" align="center" class="border1px">
        <tr>
            <td>
                <!-- list external emails -->
                <table width="100%">
                    <tr>
                        <td>
                            <table width="100%" border="0" cellpadding="4">
                            {if $rows|@count == 0}
                                <tr><td>{'NO_EMAIL_S_RETURN'|TXT_UCF}</td></tr>
                            {else}
                                <tr>
                                    <td class="shaded_title bottom_line">
                                        <strong>{'EXTERNAL_EMAIL_ADDRESSES'|TXT_UCF}</strong>
                                    </td>
                                    <td class="shaded_title bottom_line" style="padding-left:5px">
                                        <strong>{'FULL_NAME'|TXT_UCF}</strong>
                                    </td>
                                    <td class="shaded_title bottom_line">
                                        &nbsp;
                                    </td>
                                </tr>
                                {foreach $rows as $row}
                                    <td class="bottom_line">{$row.email}</td>
                                    <td class="bottom_line" style="padding-left:5px">{$module_utils_object->ExternalName($row.firstname, $row.lastname)}</td>
                                    <td class="bottom_line actions" style="width:50px;">
                                        {if $isEditAllowed}
                                        <a href="" onclick="xajax_moduleEmails_editExternalEmailAddresses({$row.ID_EXT});return false;" title="{'EDIT'|TXT_UCF}"><img src="{'ICON_EDIT'|constant}" class="icon-style" border="0"></a>
                                        {/if}
                                        {if $isDeleteAllowed}
                                        <a href="" onclick="xajax_moduleEmails_deleteExternalEmailAddresses({$row.ID_EXT});return false;" title="{'DELETE'|TXT_UCF}"><img src="{'ICON_DELETE'|constant}" class="icon-style" border="0"></a>
                                        {/if}
                                    </td>

                                </tr>
                                {/foreach}
                            {/if}
                            </table>
                        </td>
                        <td>&nbsp;</td>
                    </tr>
                </table>
                <br />
                <!-- /list external emails -->
                <!-- submit new external email -->
                <div id="neEdit"><strong>{if $isAddAllowed}{'ADD_NEW_EMAIL'|TXT_UCW}</strong>{/if}</div>
                <div id="neDiv">
                {if $isAddAllowed}
                    <form id="neForm" name="neForm" onsubmit="submitSafeForm('{$formIdentifier}', this.name); return false;">
                    {$formToken}
                        <table border="0" cellspacing="0" cellpadding="10" class="border1px">
                            <tr>
                                <td class="bottom_line">
                                    {'EXTERNAL_EMAIL_ADDRESS'|TXT_UCF} {'REQUIRED_FIELD_INDICATOR'|constant}
                                </td>
                                <td class="bottom_line">
                                    <input name="email" type="text" id="email" size="30" maxlength="78">
                                </td>
                            </tr>
                            <tr>
                                <td class="bottom_line">
                                    {'FIRST_NAME'|TXT_UCF} {'REQUIRED_FIELD_INDICATOR'|constant}
                                </td>
                                <td class="bottom_line">
                                    <input name="firstname" type="text" id="firstname" size="30" maxlength="250" />
                                </td>
                            </tr>
                            <tr>
                                <td class="bottom_line">
                                    {'LAST_NAME'|TXT_UCF} {'REQUIRED_FIELD_INDICATOR'|constant}
                                </td>
                                <td class="bottom_line">
                                    <input name="lastname" type="text" id="lastname" size="30" maxlength="250" />
                                </td>
                            </tr>
                        </table>
                        <br />
                        <input type="submit" id="submitButton" class="btn btn_width_80" value="{'SAVE'|TXT_BTN}">
                    </form>
                {/if}
                </div>
                <!-- /submit new external email -->
                <br />
            </td>
        </tr>
    </table>
<!-- /emailExternalEmailAdresses.tpl -->