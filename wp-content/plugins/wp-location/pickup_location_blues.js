/**
 * Created by jwesely on 3/22/2016.
 */


    jQuery(document).ready(function(){
        jQuery('p.store-pickup > #store_pickup > option[value=""]').prop('disabled',true).prop('selected', true).prop('hidden', true);
        jQuery('p.store-pickup > #store_pickup > option[value="1"]').prop('hidden',true);
        var location_tabs = function(){

            if (jQuery(this).length) {
                if (jQuery(this).attr("id") == 'local_pickup') {
                    jQuery('p.store-pickup').show();
                    jQuery('p.store-pickup > #store_pickup').val("");
                }
                else{
                    jQuery('p.store-pickup').hide();
                    jQuery('p.store-pickup > #store_pickup').val(1);
                }
            }
        }

        jQuery('ul#checkout_method_field > li').on('click',location_tabs);
    });

