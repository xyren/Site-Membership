<?
add_action('admin_menu', 'teamphoto_menu');

function teamphoto_menu(){
	global $teamphoto_screen,$teamphoto_race_screen;
	add_menu_page('Team Photo','Team Photo','administrator','team-photo','teamphoto_ui','');
	
	$teamphoto_screen = add_submenu_page('team-photo','Team League List','League List','administrator','team-photo','teamphoto_ui');
		add_submenu_page('team-photo','Add Team Photo','Add New Event','administrator','team-photo-add','teamphoto_add_ui');
		add_submenu_page('team-photo1','Edit Team Photo','Edit Team Photo','administrator','team-photo&action=edit','teamphoto_edit_ui');
		add_submenu_page('team-photo1','View Team Photo','Racing Event','administrator','team-photo&action=view','teamphoto_view_ui');
	
	if(isset($_GET['page'])){
		if(strrpos($_GET['page'],'team-photo') !== false){
			add_action('admin_print_scripts','teamphoto_action_script');
		}
	}
}

function teamphoto_ui(){
	switch ($_GET['action']) {
		case 'add':
			teamphoto_add_ui();break;
		case 'edit':
			teamphoto_edit_ui();break;
		case 'view':
			teamphoto_view_ui();break;
		default:
			require_once('team/list.team.php');break;
	}
	//require_once('home-overview.php');
}
function teamphoto_add_ui(){require_once('team/add.team.php');}
function teamphoto_edit_ui(){require_once('team/edit.team.php');}
function teamphoto_view_ui(){require_once('team/view.team.php');}
