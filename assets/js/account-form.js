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
    
});