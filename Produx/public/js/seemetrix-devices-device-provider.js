/**
* Device.
*
* Class subscribe device data.
* @constructor
* @param {int} id - device identifier.
* @param {string} name - device name.
* @param {bool} online - online device flag.
* @param {bool} frozen - frozen device flag.
*/
function Device(id, name, online, frozen, status, ownedByMe) {
    this.id = id;
    this.name = name;
    this.online = online;
    this.frozen = frozen;
    this.status = status;
    this.ownedByMe = ownedByMe;

    /**
    * setFrozen.
    *
    * Set frozen state using DeviceProvider.
    * @param {bool} value - frozen value.
    */
    this.setFrozen = function(value) {
        DeviceProvider.instance().setFrozen(this.id, value);
        this.frozen = value;
    };
};

/**
* DeviceGroup.
*
* Class contain objects of Device.
* @constrictor
* @param {list[Device]} devices - devices.
*/
function DeviceGroup(devices) {
    this.devices = devices;

    this.length = function() { return this.devices.length; };
    this.get = function(index) { return this.devices[index]; };
    this.set = function(index, value) { this.devices[index] = value; }
    this.empty = function() { return Boolean(this.devices.length == 0); }

    /**
    * getOffline.
    *
    * Return all offline device as DeviceGroup.
    */
    this.getOffline = function() {
        var offlines = [];
        for(let device of this.devices) {
            if(!device.online) {
                offlines.push(device);
            }
        }
        return new DeviceGroup(offlines);
    };

    /**
    * Return all online device as DeviceGroup.
    */
    this.getOnline = function() {
        var onlines = [];
        for(let device of this.devices) {
            if(device.online) {
                onlines.push(device);
            }
        }
        return new DeviceGroup(onlines);
    };

    /**
    * Return all frozen device as DeviceGroup.
    */
    this.getFrozen = function() {
        var frozen = [];
        for(let device of this.devices) {
            if(device.frozen) {
                frozen.push(device);
            }
        }
        return new DeviceGroup(frozen);
    };

    /**
    * Return all unfrozen device as DeviceGroup.
    */
    this.getUnFrozen = function() {
        var unfrozen = [];
        for(let device of this.devices) {
            if(!device.frozen) {
                unfrozen.push(device);
            }
        }
        return new DeviceGroup(unfrozen);
    };

    this.getOwnedByMe = function() {
        var ownedByMe = [];
        for (let device of this.devices) {
            if (device.ownedByMe) {
                ownedByMe.push(device);
            }
        }
        return new DeviceGroup(ownedByMe);
    };

    this.getSharedForMe = function() {
        var sharedForMe = [];
        for (let device of this.devices) {
            if (!device.ownedByMe) {
                sharedForMe.push(device);
            }
        }
        return new DeviceGroup(sharedForMe);
    };

    /**
    * filter by the custom condition:
    * Example:
    *   predicate as   lambda: (dev) => { return dev.status == 1; }
    *   predicate as function: function(dev) { return dev.status == 1; }
    */
    this.filter = function(predicate) {
        var _devices = [];
        for (let device of this.devices) {
            if (predicate(device)) {
                _devices.push(device);
            }
        }
        return new DeviceGroup(_devices);
    };
};


