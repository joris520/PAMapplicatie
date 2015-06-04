<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<!-- addEvaluationDocumentForm.tpl -->
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=7" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Upload File</title>
        <script type="text/javascript" src="js/mod_organisation.js"></script>
        <script type="text/javascript" src="js/mod_employees.js"></script>
        {$xajaxJavascript}
        <link href="css/layout.css" rel="stylesheet" type="text/css" />
        <link href="css/{$theme}.css" rel="stylesheet" type="text/css" />
        <link href="css/mod_organisation.css" rel="stylesheet" type="text/css" />
        <link href="css/dialogs.css" rel="stylesheet" type="text/css" />

    </head>
    <body>
        <div style="padding: 10px;">
            {if !$finished_upload}

            {if $upload_error_string}
            <strong style="color:#ff0000;">{$upload_error_string}</strong>
            <br />
            {'MAX_FILESIZE'|TXT_UCF} = {$max_size_label}.<br />
            {'ALLOWED_EXTENSIONS'|TXT_UCF}</b> {$extensions}<br />
            {/if}
            {/if}
            {if $upload_ok_string}
            <br />
            <strong>{$upload_ok_string}</strong>
            {/if}
            {if $info}
                <blockquote>{$info|nl2br}</blockquote>
            {/if}
            {if !$finished_upload}
            <form name="form1" enctype="multipart/form-data" method="post" action="{$smarty.server.REQUEST_URI}">
                {$formToken}
                {$formIdentifier}
                <input type="hidden" name="MAX_FILE_SIZE" value="{$max_size}"/><br/>
                <table width="380" border="0" cellspacing="2" cellpadding="2">
                    <tr>
                        <td style="vertical-align:bottom; padding-bottom:5px;">{'BROWSE_FILE'|TXT_UCF} {'REQUIRED_FIELD_INDICATOR'|constant}</td>
                        <td style="vertical-align:bottom; padding-bottom:5px;">
                            <input type="file" name="upload" style="height: 21px;" value="{$val_upload}">
                        </td>
                    </tr>
                </table>
                <input type="submit" name="submitButton" value="{'UPLOAD'|TXT_BTN}" class="btn btn_width_80"/>
            </form>
            {/if}
        </div>
    </body>
<!-- /addEvaluationDocumentForm.tpl -->
</html>