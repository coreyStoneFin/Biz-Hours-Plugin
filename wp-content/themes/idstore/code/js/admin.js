jQuery(document).ready(function(){
	/* Promo banner in admin panel */
	
	jQuery('.promo-text-wrapper .close-btn').click(function(){
		
		var confirmIt = confirm('Are you sure?');
		
		if(!confirmIt) return;
		
		var widgetBlock = jQuery(this).parent();
	
		var data =  {
			'action':'et_close_promo',
			'close': widgetBlock.attr('data-etag')
		};
		
		widgetBlock.hide();
		
		jQuery.ajax({
			url: ajaxurl,
			data: data,
			success: function(response){
				widgetBlock.remove();
			},
			error: function(data) {
				alert('Error while deleting');
				widgetBlock.show();
			}
		});
	});
	
	/* UNLIMITED SIDEBARS */
	
	var delSidebar = '<div class="delete-sidebar">delelte</div>';
	
	jQuery('.sidebar-etheme_custom_sidebar').find('.sidebar-name-arrow').before(delSidebar);
	
	jQuery('.delete-sidebar').click(function(){
		
		var confirmIt = confirm('Are you sure?');
		
		if(!confirmIt) return;
		
		var widgetBlock = jQuery(this).parent().parent();
	
		var data =  {
			'action':'etheme_delete_sidebar',
			'etheme_sidebar_name': jQuery(this).parent().find('h3').text()
		};
		
		widgetBlock.hide();
		
		jQuery.ajax({
			url: ajaxurl,
			data: data,
			success: function(response){
				console.log(response);
				widgetBlock.remove();
			},
			error: function(data) {
				alert('Error while deleting sidebar');
				widgetBlock.show();
			}
		});
	});
	
	
	/* end sidebars */
    
    var theme_settings = jQuery('#prima-theme-settings');
    // Only show the background color input when the background color option type is Color (Hex)
    jQuery('.background-option-types').each(function() {
        showHideHexColor(jQuery(this));
        jQuery(this).change( function() {
            showHideHexColor( jQuery(this) ) 
        });
    });
    // Add color picker to color input boxes.
    jQuery('input.color-picker').each(function (i) {
        jQuery(this).after('<div id="picker-' + i + '" style="z-index: 100; background: #EEE; border: 1px solid #CCC; position: absolute; display: block;"></div>');
        jQuery('#picker-' + i).hide().farbtastic(jQuery(this));
    })
    .focus(function() {
        jQuery(this).next().show();
        if (jQuery(this).val() == '') {
            jQuery(this).val('#');
        }
    })
    .blur(function() {
        jQuery(this).next().hide();
        if (jQuery(this).val() == '#') {
            jQuery(this).val('');
        }
    });
    // Show or hide the hex color input.
    function showHideHexColor(selectElement) {
        // Use of hide() and show() look bad, as it makes it display:block before display:none / inline.
        selectElement.next().css('display','none');
        if (selectElement.val() == 'hex') {
            selectElement.next().css('display', 'inline');
        }
    }
    var sidebarCkeck = jQuery('#product_page_sidebar');
    var defaultSidebar = sidebarCkeck.is(':checked');
    var labelText = sidebarCkeck.next().text();
    
    function checkState(element,defaultSidebar){
        changedVal = element.val();
        
        if(changedVal == 3){                
            sidebarCkeck.css('opacity',0.5).attr('checked',true).removeAttr("disabled");
            sidebarCkeck.next().text('Sidebar is always enabled for 3 products');
        }else if(changedVal == 6){
            sidebarCkeck.attr('checked',false).attr("disabled", true);
            sidebarCkeck.next().text('Sidebar is disabled for 6 products');
        }else{
            sidebarCkeck.css('opacity',1).attr('checked',defaultSidebar).removeAttr("disabled");
            sidebarCkeck.next().text(labelText);
        }
    }
    jQuery('#prodcuts_per_row').change(function(){
        checkState(jQuery(this),defaultSidebar);        
    });
    
    checkState(jQuery('#prodcuts_per_row'),defaultSidebar);
    
    jQuery('.importBtn').toggle(function(){
	    jQuery(this).next().show();
    },function(){
	    jQuery(this).next().hide();
    });
    
    jQuery('.use-global').click(function() {
	    var related = jQuery(this).data('related');
	    var value   = jQuery(this).attr('checked');
	    var selector = '.' + related;
	    
	    
	    if(value == 'checked') {
		    jQuery(selector).addClass('option-disabled');
	    }else{
		    jQuery(selector).removeClass('option-disabled');
	    }
    });
    
    var importBtn = jQuery('#install_demo_pages');
    
	importBtn.click(function(e){
		e.preventDefault();
		
		importBtn.before('<div id="floatingCirclesG" class="loading"><div class="f_circleG" id="frotateG_01"></div><div class="f_circleG" id="frotateG_02"></div><div class="f_circleG" id="frotateG_03"></div><div class="f_circleG" id="frotateG_04"></div><div class="f_circleG" id="frotateG_05"></div><div class="f_circleG" id="frotateG_06"></div><div class="f_circleG" id="frotateG_07"></div><div class="f_circleG" id="frotateG_08"></div></div>');
		
		jQuery.ajax({
			type: "POST",
			url: ajaxurl,
			data: {
				'action':'etheme_import_ajax'
			},
			success: function(data){
				
				jQuery('#option-tree-sub-header').before('<div id="setting-error-settings_updated" class="updated settings-error">' + data + '</div>');
			},
			complete: function(){
				jQuery('#floatingCirclesG').remove();
			}
		});
	
	});

	//added by StoneFIn
    jQuery('td[data-sort-value="Custom Meals"]').parent().each(function(index){
        var totalCost = 0;
        var totalTotal =0;
        var totalSalesTax=0;
        jQuery(this).nextAll().slice(0,3).each(function(index){
            totalTotal += parseFloat(jQuery(this).find("td.line_cost").text().replace('$', '').trim());
            totalCost += parseFloat(jQuery(this).find("td.item_cost").text().replace('$', '').trim());
            totalSalesTax += parseFloat(jQuery(this).find("td.line_tax").text().replace('$', '').trim());
        });
        jQuery(this).find('td.line_cost').text('$'+totalTotal.toFixed(2));
        jQuery(this).find('td.item_cost').text('$'+totalCost.toFixed(2));
        jQuery(this).find('td.line_tax').text('$'+totalSalesTax.toFixed(2));

    });
		jQuery('#woocommerce-order-items tr.composited_item td.line_cost div').remove();
		jQuery('#woocommerce-order-items tr.composited_item td.line_tax div').remove();
		jQuery('#woocommerce-order-items tr.composited_item td.quantity div').remove();
		jQuery('#woocommerce-order-items tr.composited_item td.thumb a').remove();
});


