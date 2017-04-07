var invoice = {
    isNewCustomer: false,
    tax21: false,
    invoiceRaw: false,
    isApp: false,
    taxOther: false,
    onClickStep1: function () {
        var name;
        var typeVat;
        if (invoice.isNewCustomer) {
            name = $('#Customer_name').val();
            typeVat = $('input[type="radio"][name="Customer[type_tax]"]:checked').val();

            //set Invoice[type_tax]
            if (typeVat == 1) {
                $('#Invoices_type_tax_0').prop('checked', true);
            } else {
                $('#Invoices_type_tax_21').prop('checked', true);
            }

        } else {
            name = $('#Invoices_customer_id :selected').text();
            typeVat = $('input[type="radio"][name="Invoices[type_tax]"]:checked').val();
        }

        $('#Invoices_company_name').val(name);

        if (typeVat == 1) {
            $('#type-tax').html('0%');
        } else {
            $('#type-tax').html('21%');
        }

    },

    onChangeCustomer: function(_this) {
        var tax = _this.find('option:selected').attr('data-tax');

        if (tax == 1) {
            $('#Invoices_type_tax_0').prop('checked', true);
        } else {
            $('#Invoices_type_tax_21').prop('checked', true);
        }

        invoice.checkStep1();
    },

    changeCompanyName: function(_this) {
        var name = _this.val();
        if (name.length >= 5) {
            invoice.checkNameCustomer(name);
        } else {
            $('#err_Customer_name').html("Company Name is too short (minimum is 5 characters).");
        }
        invoice.checkStep1();
    },

    changeCustomerEmail: function(_this) {
        var checkExist = false;
        var email = _this.val();
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        var checkEmail = regex.test(email);
        if (checkEmail == false) {
            $('#err_Customer_email').html('Email wrong format!');
            return false;
        } else {
            $('#err_Customer_email').html('');
            checkExist = invoice.checkExistEmail(email);
        }

        invoice.checkStep1();
    },

    enabledStep1: function() {
        $('#step-1').prop('disabled', false);
    },

    disabledStep1: function() {
        $('#step-1').prop('disabled', true);
    },

    checkStep1: function() {
        if (invoice.isNewCustomer) {
            var name = $('#Customer_name').val();
            var errName = $('#err_Customer_name').text().length;
            var radioVAT = $('input[type="radio"][name="Customer[type_tax]"]:checked').val();
            var vat = $('#Customer_VAT').val();
            
            var email = $('#Customer_email').val();
            var errEmail = $('#err_Customer_email').text().length;

            var country = $('#Customer_country').val();
            var errCountry = $('#err_Customer_country').text().length;

            if (name == '' || errName > 0 
                || email =='' || errEmail > 0 
                || (radioVAT == 1 && vat == '')
                || country =='' || errCountry > 0 
                ) {
                invoice.disabledStep1();
            } else {
                invoice.enabledStep1();
            }

        } else {
            var selectCustomer = $('#Invoices_customer_id').val();
            if (selectCustomer == '') {
                invoice.disabledStep1();
            } else {
                console.log('enabledStep1');
                invoice.enabledStep1();
            }

        }
    },

    checkExistEmail: function(email) {
        var action = 'checkCustomerEmail';

        var params = {};
        params.url = actionReq.getUrl();
        params.data = {
            action: action,
            email: email
        };
        var ajax = req.request(params);
        ajax.done(function(response){
            if (response.status) {
                if (response.error) {
                    $('#err_Customer_email').html(response.msg);
                } else {
                    $('#err_Customer_email').html("");
                    invoice.checkStep1();
                }
            }
        });

    },

    checkNameCustomer: function(company_name) {
        var action = 'checkCompanyName';

        var params = {};
        params.url = actionReq.getUrl();
        params.data = {
            action: action,
            company_name: company_name
        };
        var ajax = req.request(params);
        ajax.done(function(response){
            if (response.status) {
                if (response.error) {
                    $('#err_Customer_name').html(response.msg);
                } else {
                    $('#err_Customer_name').html("");
                }

                invoice.checkStep1();
            }
        });

    },

    deleteRow: function(_this) {
        _this.parents('tr').remove();
        invoice.reloadSomething();
    },

    updateTotal: function() {
        //for raw invoice
        if (invoice.invoiceRaw) {

            //load total each row
            var total = 0.00;
            $('tr.item').each(function() {
                var price = $(this).find('.item-price').val();
                var qty = $(this).find('.item-qty').val();
                if (price == '') {
                    price = 0;
                }
                if (qty == '') {
                    qty = 0;
                }

                var amount = (parseInt(qty) * parseFloat(price)).toFixed(2);
                $(this).find('.item-amount').val(amount);
                total+= parseFloat(amount);
            });
            var subtotal = total;

            $('#RawInvoices_subtotal').val(total.toFixed(2));
            if ($('#RawInvoices_shipping').val() != '') {
                var shipping = parseFloat($('#RawInvoices_shipping').val());
                if (isNaN(shipping)) {
                    shipping = 0.00;
                    $('#RawInvoices_shipping').val(shipping);
                }
                total+= shipping;
            }

            // var typeVat = $('#RawInvoices_type_tax').val();
            var typeVat = $('input[type="radio"][name="RawInvoices[type_tax]"]:checked').val()
            if (typeVat == 2) {
                var vat = subtotal*(21/100);
                $('#RawInvoices_vat').val(vat.toFixed(2));
                total = total - vat;
            } else {
                $('#RawInvoices_vat').val('0.00');
            }

            $('#RawInvoices_total').val(total.toFixed(2));
        } else {

            //load total each row
            var total = 0.00;
            $('tr.item').each(function() {
                var price = $(this).find('.item-price').val();
                var qty = $(this).find('.item-qty').val();
                if (price == '') {
                    price = 0;
                }
                if (qty == '') {
                    qty = 0;
                }

                var amount = (parseInt(qty) * parseFloat(price)).toFixed(2);
                $(this).find('.item-amount').val(amount);
                total+= parseFloat(amount);
            });
            var subtotal = total;

            $('#Invoices_subtotal').val(total.toFixed(2));
            if ($('#Invoices_shipping').val() != '') {
                var shipping = parseFloat($('#Invoices_shipping').val());
                if (isNaN(shipping)) {
                    shipping = 0.00;
                    $('#Invoices_shipping').val(shipping);
                }
                total+= shipping;
            }

            if (invoice.taxOther) { //typeVat == 3
                var vat = parseFloat($('#Invoices_tax_amount_extend').val());
                if (isNaN(vat)) {
                    vat = 0.00;
                    $('#Invoices_tax_amount_extend').val(vat);
                }
                total+= vat;
            } else {
                var typeVat = $('input[type="radio"][name="Invoices[type_tax]"]:checked').val()
                if (typeVat == 2) {
                    var vat = subtotal*(21/100);
                    $('#Invoices_vat').val(vat.toFixed(2));
                    total+= vat;
                } else {
                    $('#Invoices_vat').val('0.00');
                }
            }

            if (invoice.isApp) {
                var prepaid = parseFloat($('#Invoices_prepaid_money').val());
                if (isNaN(prepaid)) {
                    prepaid = 0.00;
                    $('#Invoices_prepaid_money').val(prepaid);
                }
                total = total - prepaid;
            }

            $('#Invoices_total').val(total.toFixed(2));
        }
        invoice.checkEmpty();
    },

    addRow: function(){
        if (invoice.invoiceRaw) {
            var action = 'onClickAddRowRaw';
        } else {
            var action = 'onClickAddRow';
        }

        var params = {};
        params.url = actionReq.getUrl();
        params.data = {
            action: action,
        };
        var ajax = req.request(params);
        ajax.done(function(response){
            if (response.status) {
                $('tr.item:last').after(response.html);
            }
        });

        invoice.reloadSomething();
    },

    reloadSomething: function() {
        invoice.canDelete();
        invoice.checkEmpty();
        invoice.updateTotal();
    },

    canDelete: function() {
        if ($(".delete").length > 0) {
            $(".delete").show();
        }

        if ($('tr.item').length == 1) {
            $(".delete").hide();
        }
    },

    checkEmpty: function(){
      var productcode = 1;
      $('.item-productcode').each(function(){
        var val_productcode = $(this).val();
        if (val_productcode == '') {
            productcode = 0;
            $(this).parent('li').find('.err_productcode').html("Product ID can't blank.");
        }
      });

      var description = 1;
      $('.item-description').each(function(){
        var val_description = $(this).val();
        if (val_description == '') {
            description = 0;
            $(this).parent('li').find('.err_description').html("Description can't blank.");
        }
      });

      var price = 1;
      $('.item-price').each(function(){
        var val_price = $(this).val();
        if (val_price == '') {
            price = 0;
            $(this).parent('li').find('.err_price').html("Price can't blank.");
        }
      });

      var qty = 1;
      $('.item-qty').each(function(){
        var val_qty = $(this).val();
        if (val_qty == '') {
            qty = 0;
            $(this).parent('li').find('.err_quantity').html("Quantity can't blank.");
        }
      });
      if (qty == 0 || price == 0 || description == 0 || productcode == 0) {
        $('#step-2').attr('disabled', 'disabled');
      } else {
        $('#step-2').removeAttr('disabled', 'disabled');
      }

    },

    createPreviewPDF: function() {
        $.ajax({
            method: 'POST',
            url: actionReq.getUrlAjax() + '/PDFInvoice',
            data: $('#invoice-form').serialize(),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .success(function (response) {
            $('#pdf-file').attr('src', response);
            $('#download_bon').attr('href', response);
        });
    },

    createPreviewPDFRaw: function() {
        $.ajax({
            method: 'POST',
            url: actionReq.getUrlAjax() + '/PDFInvoiceRaw',
            data: $('#invoice-form').serialize(),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .success(function (response) {
            $('#pdf-file').attr('src', response);
            $('#download_bon').attr('href', response);
        });
    },

    onChangeCustomerForRaw: function(_this) {
        var name = $('#RawInvoices_customer_id :selected').text();
        $('#RawInvoices_company_name').val(name);

        var tax = $('#RawInvoices_customer_id option:selected').attr('data-tax');

        if (tax == 1) {
            $('#RawInvoices_type_tax_0').prop('checked', true);
        } else {
            $('#RawInvoices_type_tax_21').prop('checked', true);
        }
    },
};