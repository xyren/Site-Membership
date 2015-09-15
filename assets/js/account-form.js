jQuery(document).ready(function($) {
		
	jQuery("#email").on( "change", function() {
		$.post( "/api/ajax", { email: $(this).val(), action: "checkemail" })
	        .done(function( data ) {
	        console.log(data);
	    });
    });
    jQuery("#user").on( "change", function() {
		$.post( "/api/ajax", { user: $(this).val(), action: "checkusername" })
	        .done(function( data ) {
	        console.log( data );
	    });
    });
    
});	