/**
 * Upload Option
 * Allows window.send_to_editor to function properly using a private post_id
 * Dependencies: jQuery, Media Upload, Thickbox
 * Credits: OptionTree
 */
(function ($) {
  uploadOption = {
    init: function () {
      var formfield,
          formID,
          btnContent = true;
      // On Click
      $('.upload_button').live("click", function () {
        formfield = $(this).prev('input').attr('id');
        formID = $(this).attr('rel');
        // Display a custom title for each Thickbox popup.
        var prima_title = '';
        prima_title = $(this).prev().prev('.upload_title').text();
        tb_show( prima_title, 'media-upload.php?post_id='+formID+'&type=image&amp;TB_iframe=1');
        return false;
      });
            
      window.original_send_to_editor = window.send_to_editor;
      window.send_to_editor = function(html) {
        if (formfield) {
          if ( $(html).html(html).find('img').length > 0 ) {
          	itemurl = $(html).html(html).find('img').attr('src');
          } 
		  else {
          	var htmlBits = html.split("'");
          	itemurl = htmlBits[1];
          	var itemtitle = htmlBits[2];
          	itemtitle = itemtitle.replace( '>', '' );
          	itemtitle = itemtitle.replace( '</a>', '' );
          }
          var image = /(^.*\.jpg|jpeg|png|gif|ico*)/gi;
          var document = /(^.*\.pdf|doc|docx|ppt|pptx|odt*)/gi;
          var audio = /(^.*\.mp3|m4a|ogg|wav*)/gi;
          var video = /(^.*\.mp4|m4v|mov|wmv|avi|mpg|ogv|3gp|3g2*)/gi;
          if (itemurl.match(image)) {
            btnContent = '<img src="'+itemurl+'" alt="" /><a href="#" class="remove etheme">Remove Image</a>';
          } else {
            btnContent = '<div class="no_image">'+html+'<a href="#" class="remove etheme">Remove</a></div>';
          }
          $('#' + formfield).val(itemurl);
          $('#' + formfield).next().next('div').slideDown().html(btnContent);
          tb_remove();
        } else {
          window.original_send_to_editor(html);
        }
      }
    }
  };
  $(document).ready(function () {
	  uploadOption.init();
      // Remove Uploaded Image
      $('.remove').live('click', function(event) { 
        $(this).hide();
        $(this).parents().prev().prev('.upload').attr('value', '');
        $(this).parents('.screenshot').slideUp();
      });
  })
})(jQuery);