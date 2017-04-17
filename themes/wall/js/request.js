var actionReq = {
    url: null,
    setUrl: function (url) {
        actionReq.url = url;
    },
    getUrl: function () {
        return actionReq.url;
    },
    urlajax: null,
    setUrlAjax: function (urlajax) {
        actionReq.urlajax = urlajax;
    },
    getUrlAjax: function () {
        return actionReq.urlajax;
    },
    getUrlHome: function() {
        return document.location.origin;
    }
};

var req = {
    request: function (params) {
        var promise = $.ajax({
            url: params.url,
            type: 'POST',
            dataType: 'json',
            data: params.data,
            cache: false,
            async: false,
            beforeSend: function () {
                ui.doBlockUI(params);
            }
        });
        return promise;
    },
    //for submit file by ajax
    requestData: function (params) {
        var promise = $.ajax({
            url: params.url,
            type: 'POST',
            dataType: 'json',
            data: params.data,
            cache: false,
            processData: false, // Don't process the files
            contentType: false, // Set content type to false as jQuery will tell the server its a query string request
            beforeSend: function () {
                ui.doBlockUI(params);
            }
        });
        return promise;
    }
};

// haidt - ui block
var ui = {
    doBlockUI: function (params) {
        if (params.blockUI) {
            $.blockUI({message: null});
        }
    },
    doUnBlockUI: function (params) {
        if (params.blockUI) {
            $.unblockUI();
        }
    }
};