/**
* Class for management of the devices in devices table. 
*
* (Singleton)
*/
function DeviceProvider() {

    /**
    * Create Device object by JQuery $(<tr>...</tr>) result set.
    */
    this.deviceByRow = function(row) {
        var device = null;

        try {
            var id = row.attr('data-device-id');
            var name = row.attr('data-device-name');
            var status = row.attr('data-device-status');
            var frozen = row.attr('data-device-frozen');
            var statusCode = row.attr('data-device-status-code');
            var ownedByMe = row.attr('data-device-owner');

            if ( id !== undefined && name !== undefined &&
            status !== undefined && frozen !== undefined && 
            statusCode !== undefined && ownedByMe !== undefined)
            {
                device = new Device(
                    parseInt(id),
                    name,
                    Boolean(status === "online"),
                    Boolean(parseInt(frozen) == 1),
                    parseInt(statusCode),
                    Boolean(parseInt(ownedByMe, 10))
                );
            } else {
                throw new SyntaxError("deviceByElement: expected 'id', 'name', 'status', 'frozen' and 'owner' in dataset");
            }
        }catch(err) {
            console.log(err.message);
            return null;
        }
        return device;
    };

    /**
    * Create Device object by JavaScript <tr>...</tr> element.
    * (DEPRECATED)
    */
    this.deviceByElement = function(e) {
        var device = null;

        try {
            if ('deviceId' in e.dataset && 'deviceName' in e.dataset && 'deviceStatus' in e.dataset && 'deviceFrozen'in e.dataset && 'deviceOwner' in d.dataset) {
                device = new Device(
                    parseInt(e.dataset.deviceId),
                    e.dataset.deviceName,
                    Boolean(e.dataset.deviceStatus == "online"),
                    Boolean(parseInt(e.dataset.deviceFrozen) == 1),
                    parseInt(e.dataset.deviceStatusCode),
                    Boolean(parseInt(e.dataset.deviceOwner, 10))
                );
            } else {
                throw new SyntaxError("deviceByElement: expected 'id', 'name', 'status', 'frozen' and 'owner' in dataset");
            }
        }catch(err) {
            console.log(err.message);
            return null;
        }
        return device;
    };

    /**
    * Find row in devices table by deviceId and return
    * in the jQuery result set or null in not found.
    */
    this.getRow = function(deviceId) {
        var $row = null;
        var indexes = devicesTable.rows().indexes();
        for (var i=0; i < indexes.length; ++i) {
            var row = devicesTable.row(indexes[i]).nodes().to$();
            if ( row.attr('data-device-id') === deviceId.toString() ) {
                $row = row;
                break;
            }
        }
        return $row;
    };

    this.getDevice = function(deviceId) {
        var $row = this.getRow(deviceId);
        return this.deviceByRow($row);
    };

    this.getCheckedDevicesGroup = function() {
        // for found checked devices on all pages
        if (app.firstGroupAction) {
            for (var i=0; i<devicesTable.page.info().pages; ++i) {
                devicesTable.page(i).draw(false);
            }
            devicesTable.page(0).draw(false);
            app.firstGroupAction = false;
        }

        var devices = [];
        devicesTable.rows().eq(0).each( function( rowIdx ) {
            var $row = devicesTable.rows(rowIdx).nodes().to$();
            var deviceId = parseInt($row.attr('data-device-id'), 10);
            if ($row.find('div.icheckbox_minimal-blue.checked').length > 0 && (app.showDevicesIds == null || app.showDevicesIds.includes(deviceId))) {
                let device = DeviceProvider.instance().deviceByRow($row);
                if (device != null) {
                    devices.push(device);
                }
            }
        });
        return new DeviceGroup(devices);
    };

    this.uncheckAll = function() {
        devicesTable.rows().eq(0).each( function( rowIdx ) {
            devicesTable.rows(rowIdx).nodes().to$().find('input.check-single').iCheck('uncheck');
        });
        $('input.check-all').removeProp('checked').prop('checked', false).iCheck('update');
    };

    /**
    * deviceId(Int): device id.
    * value(Boolean): setting value.
    */
    this.setFrozen = function(deviceId, value) {
        var $row = this.getRow(deviceId);
        if (!$row) {
            console.log("DeviceProvider.setFrozen: Device ID=" + deviceId.toString() + " not found.");
            return;
        }
        $row.attr('data-device-frozen', value ? 1 : 0);

        var button = $row.find('a[data-device-action="' + (value ? 'freeze' : 'unfreeze') +  '"]');
        button.attr('data-device-action', value ? "unfreeze" : "freeze");
        button.attr('title', value ? gettext("Unfreeze device") : gettext("Freeze device"));
        button.removeClass(value ? "green" : "red");
        button.addClass(value ? "red" : "green");
    }

    /**
    * deviceId(Int): device id.
    * value(Int): status of Device.
    */
    this.setStatus = function(deviceId, value) {
        var deviceIdStr = deviceId.toString();
        var $row = this.getRow(deviceId);
        if (!$row) {
            console.log("DeviceProvider.setStatus: Device ID=" + deviceIdStr + " not found.");
            return;
        }
        var oldStatus = parseInt($row.attr('data-device-status-code'));

        // Small optimisations
        if (oldStatus == value) {
            // console.log("Skip setStatus(" + deviceIdStr + "," + value.toString() + ") same old status.");
            return;
        }

        // 1. remove
        DeviceProvider.instance().removeDevice(deviceId);

        // 2. change
        if (value != STATUS_REG) {
            $row.find('div[class="sm-td-overlay"]').remove();
            // enable checkbox
            $row.find('input[type="checkbox"]').prop('disabled', false);
            $row.find('td:first-child > div').removeClass('disabled');
        } else {
            // add overlay
            $row.find('td > div').each(function(index) {
                var $div = $("<div class='sm-td-overlay'></div>");
                if(index === 2) {
                    $div.append("<i class='fa fa-refresh fa-spin fa-3x fa-fw sm-td-overlay-spinner'></i>");
                }
                $(this).append($div);
            });
            // disable checkbox
            $row.find('input[type="checkbox"]').prop('disabled', true);
            $row.find('td:first-child > div').addClass('disabled');
        }

	    $row[0].dataset.deviceStatus = statusesLower[value];
	    $row[0].dataset.deviceStatusCode = value;

        // Change status
	    $row.find("td:nth-last-child(4) > div > div > span").html(gettext(statusesUpper[value]));
	    $row.find("td:nth-last-child(4) > div > div > span").css('color', colors[value]);

        // Change enable/disable actions buttons
        if (value == STATUS_ON) {
            $row.find("td:nth-last-child(2) > div > div > a.sm-btn-actions").removeClass('disabled');
        } else {
            $row.find('td:nth-last-child(4) > div > div > a.sm-btn-actions[data-device-action!="freeze"][data-device-action!="unfreeze"]').addClass('disabled');
        }

        // Change status in tr data attribute
        $row.find("td:nth-last-child(4)").attr("data-device-status", statusesLower[value]);

        // 3. add
        addRowToTable($row);

        if (oldStatus == STATUS_REG && oldStatus != value) {
            // remove device id from unregistered devices
            var ind = app.unregisteredDevices.indexOf(deviceId);
            if (ind != -1) {
                app.unregisteredDevices.splice(ind, 1);
            }
        }
    };

    this.setShared = function(deviceId, value) {
        var $row = this.getRow(deviceId);
        if (!$row) {
            console.log(`DeviceProvider.setShared: Device ID=${deviceId} not found.`);
            return;
        }
        $row.find('input.sm-device-name').css('color', value ? 'blue' : 'inherit');
    };

    this.removeDevice = function(deviceId) {
        var $row = this.getRow(deviceId);
        if (!$row) {
            console.log(`DeviceProvider.removeDevice: Device ID=${deviceId} not found.`);
            return;
        }
        devicesTable.row($row).remove().draw();
    };

    this.addDevice = function(deviceId, html) {
        // TODO: Implement it!
    };

    // value(Int): status for all Devices.
    this.setStatusAll = function(value) {
        devicesTable.rows().eq( 0 ).each( function (rowIdx) {
            try {
                var deviceId = parseInt(devicesTable.rows(rowIdx).nodes().to$().attr('data-device-id'));
                DeviceProvider.instance().setStatus(deviceId, value);
            } catch(err) {
                console.log(err.message);
            }
        });
    };

    this.getIds = function() {
        ids = [];
        devicesTable.rows().eq( 0 ).each( function (rowIdx) {
            var deviceId = parseInt(devicesTable.rows(rowIdx).nodes().to$().attr('data-device-id'));
            ids.push(deviceId);
        });
        return ids;
    };
};

/**
* DeviceProvider.instance.
*
* Singleton object for device provider.
*/
DeviceProvider.instance = function() {
    if (typeof(DeviceProvider.inst) == "undefined") {
        DeviceProvider.inst = new DeviceProvider();
    }
    return DeviceProvider.inst;
}