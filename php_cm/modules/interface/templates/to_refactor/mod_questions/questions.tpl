<!-- questions.tpl -->
<br />
<table border="0" cellspacing="0" cellpadding="5" width="670" align="center" class="border1px">
    <tr>
        <td>
            <form id="mod_questionsForm" name="mod_questionsForm" onsubmit="submitSafeForm('{$formIdentifier}', this.name); return false;">
            {$form_token}
            <table width="100%" cellspacing="1" cellpadding="2">
                <tr>
                    <td class="bottom_line shaded_title" width="100"><b>{'ACTIVE'|TXT_UCF}</b></td>
                    <td class="bottom_line shaded_title" width="100"><b>{'ORDER'|TXT_UCF}</b></td>
                    <td class="bottom_line shaded_title"><b>{'QUESTION_LABEL'|TXT_UCF}</b></td>
                </tr>
                {foreach $a_questions as $question}
                <tr>
                    <td class="bottom_line">
                        <input type="checkbox" name="active{$question@iteration}" value="1" {if $question['active']}checked="checked"{/if} />
                    </td>
                    <td class="bottom_line">
                        <input name="question_id{$question@iteration}" type="hidden" value="{$question['ID_MQ']}"/>
                        {$question@iteration}
                    </td>
                    <td class="bottom_line">
                        <textarea name="question{$question@iteration}" cols="70" rows="2">{$question['question']}</textarea>
                    </td>
                </tr>
                {/foreach}
                <tr>
                    <td colspan="3">
                         <input type="submit" id="submitButton" value="{'SAVE'|TXT_BTN}" class="btn btn_width_80" />
                    </td>
                </tr>
            </table>
            </form>
        </td>
    </tr>
</table>
<!-- /questions.tpl -->