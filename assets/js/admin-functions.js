jQuery(document).ready(function($) {
		
	jQuery("#email").on( "change", function() {
		$.post( "/api/ajax", { email: $(this).val(), action: "account_checkemail" })
	        .done(function( data ) {
	        console.log(data);
	    });
    });
    jQuery("#user").on( "change", function() {
		$.post( "/api/ajax", { user: $(this).val(), action: "account_checkusername" })
	        .done(function( data ) {
	        console.log( data );
	    });
    });
    
    
    /* $("#user-info").validate(); */
    /* 
    
    $('#contact-form').validate({
    rules: {
      login: {
        required: true,
        remote: {
            url: "user_availability.php",
            type: "post",
            data:
                  {
                      login: function()
                      {
                          return $('#contact-form :input[name="login"]').val();
                      }
                  }
        }           
      }       
    },
     messages:{
         login:{
         required: "Please enter your login.",
         remote: jQuery.validator.format("{0} is already taken.")
         }            
    } */
    
	
	jQuery(".notice-dismiss").live( "click", function() {
		jQuery(".notice.is-dismissible").slideUp(150);
    });
});

(function($){
	
	 $.fn.extend({
        api_ajax: function(target_div,success_msg){
			$.post( "/api/ajax", this.serialize())
				.done(function( data ) {
					var msg_ret = '<div id="message" class="updated notice is-dismissible">';
						msg_ret += '<p>'+success_msg+'</p>';
						msg_ret += '<button class="notice-dismiss" type="button"><span class="screen-reader-text">Dismiss this notice.</span></button>';
						msg_ret += '</div>';
						$('html, body').animate({
							scrollTop: $(target_div).offset().top - 100
						}, 1000);
						
					$(target_div).fadeOut().html(msg_ret).fadeIn();
					return data;
			});
        }
    });
    
    
    
   /*  $.fn.api_ajax = function(datafields) {
        $.post( "/api/ajax", { email: $(this).val(), action: "account_checkemail" })
	        .done(function( data ) {
	        console.log(data);
	    });
	    
	            // This is the easiest way to have default options.
        var settings = $.extend({
            // These are the defaults.
            color: "#556b2f",
            backgroundColor: "white"
        }, options );
 
        // Greenify the collection based on the settings variable.
        return this.css({
            color: settings.color,
            backgroundColor: settings.backgroundColor
        });
	    
        this.css( "color", "green" );
        return this;
    }; */
}( jQuery ));