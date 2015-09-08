<?
if( ! class_exists('WP_Screen') ) {
	require_once( ABSPATH . 'wp-admin/includes/screen.php' );
}

class wp_screen_members{
 
	private $admin_page;
	private $admin_screen;
 
	public function __construct() {
		add_action( 'admin_menu', array(&$this, 'admin_menu') );
	}
 
	public function admin_menu() {
		global $sitemember_screen,$sitemember_screen_manage;
		//$screen = get_current_screen();
		foreach($sitemember_screen_manage as $_key => $val){
			$this->admin_page = $val;
			add_action("load-{$this->admin_page}",array(&$this,'create_help_screen'));
		}
	}
	
	public function create_help_screen() {
		global $wp_list_table,$sitemember_screen_manage;
		
	/* 	if($_REQUEST['action']=='view'){
			$wp_list_table = new members_list_Table();
			$this->admin_screen = WP_Screen::get($this->admin_page);
			//$event_per_page = get_option( 'horse_racing_events_per_page', 10 );
			$this->admin_screen->add_option(
				'per_page', 
				array(
					'label' => 'Price per page', 
					'default' => 10, 
					'option' => 'edit_per_page'
				)
			);
		}*/
		
		
		$_reqID = explode('_',$_GET['page']);
		$_levelID = (int)end($_reqID );
		
		$wp_list_table = new members_list_Table();
		$this->admin_screen = WP_Screen::get($sitemember_screen_manage[$_levelID]);
		$this->admin_screen->add_option(
			'per_page', 
			array(
				'label' => 'List per page', 
				'default' => 10, 
				'option' => 'list_per_page'
			)
		);
	}
	
}
function screen_members_init() {
	$screenTest = new wp_screen_members();
}
add_action( 'init', 'screen_members_init' );


function sitemember_list_set_option($status, $option, $value) {
	if ( 'list_per_page' == $option ) return $value;
    return $status;
}
add_filter('set-screen-option', 'sitemember_list_set_option', 10, 3);


