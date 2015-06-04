{* smarty *}

<!-- selectEmails.tpl -->

<div class="comp_select_emails" id="comp_select_emails">
    <input id="selected_ID_PDs" type="hidden" value="" name="selected_ID_PDs">
    <div>
        <strong>{'CLUSTER'|TXT_UCF}</strong><br />
        <input type="radio" name="cluster" id="cluster1" value="internal"     onclick="xajax_modulePersonData_selectEmailCluster(this.value, {$employee_id}, document.getElementById('selected_ID_PDs').value);">{'INTERNAL'|TXT_UCF}<br />
        <input type="radio" name="cluster" id="cluster2" value="external"   onclick="xajax_modulePersonData_selectEmailCluster(this.value, {$employee_id}, document.getElementById('selected_ID_PDs').value);">{'EXTERNAL'|TXT_UCF} *<br />
        <input type="radio" name="cluster" id="cluster3" value="both" checked onclick="xajax_modulePersonData_selectEmailCluster(this.value,{$employee_id},  document.getElementById('selected_ID_PDs').value);">{'BOTH'|TXT_UCF}<br />
    </div>

    <div>
        <strong>{'AVAILABLE'|TXT_UCF}</strong><br />
        <div id="selectCluster">
            {include file='components/select/selectEmails_selectCluster.tpl'}
        </div>
    </div>

    <div style="float: left; padding: 5px;" align="center">
        <br />
        <br>
        <input id="buttonadd"    type="button" onclick="switchSelectBox('add', 'personIDs', 'personIDs_selected', 'selected_ID_PDs');    return false;" value=">>" name="forward">
        <br>
        <br>
        <input id="buttonremove" type="button" onclick="switchSelectBox('remove', 'personIDs', 'personIDs_selected', 'selected_ID_PDs'); xajax_modulePersonData_selectEmailCluster(get_radio_value('cluster'), {$employee_id}, document.getElementById('selected_ID_PDs').value); return false;" value="<<" name="back">
        </div>

        <div>
            <strong>{'SELECTED'|TXT_UCF}</strong><br />
            <select name="personIDs_selected" id="personIDs_selected" ondblclick="switchSelectBox('remove', 'personIDs', 'personIDs_selected', 'selected_ID_PDs');  xajax_modulePersonData_selectEmailCluster(get_radio_value('cluster'), {$employee_id}, document.getElementById('selected_ID_PDs').value); return false;" size="10" multiple="multiple" style="width:250px;">
            </select>
        </div>
    </div>
</div>

<!-- /selectEmails.tpl -->