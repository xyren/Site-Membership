<?php
/*
Plugin Name: Site Membership
Plugin URI: 
Description: Site Membership
Author: Jenner ALagao
Version: 9.3
Author URI: 
*/

define("TEAMPHOTO_TABLE",$wpdb->prefix.'teamphoto');
define("TEAMPHOTO_TABLE_LOGS",$wpdb->prefix.'teamphoto_logs');
define("TEAMPHOTO_SECRET",'team-photo');
define("TEAMPHOTO_URL_PLUG",WP_PLUGIN_URL . '/team-photo');
define("WP_HOME",site_url());

#$upload_dir = wp_upload_dir();

$upload_dir = array(
	'baseurl' => WP_HOME .'/images',
	'basedir' => ABSPATH . 'images'
);/* 


define("TEAMPHOTO_UPLOAD_URL",$upload_dir['baseurl']);
define("TEAMPHOTO_UPLOAD_DIR",$upload_dir['basedir']);


define("TEAMPHOTO_FLAG_URL",$upload_dir['baseurl'].'/flags/flags-16');
define("TEAMPHOTO_FLAG_DIR",$upload_dir['basedir'].'/flags/flags-16');


include_once('menu.team-photo.php');
include_once('ajax.team-photo.php');
include_once('function.team-photo.php');
include_once("class.team-photo.php");

include_once("team/class.team.table.php");
include_once("team/screen.team.php"); 

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