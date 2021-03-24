function sendAjaxRequest(url, data, done, always, fail, reqType, timeout) {
    var _done = function() {};
    var _always = function() {};
    var _fail = function(jqXHR,status,err){
        alert('Error (' + status + '): ' + err + '\n' + jqXHR.responseText);
    }
    var _reqType ='POST'
    var _timeout = 60000;

    if (typeof done !== 'undefined') _done = done;
    if (typeof always !== 'undefined') _always = always;
    if (typeof fail !== 'undefined') _fail = fail;
    if (typeof reqType !== 'undefined') _reqType = reqType;
    if (typeof timeout !== 'undefined') _timeout = timeout;
    //var csrf = $('input[name=csrfmiddlewaretoken]').val();
    var csrftoken = $.cookie('csrftoken');
    $.ajax({
        url: url,
        headers:{ 'X-CSRFToken': csrftoken },
        data: data,
        cache: false,
        type: _reqType,
        //dataType: "json",
        timeout: _timeout
    }).done(_done).always(_always).fail(_fail);
};

/**
* failActionRequest
*
* Default handler for ajax fail result.
*/
var failActionRequest = function(jqXHR,status,err) {
    hideWait();
    if (jqXHR.status == HTTP_RESPONSE_TOO_MANY_REQUESTS) {
        showWarning("(" + jqXHR.status + ") Too Many Requests", jqXHR.responseText);
    } else {
        showError("(" + jqXHR.status + ") " + jqXHR.statusText, jqXHR.responseText);
    }
};