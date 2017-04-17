function loadDataTable() {
    $('.tb-break').DataTable( {
        responsive: true,
        paging: false,
        searching: false,
        "order": [],
        "info": false,
        columnDefs: [
          { "targets": 'no-sort', "orderable": false }
        ]
    });
}

$(document).ready(function() {
    loadDataTable();
});

//Validate form
var formValidator = {
    run: function (_this, event) {
        var inst = this;
        var hasError = false;        
        var noError = true;
        hasError = inst.required(_this);

        if (hasError) {
            noError = false;
            event.preventDefault();
        }

        hasError = inst.email(_this);

        if (hasError) {
            noError = false;
            event.preventDefault();
        }

        hasError = inst.length(_this);

        if (hasError) {
            noError = false;
            event.preventDefault();
        }

        hasError = inst.url(_this);

        if (hasError) {
            noError = false;
            event.preventDefault();
        }

        return noError;
    },

    required: function (_this) {
        
        var required = _this.find("[data-vrequired='required']");
        var error = false;
        var msg = 'This field can not be blank.';


        required.each(function (i, item) {
            var el = $(item);
            var vparent = el.attr('data-vparent');
            var value = el.val();
            var cMsg = el.attr('data-vmsg');
            var noneValidate = $('#' + vparent).hasClass('hidden');
            if (noneValidate) {
                //field hidden not validate
            } else {
                if (value.trim().length <= 0) {
                    if (cMsg !== undefined) {
                        if (cMsg.length > 0) {
                            $('#' + vparent).find('.errorMessage').text(cMsg).show();
                        } else {
                            $('#' + vparent).find('.errorMessage').text(msg).show();
                        }
                    } else {
                        $('#' + vparent).find('.errorMessage').text(msg).show();
                    }

                    error = true;

                } else {
                    $('#' + vparent).find('.errorMessage').text('').hide();
                }
            }
        });
        return error;

    },

    email: function (_this) {
        var vemail = _this.find("[data-vemail='required']");
        var error = false;
        var msg = 'Please enter a valid email address.';

        vemail.each(function (i, item) {
            var el = $(item);
            var vparent = el.attr("data-vparent");
            var value = el.val();
            var cMsg = el.attr("data-vmsg");
            var re = /[A-Z0-9._%+-]+@[A-Z0-9.-]+.[A-Z]{2,4}/igm;

            if ($('#' + vparent).hasClass('hidden')) {

            } else {

                if (value.trim().length > 0) {
                    if (!re.test(value)) {
                        if (cMsg !== undefined) {
                            if (cMsg.length > 0) {
                                $('#' + vparent).find('.errorMessage').text(cMsg).show();
                            } else {
                                $('#' + vparent).find('.errorMessage').text(msg).show();
                            }
                        } else {
                            $('#' + vparent).find('.errorMessage').text(msg).show();
                        }

                        error = true;
                    } else {

                        $('#' + vparent).find('.errorMessage').text('').hide();
                    }
                }

            }

        });
        return error;
    },

    url: function (_this) {
        var vurl = _this.find("[data-vurl='required']");
        var error = false;
        var msg = 'Please enter a valid url.';

        vurl.each(function (i, item) {
            var el = $(item);
            var vparent = el.attr("data-vparent");
            var value = el.val();
            var cMsg = el.attr("data-vmsg");
            var re = /^(https?|s?ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i;

            if ($('#' + vparent).hasClass('hidden')) {

            } else {

                if (value.length > 0) {
                    if (!re.test(value)) {
                        if (cMsg !== undefined) {
                            if (cMsg.length > 0) {
                                $('#' + vparent).find('.errorMessage').text(cMsg).show();
                            } else {
                                $('#' + vparent).find('.errorMessage').text(msg).show();
                            }
                        } else {
                            $('#' + vparent).find('.errorMessage').text(msg).show();
                        }

                        error = true;
                    } else {
                        $('#' + vparent).find('.errorMessage').text('').hide();
                    }
                }

            }
        });
        return error;
    },

    length: function (_this) {
        var els = _this.find("[data-vlength='required']");
        var error = false;
        var msg = 'Only 8 digits are allowed.';
        els.each(function (i, item) {
            var el = $(item);
            var vparent = el.attr("data-vparent");
            var length = el.attr("data-length");
            var cMsg = el.attr("data-vmsg");
            var value = el.val();

            if ($('#' + vparent).hasClass('hidden')) {

            } else {

                if (length !== undefined) {
                    if (parseInt(length) !== parseInt(value.length)) {
                        if (cMsg !== undefined) {
                            if (cMsg.length > 0) {
                                $('#' + vparent).find('.errorMessage').text(cMsg).show();
                            } else {
                                $('#' + vparent).find('.errorMessage').text(msg).show();
                            }
                        } else {
                            $('#' + vparent).find('.errorMessage').text(msg).show();
                        }

                        error = true;
                    } else {
                        $('#' + vparent).find('.errorMessage').text('').hide();
                    }
                }

            }
        });
        return error;
    },

};


function validateNumber() {
    var ctrlDown = false;
    var ctrlKey = 17, vKey = 86, cKey = 67, xKey = 88;
    $("body").on('keydown', '.numeric-control', function (e) {
        var key = e.which;
        if (key == ctrlKey) {
            ctrlDown = true;
        }

        // backspace, add, tab, left arrow, up arrow, right arrow, down arrow, delete, numpad decimal pt, period, enter
        if (key != 8 && key != 16 && key != 9 && key != 37 && key != 38 && key != 39 
            && key != 40 && key != 46 && key != 110 && key != 13 && key != 96 && key != 97 
            && key != 98 && key != 99 && key != 100 && key != 101 && key != 102 && key != 103 && key != 104 && key != 105 && key != 190)
        {
            if (e.shiftKey) {
                if (key == 61)
                    return key.returnValue;
                else
                    e.preventDefault();
            } else {
                if (key < 48 || key > 57) {
                    if (ctrlDown == false) {
                        e.preventDefault();
                    }                    
                }
            }
        } else if (e.shiftKey) {
            if (key == 190) {
                e.preventDefault();
            }
        }

    }).keyup(function (e)
    {
        if (e.which == ctrlKey) {
            ctrlDown = false;
        }

    });

    $("body").on('keydown', '.integer-control', function (e) {
        var key = e.which;
        if (key == ctrlKey) {
            ctrlDown = true;
        }

        // backspace, add, tab, left arrow, up arrow, right arrow, down arrow, delete, numpad decimal pt, period, enter
        if (key != 8 && key != 16 && key != 9 && key != 37 && key != 38 && key != 39 
            && key != 40 && key != 46 && key != 110 && key != 13 && key != 96 && key != 97 
            && key != 98 && key != 99 && key != 100 && key != 101 && key != 102 && key != 103 && key != 104 && key != 105)
        {
            if (e.shiftKey) {
                if (key == 61)
                    return key.returnValue;
                else
                    e.preventDefault();
            } else {
                if (key < 48 || key > 57) {
                    if (ctrlDown == false) {
                        e.preventDefault();
                    }                    
                }
            }
        }

    }).keyup(function (e)
    {
        if (e.which == ctrlKey) {
            ctrlDown = false;
        }

    });

}

$('.datepicker').datetimepicker({
    format: 'YYYY/MM/DD',
    locale: 'en'
});

$("#status-switch").bootstrapSwitch({
    'onText': 'Active',
    'offText': 'Inactive'
});