
function addDeviceOnClickDashboard(event) {
    addDeviceOnClick(event, successAddDeviceOnDashboard);
};

function successAddDeviceOnDashboard(response) {
    $("#modal-success").modal();
    $("#sm-devices-count-online").text(response['devices_count_online']);
    $("#sm-devices-count").text(response['devices_count']);
};