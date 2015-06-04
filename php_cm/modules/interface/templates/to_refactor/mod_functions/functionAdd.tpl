<!-- functionAdd.tpl -->

        <div id="mod_function_right">
            <form id="addFunctionForm" name="addFunctionForm" onsubmit="submitSafeForm('{$formIdentifier}', this.name); return false;">

            <p>{'ADD_NEW_PROFILE'|TXT_UCF}</p>
            <table border="0" cellspacing="2" cellpadding="0" width="80%">
                <tr>
                    <td>
                        <strong>{'JOB_PROFILE_NAME'|TXT_UCF}:</strong>
                        <br>
                        <input type="text" id="function" name="function" size="50" autocomplete="off">
                        &nbsp;&nbsp;{$functionsSelectForCopy}
                        <br /><br />
                    </td>
                </tr>
                <tr>
                    <td>
                    {if $rows|@count == 0}
                        {'NO_COMPETENCE_RETURN'|TXT_UCF}
                    {else}
                        {assign var="ksp_prefix" value=""}
                        {assign var="showNextAsSub" value="0"}
                        <table border="0" cellspacing="0" cellpadding="1" width="99%">
                            <tr>
                                <td width="25px">&nbsp;</td>
                                <td width="100px"><strong>{'CATEGORY'|TXT_UCF}</strong></td>
                                <td><strong>{'CLUSTER'|TXT_UCF}</strong></td>
                                <td><strong>{'COMPETENCE'|TXT_UCF}</strong></td>
                                <td><strong>{'NORM'|TXT_UCF}</strong></td>';
                                if (C
                                USTOMER_OPTION_SHOW_WEIGHT) {
                                {if {$showSkillWeight} == 1}
                                <td><strong>{'WEIGHT_FACTOR'|TXT_UCF}</strong></td>
                                {/if}
                                <td><span style="display:none"><strong>{'KEY_COMPETENCE'|TXT_UCF}</strong></span>&nbsp;</td>
                            </tr>
                            {foreach $rows as $row}
                            
                            {/foreach}
                    {/if}
                            
<!-- end -->
                        </table>
                    </td>
                </tr>
            </table>
            <br>
            {'NOTE'|TXT_UCF}: {'SIGN_IS_KEY_COMP'|constant}= {'COLLECTIVE_KEY_COMPETENCE'|TXT_UCF}
            <br>
            <table border="0" cellspacing="0" cellpading="0">
                <tr>
                    <td>
                        <input type="submit" id="submitButton" value="{'SAVE'|TXT_BTN}" class="btn btn_width_80">
                    </td>
                    <td>
                        <input type="button" value="{'CANCEL'|TXT_BTN}" class="btn btn_width_80" onclick="xajax_moduleFunctions();return false;">
                    </td>
                </tr>
            </table>
            </form>
        </div>';
<!-- /functionAdd.tpl -->