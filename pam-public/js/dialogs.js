

// jqueryui
function activateDialogUI (dialog_id, dialog_height, dialog_width)
{
    // Controleer of er extra opties zijn
        $('#'+dialog_id).dialog({
            autoResize:true,
			width: dialog_width,
            resizable: false,
            draggable: false,
			modal: true
		});
}

/* modal: http://www.ericmmartin.com/projects/simplemodal */
function activateFormDialog (dialog_id, dialog_width, dialog_height, borderStyle)
{
    $('#'+dialog_id).modal({onOpen: function (dialog) {
        dialog.overlay.fadeIn('fast', function () {
            dialog.container.fadeIn('fast', function () {
                dialog.data.fadeIn('fast');
            });
        });
    }, onClose: function (dialog) {
        dialog.data.fadeOut('fast', function () {
            dialog.container.fadeIn('fast', function () {
                dialog.overlay.fadeOut('fast', function () {
                    $.modal.close();
                });
            });
        });
    }, containerCss:{
            height: dialog_height,
            width: dialog_width,
            border: borderStyle
    }});

}

function showDialogMessage(messageHeight)
{
    if ($('#dialog_message').is(':hidden')) {
        dialogHeight = parseInt($('#simplemodal-container').height());
        $('#dialog_message').css({height: messageHeight}).show();
        messageMarginTop = parseInt($('#dialog_message').css('margin-top').replace('px', ''));
        messageMarginBottom = parseInt($('#dialog_message').css('margin-bottom').replace('px', ''));
        messageMargins = messageMarginTop + messageMarginBottom;
        dialogHeight = dialogHeight + messageHeight + messageMargins;
        $('#simplemodal-container').css({height: dialogHeight});
    }
}

function hideDialogMessage ()
{
    if (!$('#dialog_message').is(':hidden')) {
        dialogHeight = parseInt($('#simplemodal-container').height());
        messageHeight = parseInt($('#dialog_message').height());
        messageMarginTop = parseInt($('#dialog_message').css('margin-top').replace('px', ''));
        messageMarginBottom = parseInt($('#dialog_message').css('margin-bottom').replace('px', ''));
        messageMargins = messageMarginTop + messageMarginBottom;
        $('#dialog_message').css({height: 0}).hide();
        dialogHeight = dialogHeight - (messageHeight + messageMargins);
        $('#simplemodal-container').css({height: dialogHeight});
    }
}

function closeFormDialog()
{
    $('#form_dialog').html('');
    $.modal.close('form_dialog');
}

