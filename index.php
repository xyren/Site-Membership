<?php
/*
Plugin Name: Site Membership
Plugin URI: 
Description: Site Membership
Author: Jenner ALagao
Version: 9.3
Author URI: 
*/

define("MEMBERS_TABLE",$wpdb->prefix.'sitemembership');
define("WPUSERS_TABLE",$wpdb->prefix.'users');
define("MEMBERS_SECRET",basename(dirname(__FILE__)));
define("MEMBERS_URL_PLUG",WP_PLUGIN_URL . '/'.basename(dirname(__FILE__)));
define("MEMBERS_DIR_PLUG",WP_PLUGIN_DIR . '/'.basename(dirname(__FILE__)));

if(!defined('WP_HOME'))
	define("WP_HOME",site_url());
#$upload_dir = wp_upload_dir();

$upload_dir = array(
	'baseurl' => WP_HOME .'/images',
	'basedir' => ABSPATH . 'images'
);

require_once('_inc/init.php');
require_once('_inc/scripts.php');

/* 
define("TEAMPHOTO_UPLOAD_URL",$upload_dir['baseurl']);
define("TEAMPHOTO_UPLOAD_DIR",$upload_dir['basedir']);
*/
include_once('_inc/menu.php');
/*
include_once('ajax.team-photo.php');


*/
include_once('_inc/function.php');
include_once('_inc/class.members.php');
include_once('site-member/class.table.php');
include_once('site-member/screen.php'); 

add_action( 'init', 'site_members::init' );

register_activation_hook( __FILE__, 'site_member_install');
register_deactivation_hook(__FILE__, 'uninstall_site_member');
function site_member_install(){
    site_members::install();
}
function uninstall_site_member(){
	site_members::uninstall();
}


/*




print_r(site_members::removeRules());
#add Menu as separate sports
function add_menu_sports(){

	
	global $wpdb;
	//$distinctSport_SQL = $wpdb->get_results("SELECT DISTINCT(sport) FROM ".TEAMPHOTO_TABLE);
	$distinctSport_SQL = teamphoto_list_Table::distinct('sport');
	foreach ( $distinctSport_SQL as $distinctSport ){
		$sport = preg_replace("/[^A-Za-z0-9]/", '', $distinctSport);
		$url_sport = urlencode('sport:'.$distinctSport);
		add_submenu_page('team-photo',$distinctSport.' Team logo',' &raquo; '.$distinctSport,'administrator','team-photo&filter='.$url_sport,'teamphoto_ui');
		//echo "<option>{$distinctSport}</option>";
	}
		
	
}
add_action('admin_menu', 'add_menu_sports');
 */