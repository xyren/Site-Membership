<?

class member_scripts extends site_members {

	public function __construct(){
	
		//wp_deregister_script( 'jquery'); 
		//wp_register_script( 'jquery', MEMBERS_URL_PLUG . '/assets/js/jquery-1.11.3.min.js','', '1.11.3');
	
		//wp_register_script( 'jquery', MEMBERS_URL_PLUG.'/js/jquery.min.js'); 
		//wp_register_script( 'simple-user-password-generator', MEMBERS_URL_PLUG.'/assets/js/simple-user-password-generator.js'); 
		wp_register_script( 'jquery-uploadify', MEMBERS_URL_PLUG.'/uploadify/jquery.uploadify.min.js');
		wp_register_style( 'uploadify', MEMBERS_URL_PLUG.'/uploadify/uploadify.css');
		wp_register_style( 'font-awesome', MEMBERS_URL_PLUG.'/ext/font-awesome-4.4.0/css/font-awesome.min.css');
		
		wp_register_script('jquery-validate', MEMBERS_URL_PLUG.'/assets/js/jquery_validation/dist/jquery.validate.min.js',array('jquery'));
		wp_register_script('jquery-validate-addt', MEMBERS_URL_PLUG.'/assets/js/jquery_validation/dist/additional-methods.min.js',array('jquery','jquery-validate'));
		wp_register_script('site-member_account-form', MEMBERS_URL_PLUG.'/assets/js/account-form.js',array('jquery','jquery-validate','jquery-validate-addt'));
		wp_register_script('admin-functions', MEMBERS_URL_PLUG.'/assets/js/admin-functions.js',array('jquery','jquery-validate','jquery-validate-addt'));
		
		//wp_enqueue_script('jquery-validate');
		//wp_enqueue_script('jquery-uploadify');
		//wp_enqueue_script('media-upload');
		//wp_enqueue_script('thickbox');
		//wp_enqueue_style('uploadify');
		
		/* if(($_GET['page']=='team-photo')or($_GET['page']=='team-photo')){
			wp_admin_css('thickbox');
			//add_thickbox();
			//wp_enqueue_script('jquery-ui-autocomplete');
			
		} */
	}
	
	
	
	public function member_form_add(){
		$clone = new member_scripts();
		
		//wp_enqueue_script( 'password-strength-meter' );
		wp_enqueue_style('uploadify');
		wp_enqueue_style('font-awesome');
		wp_enqueue_script('jquery-validate');
		wp_enqueue_script('jquery-validate-addt');
		wp_enqueue_script('site-member_account-form');
		//wp_enqueue_script('jquery-uploadify');
		//wp_print_scripts('simple-user-password-generator');
		
	}
	
	public function admin(){
		$clone = new member_scripts();
		wp_enqueue_style('uploadify');
		wp_enqueue_style('font-awesome');
		wp_enqueue_script('jquery-validate');
		wp_enqueue_script('jquery-validate-addt');
		wp_enqueue_script('admin-functions');
	}
	
	
	public function iframe(){
		wp_deregister_script('jquery');
		wp_register_script( 'jquery', MEMBERS_URL_PLUG . '/js/jquery.min.js','', '1.7.2');
		wp_register_script( 'jquery-uploadify', MEMBERS_URL_PLUG.'/uploadify/jquery.uploadify.min.js'); 
		wp_register_style( 'uploadify', MEMBERS_URL_PLUG.'/uploadify/uploadify.css');
	
		
		wp_enqueue_style( 'global' );
		wp_enqueue_style( 'wp-admin'); 
		wp_enqueue_style( 'admin-ui-theme'); 
		 
		
		wp_enqueue_style('jquery-ui-theme');
		wp_admin_css('css/wp-admin.min');
		wp_enqueue_style('buttons');
		wp_enqueue_style('colors'); 
		//do_action("admin_print_styles"); 
		
		wp_print_styles('buttons'); 
		wp_print_styles('colors');
		wp_print_styles('uploadify');
		
		
		wp_print_scripts('jquery');
		wp_print_scripts('jquery-uploadify');
		add_thickbox();
		
	}
	
	
}