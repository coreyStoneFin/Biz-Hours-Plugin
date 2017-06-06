/**
 * Created by jwesely on 11/24/2015.
 */

(function ($) {
    //debugger;
    var src = "https://taxcloud.net/SalesTaxPolicy/?m=D8TIItfHsaE=";
    var iframe = $('<iframe src="https://taxcloud.net/SalesTaxPolicy/?m=D8TIItfHsaE=" frameborder="0" marginwidth="0" marginheight="0" allowfullscreen></iframe>');
    var dialog = $("<div></div>").append(iframe).appendTo("body").dialog({
        autoOpen: false,
        modal: true,
        resizable: false,
        width: '250px',
        height: 'auto',
        close: function () {

        }
    });
    $.fn.exists = function () {
        return this.length !== 0;
    }
    //debugger;
    $('#wootax_sales_policy_link').on('click', function () {
        $(dialog).dialog('open');
    });
    $(document).ajaxComplete(function (event, xhr, settings) {
        //debugger;
        if (!$('#wootax_sales_policy_link').exists()) {
            $('.tax-rate > th').append('<a id="wootax_sales_policy_link" href="#z" style="text-transform: lowercase;">policy</a>');
        }
        $('#wootax_sales_policy_link').on('click', function () {
            $(dialog).dialog('open');
        });

    });

    jQuery('body')
        .bind(
        'click',
        function (e) {
            if (
                jQuery(dialog).dialog('isOpen')
                && !jQuery(e.target).is('.ui-dialog, a')
                && !jQuery(e.target).closest('.ui-dialog').length
            ) {
                jQuery(dialog).dialog('close');
            }
        }
    );


    jQuery('.shipping_address').before('<div id="compiled_billing"><legend>Shipping Address</legend><p><span name= "cb_name" id="cb_name" class="address-300"></span></p><p><span name="cb_company_name" id="cb_company_name" class="address-300"></span></p><p><span name="cb_address1" id="cb_address1" class="address-300"></span><span name="cb_address2" id="cb_address2" class="address-300"></span><span class="address-300"><span id="cb_city"></span>, <span id="cb_state"></span><span id="cb_zip"></span></span></p><p><span name="cb_email" id="cb_email" class="address-300"></span></p><p><span name="cb_phone" id="cb_phone" class="address-300"></span></p></div>');
    if (jQuery('[name="ship_to_different_address"]').prop('checked')) {
        jQuery('#compiled_billing').hide();
    }
    jQuery('[name="ship_to_different_address"]').on('click', function () {
        if (jQuery('[name="ship_to_different_address"]').prop('checked')) {
            jQuery('#compiled_billing').hide();
        }else{
            jQuery('#compiled_billing').show();
        }
    });

    var pop_combiled_billing = function () {
        jQuery('#compiled_billing #cb_name').text(jQuery('#billing_first_name').val() + " " + jQuery('#billing_last_name').val());
        jQuery('#compiled_billing #cb_company_name').text(jQuery('#billing_company').val());
        jQuery('#compiled_billing #cb_address1').text(jQuery('#billing_address_1').val());
        jQuery('#compiled_billing #cb_address2').text(jQuery('#billing_address_2').val());
        jQuery('#compiled_billing #cb_city').text(jQuery('#billing_city').val());
        jQuery('#compiled_billing #cb_state').text(jQuery('#billing_state').val());
        jQuery('#compiled_billing #cb_zip').text(jQuery('#billing_postcode').val());
        jQuery('#compiled_billing #cb_email').text(jQuery('#billing_email').val());
        jQuery('#compiled_billing #cb_phone').text(jQuery('#billing_phone').val());

    };
    pop_combiled_billing();
    jQuery('.woocommerce-billing-fields').find('input').on('input',pop_combiled_billing );
})(jQuery);