<?
/* if( ! class_exists('WP_Screen') ) {
	require_once( ABSPATH . 'wp-admin/includes/screen.php' );
}
 */
 global $horse_racing_race_screen;
class wp_screen_horse_racing_race{
 
	private $admin_page;
	private $admin_screen;
 
	public function __construct() {
		add_action( 'admin_menu', array(&$this, 'admin_menu') );
	}
 
	public function admin_menu() {
		global $horse_racing_race_screen;
		$this->admin_page =  $horse_racing_race_screen;
		add_action("load-{$this->admin_page}",array(&$this,'create_help_screen'));	
	}
	
	public function create_help_screen() {
		global $wp_list_table;
		
		if($_REQUEST['action']=='view'){
			$wp_list_table = new horse_racing_price_list_Table();
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
		}else{
		
			$wp_list_table = new horse_racing_race_list_Table();
			$this->admin_screen = WP_Screen::get($this->admin_page);
			//$event_per_page = get_option( 'horse_racing_events_per_page', 10 );
			$this->admin_screen->add_option(
				'per_page', 
				array(
					'label' => 'Races per page', 
					'default' => 10, 
					'option' => 'edit_per_page'
				)
			);
		}
	}
	
}
function screen_horserace_init() {
	$screenTest = new wp_screen_horse_racing_race();
}
add_action( 'init', 'screen_horserace_init' );