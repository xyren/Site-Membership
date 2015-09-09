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


$_memberLevel = array(
	0 => 'Member',
	1 => 'Band',
	2 => 'Venue Manager',
	3 => 'Modulator',
	7 => 'Admin',
);


global $_memberLevel;

$_reqID = explode('_',$_GET['page']);
$_levelID = (int)end($_reqID );

if(array_key_exists($_levelID, $_memberLevel)){
	$_memberLevel_ID = $_levelID;
}else{
	$_memberLevel_ID = -1;
}

/* 


define("TEAMPHOTO_UPLOAD_URL",$upload_dir['baseurl']);
define("TEAMPHOTO_UPLOAD_DIR",$upload_dir['basedir']);


define("TEAMPHOTO_FLAG_URL",$upload_dir['baseurl'].'/flags/flags-16');
define("TEAMPHOTO_FLAG_DIR",$upload_dir['basedir'].'/flags/flags-16');

*/
include_once('_inc/menu.php');
/*
include_once('ajax.team-photo.php');


*/
include_once('_inc/function.php');
include_once('_inc/class.members.php');
include_once('site-member/class.table.php');
include_once('site-member/screen.php'); 
/*


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