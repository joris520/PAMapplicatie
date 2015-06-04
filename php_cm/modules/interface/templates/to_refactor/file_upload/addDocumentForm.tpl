<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<html>
<!-- addDocumentForm.tpl -->
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=7" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Upload File</title>
        <script type="text/javascript" src="js/mod_organisation.js"></script>
        <script type="text/javascript" src="js/mod_employees.js"></script>
        <script type="text/javascript" src="js/select_employees.js"></script>

        {$xajaxJavascript}
        <link href="css/layout.css" rel="stylesheet" type="text/css" />
        <link href="css/{$theme}.css" rel="stylesheet" type="text/css" />
        <link href="css/mod_organisation.css" rel="stylesheet" type="text/css" />
        <link href="css/dialogs.css" rel="stylesheet" type="text/css" />

{* DIT STAAT UIT, OMDAT HET RARE VERTONINGEN VEROORZAAKTE IN MSIE ...
        <style type="text/css">
            <!--
            label {
                float:left;
                display:block;
                width:120px;
            }
            input {
                float:left;
            }
            -->
        </style>
*}

    </head>
    <body>
        <div style="padding: 10px;">
            {'MAX_FILESIZE'|TXT_UCF} = {$max_size_label}.<br/>
            {'ALLOWED_EXTENSIONS'|TXT_UCF}</b> {$extensions}<br />

            {if $upload_error_string}
            <div class="error" style="padding:5px">
                <p>{$upload_error_string}</p>
            </div>
            {/if}
            {if $upload_ok_string}
            <div class="success" style="padding:5px">
                <p>{$upload_ok_string}</p>
            </div>
            {/if}
            {if $info}
            <div class="info" style="padding:5px">
                <blockquote>{$info|nl2br}</blockquote>
            </div>
            {/if}
            <form id="attachmentBatchForm" name="attachmentBatchForm" enctype="multipart/form-data" method="post" action="{$smarty.server.REQUEST_URI}">
                {$formToken}
                {$formIdentifier}
                <input type="hidden" name="MAX_FILE_SIZE" value="{$max_size}"/><br/>
                <table width="620" border="0" cellspacing="2" cellpadding="2">
                    <tr>
                        <td style="width:150px; vertical-align:bottom; padding-bottom:5px;">{'BROWSE_FILE'|TXT_UCF} {'REQUIRED_FIELD_INDICATOR'|constant}</td>
                        <td style="vertical-align:bottom; padding-bottom:5px;">
                            <input type="file" name="upload" style="height: 21px;" value="{$val_upload}">
                        </td>
                    </tr>
                    <tr>
                       <td>{'CLUSTER'|TXT_UCF}</td>
                       <td>{include file='components/select/selectDocumentCluster.tpl'}</td>
                    </tr>
                    <tr>
                       <td>{'ACCESS'|TXT_UCF}</td>
                       <td>{include file='components/select/selectDocumentAuthorisation.tpl'}</td>
                    </tr>
                    <tr>
                        <td>{'DESCRIPTION'|TXT_UCF}</td>
                        <td><textarea name="description" cols="60" rows="3">{$val_description}</textarea></td>
                    </tr>
                    <tr>
                        <td>{'REMARKS'|TXT_UCF}</td>
                        <td><textarea name="remarks" cols="60" rows="3" >{$val_remarks}</textarea></td>
                    </tr>
                </table>
                {if $showSelectEmployees}
                    <p>{'SELECT'|TXT_UCW} {'EMPLOYEES'|TXT_UCW} {'REQUIRED_FIELD_INDICATOR'|constant}</p>
                    {include file='components/select/selectEmployees.tpl'}
                {/if}
                <input type="submit" name="submitButton" value="{'UPLOAD'|TXT_BTN}" class="btn btn_width_80"/>
            </form>

        </div>
    </body>
<!-- /addDocumentForm.tpl -->
</html>