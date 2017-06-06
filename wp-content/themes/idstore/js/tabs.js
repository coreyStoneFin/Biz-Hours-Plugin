jQuery(document).ready(function(){
    var tabs = jQuery('.tabs');
    
    tabs.find('.tab-title').click(function(e){
        if(jQuery(this).hasClass('opened')){
            jQuery(this).removeClass('opened').next().slideUp(200);
            tabs.addClass('closed');
        }else{
            jQuery(this).parent().find('.tab-title').each(function(){
                jQuery(this).removeClass('opened').next().hide();
            });
            jQuery(this).addClass('opened').next().slideDown(200);
        }
    });
    
});