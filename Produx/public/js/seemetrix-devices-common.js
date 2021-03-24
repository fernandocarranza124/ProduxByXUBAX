/**
* Add device OnClick Handler
*   success: handler for successful addition of device.
*/
function addDeviceOnClick(event, success) {
    $('#modal').modal("hide");

    // send form data to server
    var data = $('#device-create').serialize();
    data['device-name'] = $('#id_name').val();
    data['device-key'] = $('#id_pin').val();

    showWait();

    sendAjaxRequest("/devices/add/", data,
        function(response, textStatus, jqXHR) {
            $('#please-wait-dialog').on('hidden.bs.modal', function (event) {

                $('#please-wait-dialog').unbind('hidden.bs.modal');

                if (typeof response == 'object') {
                    if (typeof success !== 'undefined') { success(response); } else { window.location.reload(); }
                } else {
                    var modal = $('#modal');
                    modal.html(response);
                    $('#btn-add-device-ok').on('click', addDeviceOnClick);

                    // support of post of form by push enter
                    $('#device-create').find('input[type="text"]').on('keydown',
                        function(e) { if (e.keyCode == 13) {// Enter
                            addDeviceOnClick(null, success);
                        }
                    });
                    modal.modal('show');
                }
            });

            hideWait();
        }, undefined, failActionRequest, 'POST');

    return false;
};

/**
* showWait.
*
* Show waiting modal.
* @param: {function} cancelCallback - if set then show 'Cancel' button and set this as onClick handler.
*/
function showWait(cancelCallback) {
    if (typeof(cancelCallback) == 'function') {
        $('#please-wait-dialog-footer').css('display', 'block');
        $('#please-wait-dialog-cancel-btn').on('click', cancelCallback);
    } else {
        $('#please-wait-dialog-footer').css('display', 'none');
    }
    $('#please-wait-dialog').modal('show');
};

/**
* hideWait.
*
* Hide waiting modal.
*/
function hideWait() {
    $('#please-wait-dialog').modal('hide');
};


function setFocusAndEndPos(el) {
    if(el === undefined) return;
    el.focus();
    var strLength = el.value.length;
    if(el.setSelectionRange !== undefined) {
        el.setSelectionRange(strLength, strLength);
    } else {
        $(el).val(el.value);
    }
}

function SelectDevicesGroup() {
    this.type = SelectDevicesGroup.DEFAULT_TYPE;
    this.id = SelectDevicesGroup.DEFAULT_ID;

    this.setCurrent = function(type, id) {
        if (!["custom", "sharedBy", "sharedTo", null].includes(type)) {
            throw new Error(`Unknown devices group type (${type})`);
        }
        this.type = type;
        this.id = id;
    };

    this.isDefaultGroup = function() {
        return Boolean(this.type === SelectDevicesGroup.DEFAULT_TYPE && SelectDevicesGroup.id === this.DEFAULT_ID);
    };

    this.isEqual = function(other) {
        if (!(other instanceof SelectDevicesGroup)) {
            throw new Error("Expected instance of SelectDevicesGroup class");
        }
        return Boolean(this.type === other.type && this.id === other.id);
    }
}

SelectDevicesGroup.DEFAULT_TYPE = null;
SelectDevicesGroup.DEFAULT_ID = -1;